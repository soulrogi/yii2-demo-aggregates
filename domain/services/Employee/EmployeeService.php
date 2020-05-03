<?php

declare(strict_types=1);

namespace app\domain\services\Employee;

use app\domain\dispatchers\EventDispatcherInterface;
use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\ValueObjects\Address;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\entities\Employee\ValueObjects\Name;
use app\domain\entities\Employee\ValueObjects\Phone;
use app\domain\repositories\EmployeeRepositoryInterface;
use app\domain\services\Employee\dto\AddressDto;
use app\domain\services\Employee\dto\EmployeeArchiveDto;
use app\domain\services\Employee\dto\EmployeeCreateDto;
use app\domain\services\Employee\dto\EmployeeReinstateDto;
use app\domain\services\Employee\dto\NameDto;
use app\domain\services\Employee\dto\PhoneDto;
use DateTimeImmutable;

/**
 * Здесь сервис не особо большой и его действия совпадают с методами сущности.
 * Но могут быть и сервисы, оперирующие несколькими агрегатами.
 * Например, метод отправки этого сотрудника в командировку может не только
 * модифицировать сущность сотрудника, но и одновременно создавать сущность приказа
 * и заполнять сущность командировочного листа.
 *
 */
class EmployeeService {
	protected EmployeeRepositoryInterface $repository;
	protected EventDispatcherInterface    $dispatcher;

	public function __construct(
		EmployeeRepositoryInterface $repository,
		EventDispatcherInterface $dispatcher
	) {
		$this->repository = $repository;
		$this->dispatcher = $dispatcher;
	}

	public function create(EmployeeCreateDto $dto): void {
		$employee = new Employee(
			Id::next(),
			new DateTimeImmutable,
			new Name(
				$dto->name->last,
				$dto->name->first,
				$dto->name->middle
			),
			new Address(
				$dto->address->country,
				$dto->address->region,
				$dto->address->city,
				$dto->address->street,
				$dto->address->house
			),
			array_map(
				static function (PhoneDto $phone): Phone {
					return new Phone(
						$phone->country,
						$phone->code,
						$phone->number
					);
				},
				$dto->phones
			)
		);
		$this->repository->add($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}

	public function rename(Id $id, NameDto $dto): void {
		$employee = $this->repository->get($id);
		$employee->rename(new Name(
				$dto->last,
				$dto->first,
				$dto->middle
		));
		$this->repository->save($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}

	public function changeAddress(Id $id, AddressDto $dto): void {
		$employee = $this->repository->get($id);
		$employee->changeAddress(new Address(
			$dto->country,
			$dto->region,
			$dto->city,
			$dto->street,
			$dto->house
		));
		$this->repository->save($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}

	public function addPhone(Id $id, PhoneDto $dto): void {
		$employee = $this->repository->get($id);
		$employee->addPhone(new Phone(
			$dto->country,
			$dto->code,
			$dto->number
		));
		$this->repository->save($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}

	public function removePhone(Id $id, int $index): void {
		$employee = $this->repository->get($id);
		$employee->removePhone($index);
		$this->repository->save($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}

	public function archive(Id $id, EmployeeArchiveDto $dto): void {
		$employee = $this->repository->get($id);
		$employee->archive($dto->date);
		$this->repository->save($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}

	public function reinstate(Id $id, EmployeeReinstateDto $dto): void {
		$employee = $this->repository->get($id);
		$employee->reinstate($dto->date);
		$this->repository->save($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}

	public function remove(Id $id): void {
		$employee = $this->repository->get($id);
		$employee->remove();
		$this->repository->save($employee);
		$this->dispatcher->dispatch($employee->releaseEvents());
	}
}
