<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\Events;

use app\domain\entities\Employee\ValueObjects\Id;

class EmployeeRemoved implements Event {
	/** @var Id */
	public $id;

	public function __construct(Id $id) {
		$this->id = $id;
	}
}
