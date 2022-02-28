<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cart_price' => $this->getCartPrice(),
            'total' => $this->getTotalPrice(),
            'qty' => $this->qty,
            'product' => new ProductResource($this->product),
            'is_event' => $this->is_event,
            'event_id' => $this->event_id,
            'is_in_stock' => $this->isInStock(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
