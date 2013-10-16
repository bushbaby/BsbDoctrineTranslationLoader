<?php

namespace BsbDoctrineTranslationLoader\I18n\Translator\Loader;

use BsbDoctrineTranslationLoader\I18n\Exception;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Expr\Join;
use Zend\I18n\Translator\Loader\RemoteLoaderInterface;
use Zend\I18n\Translator\Plural\Rule as PluralRule;
use Zend\I18n\Translator\TextDomain;

class Doctrine implements RemoteLoaderInterface
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    protected $entityClassMap = array(
        'locale'=>'BsbDoctrineTranslationLoader\Entity\Locale',
        'message'=>'BsbDoctrineTranslationLoader\Entity\Message'
    );

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $entityClassMap
     */
    public function setEntityClassMap($entityClassMap)
    {
        if (!is_array($entityClassMap)) {
            return;
        }

        if (isset($entityClassMap['locale']) && is_string($entityClassMap['locale'])) {
            $this->entityClassMap['locale'] = $entityClassMap['locale'];
        }

        if (isset($entityClassMap['message']) && is_string($entityClassMap['message'])) {
            $this->entityClassMap['message'] = $entityClassMap['message'];
        }
    }

    /**
     * @param string $locale
     * @param string $domain
     * @return null|TextDomain
     * @throws \BsbDoctrineTranslationLoader\I18n\Exception\InvalidArgumentException
     */
    public function load($locale, $domain)
    {
        $textDomain         = new TextDomain();
        $queryBuilder       = $this->entityManager->createQueryBuilder();
        $query              = $queryBuilder->select('locale.id, locale.plural_forms')
                                           ->from($this->entityClassMap['locale'], 'locale')
                                           ->where('locale.locale = :locale')
                                           ->setParameters(array(':locale' => $locale))
                                           ->getQuery();

        try {
            $localeInformation  = $query->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
        } catch (NonUniqueResultException $e) {
            throw new Exception\InvalidArgumentException(
                sprintf("Duplicate locale entry detected ('%s').", $locale)
            );
        }

        if (!count($localeInformation)) {
            return $textDomain;
        }

        if(strlen($localeInformation['plural_forms'])) {
            try {
                $textDomain->setPluralRule(
                    PluralRule::fromString($localeInformation['plural_forms'])
                );
            } catch (\Exception $e) {
                throw new Exception\InvalidArgumentException(
                    sprintf("Incorrect plural rule detected for locale '%s'.", $locale)
                );
            }
        }

        $query              = $queryBuilder
                                           ->select('DISTINCT message.id, message.message, message.translation, message.plural_index')
                                           ->from($this->entityClassMap['message'], 'message')
                                           ->where('message.domain = :domain')
                                           ->andWhere('l.id = :locale_id')
                                           ->join('message.locale', 'l')
                                           ->getQuery();

        $messages           = $query->execute(array(':locale_id' => $localeInformation['id'],
                                          ':domain' => $domain), AbstractQuery::HYDRATE_OBJECT);

        foreach ($messages as $message) {
            if (is_int($message['plural_index'])) {
                if (!isset($textDomain[$message['message']])) {
                    $textDomain[$message['message']] = array();
                }
                if (isset($textDomain[$message['message']]) && !is_array($textDomain[$message['message']])) {
                    throw new Exception\InvalidArgumentException(
                        'Plural entries must be have unique keys from singular forms.'
                    );
                }
                if (isset($textDomain[$message['message']][$message['plural_index']])) {
                    throw new Exception\InvalidArgumentException(
                        "Duplicate plural entry detected."
                    );
                }

                $textDomain[$message['message']][$message['plural_index']] = $message['translation'];
            } else {
                if (isset($textDomain[$message['message']])) {
                    throw new Exception\InvalidArgumentException(
                        sprintf("Singular entries must be have unique keys from both singular and plural forms (locale '%s', '%s', '%s')", $locale, $domain, $message['message'])
                    );
                }

                $textDomain[$message['message']] = $message['translation'];
            }
        }

        return $textDomain;
    }
}