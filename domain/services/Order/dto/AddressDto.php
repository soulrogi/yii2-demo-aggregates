<?php

declare(strict_types=1);

namespace app\domain\services\Employee\dto;

class AddressDto {
	public string $country;
	public string $region;
	public string $city;
	public string $street;
	public string $house;
}
