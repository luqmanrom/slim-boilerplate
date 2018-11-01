<?php

namespace App\Middlewares;


class TestMiddleware
{


	private $container;

	public function __construct($container) {
		$this->container = $container;
    }

	public function __invoke($request, $response, $next) {

		$method = $request->getMethod();

		$url = $request->getUri();

		$this->container->logger->info("$method $url");

		$response = $next($request, $response);

		return $response;

	}

}