<?php

declare(strict_types=1);

namespace app\forms;

use app\domain\services\Employee\dto\AddressDto;
use app\domain\services\Employee\dto\EmployeeCreateDto;
use app\domain\services\Employee\dto\NameDto;
use yii\base\Model;

class EmployeeCreateForm extends Model {
	public function getDto(): EmployeeCreateDto {
		$dto          = new EmployeeCreateDto;
		$dto->name    = new NameDto;
		$dto->address = new AddressDto;

		return $dto;
	}
}
