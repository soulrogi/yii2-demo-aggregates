<?php

declare(strict_types=1);

namespace app\entities\Employee\Exceptions;

use app\entities\Employee\ValueObjects\Phone;
use DomainException;

class PhoneAlreadyExistsException extends DomainException {
	public function __construct(Phone $phone) {
		parent::__construct('Phone ' . $phone->getFull() . ' already exists.');
	}
}
