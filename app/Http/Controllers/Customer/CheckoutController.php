<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\ErrorSQLException;
use App\Exceptions\InvalidQuantityException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CheckoutRequest;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function handle(CheckoutRequest $request)
    {
        $data = $this->mapCheckoutOrder($request);

        return new OrderResource($data);
    }

    private function mapCheckoutOrder($data)
    {
        $carts = Cart::whereIn('id', $data->cart_ids);
        $price = $this->getPrice($carts);
        $subtotal = (int)$price + (int)$data->delivery_fee - (int)$data->discount;

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'uuid' => \Str::orderedUuid(),
                'customer_delivery_name' => $data->customer_delivery_name,
                'customer_delivery_address' => $data->customer_delivery_address,
                'customer_delivery_phone' => $data->customer_delivery_phone,
                'delivery_fee' => $data->delivery_fee,
                'discount' => $data->discount ? $data->discount : 0,
                'price' => $price,
                'subtotal' => $subtotal,
                'status' => Order::PROCESS,
                'note' => $data->note
            ]);

            $this->saveOrderProduct($carts, $order);
            /* Clear Carts */
            $carts->delete();

            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            throw new ErrorSQLException($e);
        }
    }

    private function getPrice($carts)
    {

        /*
         * Calculate price for each product in cats and validate if product is in stock
         */

        $price = 0;
        foreach ($carts->get() as $cart) {
            $price = $price + (int)$cart->getTotalPrice();
            if(!$cart->isInStock()) {
                throw new InvalidQuantityException();
            }
        }

        return $price;
    }

    private function saveOrderProduct($carts, $order) :void
    {
        foreach ($carts->get() as $cart) {
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'qty' => $cart->qty,
                'unit_price' => $cart->getCartPrice(),
                'subtotal' => $cart->getTotalPrice()
            ]);
        }
    }
}
