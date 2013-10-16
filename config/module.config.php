<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'bsbdoctrinetranslationloader_annotation_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'BsbDoctrineTranslationLoader\Entity' => 'bsbdoctrinetranslationloader_annotation_driver'
                )
            )
        ),
    ),
);
