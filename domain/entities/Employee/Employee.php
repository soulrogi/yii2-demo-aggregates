<?php

declare(strict_types=1);

namespace app\domain\entities\Employee;

use app\domain\entities\AggregateRoot;
use app\domain\entities\Employee\Events\EmployeeAddressChanged;
use app\domain\entities\Employee\Events\EmployeeArchived;
use app\domain\entities\Employee\Events\EmployeeCreated;
use app\domain\entities\Employee\Events\EmployeePhoneAdded;
use app\domain\entities\Employee\Events\EmployeePhoneRemoved;
use app\domain\entities\Employee\Events\EmployeeReinstated;
use app\domain\entities\Employee\Events\EmployeeRemoved;
use app\domain\entities\Employee\Events\EmployeeRenamed;
use app\domain\entities\Employee\Exceptions\RemoveActiveEmployeeException;
use app\domain\entities\Employee\ValueObjects\Address;
use app\domain\entities\Employee\ValueObjects\Id;
use app\domain\entities\Employee\ValueObjects\Name;
use app\domain\entities\Employee\ValueObjects\Phone;
use app\domain\entities\Employee\ValueObjects\Phones;
use app\domain\entities\Employee\ValueObjects\Status;
use app\domain\entities\EventTrait;
use app\domain\entities\InstantiateTrait;
use app\domain\entities\LazyLoadTrait;
use DateTimeImmutable;
use DomainException;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use ProxyManager\Proxy\LazyLoadingInterface;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Cущность-агрегат предметной области Employee
 * со своей собственной бизнес-логикой
 * для описания объектов сотрудников
 */
class Employee extends ActiveRecord implements AggregateRoot {
	use EventTrait, InstantiateTrait, LazyLoadTrait;

	//region -- ActiveRecord attributes
	const ATTR_EMPLOYEE_ID              = 'employee_id';
	const ATTR_EMPLOYEE_NAME_LAST       = 'employee_name_last';
	const ATTR_EMPLOYEE_NAME_FIRST      = 'employee_name_first';
	const ATTR_EMPLOYEE_NAME_MIDDLE     = 'employee_name_middle';
	const ATTR_EMPLOYEE_ADDRESS_COUNTRY = 'employee_address_country';
	const ATTR_EMPLOYEE_ADDRESS_REGION  = 'employee_address_region';
	const ATTR_EMPLOYEE_ADDRESS_CITY    = 'employee_address_city';
	const ATTR_EMPLOYEE_ADDRESS_STREET  = 'employee_address_street';
	const ATTR_EMPLOYEE_ADDRESS_HOUSE   = 'employee_address_house';
	const ATTR_EMPLOYEE_CREATE_DATE     = 'employee_create_date';
	const ATTR_EMPLOYEE_CURRENT_STATUS  = 'employee_current_status';
	const ATTR_EMPLOYEE_STATUSES        = 'employee_statuses';
	//endregion

	//region -- Private properties
	private ID $id;
	private Name $name;
	private Address $address;
	private Phones $phones;
	private DateTimeImmutable $createDate;
	/** @var Status[] */
	private array $statuses = [];
	//endregion

	//region -- Public methods
	public function __construct(
		Id $id,
		DateTimeImmutable $createDate,
		Name $name,
		Address $address,
		array $phones
	) {
		$this->id         = $id;
		$this->name       = $name;
		$this->address    = $address;
		$this->createDate = $createDate;
		$this->phones     = new Phones($phones);

		$this->addStatus(Status::ACTIVE, $createDate);

		$this->recordEvent(new EmployeeCreated($this->id));

		parent::__construct();
	}

	public function rename(Name $name): void {
		$this->name = $name;
		$this->recordEvent(new EmployeeRenamed($this->id, $name));
	}

	public function changeAddress(Address $address): void {
		$this->address = $address;
		$this->recordEvent(new EmployeeAddressChanged($this->id, $address));
	}

	public function addPhone(Phone $phone): void {
		$this->phones->add($phone);
		$this->recordEvent(new EmployeePhoneAdded($this->id, $phone));
	}

	public function removePhone(int $index): void {
		$phone = $this->phones->remove($index);
		$this->recordEvent(new EmployeePhoneRemoved($this->id, $phone));
	}

	public function archive(DateTimeImmutable $date): void {
		if ($this->isArchived()) {
			throw new DomainException('Employee is already archived.');
		}

		$this->addStatus(Status::ARCHIVED, $date);
		$this->recordEvent(new EmployeeArchived($this->id, $date));
	}

	public function reinstate(DateTimeImmutable $date): void {
		if (false === $this->isArchived()) {
			throw new DomainException('Employee is not archived.');
		}

		$this->addStatus(Status::ACTIVE, $date);
		$this->recordEvent(new EmployeeReinstated($this->id, $date));
	}

	public function remove(): void {
		if ($this->isActive()) {
			throw new RemoveActiveEmployeeException($this);
		}

		$this->recordEvent(new EmployeeRemoved($this->id));
	}

	public function isActive(): bool {
		return $this->getCurrentStatus()->isActive();
	}

	public function isArchived(): bool {
		return $this->getCurrentStatus()->isArchived();
	}

	public function getId(): Id {
		return $this->id;
	}

	public function getName(): Name {
		return $this->name;
	}

