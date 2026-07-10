<?php

namespace QUI\Socialshare;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use QUI\Interfaces\Projects\Site;

class EventHandlerTest extends TestCase
{
    /**
     * @return iterable<string, array{string, string}>
     */
    public static function openGraphTypeProvider(): iterable
    {
        yield 'website' => ['website', 'website'];
        yield 'article' => ['article', 'article'];
        yield 'legacy movie' => ['movie', 'video.movie'];
        yield 'legacy blog' => ['blog', 'website'];
        yield 'unknown type' => ['event', 'website'];
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function openGraphLocaleProvider(): iterable
    {
        yield 'German' => ['de', 'de_DE'];
        yield 'English' => ['en', 'en_US'];
        yield 'Polish' => ['pl', 'pl_PL'];
        yield 'hyphenated locale' => ['en-gb', 'en_GB'];
        yield 'underscored locale' => ['pt_BR', 'pt_BR'];
        yield 'unsupported bare language' => ['fr', ''];
    }

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

    public function testMetaTagUsesRequestedAttributeAndEscapesValues(): void
    {
        self::assertSame(
            '<meta name="twitter:title&quot;" content="Social &amp; &quot;safe&quot; &lt;title&gt;" />',
            EventHandler::createMetaTag('name', 'twitter:title"', 'Social & "safe" <title>')
        );
    }

    public function testMetaTagRejectsUnsupportedAttribute(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        EventHandler::createMetaTag('http-equiv', 'refresh', '0');
    }

    public function testImageMetadataUsesValidOpenGraphAndTwitterAttributes(): void
    {
        $tags = EventHandler::createImageMetaTags(
            'https://example.test/media/social.jpg?size=large&crop=1',
            'image/jpeg',
            1200,
            630,
            'An "important" image'
        );

        self::assertContains(
            '<meta property="og:image" content="https://example.test/media/social.jpg?size=large&amp;crop=1" />',
            $tags
        );
        self::assertContains(
            '<meta name="twitter:image" content="https://example.test/media/social.jpg?size=large&amp;crop=1" />',
            $tags
        );
        self::assertContains(
            '<meta property="og:image:secure_url" content="https://example.test/media/social.jpg?size=large&amp;crop=1" />',
            $tags
        );
        self::assertContains('<meta property="og:image:type" content="image/jpeg" />', $tags);
        self::assertContains('<meta property="og:image:width" content="1200" />', $tags);
        self::assertContains('<meta property="og:image:height" content="630" />', $tags);
        self::assertContains(
            '<meta property="og:image:alt" content="An &quot;important&quot; image" />',
            $tags
        );
        self::assertContains(
            '<meta name="twitter:image:alt" content="An &quot;important&quot; image" />',
            $tags
        );
    }

    public function testOptionalImageMetadataIsOmitted(): void
    {
        self::assertSame(
            [
                '<meta property="og:image" content="http://example.test/social.jpg" />',
                '<meta name="twitter:image" content="http://example.test/social.jpg" />',
                '<meta itemprop="image" content="http://example.test/social.jpg" />'
            ],
            EventHandler::createImageMetaTags('http://example.test/social.jpg')
        );
    }

    #[DataProvider('openGraphTypeProvider')]
    public function testOpenGraphTypeNormalization(string $type, string $expected): void
    {
        self::assertSame($expected, EventHandler::getOpenGraphType($type));
    }

    #[DataProvider('openGraphLocaleProvider')]
    public function testOpenGraphLocaleNormalization(string $language, string $expected): void
    {
        self::assertSame($expected, EventHandler::getOpenGraphLocale($language));
    }
}
