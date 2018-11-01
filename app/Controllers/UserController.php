<?php

namespace App\Controllers;


use App\Helpers\Helper;
use Firebase\JWT\JWT;
use Tuupola\Base62;

class UserController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function postSignup($request, $response, $args) {


		$body = $request->getParsedBody();

		$now = new \DateTime();
		$future = new \DateTime("now +2 hours");

		$jti = (new Base62())->encode(random_bytes(16));

		$scopes = [
			"tasks.create"
		];

		$users = [
			'email' => $body['email']
		];

		$payload = [
			"iat" => $now->getTimeStamp(),
			"exp" => $future->getTimeStamp(),
			"jti" => $jti,
			"scope" => $scopes,
			"users" => $users
		];

		$secret = getenv("JWT_SECRET");

		$token = JWT::encode($payload, $secret, "HS256");


		$this->db->insert('users', [
			'email' => $body['email'],
			'password' => password_hash($body['password'], PASSWORD_DEFAULT) ,
			'name' => $body['name'],
			'api_token' => $token
		]);

		return $response->withHeader('Content-Type', 'application/json')
			->withJson([
				'success' => True,
				'token' => $token
			], 200);


	}

	public function postLogin($request, $response, $args) {

		$body = $request->getParsedBody();

		$userData = $this->db->row(
			"SELECT * FROM users WHERE email = ?",
			$body['email']
		);

		if (password_verify($body['password'], $userData['password'])) {

			$status = 200;

			// @todo Isssue JWT

			$returnedData = [
				'data' => [
					'type' => 'users',
					'id' => $userData['ID'],
					'email' => $userData['email'],
					'name' => $userData['name'],
					'api_token' => $userData['api_token']
				]
			];

		} else {
			$status = 400;

			$returnedData = [
				'error' => [
					'msg' => 'Incorrect credentials'
				]
			];
		}


		return $response->withHeader('Content-Type', 'application/json')
			->withJson($returnedData, $status);

	}
}