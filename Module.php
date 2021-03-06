<?php

namespace BsbDoctrineTranslationLoader;

use BsbDoctrineTranslationLoader\Util\ConfigManipulate;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function init(ModuleManager $moduleManager)
    {
        $moduleManager
            ->getEventManager()
            ->attach(
                ModuleEvent::EVENT_MERGE_CONFIG,
                array('BsbDoctrineTranslationLoader\Util\ConfigManipulate', 'onMergeConfig')
            );
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
}
