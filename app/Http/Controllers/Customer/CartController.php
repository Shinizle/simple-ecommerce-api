<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\DuplicateEntryException;
use App\Exceptions\ErrorSQLException;
use App\Exceptions\InvalidQuantityException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\AddToCartRequest;
use App\Http\Requests\Customer\GetCartRequest;
use App\Http\Requests\Customer\RemoveFromCartRequest;
use App\Http\Requests\Customer\UpdateItemCartRequest;
use App\Http\Resources\CartResource;
use App\Http\Resources\CartResourceCollection;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductEvent;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getUserCart()
    {
        $data = Auth::user()->carts()->paginate();

        return new CartResourceCollection($data);
    }

    public function addToCart(AddToCartRequest $request)
    {
        $cart = $this->mapNewCartData($request);

        return new CartResource($cart);
    }

    public function getCart(GetCartRequest $request)
    {
        $data = Cart::find($request->id);

        return new CartResource($data);
    }

    public function updateItemCart(UpdateItemCartRequest $request)
    {
        $cart = $this->mapUpdateCartData($request);

        return new CartResource($cart);
    }

    public function removeFromCart(RemoveFromCartRequest $request)
    {
        Cart::find($request->id)->delete();

        return response()->json(['message' => 'Product cart has been removed.'], self::SUCCESS_STATUS);
    }

    private function mapNewCartData($data)
    {

        /*
         * -- Simple Cart logic start here --
         * 1. The product_event_id is nullable and product_id will required if the product_event_id is null and the validation has been set in request file above.
         * 2. We'll check if request given is using product_event_id, it will be prioritizing over product_id.
         * 3. Then if it is, We'll ignore the product_id even it was submited inside request. We'll use quantity and price data from product_events table given.
         * 4. Else, we will use product_id which is required if product_event_id is null and use the original price and quantity from products table.
         * 5. We'll also check if there is duplicate product in the cart.
         */

        if ($data->has('product_event_id')) {
            $product = ProductEvent::find($data->product_event_id);
            $productId = $product->product_id;
            $isValidQty = $this->validateQuantity($data->qty, $product->product_event_qty);
            $isEvent = true;
        } else {
            $product = Product::find($data->product_id);
            $productId = $product->id;
            $isValidQty = $this->validateQuantity($data->qty, $product->qty);
            $isEvent = false;
        }

        $isExist = Cart::whereUserId(Auth::user()->id)->whereProductId($productId)->exists();
        if ($isExist) {
            throw new DuplicateEntryException();
        } elseif (!$isValidQty) {
            throw new InvalidQuantityException();
        } else {
            DB::beginTransaction();

            try {
                $newCartData = Cart::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $productId,
                    'qty' => $data->qty,
                    'is_event' => $isEvent,
                    'event_id' => @$product->event_id,
                ]);

                DB::commit();

                return $newCartData;
            } catch (\Exception $e) {
                DB::rollback();
                throw new ErrorSQLException();
            }
        }
    }

    private function mapUpdateCartData($data)
    {
        $cart = Cart::find($data->id);
        if ($cart->is_event) {
            $product = $cart->event->productEvents()->whereProductId($cart->product_id)->first();
            $isValidQty = $this->validateQuantity($data->qty, $product->product_event_qty);
        } else {
            $isValidQty = $this->validateQuantity($data->qty, $cart->$product->qty);
        }

        if (!$isValidQty) {
            throw new InvalidQuantityException();
        } else {
            DB::beginTransaction();

            try {
                $cart->update(['qty' => $data->qty]);

                DB::commit();

                return $cart;
            } catch (\Exception $e) {
                DB::rollback();
                throw new ErrorSQLException();
            }
        }
    }

    private function validateQuantity($requestQty, $inventoryQty)
    {
        if ((int)$requestQty <= (int)$inventoryQty) {
            return true;
        }

        return false;
    }
}
