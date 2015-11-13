<?php
namespace Scaffolding\Service\Entity;

use Zend\Db\TableGateway\TableGateway;

class CreateEntity implements CreateEntityInterface
{

    /** @var  TableGateway */
    private $tableGateway;

    private $savePath;

    private $namespace;

    private $tableName;

    public function __construct($tableName, $tableGateway, $savePath, $namespace)
    {
        $this->tableGateway = $tableGateway;
        $this->savePath = $savePath;
        $this->namespace = $namespace;
        $this->tableName = $tableName;
    }

    private function getColumns()
    {
        return $this->tableGateway->getColumns();
    }

    public function createGetters()
    {
        $data = "";
        $columns = $this->getColumns();
        foreach($columns as $col) {
            $template = file_get_contents(__DIR__ . '/../../../../template/Entity/GetterTemplate.txt');
            $template = str_replace("{{getterName}}", $this->camelCase("get_".$col), $template);
            $template = str_replace("{{propertyName}}", $col, $template);
            $data .= $template;
        }
        return $data;
    }

    public function createSetters()
    {
        $data = "";
        $columns = $this->getColumns();
        foreach($columns as $col) {
            $template = file_get_contents(__DIR__ . '/../../../../template/Entity/SetterTemplate.txt');
            $template = str_replace("{{setterName}}", $this->camelCase("set_".$col), $template);
            $template = str_replace("{{propertyName}}", $col, $template);
            $data .= $template;
        }
        return $data;
    }

    public function createProperties()
    {
        $data = "    ";
        $columns = $this->getColumns();
        foreach($columns as $col) {
            $data .= "protected " . '$' ."{$col};\n    ";
        }
        return $data;
    }

    public function create()
    {
        $template = file_get_contents(__DIR__ . '/../../../../template/Entity/EntityTemplate.txt');
        $template = str_replace("{{namespace}}", $this->namespace, $template);
        $template = str_replace("{{className}}", $this->createEntityClassName($this->tableName), $template);
        $template = str_replace("{{properties}}", $this->createProperties(), $template);
        $template = str_replace("{{getters}}", $this->createGetters(), $template);
        $template = str_replace("{{setters}}", $this->createSetters(), $template);
        file_put_contents($this->savePath, $template);
        return $template;
    }

    private static function camelCase($str, array $noStrip = [])
    {
        // non-alpha and non-numeric characters become spaces
        $str = preg_replace('/[^a-z0-9' . implode("", $noStrip) . ']+/i', ' ', $str);
        $str = trim($str);
        // uppercase the first character of each word
        $str = ucwords($str);
        $str = str_replace(" ", "", $str);
        $str = lcfirst($str);

        return $str;
    }

    private function createEntityClassName($tableName)
    {
        return ucfirst($this->camelCase($tableName)) . "Entity";
    }

}