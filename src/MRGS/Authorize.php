<?php

namespace AKEB\MRGS;

class Authorize {
	private static $singleton;

	private $appId = 0;
	private $secret = '';

	private $accessToken;
	private $refreshToken;
	private $token_type;
	private $expires_in;
	private $scope;

	private $expireAccessToken = 0;
	private $expireRefreshToken = 0;

	private $accessTokenUrl = 'https://mrgs.my.games/oauth/token/';
	private $refreshTokenUrl = 'https://mrgs.my.games/oauth/token/';

	public function __construct(int $appId, string $secret) {
		if (!$appId) throw new Exception\AuthorizeException("AppId parameter is required", 400);
		if (!$secret) throw new Exception\AuthorizeException("secret parameter is required", 400);
		$this->appId = intval($appId);
		$this->secret = strval($secret);
		if (!\class_exists('\\AKEB\\CurlGet')) {
			throw new Exception\AuthorizeException("Class \AKEB\CurlGet is required", 500);
		}
		static::$singleton = $this;

	}

	public static function getInstance():self {
		if (self::$singleton === null) {
			throw new Exception\AuthorizeException("First call construct method!");
		}
		return self::$singleton;
	}

	public function authorize(bool $force=false):bool {
		if (!$force && $this->isAuthorized()) return true;
		$this->unauthorize();
		$POST = [
			'grant_type' => 'client_credentials',
			'client_id' => $this->appId,
			'client_secret' => $this->secret,
		];
		$HEADER = [
			'Content-Type: application/x-www-form-urlencoded'
		];
		$curl = new \AKEB\CurlGet($this->accessTokenUrl,[],$POST,$HEADER);
		$curl->timeout = 30;
		$curl->exec();
		if ($curl->responseCode !== 200) {
			throw new Exception\AuthorizeException(sprintf("Authorize error: [%d] %s",$curl->responseErrorNum,$curl->responseError), $curl->responseCode);
		}
		$response = $curl->responseBody;
		if (isset($response) && \is_string($response)) {
			$response = \json_decode($response, true);
		}
		if (!$response || !$response['access_token']) {
			throw new Exception\AuthorizeException(sprintf("Authorize error: %s",\json_encode($response)), $curl->responseCode);
		}
		$this->accessToken = strval($response['access_token']) ?? '';
		$this->token_type = strval($response['token_type']) ?? '';
		$this->expires_in = strval($response['expires_in']) ?? '';
		$this->refreshToken = strval($response['refresh_token']) ?? '';
		$this->scope = strval($response['scope']) ?? '';
		if ($this->expires_in < time()) {
			$this->expireAccessToken = time() + $this->expires_in - 10;
		} else {
			$this->expireAccessToken = $this->expires_in;
		}
		$this->expireRefreshToken = time() + 86400 - 10;
		return $this->accessToken ? true : false;
	}

	public function unauthorize() {
		$this->accessToken = '';
		$this->expireAccessToken = 0;
		$this->refreshToken = '';
		$this->token_type = '';
		$this->scope = '';
		$this->expires_in = 0;
		$this->expireRefreshToken = 0;
	}

	public function isAuthorized():bool {
		if ($this->expireAccessToken > time()+10 && $this->accessToken) return true;
		return false;
	}

	public function setAccessTokenUrl(string $accessTokenUrl) {
		$accessTokenUrl = strval(trim($accessTokenUrl));
		if (!$accessTokenUrl) throw new Exception\AuthorizeException("accessTokenUrl parameter is required", 400);
		$this->accessTokenUrl = $accessTokenUrl;
	}

	public function setRefreshTokenUrl(string $refreshTokenUrl) {
		$refreshTokenUrl = strval(trim($refreshTokenUrl));
		if (!$refreshTokenUrl) throw new Exception\AuthorizeException("refreshTokenUrl parameter is required", 400);
		$this->refreshTokenUrl = $refreshTokenUrl;
	}

	public function getAccessToken(): string {
		if (!$this->isAuthorized()) return '';
		return $this->accessToken;
	}

	public function getRefreshToken():string {
		if ($this->expireRefreshToken < time() || !$this->refreshToken) return '';
		return $this->refreshToken;
	}

	public function getScope() {
		return $this->scope;
	}

	public function getTokenType():string {
		return \ucfirst($this->token_type);
	}

	public function getAppId():int {
		return intval($this->appId);
	}

	public function __destruct() {

	}

}