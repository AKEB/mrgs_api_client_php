<?php

namespace AKEB\MRGS;

class CustomRequest extends \AKEB\MRGS\Request {
	protected $path = 'test/sync/';
	protected $scopes = ['server', 'client'];

	public function __construct(string $path, array $GET=[], array $POST=[]) {
		$this->path = $path;
		$this->GET = $GET;
		$this->POST = $POST;
	}

	public function send() {
		$response = $this->_request();
		return $response;
	}

}