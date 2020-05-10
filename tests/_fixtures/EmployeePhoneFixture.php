<?php

declare(strict_types=1);

namespace app\tests\_fixtures;

use yii\test\ActiveFixture;

class EmployeePhoneFixture extends ActiveFixture {
	const NAME = 'phones';

	public $tableName = 'sql_employee_phones';
	public $dataFile = '@app/tests/_fixtures/data/employees_phones.php';
}
