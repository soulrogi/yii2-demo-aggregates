<?php
$db = require __DIR__ . '/db.php';
// test database! Important not to run tests on production or development databases
$db['dsn']      = 'pgsql:host=postgres;port=5432;dbname=db_name_tests';
$db['username'] = 'db_user';
$db['password'] = 'db_pass';

return $db;
