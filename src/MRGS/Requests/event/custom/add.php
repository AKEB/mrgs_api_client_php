<?php

namespace AKEB\MRGS\Requests\event\custom;

class add extends \AKEB\MRGS\Request {
	protected $path = 'event/custom/add/';
	protected $scopes = ['server', 'client'];

	protected $events;

	public function __construct(array $BODY=[]) {
		if ($BODY) {
			$this->BODY = $BODY;
		}
	}

	public function setEvent(array $event) {
		$this->events[] = $event;
	}

	public function send() {
		if (isset($this->events)) {
			foreach($this->events as $event) {
				$this->BODY[] = $event;
			}

		}

		$response = $this->_request();
		return $response;
	}

}