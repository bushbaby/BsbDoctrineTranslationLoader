<?php

namespace BsbDoctrineTranslationLoaderTest\I18n\Translator\Loader;

use BsbDoctrineTranslationLoader\Entity\Locale;
use BsbDoctrineTranslationLoaderTest\Framework\TestCase;

class LocaleTest extends TestCase
{
    public function testAccessorsId()
    {
        $locale = new Locale();

        $expected = 2;
        $locale->setId($expected);

        $this->assertEquals($expected, $locale->getId());
    }

    public function testAccessorsLocale()
    {
        $locale = new Locale();

        $expected = 'foo';
        $locale->setLocale($expected);

        $this->assertEquals($expected, $locale->getLocale());
    }

    public function testAccessorsPluralForms()
    {
        $locale = new Locale();

        $expected = 'foo';
        $locale->setPluralForms($expected);

        $this->assertEquals($expected, $locale->getPluralForms());
    }
}
