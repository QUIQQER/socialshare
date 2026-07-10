<?php

namespace QUI\Socialshare;

use PHPUnit\Framework\TestCase;

class ManagerTest extends TestCase
{
    public function testAvailableSocialProvidersExist(): void
    {
        $providers = Manager::getAvailableSocials();

        self::assertNotEmpty($providers);
        self::assertSame($providers, array_values(array_unique($providers)));
        self::assertContains('WordPress', $providers);
        self::assertNotContains('WorldPress', $providers);
        self::assertNotContains('Google', $providers);

        foreach ($providers as $provider) {
            $class = 'QUI\\Socialshare\\Shares\\' . $provider;

            self::assertTrue(class_exists($class), $class . ' does not exist.');
            self::assertTrue(is_subclass_of($class, Socialshare::class));
        }
    }
}
