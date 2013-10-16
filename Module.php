<?php

namespace BsbDoctrineTranslationLoader;

use Zend\I18n\Translator\LoaderPluginManager;
use Zend\ServiceManager\Config;
use Zend\Mvc\MvcEvent;
use Zend\I18n\Translator\Translator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        /** @var Translator $translator */
        $translator = $sm->get('MvcTranslator');

        /** @var LoaderPluginManager $plugins */
        $plugins = $translator->getPluginManager();
        $plugins->setServiceLocator($sm);

        /** @var Config $config */
        $config  = new Config($this->getTranslatorConfig());
        $config->configureServiceManager($plugins);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getTranslatorConfig()
    {
        return array(
            'factories' => array(
                'BsbDoctrineTranslationLoader' => 'BsbDoctrineTranslationLoader\I18n\Translator\Loader\Service\DoctrineFactory',
            ),
        );
    }
}
