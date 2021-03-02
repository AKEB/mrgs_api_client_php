<?php

error_reporting(E_ALL);

class ServerRequestsTest extends PHPUnit\Framework\TestCase {

	protected function setUp() {
		new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), getenv('MRGS_SERVER_SECRET'));
		\AKEB\MRGS\Authorize::getInstance()->authorize();
	}

	protected function tearDown() {
		\AKEB\MRGS\Authorize::getInstance()->unauthorize();
	}


	public function testSyncServerRequest() {

		$string1 = md5( time() . rand(1, 10000000) );
		$string2 = md5( time() . rand(1, 10000000) );
		$string3 = md5( time() . rand(1, 10000000) );

		$syncRequest = new \AKEB\MRGS\Requests\test\syncServer([
			'param1' => '333',
			'param3' => $string3,
		]);
		$syncRequest->setParam1($string1);
		$syncRequest->setParam2($string2);
		$response = $syncRequest->send();

		$this->assertTrue(is_array($response));
		$this->assertArrayHasKey('response', $response);
		$this->assertArrayHasKey('status', $response);
		$this->assertArrayHasKey('fromCache', $response);
		$this->assertArrayHasKey('serverTimeUnix', $response);
		$this->assertArrayHasKey('serverTime', $response);
		$this->assertArrayHasKey('action', $response);

		$this->assertEquals($response['action'], 'test_syncServer');

		$this->assertArrayHasKey('param1', $response['response']);
		$this->assertArrayHasKey('param2', $response['response']);

		$this->assertArrayNotHasKey('param3', $response['response']);

		$this->assertEquals($response['response']['param1'], $string1);
		$this->assertEquals($response['response']['param2'], $string2);

	}

	public function testAsyncServerRequest() {

		$string1 = md5( time() . rand(1, 10000000) );
		$string2 = md5( time() . rand(1, 10000000) );
		$string3 = md5( time() . rand(1, 10000000) );

		$syncRequest = new \AKEB\MRGS\Requests\test\asyncServer([
			'param1' => '321',
			'param3' => $string3,
		]);
		$syncRequest->setParam1($string1);
		$syncRequest->setParam2($string2);
		$response = $syncRequest->send();

		$this->assertTrue(is_array($response));
		$this->assertArrayHasKey('response', $response);
		$this->assertArrayHasKey('status', $response);
		$this->assertArrayHasKey('fromCache', $response);
		$this->assertArrayHasKey('serverTimeUnix', $response);
		$this->assertArrayHasKey('serverTime', $response);
		$this->assertArrayHasKey('action', $response);

		$this->assertEquals($response['action'], 'test_asyncServer');

		$this->assertArrayNotHasKey('param1', $response['response']);
		$this->assertArrayNotHasKey('param2', $response['response']);
		$this->assertArrayNotHasKey('param3', $response['response']);

		$this->assertTrue($response['fromCache']);

	}

	public function testKafkaServerRequest() {

		$string1 = md5( time() . rand(1, 10000000) );
		$string2 = md5( time() . rand(1, 10000000) );
		$string3 = md5( time() . rand(1, 10000000) );

		$syncRequest = new \AKEB\MRGS\Requests\test\kafkaServer([
			'param1' => '123',
			'param3' => $string3,
		]);
		$syncRequest->setParam1($string1);
		$syncRequest->setParam2($string2);
		$response = $syncRequest->send();

		$this->assertTrue(is_array($response));
		$this->assertArrayHasKey('response', $response);
		$this->assertArrayHasKey('status', $response);
		$this->assertArrayHasKey('fromCache', $response);
		$this->assertArrayHasKey('serverTimeUnix', $response);
		$this->assertArrayHasKey('serverTime', $response);
		$this->assertArrayHasKey('action', $response);

		$this->assertEquals($response['action'], 'test_kafkaServer');

		$this->assertArrayNotHasKey('param1', $response['response']);
		$this->assertArrayNotHasKey('param2', $response['response']);
		$this->assertArrayNotHasKey('param3', $response['response']);

		$this->assertTrue($response['fromCache']);

	}
}
