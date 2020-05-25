<?php

declare(strict_types=1);

namespace app\domain\services\Employee\dto;

class PhoneDto {
	public int    $country;
	public string $code;
	public string $number;
}
