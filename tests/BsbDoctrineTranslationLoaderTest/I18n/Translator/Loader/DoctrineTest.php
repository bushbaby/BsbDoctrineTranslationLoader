<?php

namespace BsbDoctrineTranslationLoaderTest\I18n\Translator\Loader;

use BsbDoctrineTranslationLoader\Entity\Locale;
use BsbDoctrineTranslationLoader\Entity\Message;
use BsbDoctrineTranslationLoaderTest\Framework\TestCase;
use BsbDoctrineTranslationLoaderTest\Util\ServiceManagerFactory;
use BsbDoctrineTranslationLoader\I18n\Translator\Loader\Doctrine;
use Zend\I18n\Translator\TextDomain;
use Zend\ServiceManager\ServiceManager;

class DoctrineTest extends TestCase
{

    /**
     * @var Doctrine $doctrineLoader
     */
    protected $doctrineLoader;

    public function setUp()
    {
        parent::setUp();
        
        $this->createDb();

        $this->doctrineLoader = new Doctrine($this->getEntityManager());
    }

    public function tearDown()
    {
        $this->dropDb();

        unset($this->doctrineLoader);
    }

    protected function addLocale($locale, $pluralForm = 'nplurals=2; plural=n != 1;') {
        $entity = new Locale();
        $entity->setLocale($locale);
        $entity->setPluralForms($pluralForm);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $entity;
    }

    protected function addMessage($locale, $message, $translation, $pluralIndex = null, $domain = 'default') {
        if (is_string($locale)) {
            $localeEntity = $this->getEntityManager()->getRepository('BsbDoctrineTranslationLoader\Entity\Locale')->findOneBy(array('locale'=>$locale));
        } else {
            $localeEntity = $locale;
        }

        $entity = new Message();
        $entity->setLocale($localeEntity);
        $entity->setMessage($message);
        $entity->setTranslation($translation);
        $entity->setDomain($domain);
        $entity->setPluralIndex($pluralIndex);

        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();

        return $message;
    }

    public function test_SingularLoad()
    {
        $locale = $this->addLocale('nl_NL');
        $this->addMessage($locale, 'key', 'sleutel');
        $locale = $this->addLocale('en_GB');
        $this->addMessage($locale, 'key', 'key');

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
        $this->assertArrayHasKey('key', $textDomain);
        $this->assertEquals($textDomain['key'], 'sleutel');

        $textDomain = $this->doctrineLoader->load('en_GB', 'default');
        $this->assertArrayHasKey('key', $textDomain);
        $this->assertEquals($textDomain['key'], 'key');

    }

    public function test_PluralLoad()
    {
        $locale = $this->addLocale('nl_NL');
        $this->addMessage($locale, '%s key', '%s sleutels', 0);
        $this->addMessage($locale, '%s key', '%s sleutel', 1);
        $locale = $this->addLocale('en_GB');
        $this->addMessage($locale, '%s key', '%s keys', 0);
        $this->addMessage($locale, '%s key', '%s key', 1);

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
        $this->assertArrayHasKey('%s key', $textDomain);
        $this->assertInternalType('array', $textDomain['%s key']);
        $this->assertArrayHasKey(0, $textDomain['%s key']);
        $this->assertArrayHasKey(1, $textDomain['%s key']);
        $this->assertEquals($textDomain['%s key'][0], '%s sleutels');
        $this->assertEquals($textDomain['%s key'][1], '%s sleutel');

        $textDomain = $this->doctrineLoader->load('en_GB', 'default');
        $this->assertArrayHasKey('%s key', $textDomain);
        $this->assertInternalType('array', $textDomain['%s key']);
        $this->assertArrayHasKey(0, $textDomain['%s key']);
        $this->assertArrayHasKey(1, $textDomain['%s key']);
        $this->assertEquals($textDomain['%s key'][0], '%s keys');
        $this->assertEquals($textDomain['%s key'][1], '%s key');
    }

    public function test_incorrectPluralRuleThrowsException()
    {
        $locale = $this->addLocale('nl_NL', 'incorrect plural rule');

        $this->setExpectedException('BsbDoctrineTranslationLoader\I18n\Exception\InvalidArgumentException',
            'Incorrect plural rule detected for locale');

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
    }

    public function test_duplicateLocaleThrowsException()
    {
        $locale = $this->addLocale('nl_NL');
        $locale = $this->addLocale('nl_NL');

        $this->setExpectedException('BsbDoctrineTranslationLoader\I18n\Exception\InvalidArgumentException',
            'Duplicate locale entry detected');

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
    }

    public function test_unknownLocaleReturnsEmptyTextDomain()
    {
        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');

        $this->assertInstanceOf('Zend\I18n\Translator\TextDomain', $textDomain);
        $this->assertCount(0, $textDomain);
    }

    public function test_unknownDomainReturnsEmptyTextDomain()
    {
        $locale = $this->addLocale('nl_NL');
        $this->addMessage($locale, 'key', 'sleutel');
        $this->addMessage($locale, 'key', 'sleutel', 0);

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'some_domain');

        $this->assertInstanceOf('Zend\I18n\Translator\TextDomain', $textDomain);
        $this->assertCount(0, $textDomain);
    }

    public function test_duplicateSingularMessageThrowsException()
    {
        $locale = $this->addLocale('nl_NL');
        $this->addMessage($locale, 'key', 'sleutel');
        $this->addMessage($locale, 'key', 'sleutel');

        $this->setExpectedException('BsbDoctrineTranslationLoader\I18n\Exception\InvalidArgumentException',
            'Singular entries must be have unique keys from both singular and plural forms');

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
        var_dump($textDomain->getArrayCopy());
    }

    public function test_identicalSingularAndPluralMessageThrowsException()
    {
        $locale = $this->addLocale('nl_NL');
        $this->addMessage($locale, 'key', 'sleutel');
        $this->addMessage($locale, 'key', 'sleutel', 1);

        $this->setExpectedException('BsbDoctrineTranslationLoader\I18n\Exception\InvalidArgumentException',
            'Plural entries must be have unique keys from singular forms');

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
    }

    public function test_IdenticalPluralAndSingularMessageThrowsException()
    {
        $locale = $this->addLocale('nl_NL');
        $this->addMessage($locale, 'key', 'sleutel', 1);
        $this->addMessage($locale, 'key', 'sleutel');

        $this->setExpectedException('BsbDoctrineTranslationLoader\I18n\Exception\InvalidArgumentException',
            'Singular entries must be have unique keys from both singular and plural forms');

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
    }

    public function test_duplicatePluralIndexThrowsException()
    {
        $locale = $this->addLocale('nl_NL');
        $this->addMessage($locale, '%s key', 'sleutels', 1);
        $this->addMessage($locale, '%s key', 'sleutel', 1);

        $this->setExpectedException('BsbDoctrineTranslationLoader\I18n\Exception\InvalidArgumentException',
            'Duplicate plural entry detected');

        /** @var TextDomain $textDomain */
        $textDomain = $this->doctrineLoader->load('nl_NL', 'default');
    }
}