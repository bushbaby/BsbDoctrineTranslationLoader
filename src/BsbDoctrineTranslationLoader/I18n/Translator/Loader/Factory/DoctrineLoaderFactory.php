<?php

namespace BsbDoctrineTranslationLoader\I18n\Translator\Loader\Factory;

use BsbDoctrineTranslationLoader\I18n\Translator\Loader\DoctrineLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineLoaderFactory implements FactoryInterface
{
    /**
     * {@inheritdocs}
     *
     * @todo make EntityManager configurable
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $serviceLocator = $serviceLocator->getServiceLocator();
        $config         = $serviceLocator->get('config');
        $entity_manager = $config['bsb_doctrine_translation_loader']['entity_manager'];
        $entityManager  = $serviceLocator->get(sprintf('doctrine.entity_manager.%s', $entity_manager));

        $service = new DoctrineLoader($entityManager);

        return $service;
    }
}
