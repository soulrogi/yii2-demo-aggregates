<?php

declare(strict_types=1);

namespace app\domain\infrastructure\yii2\helper;

class ResponseDto {
	public bool $result = false;

	/** @var mixed */
	public $payload;

	/** @var string[] */
	public array $errors = [];
}
