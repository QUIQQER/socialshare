<?php

namespace QUI\Socialshare;

class TestSocialshare extends Socialshare
{
    public int $count = 0;

    public function getCountUrl(): string
    {
        return '';
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getShareUrl(): string
    {
        return 'https://example.test/share';
    }

    public function getLogo(): string
    {
        return 'test-logo';
    }

    public function getLabel(): string
    {
        return 'Test label';
    }

    public function getShareTitle(): string
    {
        return 'Auf Test teilen';
    }

    public function getName(): string
    {
        return 'test-share';
    }

    /**
     * @return array<string|int, mixed>
     */
    public function decode(string | bool $response): array
    {
        return $this->decodeCountResponse($response);
    }
}
