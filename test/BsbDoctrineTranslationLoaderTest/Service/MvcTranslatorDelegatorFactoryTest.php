<?php

namespace BsbDoctrineTranslationLoaderTest\Service;

use BsbDoctrineTranslationLoader\Service\MvcTranslatorDelegatorFactory;
use BsbDoctrineTranslationLoaderTest\Framework\TestCase;

class MvcTranslatorDelegatorFactoryTest extends TestCase
{
    public function testConfiguresTranslatorService()
    {
        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager');

        $loaderPluginManager = $this->getMockBuilder('Zend\I18n\Translator\LoaderPluginManager')
            ->disableOriginalConstructor()
            ->getMock();

        $translator = $this->getMockBuilder('Zend\I18n\Translator\Translator')
            ->disableOriginalConstructor()
            ->getMock();

        $translator->expects($this->once())->method('getPluginManager')->willReturn($loaderPluginManager);
        $loaderPluginManager->expects($this->once())->method('setServiceLocator')->with($serviceLocator);

        $loaderPluginManager
            ->expects($this->once())
            ->method('setFactory')
            ->with(
                'BsbDoctrineTranslationLoader',
                'BsbDoctrineTranslationLoader\I18n\Translator\Loader\Factory\DoctrineLoaderFactory'
            );

        $callback = function () use ($translator) {
            return $translator;
        };

        $delegator = new MvcTranslatorDelegatorFactory();

        $delegator->createDelegatorWithName($serviceLocator, 'xxx', 'xxx', $callback);

    }
}
