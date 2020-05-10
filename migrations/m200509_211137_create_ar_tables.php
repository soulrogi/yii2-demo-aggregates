<?php

declare(strict_types=1);

use yii\db\Migration;

class m200509_211137_create_ar_tables extends Migration {
	const EMPLOYEES_TABLE         = 'ar_employees';
	const EMPLOYEE_PHONES_TABLE   = 'ar_employee_phones';
	const EMPLOYEE_STATUSES_TABLE = 'ar_employee_statuses';

	const ATTR_EMPLOYEE_ID              = 'employee_id';
	const ATTR_EMPLOYEE_CREATE_DATE     = 'employee_create_date';
	const ATTR_EMPLOYEE_NAME_LAST       = 'employee_name_last';
	const ATTR_EMPLOYEE_NAME_FIRST      = 'employee_name_first';
	const ATTR_EMPLOYEE_NAME_MIDDLE     = 'employee_name_middle';
	const ATTR_EMPLOYEE_ADDRESS_COUNTRY = 'employee_address_country';
	const ATTR_EMPLOYEE_ADDRESS_REGION  = 'employee_address_region';
	const ATTR_EMPLOYEE_ADDRESS_CITY    = 'employee_address_city';
	const ATTR_EMPLOYEE_ADDRESS_STREET  = 'employee_address_street';
	const ATTR_EMPLOYEE_ADDRESS_HOUSE   = 'employee_address_house';
	const ATTR_EMPLOYEE_CURRENT_STATUS  = 'employee_current_status';

	const ATTR_PHONE_ID          = 'phone_id';
	const ATTR_PHONE_EMPLOYEE_ID = 'phone_employee_id';
	const ATTR_PHONE_COUNTRY     = 'phone_country';
	const ATTR_PHONE_CODE        = 'phone_code';
	const ATTR_PHONE_NUMBER      = 'phone_number';
	const PHONE_INDEX            = 'idx-' . self::EMPLOYEE_PHONES_TABLE . '-employee_id';
	const PHONE_FOREIGN_KEY      = 'fk-' . self::EMPLOYEE_PHONES_TABLE . '-employee';

	const ATTR_STATUS_ID          = 'status_id';
	const ATTR_STATUS_EMPLOYEE_ID = 'status_employee_id';
	const ATTR_STATUS_VALUE       = 'status_value';
	const ATTR_STATUS_DATE        = 'status_date';
	const STATUS_INDEX            = 'idx-' . self::EMPLOYEE_STATUSES_TABLE . '-employee_id';
	const STATUS_FOREIGN_KEY      = 'fk-' . self::EMPLOYEE_STATUSES_TABLE . '-employee';

	/**
	 * {@inheritdoc}
	 */
	public function safeUp() {
		$this->createTable(static::EMPLOYEES_TABLE, [
			static::ATTR_EMPLOYEE_ID              => $this->char(36)->notNull(),
			static::ATTR_EMPLOYEE_CREATE_DATE     => $this->dateTime(),
			static::ATTR_EMPLOYEE_NAME_LAST       => $this->string(),
			static::ATTR_EMPLOYEE_NAME_FIRST      => $this->string(),
			static::ATTR_EMPLOYEE_NAME_MIDDLE     => $this->string(),
			static::ATTR_EMPLOYEE_ADDRESS_COUNTRY => $this->string(),
			static::ATTR_EMPLOYEE_ADDRESS_REGION  => $this->string(),
			static::ATTR_EMPLOYEE_ADDRESS_CITY    => $this->string(),
			static::ATTR_EMPLOYEE_ADDRESS_STREET  => $this->string(),
			static::ATTR_EMPLOYEE_ADDRESS_HOUSE   => $this->string(),
			static::ATTR_EMPLOYEE_CURRENT_STATUS  => $this->string(16)->notNull(),
		]);
		$this->addPrimaryKey(
			'pk-' . static::EMPLOYEES_TABLE,
			static::EMPLOYEES_TABLE,
			static::ATTR_EMPLOYEE_ID
		);

		$this->createTable(static::EMPLOYEE_PHONES_TABLE, [
			static::ATTR_PHONE_ID          => $this->primaryKey(),
			static::ATTR_PHONE_EMPLOYEE_ID => $this->char(36)->notNull(),
			static::ATTR_PHONE_COUNTRY     => $this->integer()->notNull(),
			static::ATTR_PHONE_CODE        => $this->string()->notNull(),
			static::ATTR_PHONE_NUMBER      => $this->string()->notNull(),
		]);
		$this->createIndex(
			static::PHONE_INDEX,
			static::EMPLOYEE_PHONES_TABLE,
			static::ATTR_PHONE_EMPLOYEE_ID
		);
		$this->addForeignKey(
			static::PHONE_FOREIGN_KEY,
			static::EMPLOYEE_PHONES_TABLE,
			static::ATTR_PHONE_EMPLOYEE_ID,
			static::EMPLOYEES_TABLE,
			static::ATTR_EMPLOYEE_ID,
			'CASCADE',
			'RESTRICT'
		);

		$this->createTable(static::EMPLOYEE_STATUSES_TABLE, [
			static::ATTR_STATUS_ID          => $this->primaryKey(),
			static::ATTR_STATUS_EMPLOYEE_ID => $this->char(36)->notNull(),
			static::ATTR_STATUS_VALUE       => $this->string(32)->notNull(),
			static::ATTR_STATUS_DATE        => $this->dateTime()->notNull(),
		]);
		$this->createIndex(
			static::STATUS_INDEX,
			static::EMPLOYEE_STATUSES_TABLE,
			static::ATTR_STATUS_EMPLOYEE_ID
		);
		$this->addForeignKey(
			static::STATUS_FOREIGN_KEY,
			static::EMPLOYEE_STATUSES_TABLE,
			static::ATTR_STATUS_EMPLOYEE_ID,
			static::EMPLOYEES_TABLE,
			static::ATTR_EMPLOYEE_ID,
			'CASCADE',
			'RESTRICT'
		);
	}

	/**
	 * {@inheritdoc}
	 */
	public function safeDown() {
		$this->dropTable(static::EMPLOYEES_TABLE);
		$this->dropTable(static::EMPLOYEE_PHONES_TABLE);
		$this->dropTable(static::EMPLOYEE_STATUSES_TABLE);
	}
}
