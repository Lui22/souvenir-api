<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartProductResponse extends JsonResource
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
        	"id" => $this->id,
			"product_id" => $this->product_id,
			"name" => $this->product->name,
			"description" => $this->product->description,
			"price" => $this->product->price,
		];
    }
}
