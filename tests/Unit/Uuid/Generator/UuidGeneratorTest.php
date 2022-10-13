<?php

declare(strict_types=1);

namespace Tests\Unit\Uuid\Generator;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Rixafy\Uuid\Generator\UuidGenerator;

class UuidGeneratorTest extends TestCase
{
	public function testMonotonicity(): void
	{
		$dateTime = new DateTimeImmutable('2022-01-01 00:00:00');
		
		$previousUuid = null;
		for ($i = 0; $i < 1000; $i++) {
			$uuid = UuidGenerator::uuid7($dateTime);
			
			if ($previousUuid !== null) {
				$this->assertGreaterThan($previousUuid->getInteger()->toString(), $uuid->getInteger()->toString());
			}
			
			$previousUuid = $uuid;
		}

		$previousUuid = null;
		for ($i = 0; $i < 1000; $i++) {
			$uuid = UuidGenerator::uuid7();
			
			if ($previousUuid !== null) {
				$this->assertGreaterThan($previousUuid->getInteger()->toString(), $uuid->getInteger()->toString());
			}
			
			$previousUuid = $uuid;
		}
		
		$this->assertEquals(UuidGenerator::uuid7($dateTime)->getInteger()->toString(), bcsub(UuidGenerator::uuid7($dateTime)->getInteger()->toString(), '1'));
	}
}
