BsbDoctrineTranslationLoader
============================

BsbDoctrineTranslationLoader is a small ZF2 module that provides a Doctrine based translation loader.

[![Latest Stable Version](https://poser.pugx.org/bushbaby/bsb-doctrine-translation-loader/v/stable.svg)](https://packagist.org/packages/bushbaby/bsb-doctrine-translation-loader) [![Total Downloads](https://poser.pugx.org/bushbaby/bsb-doctrine-translation-loader/downloads.svg)](https://packagist.org/packages/bushbaby/bsb-doctrine-translation-loader) [![Latest Unstable Version](https://poser.pugx.org/bushbaby/bsb-doctrine-translation-loader/v/unstable.svg)](https://packagist.org/packages/bushbaby/bsb-doctrine-translation-loader) [![License](https://poser.pugx.org/bushbaby/bsb-doctrine-translation-loader/license.svg)](https://packagist.org/packages/bushbaby/bsb-doctrine-translation-loader)

[![Build Status](https://travis-ci.org/bushbaby/BsbDoctrineTranslationLoader.svg?branch=master)](https://travis-ci.org/bushbaby/BsbDoctrineTranslationLoader)
[![Code Coverage](https://scrutinizer-ci.com/g/bushbaby/BsbDoctrineTranslationLoader/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bushbaby/BsbDoctrineTranslationLoader/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bushbaby/BsbDoctrineTranslationLoader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bushbaby/BsbDoctrineTranslationLoader/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bushbaby/BsbDoctrineTranslationLoader/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bushbaby/BsbDoctrineTranslationLoader/build-status/master)
[![Dependency Status](https://www.versioneye.com/user/projects/5464c8ef4de5ef380a000004/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5464c8ef4de5ef380a000004)

## Installation

```sh
php composer.phar require "bushbaby/bsb-doctrine-translation-loader:~1.0"
```

Then add `BsbDoctrineTranslationLoader` to the `config/application.config.php` modules list.

Copy the `config/bsb_doctrine_translation_loader.global.php.dist` to the `config/autoload` directory to jump start configuration. 

Create the required database tables by importing running;

mysql database < etc/mysql.sql

## Requirements

- \>=PHP5.3
- \>=ZF2.2.2


## Configuration

To configure the module just copy the bsb_doctrine_translation_loader.global.php.dist (you can find this file in the config folder of BsbDoctrineTranslationLoader) into your config/autoload folder, and override what you want.

To enable the loader for a particular text domain add a remote.

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

### Change the connection
 
By default BsbDoctrineTranslationLoader will use the orm_default connection which is configured by DoctrineORMModule. If you need to change the connection, change the 'entity_manager' key;

```
return array(
    'bsb_doctrine_translation_loader' => array(
        'entity_manager' => 'em_identifier',
    ),
);
```
Note: that is up to you to [configure](https://github.com/doctrine/DoctrineORMModule/blob/master/docs/configuration.md#how-to-use-two-connections) the DoctrineORMModule such that 'em_identifier' exists as a valid connection.

