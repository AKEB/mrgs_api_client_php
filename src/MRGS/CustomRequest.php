<?php

namespace AKEB\MRGS;

class CustomRequest extends \AKEB\MRGS\Request {
	protected $path = 'test/sync/';
	protected $scopes = ['server', 'client'];

	public function __construct(string $path, array $GET=[], array $POST=[], array $BODY=[]) {
		$this->path = $path;
		$this->GET = $GET;
		$this->POST = $POST;
		$this->BODY = $BODY;
	}

	public function send() {
		$response = $this->_request();
		return $response;
	}

}