<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

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

        foreach($createSql as $sql) {
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
