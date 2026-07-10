<?php

namespace QUI\Socialshare;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use QUI\Interfaces\Projects\Site;

class EventHandlerTest extends TestCase
{
    /**
     * @return iterable<string, array{mixed, mixed, mixed, string}>
     */
    public static function descriptionProvider(): iterable
    {
        yield 'socialshare override' => ['Social', 'Short', 'SEO', 'Social'];
        yield 'short description' => ['', 'Short', 'SEO', 'Short'];
        yield 'SEO fallback' => ['', '', 'SEO', 'SEO'];
        yield 'no description' => [false, null, '', ''];
    }

    #[DataProvider('descriptionProvider')]
    public function testSocialDescriptionFallback(
        mixed $socialDescription,
        mixed $shortDescription,
        mixed $seoDescription,
        string $expected
    ): void {
        $Site = $this->createMock(Site::class);
        $Site->method('getAttribute')->willReturnMap([
            ['quiqqer.socialshare.description', $socialDescription],
            ['short', $shortDescription],
            ['meta.description', $seoDescription]
        ]);

        self::assertSame($expected, EventHandler::getSocialDescription($Site));
    }
}
