<?php

namespace BsbDoctrineTranslationLoaderTest\Util;

use BsbDoctrineTranslationLoader\Util\ConfigManipulate;
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

    public function testOnMergeConfig()
    {
        $inputConfig    = array(
            'bsb_doctrine_translation_loader' => array(
                'entity_manager' => 'orm_default',
                'doctrine'       => array(
                    ConfigManipulate::EM_REPLACE_TOKEN => 'bar'
                ),
            ),
            'doctrine'                        => array()
        );
        $outputConfig   = array(
            'bsb_doctrine_translation_loader' => array(
                'entity_manager' => 'orm_default',
            ),
            'doctrine'                        => array(
                'orm_default' => 'bar',
            )
        );

        $event          = new \Zend\ModuleManager\ModuleEvent();
        $configListener = $this->getMock('Zend\ModuleManager\Listener\ConfigMergerInterface');

        $event->setConfigListener($configListener);

        $configListener->expects($this->once())->method('getMergedConfig')->with(false)->willReturn($inputConfig);
        $configListener->expects($this->once())->method('setMergedConfig')->with($outputConfig);

        ConfigManipulate::onMergeConfig($event);
    }
}
