<?php

namespace AKEB\MRGS\Requests\test;

class async extends \AKEB\MRGS\Request {
	protected $path = 'test/async/';
	protected $scopes = ['server', 'client'];

	public $param1;
	public $param2;

	public function __construct(array $POST=[]) {
		if ($POST) {
			$this->POST = $POST;
		}
	}

	public function setParam1($param1) {
		$this->param1 = $param1;
	}

	public function setParam2($param2) {
		$this->param2 = $param2;
	}

	public function send() {
		if (isset($this->param1)) $this->POST['param1'] = $this->param1;
		if (isset($this->param2)) $this->POST['param2'] = $this->param2;

		$response = $this->_request();
		return $response;
	}

}