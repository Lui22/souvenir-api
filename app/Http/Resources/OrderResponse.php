<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
		$products = $this->products;

		$product_ids = $products->map(function ($item, $key) {
			return $item->id;
		});

        return [
        	"id" => $this->id,
			"products" => $product_ids,
			"order_price" => $products->sum('price')
		];
    }
}
