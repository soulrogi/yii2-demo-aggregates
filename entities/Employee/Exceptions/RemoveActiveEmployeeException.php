<?php

declare(strict_types=1);

namespace app\entities\Employee\Exceptions;

use app\entities\Employee\Employee;

class RemoveActiveEmployeeException extends \DomainException {
	public function __construct(Employee $employee) {
		parent::__construct('Unable to remove employee (' . $employee->getId()->getId() . ') because he is active');
	}
}
