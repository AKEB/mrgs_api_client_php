<?php

error_reporting(E_ALL);

class exchageRateTest extends PHPUnit\Framework\TestCase {

	protected function setUp() {
		new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), getenv('MRGS_CLIENT_SECRET'));
		\AKEB\MRGS\Authorize::getInstance()->authorize();
	}

	protected function tearDown() {
		\AKEB\MRGS\Authorize::getInstance()->unauthorize();
	}

	public function testRequest() {

		$syncRequest = new \AKEB\MRGS\Requests\payments\exchangeRate();
		$syncRequest->setDate('2021-03-01');
		$syncRequest->setSource('OPENEXCHANGE');
		$response = $syncRequest->send();

		$this->assertTrue(is_array($response));
		$this->assertArrayHasKey('response', $response);
		$this->assertArrayHasKey('status', $response);
		$this->assertArrayHasKey('fromCache', $response);
		$this->assertArrayHasKey('serverTimeUnix', $response);
		$this->assertArrayHasKey('serverTime', $response);
		$this->assertArrayHasKey('action', $response);

		$this->assertEquals($response['action'], 'payments_exchangeRate');
		$this->assertTrue(is_array($response['response']));
		if (count($response['response']) > 0) {
			foreach($response['response'] as $item) {
				$this->assertArrayHasKey('Code', $item);
				$this->assertArrayHasKey('Date', $item);
				$this->assertArrayHasKey('Value', $item);
				$this->assertArrayHasKey('Source', $item);

				$this->assertEquals($item['Code'], strtoupper($item['Code']));
				$this->assertEquals(strlen($item['Code']), 3);
				$this->assertEquals($item['Date'], '2021-03-01');
			}
		}

	}


	public function testRequestAssert() {
		try {
			$syncRequest = new \AKEB\MRGS\Requests\payments\exchangeRate();
			$syncRequest->setDate('asd20210301');
			$response = $syncRequest->send();

			$this->assertTrue(false);
		} catch(\AKEB\MRGS\Exception\RequestException $ex) {
			$this->assertEquals($ex->getCode(), 400);
		}

		try {
			$syncRequest = new \AKEB\MRGS\Requests\payments\exchangeRate();
			$response = $syncRequest->send();

			$this->assertTrue(false);
		} catch(\AKEB\MRGS\Exception\RequestException $ex) {
			$this->assertEquals($ex->getCode(), 400);
		}

		try {
			$syncRequest = new \AKEB\MRGS\Requests\payments\exchangeRate();
			$syncRequest->setDate('2021-03-01');
			$syncRequest->setSource('ksdbvhbksbgkbskbskbnvksnbs');
			$response = $syncRequest->send();

			$this->assertTrue(false);
		} catch(\AKEB\MRGS\Exception\RequestException $ex) {
			$this->assertEquals($ex->getCode(), 400);
		}

		try {
			$syncRequest = new \AKEB\MRGS\Requests\payments\exchangeRate();
			$syncRequest->setDate(1614610976);
			$response = $syncRequest->send();

			$this->assertTrue(is_array($response));
			$this->assertArrayHasKey('response', $response);
			$this->assertArrayHasKey('status', $response);
			$this->assertArrayHasKey('fromCache', $response);
			$this->assertArrayHasKey('serverTimeUnix', $response);
			$this->assertArrayHasKey('serverTime', $response);
			$this->assertArrayHasKey('action', $response);

			$this->assertEquals($response['action'], 'payments_exchangeRate');
			$this->assertTrue(is_array($response['response']));
			if (count($response['response']) > 0) {
				foreach($response['response'] as $item) {
					$this->assertArrayHasKey('Code', $item);
					$this->assertArrayHasKey('Date', $item);
					$this->assertArrayHasKey('Value', $item);
					$this->assertArrayHasKey('Source', $item);

					$this->assertEquals($item['Code'], strtoupper($item['Code']));
					$this->assertEquals(strlen($item['Code']), 3);
					$this->assertEquals($item['Date'], '2021-03-01');
				}
			}
		} catch(\AKEB\MRGS\Exception\RequestException $ex) {
			$this->assertTrue(false);
		}


	}

}
