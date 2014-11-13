<?php

namespace BsbDoctrineTranslationLoaderTest\Framework;

use BsbDoctrineTranslationLoaderTest\Bootstrap;
use Doctrine\ORM\Tools\SchemaTool;
use PHPUnit_Framework_TestCase;
use Doctrine\ORM\EntityManager;

class TestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var boolean
     */
    protected $hasDb = false;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * Creates a database if not done already.
     */
    public function createDb()
    {
        if ($this->hasDb) {
            return;
        }

        $em        = $this->getEntityManager();
        $conn      = $em->getConnection();
        $meta      = $em->getMetadataFactory()->getAllMetadata();
        $tool      = new SchemaTool($em);
        $createSql = $tool->getCreateSchemaSql($meta);

        foreach ($createSql as $sql) {
            $conn->executeQuery($sql);
        }

        $this->hasDb = true;
    }

    public function dropDb()
    {
        $em   = $this->getEntityManager();
        $conn = $em->getConnection();

        $conn->executeQuery("PRAGMA `writable_schema` = 1");
        $conn->executeQuery("DELETE FROM `sqlite_master` WHERE `type` IN ('table', 'index', 'trigger')");
        $conn->executeQuery("PRAGMA `writable_schema` = 0");
        $conn->executeQuery("VACUUM");
        $conn->executeQuery("PRAGMA INTEGRITY_CHECK");

        $em->clear();

        $this->hasDb = false;
    }

    /**
     * Get EntityManager.
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if ($this->entityManager) {
            return $this->entityManager;
        }

        $serviceManager      = Bootstrap::getServiceManager();
        $this->entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');

        return $this->entityManager;
    }
}
