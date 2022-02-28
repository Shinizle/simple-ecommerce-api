<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\GetCustomerOrderDetailRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderResourceCollection;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function getAllOrders()
    {
        $data = Auth::user()->orders()->paginate();

        return new OrderResourceCollection($data);
    }

    public function getCustomerOrderDetail(GetCustomerOrderDetailRequest $request)
    {
        $data = Order::find($request->id);

        return new OrderResource($data);
    }
}
