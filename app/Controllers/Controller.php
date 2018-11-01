<?php
/**
 * Created by PhpStorm.
 * User: geckob
 * Date: 31/10/2018
 * Time: 2:48 PM
 */

namespace App\Controllers;


class Controller
{

	protected $db;

	public function __construct()
	{
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

}