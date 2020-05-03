<?php

namespace app\tests\unit\entities\Employee;

use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\ValueObjects\Address;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\entities\Employee\ValueObjects\Name;
use app\domain\entities\Employee\ValueObjects\Phone;
use DateTimeImmutable;

class EmployeeBuilder {
	private Id $id;

	private DateTimeImmutable $date;

	/** @var Phone[] */
	private array $phones;

	private Name $name;

	private Address $address;

	private bool $archived = false;

	public function __construct() {
		$this->id       = Id::next();
		$this->date     = new DateTimeImmutable;
		$this->name     = new Name('Pupkin', 'Vasvas', 'Bulkin');
		$this->address  = new Address('Россия', 'Липецкая обл.', 'г. Пушкин', 'ул. Ленина', 25);
		$this->phones[] = new Phone(7, '000', '00000000');
	}

	public function withId(Id $id): self {
		$clone     = clone $this;
		$clone->id = $id;

		return $clone;
	}

	public function withPhones(array $phones): self {
		$clone         = clone $this;
		$clone->phones = $phones;

		return $clone;
	}

	public function archived(): self {
		$clone           = clone $this;
		$clone->archived = true;

		return $clone;
	}

	public function build(): Employee {
		$employee = new Employee(
			$this->id,
			$this->date,
			$this->name,
			$this->address,
			$this->phones
		);

		if ($this->archived) {
			$employee->archive(new DateTimeImmutable);
		}

		return $employee;
	}
}
