<?php

namespace app\domain\entities\Employee\ValueObjects;

use app\domain\entities\Employee\Exceptions\ContainAtLeastOnePhoneException;
use app\domain\entities\Employee\Exceptions\PhoneAlreadyExistsException;
use DomainException;

class Phones {
	protected array $phones = [];

	public function __construct(array $phones) {
		if ([] === $phones) {
			throw new ContainAtLeastOnePhoneException();
		}

		foreach ($phones as $phone) {
			$this->add($phone);
		}
	}

	public function add(Phone $phone): void {
		foreach ($this->phones as $current) {
			if ($current->isEqualTo($phone)) {
				throw new PhoneAlreadyExistsException($phone);
			}
		}

		$this->phones[] = $phone;
	}

	public function remove(int $index): Phone {
		if (false === isset($this->phones[$index])) {
			throw new DomainException('Phone is not found.');
		}

		if (1 === count($this->phones)) {
			throw new DomainException('Cannot remove the last phone');
		}

		$phone = $this->phones[$index];
		unset($this->phones[$index]);

		return $phone;
	}

	public function getAll(): array {
		return $this->phones;
	}
}
