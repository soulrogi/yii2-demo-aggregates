<?php

return [
	'class'    => 'yii\db\Connection',
//	'dsn'      => 'mysql:host=localhost;dbname=yii2basic',
	'dsn'      => 'pgsql:host=postgres;port=5432;dbname=db_name',
	'username' => 'db_user',
	'password' => 'db_pass',
	'charset'  => 'utf8',

	// Schema cache options (for production environment)
	//'enableSchemaCache' => true,
	//'schemaCacheDuration' => 60,
	//'schemaCache' => 'cache',
];
