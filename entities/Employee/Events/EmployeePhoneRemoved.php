<?php

declare(strict_types=1);

namespace app\entities\Employee\Events;

use app\entities\Employee\ValueObjects\Id;
use app\entities\Employee\ValueObjects\Phone;

class EmployeePhoneRemoved implements Event {
	/** @var Id */
	public $id;

	/** @var Phone */
	public $phone;

	public function __construct(
		Id $id,
		Phone $phone
	) {
		$this->id    = $id;
		$this->phone = $phone;
	}
}
