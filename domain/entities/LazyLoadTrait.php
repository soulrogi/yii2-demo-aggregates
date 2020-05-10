<?php

declare(strict_types=1);

namespace app\domain\entities;

use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use Yii;

trait LazyLoadTrait {
	public static function getLazyFactory(): LazyLoadingValueHolderFactory {
		return Yii::createObject(LazyLoadingValueHolderFactory::class);
	}
}
