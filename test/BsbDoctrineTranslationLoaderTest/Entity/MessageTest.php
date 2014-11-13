<?php

namespace BsbDoctrineTranslationLoaderTest\I18n\Translator\Loader;

use BsbDoctrineTranslationLoader\Entity\Locale;
use BsbDoctrineTranslationLoader\Entity\Message;
use BsbDoctrineTranslationLoaderTest\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testAccessorsId()
    {
        $message = new Message();

        $expected = 2;
        $message->setId($expected);

        $this->assertEquals($expected, $message->getId());
    }

    public function testAccessorsLocale()
    {
        $message = new Message();

        $expected = $this->getMock('BsbDoctrineTranslationLoader\Entity\Locale');
        $message->setLocale($expected);

        $this->assertEquals($expected, $message->getLocale());
    }

    public function testAccessorsPluralIndex()
    {
        $message = new Message();

        $expected = 5;
        $message->setPluralIndex($expected);
        $this->assertEquals($expected, $message->getPluralIndex());
    }

    public function testAccessorsMessage()
    {
        $message = new Message();

        $expected = 'foo';
        $message->setMessage($expected);
        $this->assertEquals($expected, $message->getMessage());
    }

    public function testAccessorsDomain()
    {
        $message = new Message();

        $expected = 'foo';
        $message->setDomain($expected);
        $this->assertEquals($expected, $message->getDomain());
    }
    public function testAccessorsTranslation()
    {
        $message = new Message();

        $expected = 'foo';
        $message->setTranslation($expected);
        $this->assertEquals($expected, $message->getTranslation());
    }

}