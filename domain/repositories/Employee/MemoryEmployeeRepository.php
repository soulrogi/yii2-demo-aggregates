<?php

declare(strict_types=1);

namespace app\domain\repositories\Employee;

use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\repositories\Employee\Exceptions\EmployeeNotFoundException;
use app\domain\repositories\EmployeeRepositoryInterface;

class MemoryEmployeeRepository implements EmployeeRepositoryInterface {
	private array $items = [];

	public function get(Id $id): Employee {
		if (false === isset($this->items[$id->getId()])) {
			throw new EmployeeNotFoundException;
		}

		return clone $this->items[$id->getId()];
	}

	public function add(Employee $employee): void {
		$this->items[$employee->getId()->getId()] = $employee;
	}

	public function save(Employee $employee): void {
		$this->items[$employee->getId()->getId()] = $employee;
	}

	public function remove(Employee $employee): void {
		if ($this->items[$employee->getId()->getId()]) {
			unset($this->items[$employee->getId()->getId()]);
		}
	}
}
