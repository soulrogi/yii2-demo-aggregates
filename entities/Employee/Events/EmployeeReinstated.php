<?php

declare(strict_types=1);

namespace app\entities\Employee\Events;

use app\entities\Employee\ValueObjects\Id;
use DateTimeImmutable;

class EmployeeReinstated implements Event {
	/** @var Id */
	public $id;

	/** @var DateTimeImmutable */
	public $date;

	public function __construct(
		Id $id,
		DateTimeImmutable $date
	) {
		$this->id   = $id;
		$this->date = $date;
	}
}
