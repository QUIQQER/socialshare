<?php

namespace QUI\Socialshare;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SharesTest extends TestCase
{
    /**
     * @return iterable<string, array{class-string<Socialshare>}>
     */
    public static function providerClasses(): iterable
    {
        foreach (Manager::getAvailableSocials() as $provider) {
            $class = 'QUI\\Socialshare\\Shares\\' . $provider;

            if (is_subclass_of($class, Socialshare::class)) {
                yield $provider => [$class];
            }
        }
    }

    /**
     * @param class-string<Socialshare> $class
     */
    #[DataProvider('providerClasses')]
    public function testProviderMetadata(string $class): void
    {
        $Share = new $class();

        self::assertNotSame('', $Share->getName());
        self::assertNotSame('', $Share->getLogo());
        self::assertIsString($Share->getCountUrl());
    }
}
