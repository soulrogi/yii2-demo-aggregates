<?php

declare(strict_types=1);

namespace app\domain\entities;

use yii\db\ActiveRecordInterface;

trait InstantiateTrait {
	private static ?ActiveRecordInterface $instance  = null;
	private static ?ActiveRecordInterface $prototype = null;

	public static function instance($refresh = false): ActiveRecordInterface {
		if ($refresh || null === static::$prototype) {
			static::$instance = static::instantiate([]);
		}

		return static::$instance;
	}

	public static function instantiate($row): ActiveRecordInterface {
		if (null === static::$prototype) {
			$class = get_called_class();
			static::$prototype = unserialize(sprintf('O:%d:"%s":0:{}', strlen($class), $class));
		}

		$entity = clone static::$prototype;
		$entity->init();

		return $entity;
	}
}
