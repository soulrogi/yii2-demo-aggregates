<?php

declare(strict_types=1);

namespace app\domain\services\Employee\dto;

class EmployeeCreateDto {
	public NameDto $name;
	public AddressDto $address;
	/** @var PhoneDto[] */
	public array $phones = [];
}
