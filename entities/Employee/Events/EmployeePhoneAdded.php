<?php

declare(strict_types=1);

namespace app\entities\Employee\Events;

use app\entities\Employee\ValueObjects\Id;
use app\entities\Employee\ValueObjects\Phone;

class EmployeePhoneAdded implements Event{
	/** @var Id  */
	protected $id;

	/** @var Phone  */
	protected $phone;

	public function __construct(Id $id, Phone $phone) {
		$this->id    = $id;
		$this->phone = $phone;
	}
}
