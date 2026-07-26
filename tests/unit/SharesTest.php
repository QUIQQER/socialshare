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
        $_SERVER['REQUEST_URI'] = '/socialshare-test';
        $Share = new $class();

        self::assertNotSame('', $Share->getName());
        self::assertNotSame('', $Share->getLogo());
        self::assertNotSame('', $Share->getLabel());
        self::assertNotSame('', $Share->getShareUrl());
    }

    /**
     * @param class-string<Socialshare> $class
     */
    #[DataProvider('providerClasses')]
    public function testLogoUsesFontAwesome6Style(string $class): void
    {
        $Share = new $class();

        self::assertMatchesRegularExpression(
            '#^fa-(brands|solid|regular) fa-[a-z0-9-]+$#',
            $Share->getLogo()
        );
    }

    /**
     * Every network that opens a popup must use the single shared JavaScript
     * control; per-network control modules were consolidated into Share.js.
     *
     * @param class-string<Socialshare> $class
     */
    #[DataProvider('providerClasses')]
    public function testPopupControlUsesSharedModule(string $class): void
    {
        $Share = new $class();
        $control = $Share->getAttribute('data-qui');

        if ($control === false || $control === null) {
            self::assertTrue(true, 'network without a JavaScript control (e.g. mail)');

            return;
        }

        self::assertSame('package/quiqqer/socialshare/bin/controls/Share', $control);
    }
}
