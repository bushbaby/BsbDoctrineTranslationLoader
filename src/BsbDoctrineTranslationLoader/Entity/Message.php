<?php

namespace BsbDoctrineTranslationLoader\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="translation_message")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer $id
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BsbDoctrineTranslationLoader\Entity\Locale", inversedBy="messages")
     * @ORM\JoinColumn(name="locale_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var Locale
     */
    private $locale;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @var string $domain
     */
    private $domain;

    /**
     * @ORM\Column(name="message", type="text",  nullable=false)
     *
     * @var string message
     */
    private $message;

    /**
     * @ORM\Column(type="text",  nullable=true)
     *
     * @var string $translation
     */
    private $translation;

    /**
     * @ORM\Column(type="smallint", length=3, nullable=true)
     *
     * @var string $plural_index
     */
    private $plural_index;

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
