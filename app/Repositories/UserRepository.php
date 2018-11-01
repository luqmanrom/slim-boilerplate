<?php
/**
 * Created by PhpStorm.
 * User: geckob
 * Date: 30/10/2018
 * Time: 4:16 PM
 */

namespace App\Repositories;


class UserRepository
{

	private $db;

	public function __construct() {

		$host = getenv('DB_HOST');

		$username = getenv('DB_USER');

		$password = getenv('DB_PASSWORD');

		$database = getenv('DB_NAME');

		$this->db = \ParagonIE\EasyDB\Factory::create(
			"mysql:host=$host;dbname=$database",
			$username,
			$password
		);

	}

	public function create() {

	}

	public function findByToken($value, $field = 'api_token') {

		$userData = $this->db->row(
			"SELECT * FROM users WHERE $field = ?",
			$value
		);

		return $userData;
	}

	public function findByEmail($email) {
		$userData = $this->db->row(
			"SELECT * FROM users WHERE email = ?",
			$email
		);

		return $userData;
	}


}