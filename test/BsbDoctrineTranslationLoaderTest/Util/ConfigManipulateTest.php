<?php

namespace BsbDoctrineTranslationLoaderTest\I18n\Translator\Loader;

use BsbDoctrineTranslationLoader\I18n\Translator\Loader\Doctrine;
use BsbDoctrineTranslationLoaderTest\Framework\TestCase;

class ConfigManipulateTest extends TestCase
{

    public function dataProviderMethodReplaceKey()
    {
        return array(
            array(
                array('__x__' => 'foo', 'foo' => 'bar',),
                array('__y__' => 'foo', 'foo' => 'bar',),
            ),
            array(
                array('foo' => array('__x__' => 'foo', 'foo' => 'bar',),),
                array('foo' => array('__y__' => 'foo', 'foo' => 'bar',)),
            ),
            array(
                array('__x__' => array('__x__' => 'foo', 'foo' => 'bar',),),
                array('__y__' => array('__y__' => 'foo', 'foo' => 'bar',),),
            ),
        );
    }

    /**
     * @dataProvider   dataProviderMethodReplaceKey
     */
    public function testMethodReplaceKey($input, $expected)
    {
        $class = new \ReflectionClass('BsbDoctrineTranslationLoader\Util\ConfigManipulate');
        $method = $class->getMethod('replaceKey');
        $method->setAccessible(true);


        $actual = $method->invokeArgs(null, array($input, '__x__', '__y__'));

        $this->assertEquals($expected, $actual);
    }
}