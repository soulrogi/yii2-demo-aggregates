<?php

declare(strict_types=1);

namespace app\entities\Employee;

use app\entities\AggregateRoot;
use app\entities\Employee\Events\EmployeeAddressChanged;
use app\entities\Employee\Events\EmployeeArchived;
use app\entities\Employee\Events\EmployeeCreated;
use app\entities\Employee\Events\EmployeePhoneAdded;
use app\entities\Employee\Events\EmployeePhoneRemoved;
use app\entities\Employee\Events\EmployeeReinstated;
use app\entities\Employee\Events\EmployeeRemoved;
use app\entities\Employee\Events\EmployeeRenamed;
use app\entities\Employee\Exceptions\RemoveActiveEmployeeException;
use app\entities\Employee\ValueObjects\Address;
use app\entities\Employee\ValueObjects\Id;
use app\entities\Employee\ValueObjects\Name;
use app\entities\Employee\ValueObjects\Phone;
use app\entities\Employee\ValueObjects\Phones;
use app\entities\Employee\ValueObjects\Status;
use app\entities\EventTrait;
use DateTimeImmutable;
use DomainException;

class Employee implements AggregateRoot {
	use EventTrait;

	//region -- Private properties
	private ID $id;
	private Name $name;
	private Address $address;
	private Phones $phones;
	private DateTimeImmutable $createDate;
	/** @var Status[] */
	private array $statuses = [];
	//endregion

	//region -- Public methods
	public function __construct(
		Id $id,
		DateTimeImmutable $createDate,
		Name $name,
		Address $address,
		array $phones
	) {
		$this->id         = $id;
		$this->name       = $name;
		$this->address    = $address;
		$this->createDate = $createDate;
		$this->phones     = new Phones($phones);

		$this->addStatus(Status::ACTIVE, $createDate);

		$this->recordEvent(new EmployeeCreated($this->id));
	}

	public function rename(Name $name): void {
		$this->name = $name;
		$this->recordEvent(new EmployeeRenamed($this->id, $name));
	}

	public function changeAddress(Address $address): void {
		$this->address = $address;
		$this->recordEvent(new EmployeeAddressChanged($this->id, $address));
	}

	public function addPhone(Phone $phone): void {
		$this->phones->add($phone);
		$this->recordEvent(new EmployeePhoneAdded($this->id, $phone));
	}

	public function removePhone(int $index): void {
		$phone = $this->phones->remove($index);
		$this->recordEvent(new EmployeePhoneRemoved($this->id, $phone));
	}

	public function archive(DateTimeImmutable $date): void {
		if ($this->isArchived()) {
			throw new DomainException('Employee is already archived.');
		}

		$this->addStatus(Status::ARCHIVED, $date);
		$this->recordEvent(new EmployeeArchived($this->id, $date));
	}

	public function reinstate(DateTimeImmutable $date): void {
		if (false === $this->isArchived()) {
			throw new DomainException('Employee is not archived.');
		}

		$this->addStatus(Status::ACTIVE, $date);
		$this->recordEvent(new EmployeeReinstated($this->id, $date));
	}

	public function remove(): void {
		if ($this->isActive()) {
			throw new RemoveActiveEmployeeException($this);
		}

		$this->recordEvent(new EmployeeRemoved($this->id));
	}

	public function isActive(): bool {
		return $this->getCurrentStatus()->isActive();
	}

	public function isArchived(): bool {
		return $this->getCurrentStatus()->isArchived();
	}

	public function getId(): Id {
		return $this->id;
	}

	public function getName(): Name {
		return $this->name;
	}

	public function getAddress(): Address {
		return $this->address;
	}

	public function getPhones(): array {
		return $this->phones->getAll();
	}

	public function getCreateDate(): DateTimeImmutable {
		return $this->createDate;
	}

	public function getStatuses(): array {
		return $this->statuses;
	}
	//endregion

	//region -- Private methods
	private function addStatus($value, DateTimeImmutable $date): void {
		$this->statuses[] = new Status($value, $date);
	}

	private function getCurrentStatus(): Status {
		return end($this->statuses);
	}
	//endregion
}
