<?php

error_reporting(E_ALL);

class AutorizeTest extends PHPUnit\Framework\TestCase {

	public function testAccessToken() {
		var_dump(getenv('MRGS_APP_ID'));
		var_dump(getenv('MRGS_CLIENT_SECRET'));
		var_dump(getenv('MRGS_SERVER_SECRET'));
		var_dump(PHP_VERSION);
		$a = true;
		$this->assertTrue($a);
	}

}
