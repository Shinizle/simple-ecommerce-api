<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompleteOrderRequest;
use App\Http\Requests\Admin\GetOrderProductRequest;
use App\Http\Requests\Admin\GetOrderRequest;
use App\Http\Resources\OrderProductResourceCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderResourceCollection;
use App\Models\Order;
use App\Models\OrderProduct;

class OrderController extends Controller
{
    public function getAllOrders()
    {
        $data = Order::paginate();

        return new OrderResourceCollection($data);
    }

    public function getOrder(GetOrderRequest $request)
    {
        $data = Order::find($request->id);

        return new OrderResource($data);
    }

    public function getOrderProducts(GetOrderProductRequest $request)
    {
        $data = OrderProduct::whereOrderId($request->order_id)->paginate();

        return new OrderProductResourceCollection($data);
    }

    public function completeOrder(CompleteOrderRequest $request)
    {
        $data = Order::find($request->id);
        $data->update(['status' => Order::COMPLETED]);

        return new OrderResource($data);
    }
}
