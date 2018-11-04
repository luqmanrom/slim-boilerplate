<?php

use Slim\Http\Request;
use Slim\Http\Response;
use App\Middlewares\BearerAuthMiddleware;

// Routes
$container = $app->getContainer();

$container['user'] = [];

$app->post('/api/users/login',
	\App\Controllers\UserController::class . ':postLogin');

$app->post('/api/users/signup',
	\App\Controllers\UserController::class . ':postSignup');


$app->group('', function() {

	$app = $this;

	$app->post('/api/tasks',
		\App\Controllers\TaskController::class . ':postTask');

	$app->post('/api/subtasks',
		\App\Controllers\TaskController::class . ':postSubtasks');

	$app->delete('/api/tasks/{id}',
		\App\Controllers\TaskController::class . ':deleteTask');

	$app->post('/api/tasks/{id}',
		\App\Controllers\TaskController::class . ':putTask');

	$app->post('/api/assign/tasks',
		\App\Controllers\TaskController::class . ':postAssign');

})
	->add(new Tuupola\Middleware\JwtAuthentication([
		"secret" => getenv('JWT_SECRET'),
		"algorithm" => ["HS256"],
		"attribute" => "token",
		"relaxed" => ["127.0.0.1", "localhost"],
		"logger" => $container["logger"],
		"error" => function ($response, $arguments) {
			return $response->withJson([
				'errors' => [
					'msg' => 'Unauthorized'
				]
			], 401);
		},
		"before" => function ($request, $arguments) use($container) {

			$container["user"] = (array) $arguments['decoded']['users'];


			$userRepository = new \App\Repositories\UserRepository();

			$user = $userRepository->findByEmail($container['user']['email']);

			$container['user'] = $user;

		}
	]));

//	->add(BearerAuthMiddleware::class);

