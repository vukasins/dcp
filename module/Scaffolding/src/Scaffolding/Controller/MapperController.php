<?php
namespace Scaffolding\Controller;

use Scaffolding\Service\Common\Util;
use Scaffolding\Service\Mapper\CreateMapperService;
use Zend\Console\Adapter\Posix;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\ColorInterface as Color;

class MapperController extends AbstractActionController
{
    /** @var  CreateMapperService $createMapperService */
    private $createMapperService;
    /** @var  Posix $console */
    private $console;

    /**
     * MapperController constructor.
     * @param CreateMapperService $createMapperService
     * @param Posix $console
     */
    public function __construct(CreateMapperService $createMapperService, Posix $console)
    {
        $this->createMapperService = $createMapperService;
        $this->console = $console;
    }

    public function createMapperAction()
    {
        /**
         * CreateMapperService constructor.
         * @param $tableName
         * @param $parentClassName
         * @param $mapperName
         * @param $namespace
         * @param $path
         */
        $request = $this->getRequest();
        $tableName = $request->getParam('table');
        $parent = $request->getParam('parent');
        $mapper = $request->getParam('mapper');
        $namespace = $request->getParam('namespace');
        $path = $request->getParam('path');

        $this->createMapperService->create($tableName, $parent, $mapper, $namespace, $path);
        $this->console->write(Util::format('Mapper is created!'), Color::GREEN);
    }
}