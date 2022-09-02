<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Resources\CartProductResponse;
use App\Models\ProductUser;
use Illuminate\Support\Facades\Auth;

class ProductUserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return response(CartProductResponse::collection(
			Auth::user()->cart
		));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\ApiRequest  $request
	 * @param $product_id
	 * @return \Illuminate\Http\Response
	 */
	public function store(ApiRequest $request, $product_id)
	{
		Auth::user()->cart()->create(compact('product_id'));

		return $this->response([
			"message" => "Сувенир добавлен в корзину"
		], 201);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\ProductUser  $productUser
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(ProductUser $productUser)
	{
		if ($productUser->user->id !== Auth::id()) {
			return $this->error("Запрещено для вас", 403);
		}

		$productUser->delete();

		return $this->response([
			"message" => "Сувенир удален из корзины"
		]);
	}
}
