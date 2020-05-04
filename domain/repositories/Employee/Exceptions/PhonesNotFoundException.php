<?php

declare(strict_types=1);

namespace app\domain\repositories\Employee\Exceptions;

use LogicException;

class PhonesNotFoundException extends LogicException {
	public function __construct() {
		parent::__construct('Phones not found.');
	}
}
