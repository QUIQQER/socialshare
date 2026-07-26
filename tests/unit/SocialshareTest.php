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
        self::assertSame('noopener noreferrer', $Share->getAttribute('rel'));
    }

    public function testAccessibleNameNamesTheNetwork(): void
    {
        // with visible label: the descriptive name becomes the title tooltip
        $Share = new TestSocialshare();
        $Share->getBody();
        self::assertSame('Auf Test teilen', $Share->getAttribute('title'));

        // icon-only: the descriptive name becomes the aria-label
        $IconShare = new TestSocialshare();
        $IconShare->hideLabel();
        $body = $IconShare->getBody();
        self::assertStringNotContainsString('quiqqer-socialshare__label', $body);
        self::assertSame('Auf Test teilen', $IconShare->getAttribute('aria-label'));
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

        foreach (['button-classic', 'button', 'button-outline', 'link', 'link-muted', 'custom'] as $theme) {
            $Share->setTheme($theme);
            self::assertSame($theme, $Share->getAttribute('theme'));
        }

        // released legacy theme names are still accepted
        foreach (['classic', 'flat', 'minima', 'dark'] as $theme) {
            $Share->setTheme($theme);
            self::assertSame($theme, $Share->getAttribute('theme'));
        }

        $Share->setTheme('invalid');
        self::assertSame('button-classic', $Share->getAttribute('theme'));
    }

    public function testCounterRenderingDependsOnCount(): void
    {
        $Share = new TestSocialshare();

        self::assertSame('', $Share->createCount());

        $Share->count = 5;
        self::assertStringContainsString('quiqqer-socialshare__count', $Share->createCount());
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
