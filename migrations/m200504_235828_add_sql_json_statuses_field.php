<?php

use yii\db\Migration;

class m200504_235828_add_sql_json_statuses_field extends Migration {
	protected const TABLE_NAME  = 'sql_employees';
	protected const COLUMN_NAME = 'statuses';

	public function safeUp() {
		$this->addColumn(static::TABLE_NAME, static::COLUMN_NAME, 'JSON');
	}

	public function safeDown() {
		$this->dropColumn(static::TABLE_NAME, static::COLUMN_NAME);
	}
}
