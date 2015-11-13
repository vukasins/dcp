<?php
namespace Scaffolding\Service\Entity;

use Scaffolding\Service\Entity\CreateEntity;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\Feature\MetadataFeature;
use Zend\Db\TableGateway\TableGateway;

class CreateEntityService
{

    /** @var  Adapter $adapter */
    private $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param $tableName
     * @param $savePath
     * @param $namespace
     */
    public function create($tableName, $savePath, $namespace)
    {
        $createEntity = new CreateEntity(
            $tableName,
            $this->getTableGateway($tableName),
            $savePath,
            $namespace
        );
        $createEntity->create();
    }

    /**
     * @param $table
     * @return TableGateway
     */
    private function getTableGateway($table)
    {
        $tableGateway = new TableGateway($table, $this->adapter, new MetadataFeature());
        $tableGateway->initialize();
        return $tableGateway;
    }


}