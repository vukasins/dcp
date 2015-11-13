<?php
namespace Scaffolding\Service\Mapper;

class CreateMapperService
{
    /**
     * @param $tableName
     * @param $parentClassName
     * @param $mapperName
     * @param $namespace
     * @param $path
     * @return bool
     */
    public function create($tableName, $parentClassName, $mapperName, $namespace, $path)
    {
        $createMapper = new CreateMapper(
            $tableName,
            $parentClassName,
            $mapperName,
            $namespace,
            $path
        );

        return $createMapper->create();
    }
}