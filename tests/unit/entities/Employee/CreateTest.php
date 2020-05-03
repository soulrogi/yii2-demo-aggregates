<?php

namespace app\tests\unit\entities\Employee;

use app\domain\entities\Employee\Employee;
use app\domain\entities\Employee\Exceptions\ContainAtLeastOnePhoneException;
use app\domain\entities\Employee\Exceptions\PhoneAlreadyExistsException;
use app\domain\entities\Employee\ValueObjects\Address;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\entities\Employee\ValueObjects\Name;
use app\domain\entities\Employee\ValueObjects\Phone;
use Codeception\Test\Unit;
use DateTimeImmutable;

class CreateTest extends Unit {
	public function testSuccess(): void {
		$employee = new Employee(
			$id = Id::next(),
			$date = new DateTimeImmutable,
			$name = new Name('Pupkin', 'Vasy', 'Petrovich'),
			$address = new Address('Россия', 'Липецкая обл.', 'г. Пушкин', 'ул. Ленина', 25),
			$phones = [
				new Phone('7','999','8888888'),
				new Phone('7','999','7777777'),
			]
		);

		$this->assertEquals($id, $employee->getId());
		$this->assertEquals($date, $employee->getCreateDate());
		$this->assertEquals($name, $employee->getName());
		$this->assertEquals($address, $employee->getAddress());
		$this->assertEquals($phones, $employee->getPhones());
	}

	public function testWithoutPhones(): void {
		$this->expectException(ContainAtLeastOnePhoneException::class);

		new Employee(
			Id::next(),
			new DateTimeImmutable,
			new Name('Pupkin', 'Vasy', 'Petrovich'),
			new Address('Россия', 'Липецкая обл.', 'г. Пушкин', 'ул. Ленина', 25),
			[]
		);
	}

	public function testWithSamePhoneNumbers(): void {
		$this->expectException(PhoneAlreadyExistsException::class);

		new Employee(
			Id::next(),
			new DateTimeImmutable,
			new Name('Pupkin', 'Vasy', 'Petrovich'),
			new Address('Россия', 'Липецкая обл.', 'г. Пушкин', 'ул. Ленина', 25),
			[
				new Phone('7','999','8888888'),
				new Phone('7','999','8888888'),
			]
		);
	}
}
