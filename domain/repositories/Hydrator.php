<?php

declare(strict_types=1);

namespace app\domain\repositories;

use ReflectionClass;

class Hydrator {
	protected array $reflectionClassMap = [];

	public function hydrate(string $class, array $fields): object {
		$reflection = $this->getReflectionClass($class);
		$target     = $reflection->newInstanceWithoutConstructor();

		foreach ($fields as $field => $value) {
 			$property = $reflection->getProperty($field);
			if ($property->isPrivate() || $property->isProtected()) {
				$property->setAccessible(true);
			}

			$property->setValue($target, $value);
		}

		return $target;
	}

	public function extract($object, array $fields): array {
		$result     = [];
		$reflection = $this->getReflectionClass(get_class($object));
		foreach($fields as $field) {
			$property = $reflection->getProperty($field);
			if ($property->isPrivate() || $property->isProtected()) {
				$property->setAccessible(true);
			}
			$result[$property->getName()] = $property->getValue($object);
		}

		return $result;
	}

	protected function getReflectionClass(string $class): ReflectionClass {
		if (false === isset($this->reflectionClassMap[$class])) {
			$this->reflectionClassMap[$class] = new ReflectionClass($class);
		}

		return $this->reflectionClassMap[$class];
	}
}
