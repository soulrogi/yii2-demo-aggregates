<?php

declare(strict_types=1);

namespace app\tests\unit\repositories;

use app\domain\yii2\repositories\Employee\AREmployeeRepository;
use app\tests\_fixtures\EmployeeFixture;
use app\tests\_fixtures\EmployeePhoneFixture;
use app\tests\_fixtures\EmployeeStatusFixture;
use UnitTester;

class EmployeeRepositoryTest extends BaseRepositoryTest {
	/** @var UnitTester */
	public UnitTester $tester;

	protected function _before() {
		$this->tester->haveFixtures([
			EmployeeFixture::NAME       => EmployeeFixture::class,
			EmployeePhoneFixture::NAME  => EmployeePhoneFixture::class,
			EmployeeStatusFixture::NAME => EmployeeStatusFixture::class,
		]);

		$this->repository = new AREmployeeRepository;
	}
}
