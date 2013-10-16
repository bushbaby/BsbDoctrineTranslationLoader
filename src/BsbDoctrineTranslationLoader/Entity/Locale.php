<?php

namespace BsbDoctrineTranslationLoader\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="translation_locale")
 */
class Locale
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
     * @ORM\Column(type="string", length=5, nullable=false)
     *
     * @var string $locale
     */
    protected $locale;

    /**
     * @ORM\Column(type="string")
     *
     * var string $plural_forms
     */
    protected $plural_forms;

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
     * @param string $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $plural_forms
     */
    public function setPluralForms($plural_forms)
    {
        $this->plural_forms = $plural_forms;
    }

    /**
     * @return mixed
     */
    public function getPluralForms()
    {
        return $this->plural_forms;
    }
}
