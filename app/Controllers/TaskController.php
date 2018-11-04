<?php

namespace App\Controllers;


use ParagonIE\EasyDB\EasyDB;

class TaskController extends Controller
{


	private $container;

	public function __construct($container)
	{
		parent::__construct($container);
		$this->container = $container;
	}

	public function postTask($request, $response, $args) {

		$body = $request->getParsedBody();

		$user = $this->container->user;

		try {
			$id = $this->db->insertReturnId('tasks', [
				'title' => $body['title'],
				'description' => $body['description'],
				'creator_id' => $user['ID']

			]);

			$status = 200;

			$returnedData = [
				'data' => [
					'type' => 'tasks',
					'id' => $id,
					'attributes' => [
						'title' => $body['title'],
						'description' => $body['description'],
						'creator_id' => $user['ID']
					]
				]
			];

		} catch (\PDOException $e) {
			$status = 400;

			$returnedData = [
				'errors' => [
					'msg' => 'Something went wrong'
				]
			];
		}

		return $response->withHeader('Content-Type', 'application/json')
			->withJson($returnedData, $status);

	}


	public function deleteTask($request, $response, $args) {

		try {

			$this->db->delete('tasks', [
				'ID' => $args['id']
			]);

			$status = 200;

			$returnedData = [
				'data' => [
					'type' => 'tasks',
					'id' => $args['id']
				]
			];

		} catch (\PDOException $e) {

			$status = 400;

			$returnedData = [
				'errors' => [
					'msg' => 'Something went wrong'
				]

			];

		}

		return $response->withHeader('Content-Type', 'application/json')
			->withJson($returnedData, $status);

	}


	public function putTask($request, $response, $args) {

		$body = $request->getParsedBody();


		try {
			$this->db->update('tasks',
				[
					'title' => $body['title'],
					'description' => $body['description']
				]
				, [
					'ID' => $args['id']
				]);

			$status = 200;

			$returnedData = [
				'data' => [
					'type' => 'tasks',
					'id' => $args['id'],
					'attributes' => [
						'title' => $body['title'],
						'description' => $body['description']
					]
				]

			];

		} catch (\PDOException $e) {

			$status = 400;

			$returnedData = [
				'errors' => [
					'msg' => 'Something went wrong'
				]
			];

		}

		return $response->withHeader('Content-Type', 'application/json')
			->withJson($returnedData, $status);

	}

	public function postAssign() {

		// @todo
	}


	public function postSubtasks($request, $response, $args) {

		$body = $request->getParsedBody();


		try {
			$id = $this->db->insertReturnId('ChildrenTask', [
				'title' => $body['title'],
				'description' => $body['description'],
				'task_id' => $body['task_id']
			]);

			$status = 200;

			$returnedData = [
				'data' => [
					'type' => 'subtasks',
					'id' => $id
				]
			];

		} catch (\PDOException $e) {
			$status = 400;

			$returnedData = [
				'errors' => [
					'msg' => 'Missing data'
				]
			];
		}

		return $response->withHeader('Content-Type', 'application/json')
			->withJson($returnedData, $status);
	}
}