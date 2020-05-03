<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\Events;

use app\domain\entities\Employee\ValueObjects\Id;
use DateTimeImmutable;

class EmployeeArchived implements Event {
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
