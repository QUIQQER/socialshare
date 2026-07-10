<?php

namespace QUI\Socialshare;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../Fixtures/TestSocialshare.php';

class SocialshareTest extends TestCase
{
    public function testBodyUsesConfiguredIconLabelAndTheme(): void
    {
        $Share = new TestSocialshare();

        $body = $Share->getBody();

        self::assertStringContainsString('test-logo', $body);
        self::assertStringContainsString('Test label', $body);
        self::assertSame('https://example.test/share', $Share->getAttribute('href'));
        self::assertSame('_blank', $Share->getAttribute('target'));
    }

    public function testVisibilityAndThemeSettings(): void
    {
        $Share = new TestSocialshare();

        $Share->hideIcon();
        $Share->hideLabel();
        $Share->hideCount();
        self::assertFalse($Share->getAttribute('showIcon'));
        self::assertFalse($Share->getAttribute('showLabel'));
        self::assertFalse($Share->getAttribute('showCount'));

        $Share->showIcon();
        $Share->showLabel();
        $Share->showCount();
        self::assertTrue($Share->getAttribute('showIcon'));
        self::assertTrue($Share->getAttribute('showLabel'));
        self::assertTrue($Share->getAttribute('showCount'));

        foreach (['flat', 'minima', 'dark', 'custom', 'classic'] as $theme) {
            $Share->setTheme($theme);
            self::assertSame($theme, $Share->getAttribute('theme'));
        }

        $Share->setTheme('invalid');
        self::assertSame('classic', $Share->getAttribute('theme'));
    }

    public function testCounterRenderingDependsOnCount(): void
    {
        $Share = new TestSocialshare();

        self::assertSame('', $Share->createCount());

        $Share->count = 5;
        self::assertStringContainsString('quiqqer-socialshare-count', $Share->createCount());
    }

    public function testCountResponsesAreDecodedSafely(): void
    {
        $Share = new TestSocialshare();

        self::assertSame([], $Share->decode(false));
        self::assertSame([], $Share->decode(true));
        self::assertSame([], $Share->decode('invalid'));
        self::assertSame(['count' => 3], $Share->decode('{"count":3}'));
    }
}
