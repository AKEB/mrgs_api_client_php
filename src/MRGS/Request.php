<?php

namespace AKEB\MRGS;

abstract class Request {
	protected $path = '';
	protected $scopes = ['client', 'server'];

	protected $POST = [];
	protected $GET = [];
	protected $HEADER = [];

	protected $baseUrl = 'https://mrgs-api.my.games/api/';


	protected function _request() {
		$auth = \AKEB\MRGS\Authorize::getInstance();
		if (!$auth || !$auth->isAuthorized()) throw new Exception\RequestException("Authorize first need!", 405);
		if (!$auth->getAppId()) throw new Exception\RequestException("Authorize first need!", 405);

		if ( !in_array( $auth->getScope(), $this->scopes) ) throw new Exception\RequestException("Forbidden", 403);

		$url = $this->baseUrl . ( $auth->getAppId() ) . '/' . ( $this->path );
		$this->HEADER[] = 'Authorization: ' . ( $auth->getTokenType() ) . ' ' . ( $auth->getAccessToken() );
		$curl = new \AKEB\CurlGet($url, $this->GET, $this->POST, $this->HEADER);
		$curl->timeout = 30;
		$curl->exec();

		$response = [];
		if ($curl->responseBody) {
			$response = \json_decode($curl->responseBody, true);
		}
		if ($curl->responseCode != 200) {
			throw new Exception\RequestException(sprintf("Error: %s", $response['error'] ?? $curl->responseError), $curl->responseCode);
		}
		return $response;
	}

}