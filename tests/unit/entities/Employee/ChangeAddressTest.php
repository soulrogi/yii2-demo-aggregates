<?php

namespace app\tests\unit\entities\Employee;

use app\entities\Employee\Events\EmployeeAddressChanged;
use app\entities\Employee\ValueObjects\Address;
use Codeception\Test\Unit;

class ChangeAddressTest extends Unit {
	public function testSuccess(): void {
		$employee = (new EmployeeBuilder)->build();
		$employee->changeAddress($address = new Address('Россия', 'Липецкая обл.', 'г. Пушкин', 'ул. Ленина', 25));

		$this->assertEquals($address, $employee->getAddress());
		$this->assertNotEmpty($events = $employee->releaseEvents());
		$this->assertInstanceOf(EmployeeAddressChanged::class, end($events));
	}
}
