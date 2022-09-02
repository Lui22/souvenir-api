<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Resources\OrderResponse;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
	 */
	public function index()
	{
		return OrderResponse::collection(
			Auth::user()->orders
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\ApiRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ApiRequest $request)
	{
		$user = Auth::user();
		$cart = $user->cart;

		if ($cart->count() < 1) {
			return $this->error("Корзина пуста", 422);
		}

		$newOrder = $user->orders()->create();

		foreach ($cart as $item) {
			OrderProduct::create([
				"order_id" => $newOrder->id,
				"product_id" => $item->product_id
			]);
		}

		$user->cart()->delete();

		return $this->response([
			"order_id" => $newOrder->id,
			"message" => "Заказ оформлен"
		], 201);
	}
}
