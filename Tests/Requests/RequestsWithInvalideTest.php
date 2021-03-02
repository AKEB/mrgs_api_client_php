<?php

error_reporting(E_ALL);

class RequestsWithInvalideTest extends PHPUnit\Framework\TestCase {

	public function testCustomRequest() {
		try {
			new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), getenv('MRGS_CLIENT_SECRET'));
			\AKEB\MRGS\Authorize::getInstance()->authorize();

			$syncRequest = new \AKEB\MRGS\CustomRequest('payments/exchangeRate',[],[]);
			$syncRequest->send();

			$this->assertTrue(false);
		} catch(\AKEB\MRGS\Exception\RequestException $ex) {
			$this->assertEquals($ex->getCode(), 400);
		} catch(\AKEB\MRGS\Exception\AuthorizeException $ex) {
			$this->assertTrue(false);
		} finally {
			\AKEB\MRGS\Authorize::getInstance()->unauthorize();
		}

	}

	public function testAuthRequest() {
		try {
			new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), '123456789abcdef');
			\AKEB\MRGS\Authorize::getInstance()->authorize();
		} catch(\AKEB\MRGS\Exception\AuthorizeException $ex) {
			$this->assertEquals($ex->getCode(), 401);
		} finally {
			\AKEB\MRGS\Authorize::getInstance()->unauthorize();
		}

	}

}
