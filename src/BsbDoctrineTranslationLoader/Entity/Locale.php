<?php

namespace BsbDoctrineTranslationLoader\Entity;

class Locale
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var string $locale
     */
    protected $locale;

    /**
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
