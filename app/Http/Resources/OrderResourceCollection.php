<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function($item){
                return [
                    'id' => $item->id,
                    'uuid' => $item->uuid,
                    'user' => new UserResource($product->user),
                    'customer_delivery_name' => $item->customer_delivery_name,
                    'customer_delivery_address' => $item->customer_delivery_address,
                    'customer_delivery_phone' => $item->customer_delivery_phone,
                    'delivery_fee' => $item->delivery_fee,
                    'discount' => $item->discount,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                    'status' => $item->status,
                    'note' => $item->note,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            }),
            'pagination' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage()
            ]
        ];
    }
}
