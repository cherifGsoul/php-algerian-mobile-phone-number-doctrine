<?php

namespace Cherif\AlgerianMobilePhoneNumber\Doctrine;

use Cherif\AlgerianMobilePhoneNumber\AlgerianMobilePhoneNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class AlgerianMobilePhoneNumberTypeTest extends TestCase
{
	use ProphecyTrait;

	private $platform;
	private $type;

	public static function setUpBeforeClass(): void
	{
		if (class_exists(Type::class)) {
			Type::addType('algerian_mobile_phone_number', AlgerianMobilePhoneNumberType::class);
		}
	}

	protected function setUp(): void
	{
		parent::setUp();
	
		$this->platform = $this->prophesize(AbstractPlatform::class);
		$this->type = Type::getType('algerian_mobile_phone_number');
	}
	

	public function testGetSQLDeclaration()
	{
		$this->platform->getVarcharTypeDeclarationSQL(Argument::cetera())->willReturn('phone_number');
		$this->assertEquals('phone_number', $this->type->getSQLDeclaration([], $this->platform->reveal()));
	}

	public function testConvertToPHPValue()
	{
		$mobileNumber = $this->type->convertToPHPValue('00213-6-99-00-00-00', $this->platform->reveal());
		$normalized = '00213699000000';
		$this->assertInstanceOf(AlgerianMobilePhoneNumber::class, $mobileNumber);
		$this->assertEquals($normalized, $mobileNumber->asString());
	}

	public function testConvertToPHPValueWithNullValue()
	{
		$mobileNumber = $this->type->convertToPHPValue(null, $this->platform->reveal());
		$this->assertNull($mobileNumber);
	}

	public function testConvertToPHPValueWithValueObjectInstance()
	{
		$value = AlgerianMobilePhoneNumber::fromString('00213699000000');
		$converted = $this->type->convertToPHPValue($value, $this->platform->reveal());
		$this->assertSame($value, $converted);
	}

	public function testConvertToDatabaseValue()
	{
		$mobileNumber = AlgerianMobilePhoneNumber::fromString('00213699000000');
		$actual = $this->type->convertToDatabaseValue($mobileNumber, $this->platform->reveal());
		$this->assertEquals($mobileNumber->asString(), $actual);
	}

	public function testConvertToDatabaseValueWithNullValue()
	{
		$this->assertNull($this->type->convertToDatabaseValue(null, $this->platform->reveal()));
	}

	public function testInvalidConversionToDatabaseValue()
	{
		$this->expectException(ConversionException::class);
		$this->type->convertToDatabaseValue('foobarbaz', $this->platform->reveal());
	}


	public function testGetName()
	{
		$type = Type::getType('algerian_mobile_phone_number');
		$this->assertEquals('algerian_mobile_phone_number', $type->getName());
	}
}