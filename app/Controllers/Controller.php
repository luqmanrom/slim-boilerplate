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

	private $container;

	public function __construct($container)
	{

		$this->container = $container;
		$this->db = $this->container->db;
	}

}