	public function getAddress(): Address {
		return $this->address;
	}

	public function getPhones(): array {
		return $this->phones->getAll();
	}

	public function getCreateDate(): DateTimeImmutable {
		return $this->createDate;
	}

	public function getStatuses(): array {
		return $this->statuses;
	}
	//endregion

	//region -- Private methods
	private function addStatus($value, DateTimeImmutable $date): void {
		$this->statuses[] = new Status($value, $date);
	}

	private function getCurrentStatus(): Status {
		return end($this->statuses);
	}
	//endregion

	//region ######## INFRASTRUCTURE #########
	public static function tableName(): string {
		return 'ar_employees';
	}

	public function behaviors(): array {
		return [[
			        'class'     => SaveRelationsBehavior::class,
			        'relations' => [
				        static::RELATION_PHONES,
				        static::RELATION_STATUSES
			        ],
		        ]];
	}

	public function transactions(): array {
		return [static::SCENARIO_DEFAULT => static::OP_ALL];
	}

	public function afterFind(): void {
		$this->id = new Id($this->getAttribute(static::ATTR_EMPLOYEE_ID));

		$this->name = new Name(
			$this->getAttribute(static::ATTR_EMPLOYEE_NAME_LAST),
			$this->getAttribute(static::ATTR_EMPLOYEE_NAME_FIRST),
			$this->getAttribute(static::ATTR_EMPLOYEE_NAME_MIDDLE)
		);

		$this->address = new Address(
			$this->getAttribute(static::ATTR_EMPLOYEE_ADDRESS_COUNTRY),
			$this->getAttribute(static::ATTR_EMPLOYEE_ADDRESS_REGION),
			$this->getAttribute(static::ATTR_EMPLOYEE_ADDRESS_CITY),
			$this->getAttribute(static::ATTR_EMPLOYEE_ADDRESS_STREET),
			$this->getAttribute(static::ATTR_EMPLOYEE_ADDRESS_HOUSE),
		);

		$this->createDate = new DateTimeImmutable($this->getAttribute(static::ATTR_EMPLOYEE_CREATE_DATE));

		$this->phones = static::getLazyFactory()->createProxy(
			Phones::class,
			function(&$target, LazyLoadingInterface $proxy): void {
				$target = new Phones($this->{static::RELATION_PHONES});
				$proxy->setProxyInitializer();
			}
		);

		$this->statuses = array_map(function($row): Status {
			return new Status(
				$row['value'],
				new DateTimeImmutable($row['date'])
			);
		}, Json::decode($this->getAttribute(static::ATTR_EMPLOYEE_STATUSES)));

		parent::afterFind();
	}

	public function beforeSave($insert): bool {
		$this->setAttribute(static::ATTR_EMPLOYEE_ID, $this->id->getId());
		$this->setAttribute(static::ATTR_EMPLOYEE_NAME_LAST, $this->name->getLast());
		$this->setAttribute(static::ATTR_EMPLOYEE_NAME_FIRST, $this->name->getFirst());
		$this->setAttribute(static::ATTR_EMPLOYEE_NAME_MIDDLE, $this->name->getMiddle());
		$this->setAttribute(static::ATTR_EMPLOYEE_ADDRESS_COUNTRY, $this->address->getCountry());
		$this->setAttribute(static::ATTR_EMPLOYEE_ADDRESS_REGION, $this->address->getRegion());
		$this->setAttribute(static::ATTR_EMPLOYEE_ADDRESS_CITY, $this->address->getCity());
		$this->setAttribute(static::ATTR_EMPLOYEE_ADDRESS_STREET, $this->address->getStreet());
		$this->setAttribute(static::ATTR_EMPLOYEE_ADDRESS_HOUSE, $this->address->getHouse());
		$this->setAttribute(static::ATTR_EMPLOYEE_CREATE_DATE, $this->getCreateDate()->format(DateTimeImmutable::ATOM));
		$this->setAttribute(static::ATTR_EMPLOYEE_CURRENT_STATUS, $this->getCurrentStatus()->getValue());

		if (false === ($this->phones instanceof LazyLoadingInterface) || $this->phones->isProxyInitialized()) {
			$this->{static::RELATION_PHONES} = $this->phones->getAll();
		}

		$statuses = array_map(function(Status $status): array {
			return [
				Status::VALUE => $status->getValue(),
				Status::DATE  => $status->getDate()->format(DATE_ATOM),
			];
		}, $this->statuses);

		$this->setAttribute(static::ATTR_EMPLOYEE_STATUSES, Json::encode($statuses));

		return parent::beforeSave($insert);
	}

	public function getRelatedPhones(): ActiveQuery {
		return $this->hasMany(Phone::class, [
			                                  Phone::ATTR_PHONE_EMPLOYEE_ID => static::ATTR_EMPLOYEE_ID]
		)->orderBy(Phone::ATTR_PHONE_ID);
	}
	const RELATION_PHONES = 'relatedPhones';

	public function getRelatedStatuses(): ActiveQuery {
		return $this->hasMany(Status::class, [
			                                   Status::ATTR_STATUS_EMPLOYEE_ID => static::ATTR_EMPLOYEE_ID]
		)->orderBy(Status::ATTR_STATUS_ID);
	}
	const RELATION_STATUSES = 'relatedStatuses';
	//endregion
}
