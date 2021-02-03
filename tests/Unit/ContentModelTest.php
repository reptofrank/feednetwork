<?php

namespace App\Tests\Unit;

use App\Entity\Content;
use DateTime;
use PHPUnit\Framework\TestCase;

class ContentModelTest extends TestCase
{
    public function testSettingTitle()
    {
        $content = new Content();
        $content->setTitle('New Feed Content');

        $this->assertSame('New Feed Content', $content->getTitle());
        $this->assertIsString($content->getTitle());
    }

    public function testSettingDescription()
    {
        $content = new Content();
        $content->setDescription('New Feed Content');

        $this->assertStringContainsString('Feed', $content->getDescription());
    }

    public function testSettingGuid()
    {
        $content = new Content();
        $content->setGuid('https://biz.dev/new-content-feed');

        $this->assertStringStartsWith('https', $content->getGuid());
    }
}