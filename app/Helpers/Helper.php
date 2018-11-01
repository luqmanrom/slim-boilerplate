<?php

namespace App\Helpers;


class Helper
{
	public static function random($length = 16)
	{
		$string = '';

		while (($len = strlen($string)) < $length) {
			$size = $length - $len;

			$bytes = random_bytes($size);

			$string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
		}

		return $string;


	}

	public static function getToken($request, $header = 'Authorization') {
		$headerValueArray = $request->getHeader($header);

		return $headerValueArray;

	}

}