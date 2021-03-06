<?php

error_reporting(E_ALL);

class ClientRequestsTest extends PHPUnit\Framework\TestCase {

	protected function setUp() {
		new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), getenv('MRGS_CLIENT_SECRET'));
		\AKEB\MRGS\Authorize::getInstance()->authorize();
	}

	protected function tearDown() {
		\AKEB\MRGS\Authorize::getInstance()->unauthorize();
	}

	public function testSyncRequest() {

		$string1 = md5( time() . rand(1, 10000000) );
		$string2 = md5( time() . rand(1, 10000000) );
		$string3 = md5( time() . rand(1, 10000000) );

		$syncRequest = new \AKEB\MRGS\Requests\test\sync([
			'param1' => 'test123',
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

		$this->assertEquals($response['action'], 'test_sync');

		$this->assertArrayHasKey('param1', $response['response']);
		$this->assertArrayHasKey('param2', $response['response']);

		$this->assertArrayNotHasKey('param3', $response['response']);

		$this->assertEquals($response['response']['param1'], $string1);
		$this->assertEquals($response['response']['param2'], $string2);

	}

	public function testAsyncRequest() {

		$string1 = md5( time() . rand(1, 10000000) );
		$string2 = md5( time() . rand(1, 10000000) );
		$string3 = md5( time() . rand(1, 10000000) );

		$syncRequest = new \AKEB\MRGS\Requests\test\async([
			'param1' => 'test321',
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

		$this->assertEquals($response['action'], 'test_async');

		$this->assertArrayNotHasKey('param1', $response['response']);
		$this->assertArrayNotHasKey('param2', $response['response']);
		$this->assertArrayNotHasKey('param3', $response['response']);

		$this->assertTrue($response['fromCache']);

	}

	public function testKafkaRequest() {

		$string1 = md5( time() . rand(1, 10000000) );
		$string2 = md5( time() . rand(1, 10000000) );
		$string3 = md5( time() . rand(1, 10000000) );

		$syncRequest = new \AKEB\MRGS\Requests\test\kafka([
			'param1' => 'test333',
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

		$this->assertEquals($response['action'], 'test_kafka');

		$this->assertArrayNotHasKey('param1', $response['response']);
		$this->assertArrayNotHasKey('param2', $response['response']);
		$this->assertArrayNotHasKey('param3', $response['response']);

		$this->assertTrue($response['fromCache']);

	}

}
