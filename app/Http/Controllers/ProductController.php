<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;

class ProductController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return Product::all();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\StoreProductRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(StoreProductRequest $request)
	{
		$newProduct = Product::create($request->only('name', 'description', 'price'));

		return $this->response([
			"id" => $newProduct->id,
			"message" => "Сувенир добавлен в каталог"
		], 201);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ApiRequest  $request
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function update(ApiRequest $request, Product $product)
	{
		$product->update($request->only('name', 'description', 'price'));

		return $product;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Product  $product
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Product $product)
	{
		$product->delete();

		return $this->response([
			"message" => "Сувенир удален из каталога"
		]);
	}
}
