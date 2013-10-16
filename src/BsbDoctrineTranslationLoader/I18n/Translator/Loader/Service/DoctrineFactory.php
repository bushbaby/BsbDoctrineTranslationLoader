<?php

namespace BsbDoctrineTranslationLoader\I18n\Translator\Loader\Service;

use BsbDoctrineTranslationLoader\I18n\Translator\Loader\Doctrine AS DoctrineTranslationLoader;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class DoctrineFactory implements FactoryInterface
{
    /**
     * {@inheritdocs}
     *
     * @todo make EntityManager configurable
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();

        $config = $sm->get('config');

        $em = $sm->get('Doctrine\ORM\EntityManager');

        $service = new DoctrineTranslationLoader($em);

        if (isset($config['bsb_doctrine_translation_loader']['entity_class_map'])) {
            $service->setEntityClassMap($config['bsb_doctrine_translation_loader']['entity_class_map']);
        }

        return $service;
    }
}