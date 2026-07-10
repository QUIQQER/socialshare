<?php

/**
 * This file contains \QUI\Socialshare\EventHandler
 */

namespace QUI\Socialshare;

use Imagick;
use ImagickPixel;
use QUI;
use QUI\Exception;
use QUI\Interfaces\Projects\Site;
use QUI\Template;

use function class_exists;
use function file_exists;
use function file_get_contents;
use function htmlspecialchars;
use function is_int;
use function is_string;

/**
 * Class Events
 *
 * @author www.pcsg.de (Michael Danielczok)
 */
class EventHandler
{
    /**
     * @param Template $Template
     * @throws Exception
     */
    public static function onTemplateGetHeader(Template $Template): void
    {
        $Site = QUI::getRewrite()->getSite();

        if ($Site === null) {
            return;
        }

        $Project = $Site->getProject();
        $Request = QUI::getRequest();
        $baseurl = $Request->getScheme() . '://' . $Request->getHttpHost();

        /**
         * Site title
         */
        $title = $Site->getAttribute('meta.seotitle');

        if (!is_string($title)) {
            $title = '';
        }

        $socialTitle = $Site->getAttribute('quiqqer.socialshare.title');

        if (is_string($socialTitle) && $socialTitle !== '') {
            $title = $socialTitle;
        }

        $Template->extendHeader(self::createMetaTag('property', 'og:title', $title));
        $Template->extendHeader(self::createMetaTag('name', 'twitter:title', $title));
        $Template->extendHeader(self::createMetaTag('itemprop', 'name', $title));

        /**
         * Site short description
         */
        $description = self::getSocialDescription($Site);

        $Template->extendHeader(self::createMetaTag('property', 'og:description', $description));
        $Template->extendHeader(self::createMetaTag('name', 'twitter:description', $description));
        $Template->extendHeader(self::createMetaTag('itemprop', 'description', $description));

        /**
         * Site type, e.g. "website", "article", "movie" etc.
         */
        $type = 'website';

        $configuredType = $Site->getAttribute('quiqqer.socialshare.type');

        if (is_string($configuredType) && $configuredType !== '') {
            $type = $configuredType;
        }

        $Template->extendHeader(self::createMetaTag('property', 'og:type', self::getOpenGraphType($type)));

        $locale = self::getOpenGraphLocale($Project->getLang());

        if ($locale !== '') {
            $Template->extendHeader(self::createMetaTag('property', 'og:locale', $locale));
        }

        // itemscope itemtype="http://schema.org/WebPage"
        switch ($type) {
            case 'blog':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/BlogPosting');
                break;

            case 'product':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/Product');
                break;

            case 'movie':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/Movie');
                break;

            case 'article':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/Article');
                break;

            default:
            case 'website':
                $Site->setAttribute('meta.itemscope', 'http://schema.org/WebPage');
        }

        /**
         * Site url
         */
        $socialUrl = $Site->getAttribute('quiqqer.socialshare.url');

        if (is_string($socialUrl) && $socialUrl !== '') {
            $url = $socialUrl;
        } else {
            $url = $baseurl . $Site->getUrlRewritten();
        }

        $Template->extendHeader(self::createMetaTag('property', 'og:url', $url));

        /**
         * Site name, e.g. "The New Yor Times"
         * Not the base url
         */
        $siteName = $Project->getConfig('socialshare.settings.general.siteName');

        if (is_string($siteName) && $siteName !== '') {
            $Template->extendHeader(self::createMetaTag('property', 'og:site_name', $siteName));
        }

        /**
         * Author
         */
        $author = $Site->getAttribute('quiqqer.socialshare.author');

        if (is_string($author) && $author !== '') {
            $Template->extendHeader(self::createMetaTag('property', 'article:author', $author));
        }

        /**
         * Image
         */
        $image = '';
        $imageAlt = '';
        $imageType = '';
        $imageWidth = false;
        $imageHeight = false;

        $siteImage = $Site->getAttribute('image_site');

        if (is_string($siteImage)) {
            $image = $siteImage;
        }

        $socialImage = $Site->getAttribute('quiqqer.socialshare.image');

        if (is_string($socialImage) && $socialImage !== '') {
            $image = $socialImage;
        }

        if (!$image || substr($image, 0, 2) === 'fa') {
            $standardImage = $Project->getConfig('socialshare.settings.general.standardImage');
            $image = is_string($standardImage) ? $standardImage : '';
        }

        try {
            $Image = QUI\Projects\Media\Utils::getImageByUrl($image);
            $image = $Image->getSizeCacheUrl();
            $imageAlt = $Image->getAlt();
            $imageWidth = $Image->getWidth();
            $imageHeight = $Image->getHeight();
            $mimeType = $Image->getAttribute('mime_type');

            if (is_string($mimeType)) {
                $imageType = $mimeType;
            }

            if (str_contains($image, '.svg')) {
                $pngImage = $image . '.png';

                if (file_exists(CMS_DIR . $pngImage)) {
                    $image = $baseurl . $pngImage;
                    $imageType = 'image/png';
                } elseif (class_exists('\Imagick')) {
                    $svg = file_get_contents(CMS_DIR . $image);

                    if ($svg !== false) {
                        try {
                            $im = new Imagick();
                            $im->readImageBlob($svg);
                            $im->setImageBackgroundColor(new ImagickPixel('transparent'));
                            $im->setImageFormat("png24");
                            $im->writeImage(CMS_DIR . $pngImage);
                            $im->clear();
                            $im->destroy();

                            $image = $baseurl . $pngImage;
                            $imageType = 'image/png';
                        } catch (\Exception) {
                        }
                    }
                }
            }
        } catch (QUI\Exception) {
            // @todo Projekt Social Icon definieren
        }

        if ($image !== '' && !str_starts_with($image, 'http://') && !str_starts_with($image, 'https://')) {
            $image = rtrim($baseurl, '/') . '/' . ltrim($image, '/');
        }

        if ($image !== '') {
            foreach (
                self::createImageMetaTags(
                    $image,
                    $imageType,
                    $imageWidth,
                    $imageHeight,
                    $imageAlt
                ) as $metaTag
            ) {
                $Template->extendHeader($metaTag);
            }
        }

        /**
         * Twitter cards
         */
        $card = match ($Project->getConfig('socialshare.settings.twitter.card')) {
            'summary', 'summary_large_image', 'player' => $Project->getConfig('socialshare.settings.twitter.card'),
            default => 'summary_large_image'
        };

        // site can override this setting
        switch ($Site->getAttribute('quiqqer.socialshare.twitter.card')) {
            case 'summary':
            case 'summary_large_image':
            case 'player':
                $card = $Site->getAttribute('quiqqer.socialshare.twitter.card');
                break;
        }

        $Template->extendHeader(self::createMetaTag('name', 'twitter:card', $card));

        $twitterSite = $Project->getConfig('socialshare.settings.twitter.site');

        if (is_string($twitterSite) && $twitterSite !== '') {
            $Template->extendHeader(self::createMetaTag('name', 'twitter:site', $twitterSite));
        }

        $twitterCreator = $Site->getAttribute('quiqqer.socialshare.twitter.creator');

        if (!is_string($twitterCreator) || $twitterCreator === '') {
            $twitterCreator = $Project->getConfig('socialshare.settings.twitter.creator');
        }

        if (is_string($twitterCreator) && $twitterCreator !== '') {
            $Template->extendHeader(self::createMetaTag('name', 'twitter:creator', $twitterCreator));
        }
    }

