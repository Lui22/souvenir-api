<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserController extends Controller
{
	/**
	 * Метод для авторизации пользователя
	 *
	 * @param  ApiRequest  $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function login(ApiRequest $request)
	{
		if (!Auth::attempt($request->only('email', 'password'))) {
			return $this->error("Неправильные логин или пароль", 401);
		}

		Auth::user()->generateToken();

		return $this->response([
			"user_token" => Auth::user()->api_token
		]);
	}

	/**
	 * Метод для регистрации пользователя
	 *
	 * @param  UserRegisterRequest  $request
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function register(UserRegisterRequest $request)
	{
		$data = $request->only('fio', 'email');
		$data['password'] = Hash::make($request->password);
		$data['user_role_id'] = UserRole::query()->where('name', 'client')->first()->id;

		$newUser = User::create($data);

		Auth::login($newUser);
		Auth::user()->generateToken();

		return $this->response([
			"user_token" => Auth::user()->api_token
		], 201);
	}

	/**
	 * Метод для очистки значения токена пользователя (выход)
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
	 */
	public function logout()
	{
		Auth::user()->removeToken();

		return $this->response([
			"message" => "Вы вышли из системы"
		]);
	}
}
