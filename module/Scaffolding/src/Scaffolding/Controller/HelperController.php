<?php

namespace Scaffolding\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \Scaffolding\Service\Common\Util;
use Zend\Console\Adapter\Posix;
use Scaffolding\Service\Controller\CreateHelperService;
use Zend\Console\ColorInterface as Color;

class HelperController extends AbstractActionController
{
    private $console;
    private $helperService;

    public function __construct(Posix $console, CreateHelperService $helperService)
    {
        $this->console       = $console;
        $this->helperService = $helperService;
    }

    public function createHelperAction()
    {
        try{
            $module     = $this->params()->fromRoute('module');
            $helperName = $this->params()->fromRoute('helper');

            $this->helperService->createHelper($module, $helperName);

            $this->console->write(Util::format("View Helper: '$helperName' is created"), Color::GREEN);
        }
        catch(\Exception $e){
            $this->console->write(Util::format($e->getMessage()), Color::RED);
        }
    }

}