    /**
     * Create an escaped metadata element
     */
    public static function createMetaTag(string $attribute, string $name, string $content): string
    {
        $allowedAttributes = ['itemprop', 'name', 'property'];

        if (!in_array($attribute, $allowedAttributes, true)) {
            throw new \InvalidArgumentException('Unsupported meta tag attribute: ' . $attribute);
        }

        return '<meta ' . $attribute . '="' . self::escape($name) . '" content="' . self::escape($content) . '" />';
    }

    /**
     * Return valid Open Graph image metadata
     *
     * @return array<int, string>
     */
    public static function createImageMetaTags(
        string $image,
        string $mimeType = '',
        bool | int $width = false,
        bool | int $height = false,
        string $alt = ''
    ): array {
        $tags = [
            self::createMetaTag('property', 'og:image', $image),
            self::createMetaTag('name', 'twitter:image', $image),
            self::createMetaTag('itemprop', 'image', $image)
        ];

        if (str_starts_with($image, 'https://')) {
            $tags[] = self::createMetaTag('property', 'og:image:secure_url', $image);
        }

        if ($mimeType !== '') {
            $tags[] = self::createMetaTag('property', 'og:image:type', $mimeType);
        }

        if (is_int($width) && $width > 0) {
            $tags[] = self::createMetaTag('property', 'og:image:width', (string)$width);
        }

        if (is_int($height) && $height > 0) {
            $tags[] = self::createMetaTag('property', 'og:image:height', (string)$height);
        }

        if ($alt !== '') {
            $tags[] = self::createMetaTag('property', 'og:image:alt', $alt);
            $tags[] = self::createMetaTag('name', 'twitter:image:alt', $alt);
        }

        return $tags;
    }

    /**
     * Normalize legacy page types to supported Open Graph object types
     */
    public static function getOpenGraphType(string $type): string
    {
        return match ($type) {
            'article' => 'article',
            'movie' => 'video.movie',
            default => 'website'
        };
    }

    /**
     * Return an Open Graph locale for supported project languages
     */
    public static function getOpenGraphLocale(string $language): string
    {
        $normalized = str_replace('-', '_', $language);
        $parts = explode('_', $normalized, 2);

        if (isset($parts[1]) && $parts[0] !== '' && $parts[1] !== '') {
            return strtolower($parts[0]) . '_' . strtoupper($parts[1]);
        }

        return match (strtolower($language)) {
            'de' => 'de_DE',
            'en' => 'en_US',
            'pl' => 'pl_PL',
            default => ''
        };
    }

    private static function escape(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Return the best available description for social metadata
     */
    public static function getSocialDescription(Site $Site): string
    {
        $attributes = [
            'quiqqer.socialshare.description',
            'short',
            'meta.description'
        ];

        foreach ($attributes as $attribute) {
            $description = $Site->getAttribute($attribute);

            if (is_string($description) && $description !== '') {
                return $description;
            }
        }

        return '';
    }
}
