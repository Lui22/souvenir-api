<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * Общий формат ошибки
	 *
	 * @param $message
	 * @param $code
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function error($message, $code)
	{
		return response([
			"error" => compact('message', 'code')
		], $code);
	}

	/**
	 * Общий формат ошибки 404
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function notFound()
	{
		return $this->error("Ресурс не найден", 404);
	}

	/**
	 * Общий формат ответа
	 *
	 * @param $data
	 * @param  int  $code
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function response($data, $code = 200)
	{
		return response(compact('data'), $code);
	}
}
