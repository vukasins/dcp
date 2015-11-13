<?php

namespace Scaffolding\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \Scaffolding\Service\Common\Util;
use Zend\Console\Adapter\Posix;
use Scaffolding\Service\Controller\CreateControllerService;
use Scaffolding\Service\Controller\CreateActionService;
use Zend\Console\ColorInterface as Color;

class ControllerController extends AbstractActionController
{
    private $console;
    private $controllerService;
    private $actionService;

    public function __construct(Posix $console, CreateControllerService $controllerService, CreateActionService $actionService)
    {
        $this->console           = $console;
        $this->controllerService = $controllerService;
        $this->actionService     = $actionService;
    }

    public function createControllerAction()
    {
        try{
            $module     = $this->params()->fromRoute('module');
            $controller = $this->params()->fromRoute('contr');

            $this->controllerService->createController($module, $controller);

            $this->console->write(Util::format("Controller: '$controller' is created"), Color::GREEN);
        }
        catch(\Exception $e){
            $this->console->write(Util::format($e->getMessage()), Color::RED);
        }
    }

    public function createActionAction()
    {
        try{
            $module     = $this->params()->fromRoute('module');
            $controller = $this->params()->fromRoute('contr');
            $action     = $this->params()->fromRoute('act');

            $this->actionService->createAction($module, $controller, $action);

            $this->console->write(Util::format("Action: '$action' in controller is created"), Color::GREEN);
        }
        catch(\Exception $e){
            $this->console->write(Util::format($e->getMessage()), Color::RED);
        }
    }

}