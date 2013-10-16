BsbDoctrineTranslationLoader
============================

BsbDoctrineTranslationLoader is a small ZF2 module that provides a Doctrine based translation loader.

## Installation

### as zf2 project

BsbDoctrineTranslationLoader works with Composer. To install it into your project, just add the following line into your composer.json file:

    "require": {
        "bushbaby/bsb-doctrine-translation-loader": "*"
    }
   
Then update your project by runnning composer.phar update. 

Finally enable the module by adding BsbDoctrineTranslationLoader in your application.config.php file. 

### as standalone

For development purposes you might want to install BsbDoctrineTranslationLoader standalone. Clone the project somewhere on your computer

    git clone git@github.com:bushbaby/BsbDoctrineTranslationLoader.git BsbDoctrineTranslationLoader
    cd BsbDoctrineTranslationLoader
    curl -sS https://getcomposer.org/installer | php
    git checkout develop
    ./composer.phar install
    phpunit
    

## Configuration

To configure the module just copy the bsb_doctrine_translation_loader.local.php.dist (you can find this file in the config folder of BsbDoctrineTranslationLoader) into your config/autoload folder, and override what you want.

To enable the loader for a particular text domain add a remote

```
return array(
    'translator' => array(
        'remote_translation' => array(
            /* add a remote translation loader for each text domain */
            // array('type' => 'BsbDoctrineTranslationLoader', 'text_domain' => 'default'),
            // array('type' => 'BsbDoctrineTranslationLoader', 'text_domain' => 'other'),
        ),
    ),
);
```

