<?php
namespace Scaffolding\Service\Mapper;

use Scaffolding\Service\CreateInterface;

class CreateMapper implements CreateInterface
{

    private $tableName;
    private $parentClassName;
    private $mapperName;
    private $namespace;
    private $path;

    /**
     * CreateMapperService constructor.
     * @param $tableName
     * @param $parentClassName
     * @param $mapperName
     * @param $namespace
     * @param $path
     */
    public function __construct($tableName, $parentClassName, $mapperName, $namespace, $path)
    {
        $this->tableName = $tableName;
        $this->parentClassName = $parentClassName;
        $this->mapperName = $mapperName;
        $this->namespace = $namespace;
        $this->path = $path;
    }

    public function create()
    {
        $template = file_get_contents(__DIR__ . '/../../../../template/Mapper/MapperTemplate.txt');
        $template = str_replace("{{namespaceName}}", $this->namespace, $template);
        $template = str_replace("{{className}}", $this->mapperName, $template);
        $template = str_replace("{{tableName}}", $this->tableName, $template);
        $template = str_replace("{{parentClassName}}", $this->parentClassName, $template);
        file_put_contents($this->path, $template);
        return true;
    }

}