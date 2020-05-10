<?php

declare(strict_types=1);

namespace app\domain\entities\Employee\ValueObjects;

use app\domain\entities\InstantiateTrait;
use Assert\Assertion;
use yii\db\ActiveRecord;

class Phone extends ActiveRecord {
	use InstantiateTrait;

	const ATTR_PHONE_ID          = 'phone_id';
	const ATTR_PHONE_EMPLOYEE_ID = 'phone_employee_id';
	const ATTR_PHONE_COUNTRY     = 'phone_country';
	const ATTR_PHONE_CODE        = 'phone_code';
	const ATTR_PHONE_NUMBER      = 'phone_number';

	protected int $country;
	protected string $code;
	protected string $number;

	public function __construct(
		int $country,
		string $code,
		string $number
	) {
		Assertion::notEmpty($country);
		Assertion::notEmpty($code);
		Assertion::notEmpty($number);

		$this->country = $country;
		$this->code    = $code;
		$this->number  = $number;

		parent::__construct();
	}

	//region ######## INFRASTRUCTURE #########
	public static function tableName(): string {
		return 'ar_employee_phones';
	}

	public function afterFind(): void {
		$this->country = (int) $this->getAttribute(static::ATTR_PHONE_COUNTRY);
		$this->code    = (string) $this->getAttribute(static::ATTR_PHONE_CODE);
		$this->number  = (string) $this->getAttribute(static::ATTR_PHONE_NUMBER);

		parent::afterFind();
	}

	public function beforeSave($insert): bool {
		$this->setAttribute(static::ATTR_PHONE_COUNTRY, $this->country);
		$this->setAttribute(static::ATTR_PHONE_CODE, $this->code);
		$this->setAttribute(static::ATTR_PHONE_NUMBER, $this->number);

		return parent::beforeSave($insert);
	}
	//endregion

	public function isEqualTo(self $phone): bool {
		return ($this->getFull() === $phone->getFull());
	}

	public function getFull(): string {
		return trim('+' . $this->country . ' (' . $this->code . ') ' . $this->number);
	}

	public function getCountry(): int {
		return $this->country;
	}

	public function getCode(): string {
		return $this->code;
	}

	public function getNumber(): string {
		return $this->number;
	}
}
