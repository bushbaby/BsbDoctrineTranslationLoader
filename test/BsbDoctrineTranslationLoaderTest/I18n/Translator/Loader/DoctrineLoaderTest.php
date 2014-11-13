<?php

namespace BsbDoctrineTranslationLoaderTest\I18n\Translator\Loader;

use BsbDoctrineTranslationLoader\I18n\Translator\Loader\Doctrine;
use BsbDoctrineTranslationLoader\I18n\Translator\Loader\DoctrineLoader;
use BsbDoctrineTranslationLoaderTest\Framework\TestCase;

class DoctrineLoaderTest extends TestCase
{
    public function testInstanceOf()
    {
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $loader = new DoctrineLoader($entityManager);

        $this->assertInstanceOf('Zend\I18n\Translator\Loader\RemoteLoaderInterface', $loader);
    }
}