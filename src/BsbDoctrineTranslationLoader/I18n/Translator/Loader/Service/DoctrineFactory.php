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
        $em = $sm->get('Doctrine\ORM\EntityManager');

        $service = new DoctrineTranslationLoader($em);

        return $service;
    }
}