<?php
namespace Scaffolding\Controller;

use Scaffolding\Service\Common\Util;
use Scaffolding\Service\Entity\CreateEntityService;
use Zend\Console\Adapter\Posix;
use Zend\Console\ColorInterface as Color;
use Zend\Mvc\Controller\AbstractActionController;

class EntityController extends AbstractActionController
{
    /** @var  CreateEntityService $createEntityService */
    private $createEntityService;

    /** @var  Posix $console */
    private $console;
    /**
     * EntityController constructor.
     * @param CreateEntityService $createEntityService
     * @param Posix $console
     */
    public function __construct(CreateEntityService $createEntityService, Posix $console)
    {
        $this->createEntityService = $createEntityService;
        $this->console = $console;
    }
    public function createEntityAction()
    {
        $request = $this->getRequest();
        $table = $request->getParam('table');
        $savePath = $request->getParam('path');
        $namespace = $request->getParam('namespace');

        $this->createEntityService->create($table, $savePath, $namespace);
        $this->console->write(Util::format("Done, entity is created from {$table}!"), Color::GREEN);
    }
}