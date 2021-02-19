<?php

error_reporting(E_ALL);

class AuthorizeTest extends PHPUnit\Framework\TestCase {

	public function testAccessToken_Client() {
		// echo getenv('MRGS_APP_ID').PHP_EOL;
		// echo getenv('MRGS_CLIENT_SECRET').PHP_EOL;
		// echo getenv('MRGS_SERVER_SECRET').PHP_EOL;

		new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), getenv('MRGS_CLIENT_SECRET'));

		\AKEB\MRGS\Authorize::getInstance()->authorize();
		$this->assertTrue(\AKEB\MRGS\Authorize::getInstance()->isAuthorized());
		$accessToken = \AKEB\MRGS\Authorize::getInstance()->getAccessToken();
		$refreshToken = \AKEB\MRGS\Authorize::getInstance()->getRefreshToken();

		$this->assertNotEmpty($accessToken);
		$this->assertNotEmpty($refreshToken);

		$this->assertEquals($accessToken, \AKEB\MRGS\Authorize::getInstance()->getAccessToken());

		$this->assertEquals( \AKEB\MRGS\Authorize::getInstance()->getScope(), 'client' );
	}

	public function testAccessToken_Server() {
		new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), getenv('MRGS_SERVER_SECRET'));

		\AKEB\MRGS\Authorize::getInstance()->authorize();
		$this->assertTrue(\AKEB\MRGS\Authorize::getInstance()->isAuthorized());
		$accessToken = \AKEB\MRGS\Authorize::getInstance()->getAccessToken();
		$refreshToken = \AKEB\MRGS\Authorize::getInstance()->getRefreshToken();

		$this->assertNotEmpty($accessToken);
		$this->assertNotEmpty($refreshToken);

		$this->assertEquals($accessToken, \AKEB\MRGS\Authorize::getInstance()->getAccessToken());

		$this->assertEquals( \AKEB\MRGS\Authorize::getInstance()->getScope(), 'server' );
	}

}
