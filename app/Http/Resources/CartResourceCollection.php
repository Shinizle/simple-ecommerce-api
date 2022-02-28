<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CartResourceCollection extends ResourceCollection
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
                    'user_id' => $item->user_id,
                    'cart_price' => $item->getCartPrice(),
                    'total' => $item->getTotalPrice(),
                    'qty' => $item->qty,
                    'product' => new ProductResource($item->product),
                    'is_event' => $item->is_event,
                    'event_id' => $item->event_id,
                    'is_in_stock' => $item->isInStock(),
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
