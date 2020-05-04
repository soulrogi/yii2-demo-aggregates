<?php

use yii\db\Migration;

class m200503_115044_create_sql_tables extends Migration {
	protected const TABLE_EMPLOYEES         = 'sql_employees';
	protected const TABLE_EMPLOYEE_PHONES   = 'sql_employee_phones';
	protected const TABLE_EMPLOYEE_STATUSES = 'sql_employee_statuses';

	public function safeUp() {
		$this->createTable(static::TABLE_EMPLOYEES, [
			'id'              => $this->char(36)->notNull(),
			'create_date'     => $this->dateTime(),
			'name_last'       => $this->string(),
			'name_first'      => $this->string(),
			'name_middle'     => $this->string(),
			'address_country' => $this->string(),
			'address_region'  => $this->string(),
			'address_city'    => $this->string(),
			'address_street'  => $this->string(),
			'address_house'   => $this->string(),
			'current_status'  => $this->string(16)->notNull(),
		]);
		$this->addPrimaryKey('pk-' . static::TABLE_EMPLOYEES, static::TABLE_EMPLOYEES, 'id');

		$this->createTable(static::TABLE_EMPLOYEE_PHONES, [
			'id'          => $this->primaryKey(),
			'employee_id' => $this->char(36)->notNull(),
			'country'     => $this->integer()->notNull(),
			'code'        => $this->string()->notNull(),
			'number'      => $this->string()->notNull(),
		]);
		$this->createIndex(
			'idx-' . static::TABLE_EMPLOYEE_PHONES . '-employee_id',
			static::TABLE_EMPLOYEE_PHONES,
			'employee_id'
		);
		$this->addForeignKey(
			'fk-' . static::TABLE_EMPLOYEE_PHONES . '-employee_id',
			static::TABLE_EMPLOYEE_PHONES,
			'employee_id',
			static::TABLE_EMPLOYEES,
			'id',
			'CASCADE',
			'RESTRICT'
		);

		$this->createTable(static::TABLE_EMPLOYEE_STATUSES, [
			'id'          => $this->primaryKey(),
			'employee_id' => $this->char(36)->notNull(),
			'value'       => $this->string(32)->notNull(),
			'date'        => $this->dateTime()->notNull(),
		]);
		$this->createIndex(
			'idx-' . static::TABLE_EMPLOYEE_STATUSES . '-employee_id',
			static::TABLE_EMPLOYEE_STATUSES,
			'employee_id'
		);
		$this->addForeignKey(
			'fk-' . static::TABLE_EMPLOYEE_STATUSES . '-employee_id',
			static::TABLE_EMPLOYEE_STATUSES,
			'employee_id',
			static::TABLE_EMPLOYEES,
			'id',
			'CASCADE',
			'RESTRICT'
		);
	}

	public function safeDown() {
		$this->dropTable(static::TABLE_EMPLOYEES);
		$this->dropTable(static::TABLE_EMPLOYEE_PHONES);
		$this->dropTable(static::TABLE_EMPLOYEE_STATUSES);
	}
}
