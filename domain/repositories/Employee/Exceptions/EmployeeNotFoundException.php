<?php

declare(strict_types=1);

namespace app\domain\repositories\Employee\Exceptions;

use LogicException;

class EmployeeNotFoundException extends LogicException {
	public function __construct() {
		parent::__construct('Employee not found.');
	}
}
