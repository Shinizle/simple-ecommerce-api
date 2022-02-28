<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'uuid' => $this->uuid,
            'user' => new UserResource($this->user),
            'customer_delivery_name' => $this->customer_delivery_name,
            'customer_delivery_address' => $this->customer_delivery_address,
            'customer_delivery_phone' => $this->customer_delivery_phone,
            'delivery_fee' => $this->delivery_fee,
            'discount' => $this->discount,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
            'status' => $this->status,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
