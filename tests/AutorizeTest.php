<?php

error_reporting(E_ALL);

class AutorizeTest extends PHPUnit\Framework\TestCase {

	public function testAccessToken() {
		var_dump(getenv('MRGS_APP_ID'));
		var_export($_ENV);

	}

}