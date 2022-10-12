<?php

declare(strict_types=1);

namespace Rixafy\Uuid\Generator;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UuidGenerator
{
	private static ?string $previousUuidString = null;
	private static ?string $previousUuidInteger = null;
	
	public static function uuid7(): UuidInterface
	{
		$uuid = Uuid::uuid7();
		
		if (self::$previousUuidString !== null) {
			if (substr(self::$previousUuidString, 0, 13) === substr($uuid->toString(), 0, 13)) {
				$uuid = Uuid::fromInteger(bcadd(self::$previousUuidInteger, '1'));
			}
		}
		
		self::$previousUuidString = $uuid->toString();
		self::$previousUuidInteger = $uuid->getInteger()->toString();
		
		return $uuid;
	}
}
