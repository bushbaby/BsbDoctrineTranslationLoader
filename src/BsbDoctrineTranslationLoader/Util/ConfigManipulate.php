<?php

namespace BsbDoctrineTranslationLoader\Util;

use Zend\ModuleManager\ModuleEvent;
use Zend\Stdlib\ArrayUtils;

class ConfigManipulate
{

    const EM_REPLACE_TOKEN = '__em_token__';

    public static function onMergeConfig(ModuleEvent $e)
    {
        $configListener = $e->getConfigListener();
        $config         = $configListener->getMergedConfig(false);

        $entityManager = $config['bsb_doctrine_translation_loader']['entity_manager'];
        $doctrineConf  = $config['bsb_doctrine_translation_loader']['doctrine'];

        // manipulate configuration
        $doctrineConf  = self::replaceKey($doctrineConf, self::EM_REPLACE_TOKEN, $entityManager);
        unset($config['bsb_doctrine_translation_loader']['doctrine']);

        $config['doctrine'] = ArrayUtils::merge($config['doctrine'], $doctrineConf);

        $configListener->setMergedConfig($config);
    }

    /**
     * Recursively replace keys of associative arrays
     *
     * @param array $data
     * @param string $search
     * @param string $replace
     * @return array
     */
    final protected static function replaceKey($data, $search, $replace)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $value = self::replaceKey($data[$key], $search, $replace);
            }
            if ($key == $search) {
                $data[$replace] = $value;
                unset($data[$search]);
            }
        }

        return $data;
    }
}
