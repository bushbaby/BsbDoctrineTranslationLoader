<?php

namespace BsbDoctrineTranslationLoader\Entity;

class Message
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Locale
     */
    protected $locale;

    /**
     * @var string $domain
     */
    protected $domain;

    /**
     * @var string message
     */
    protected $message;

    /**
     * @var string $translation
     */
    protected $translation;

    /**
     * @var string $plural_index
     */
    protected $plural_index;

    /**
     * @param string $domain
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param \BsbDoctrineTranslationLoader\Entity\Locale $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return \BsbDoctrineTranslationLoader\Entity\Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param string $plural_index
     */
    public function setPluralIndex($plural_index)
    {
        $this->plural_index = $plural_index;
    }

    /**
     * @return string
     */
    public function getPluralIndex()
    {
        return $this->plural_index;
    }

    /**
     * @param string $translation
     */
    public function setTranslation($translation)
    {
        $this->translation = $translation;
    }

    /**
     * @return string
     */
    public function getTranslation()
    {
        return $this->translation;
    }
}
