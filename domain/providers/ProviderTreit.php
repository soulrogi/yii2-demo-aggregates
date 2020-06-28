<?php


namespace app\domain\providers;


trait ProviderTreit {
	/** @var mixed */
	public $payload;

	/** @var string[] */
	public array $errors = [];

	public function getPayload() {
		$payload = $this->payload;

		$this->payload = null;

		return $payload;
	}

	public function getErrors(): array {
		$errors       = $this->errors;
		$this->errors = [];

		return $errors;
	}
}
