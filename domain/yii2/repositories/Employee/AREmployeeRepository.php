<?php

declare(strict_types=1);

namespace app\domain\yii2\repositories\Employee;

use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\repositories\Employee\Exceptions\EmployeeNotFoundException;
use app\domain\repositories\EmployeeRepositoryInterface;
use RuntimeException;

class AREmployeeRepository implements EmployeeRepositoryInterface {
	public function get(Id $id): Employee {
		$employee = Employee::findOne($id->getId());
		if (null === $employee) {
			throw new EmployeeNotFoundException;
		}

		return $employee;
	}

	public function add(Employee $employee): void {
		if (false === $employee->insert()) {
			throw new RuntimeException('Adding error.');
		}
	}

	public function save(Employee $employee): void {
		if (false === $employee->update()) {
			throw new RuntimeException('Saving error.');
		}
	}

	public function remove(Employee $employee): void {
		if (false === $employee->delete()) {
			throw new RuntimeException('Remove error.');
		}
	}
}
