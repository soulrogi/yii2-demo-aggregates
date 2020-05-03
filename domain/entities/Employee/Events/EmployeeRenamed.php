<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\Events;

use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\entities\Employee\ValueObjects\Name;

class EmployeeRenamed implements Event {
	/** @var Id */
	public $id;

	/** @var Name */
	public $name;

	public function __construct(
		Id $id,
		Name $name
	) {
		$this->id   = $id;
		$this->name = $name;
	}
}
