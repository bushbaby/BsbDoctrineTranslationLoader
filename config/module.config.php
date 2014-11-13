<?php

return array(
    'bsb_doctrine_translation_loader' => array(
        'entity_manager' => 'orm_default',
        /**
         * The $config['doctrine'] configuration will be manipulated with these 'template' options
         * and will be removed from $config['bsb_doctrine_translator']
         */
        'doctrine'       => array(
            'configuration' => array(
                \BsbDoctrineTranslationLoader\Util\ConfigManipulate::EM_REPLACE_TOKEN => array(
                    'entity_namespaces' => array(
                        'BsbDoctrineTranslationLoader' => 'BsbDoctrineTranslationLoader\Entity',
                    ),
                ),
            ),
            'driver'        => array(
                \BsbDoctrineTranslationLoader\Util\ConfigManipulate::EM_REPLACE_TOKEN => array(
                    'drivers' => array(
                        'BsbDoctrineTranslationLoader\Entity' => 'bsbdoctrinetranslationloader_entity',
                    ),
                ),
            ),
        ),
    ),
    'doctrine'                        => array(
        'driver' => array(
            'bsbdoctrinetranslationloader_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/xml/bsbdoctrinetranslationloader',
            ),
        ),
    ),
    'service_manager'                 => array(
        'invokables' => array(
            'BsbDoctrineTranslationMvcTranslatorDelegator' => 'BsbDoctrineTranslationLoader\Service\MvcTranslatorDelegatorFactory',
        ),
        'delegators' => array(
            'MvcTranslator' => array('BsbDoctrineTranslationMvcTranslatorDelegator'),
        ),
    ),
);
