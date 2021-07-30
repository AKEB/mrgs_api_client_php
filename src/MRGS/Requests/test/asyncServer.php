<?php

namespace AKEB\MRGS\Requests\test;

class asyncServer extends \AKEB\MRGS\Request {
	protected $path = 'test/asyncServer/';
	protected $scopes = ['server'];

	public $param1;
	public $param2;

	public function __construct(array $BODY=[]) {
		if ($BODY) {
			$this->BODY = $BODY;
		}
	}

	public function setParam1($param1) {
		$this->param1 = $param1;
	}

	public function setParam2($param2) {
		$this->param2 = $param2;
	}

	public function send() {
		if (isset($this->param1)) $this->BODY['param1'] = $this->param1;
		if (isset($this->param2)) $this->BODY['param2'] = $this->param2;

		$response = $this->_request();
		return $response;
	}

}