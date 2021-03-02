<?php

namespace AKEB\MRGS\Requests\payments;

class exchangeRate extends \AKEB\MRGS\Request {
	protected $path = 'payments/exchangeRate/';
	protected $scopes = ['server', 'client'];

	public $date;
	public $source;

	const OPENEXCHANGE = 'OPENEXCHANGE';
	const CBRF = 'CBRF';
	const CURRATE = 'CURRATE';
	const OANDA = 'OANDA';

	public function __construct() {

	}

	public function setDate($date) {
		if (\is_numeric($date)) {
			$date = date('Y-m-d', $date);
		} elseif (strpos($date, '-') === false) {
			throw new \AKEB\MRGS\Exception\RequestException("Error: Invalid date format. Must be YYYY-MM-DD", 400);
		}
		$this->date = $date;
	}

	public function setSource($source) {
		$reflection = new \ReflectionClass(static::class);
		if ($source && !$reflection->getConstant($source)) {
			throw new \AKEB\MRGS\Exception\RequestException("Error: Incorrect value. There must be one of {'', 'CBRF', 'OPENEXCHANGE', 'CURRATE', 'OANDA'}", 400);
		}
		$this->source = $source;
	}

	public function send() {
		if (!$this->date) {
			throw new \AKEB\MRGS\Exception\RequestException("Error: Date is required", 400);
		}
		if (isset($this->date)) $this->GET['date'] = $this->date;
		if (isset($this->source)) $this->GET['source'] = $this->source;

		$response = $this->_request();
		return $response;
	}

}