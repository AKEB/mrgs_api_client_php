<?php

error_reporting(E_ALL);

class CustomRequestsTest extends PHPUnit\Framework\TestCase {

	protected function setUp():void {
		new AKEB\MRGS\Authorize(getenv('MRGS_APP_ID'), getenv('MRGS_CLIENT_SECRET'));
		\AKEB\MRGS\Authorize::getInstance()->authorize();
	}

	protected function tearDown():void {
		\AKEB\MRGS\Authorize::getInstance()->unauthorize();
	}

	public function testCustomRequest() {

		$string1 = md5( time() . rand(1, 10000000) );
		$string2 = md5( time() . rand(1, 10000000) );
		$string3 = md5( time() . rand(1, 10000000) );

		$syncRequest = new \AKEB\MRGS\CustomRequest('test/sync/',[],[
			'param1' => $string1,
			'param2' => $string2,
			'param3' => $string3,
		]);

		$response = $syncRequest->send();

		$this->assertTrue(is_array($response));
		$this->assertArrayHasKey('response', $response);
		$this->assertArrayHasKey('status', $response);
		$this->assertArrayHasKey('fromCache', $response);
		$this->assertArrayHasKey('serverTimeUnix', $response);
		$this->assertArrayHasKey('serverTime', $response);

		$this->assertArrayHasKey('param1', $response['response']);
		$this->assertArrayHasKey('param2', $response['response']);
		$this->assertArrayHasKey('action', $response['response']);

		$this->assertArrayNotHasKey('param3', $response['response']);

		$this->assertEquals($response['response']['action'], 'sync');
		$this->assertEquals($response['response']['param1'], $string1);
		$this->assertEquals($response['response']['param2'], $string2);

	}

}
