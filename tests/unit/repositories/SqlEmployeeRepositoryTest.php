<?php

declare(strict_types=1);

namespace app\tests\unit\repositories;

use app\domain\repositories\Hydrator;
use app\domain\yii2\repositories\Employee\SqlEmployeeRepository;
use app\tests\_fixtures\EmployeeFixture;
use app\tests\_fixtures\EmployeePhoneFixture;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use UnitTester;
use Yii;

class SqlEmployeeRepositoryTest extends BaseRepositoryTest {
	/** @var UnitTester */
	public UnitTester $tester;

	protected function _before() {
		$this->tester->haveFixtures([
			EmployeeFixture::NAME       => EmployeeFixture::class,
			EmployeePhoneFixture::NAME  => EmployeePhoneFixture::class,
		]);

		$this->repository = new SqlEmployeeRepository(
			Yii::$app->db,
			new Hydrator,
			new LazyLoadingValueHolderFactory
		);
	}
}
