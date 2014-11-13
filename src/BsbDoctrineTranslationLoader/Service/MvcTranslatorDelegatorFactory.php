<?php

namespace BsbDoctrineTranslationLoader\Service;

use Zend\I18n\Translator\LoaderPluginManager;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MvcTranslatorDelegatorFactory implements DelegatorFactoryInterface
{
    protected $translator_config = array(
        'factories' => array(
            'BsbDoctrineTranslationLoader'
            => 'BsbDoctrineTranslationLoader\I18n\Translator\Loader\Factory\DoctrineLoaderFactory',
        ),
    );

    public function createDelegatorWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName, $callback)
    {
        /** @var Translator $translator */
        $translator = call_user_func($callback);

        /** @var LoaderPluginManager $plugins */
        $plugins = $translator->getPluginManager();
        $plugins->setServiceLocator($serviceLocator);

        $config = new Config($this->translator_config);
        $config->configureServiceManager($plugins);

        return $translator;
    }
}
