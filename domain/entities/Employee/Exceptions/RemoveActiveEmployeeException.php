<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\Exceptions;

use app\domain\entities\Employee\Employee;

class RemoveActiveEmployeeException extends \DomainException {
	public function __construct(Employee $employee) {
		parent::__construct('Unable to remove employee (' . $employee->getId()->getId() . ') because he is active');
	}
}
