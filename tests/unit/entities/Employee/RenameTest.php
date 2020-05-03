<?php

namespace app\tests\unit\entities\Employee;

use app\domain\entities\Employee\Events\EmployeeRenamed;
use app\domain\entities\Employee\ValueObjects\Name;
use Codeception\Test\Unit;

class RenameTest extends Unit {
	public function testSuccess(): void {
		$employee = (new EmployeeBuilder)->build();
		$employee->rename($name = new Name('New', 'Test', 'Name'));

		$this->assertEquals($name, $employee->getName());
		$this->assertNotEmpty($events = $employee->releaseEvents());
		$this->assertInstanceOf(EmployeeRenamed::class, end($events));
	}
}
