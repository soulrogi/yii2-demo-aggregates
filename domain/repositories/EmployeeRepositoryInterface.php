<?php

declare(strict_types=1);

namespace app\domain\repositories;

use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\ValueObjects\Id;

interface EmployeeRepositoryInterface {
	public function get(Id $id): Employee;

	public function add(Employee $employee): void;

	public function save(Employee $employee): void;

	public function remove(Employee $employee): void;
}
