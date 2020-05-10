<?php

use yii\db\Migration;
use yii\db\Schema;

class m200509_232725_add_ar_json_statuses_field extends Migration {
	const EMPLOYEES_TABLE        = 'ar_employees';
	const ATTR_EMPLOYEE_STATUSES = 'employee_statuses';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->addColumn(
			static::EMPLOYEES_TABLE,
			static::ATTR_EMPLOYEE_STATUSES,
			Schema::TYPE_JSON
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropColumn(static::EMPLOYEES_TABLE, static::ATTR_EMPLOYEE_STATUSES);
	}
}
