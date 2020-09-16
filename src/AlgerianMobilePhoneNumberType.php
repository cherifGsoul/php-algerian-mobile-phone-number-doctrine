<?php

namespace Cherif\AlgerianMobilePhoneNumber\Doctrine;

use Cherif\AlgerianMobilePhoneNumber\AlgerianMobilePhoneNumber;
use Cherif\AlgerianMobilePhoneNumber\InvalidAlgerianMobilePhoneNumberException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;

class AlgerianMobilePhoneNumberType extends Type
{
	const NAME = 'algerian_mobile_phone_number';

	public function getSQLDeclaration(array $column, AbstractPlatform $platform)
	{
		return $platform->getVarcharTypeDeclarationSQL($column);
	}

	public function convertToPHPValue($value, AbstractPlatform $platform)
	{
		if ($value === null || $value === '') {
			return null;
		}

		if ($value instanceof AlgerianMobilePhoneNumber) {
			return $value;
		}
		
		try {
			$mobileNumber = AlgerianMobilePhoneNumber::fromString($value);
		} catch (InvalidAlgerianMobilePhoneNumberException $e) {
			throw ConversionException::conversionFailed($value, self::NAME);
			
		}

		return $mobileNumber;
	}

	public function convertToDatabaseValue($value, AbstractPlatform $platform)
	{
		if ($value === null || $value === '') {
			return null;
		}

		if (is_string($value)) {
			try {
				$value = AlgerianMobilePhoneNumber::fromString($value);
			} catch (InvalidAlgerianMobilePhoneNumberException $e) {
				throw ConversionException::conversionFailed($value, static::NAME);
			}
		}

		return (string) $value;
	}

	public function getName()
	{
		return self::NAME;
	}
}