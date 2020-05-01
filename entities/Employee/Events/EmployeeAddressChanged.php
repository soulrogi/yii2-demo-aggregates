<?php

declare(strict_types=1);

namespace app\entities\Employee\Events;

use app\entities\Employee\ValueObjects\Address;
use app\entities\Employee\ValueObjects\Id;

class EmployeeAddressChanged implements Event {
	/** @var Id */
	public $id;
	/** @var Address */
	public $address;

	public function __construct(
		Id $id,
		Address $address
	) {
		$this->id      = $id;
		$this->address = $address;
	}
}
