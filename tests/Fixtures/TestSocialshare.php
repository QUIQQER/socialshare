<?php

namespace QUI\Socialshare;

class TestSocialshare extends Socialshare
{
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
}
