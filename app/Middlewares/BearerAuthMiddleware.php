<?php

namespace App\Middlewares;


use App\Helpers\Helper;
use App\Repositories\UserRepository;

class BearerAuthMiddleware
{
	private $container;

	public function __construct($container) {
		$this->container = $container;
	}

	public function __invoke($request, $response, $next) {

		$bearerHeader = $request->getHeader('Authorization');

		$token = substr($bearerHeader[0], 7);

		$userRepo = new UserRepository();

		$user = $userRepo->findByToken($token);

		if (empty($user)) {

			$response = $response->withJson([
				'errors' => [
					'msg' => "Unauthorised"
				]
			], 401);

			return $response;

		} else {

			$this->container['user'] = $user;

			$response = $next($request, $response);

			return $response;

		}









	}
}