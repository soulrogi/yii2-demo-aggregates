<?php

declare(strict_types=1);

namespace app\forms;

use app\domain\services\Employee\dto\AddressDto;
use app\domain\services\Employee\dto\EmployeeCreateDto;
use app\domain\services\Employee\dto\NameDto;
use app\domain\services\Employee\dto\PhoneDto;
use yii\base\Model;

class EmployeeCreateForm extends Model {
	public function getDto(): EmployeeCreateDto {
		$faker = \Faker\Factory::create();

		$dto = new EmployeeCreateDto;

		$dto->name         = new NameDto;
		$dto->name->middle = $faker->name;
		$dto->name->first  = $faker->firstName;
		$dto->name->last   = $faker->lastName;

		$dto->address          = new AddressDto;
		$dto->address->country = $faker->country;
		$dto->address->region  = $faker->state;
		$dto->address->city    = $faker->city;
		$dto->address->street  = $faker->streetName;
		$dto->address->house   = (string) $faker->randomNumber();

		$phone          = new PhoneDto;
		$phone->country = (int) $faker->numerify('#');
		$phone->code    = $faker->numerify('###');
		$phone->number  = $faker->numerify('#######');
		$dto->phones    = [$phone];

		return $dto;
	}
}
