<?php

namespace BsbDoctrineTranslationLoaderTest\I18n\Translator\Loader;

use BsbDoctrineTranslationLoader\I18n\Translator\Loader\Doctrine;
use BsbDoctrineTranslationLoader\I18n\Translator\Loader\Factory\DoctrineLoaderFactory;
use BsbDoctrineTranslationLoaderTest\Framework\TestCase;

class DoctrineLoaderFactoryTest extends TestCase
{
    public function testCanCreateService()
    {
        $entityManager = $this->getMockBuilder('Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();

        $serviceLocator = $this->getMock('Zend\ServiceManager\ServiceManager');
        $serviceLocator->expects($this->at(0))
            ->method('get')
            ->with('config')
            ->will($this->returnValue(array(
                'bsb_doctrine_translation_loader' => array(
                    'entity_manager' => 'orm_name'
                ))));

        $serviceLocator->expects($this->at(1))
            ->method('get')
            ->with('doctrine.entity_manager.orm_name')
            ->will($this->returnValue($entityManager));


        $pluginManager = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $pluginManager->expects($this->once())
            ->method('getServiceLocator')
            ->will($this->returnValue($serviceLocator));


        $factory = new DoctrineLoaderFactory();
        $service = $factory->createService($pluginManager);

        $this->assertInstanceOf('BsbDoctrineTranslationLoader\I18n\Translator\Loader\DoctrineLoader', $service);
    }
}