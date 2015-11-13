<?php

namespace Scaffolding\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use \Scaffolding\Service\Common\Util;
use Zend\Console\Adapter\Posix;
use Scaffolding\Service\Controller\CreatePluginService;
use Zend\Console\ColorInterface as Color;

class PluginController extends AbstractActionController
{
    private $console;
    private $pluginService;

    public function __construct(Posix $console, CreatePluginService $pluginService)
    {
        $this->console       = $console;
        $this->pluginService = $pluginService;
    }

    public function createPluginAction()
    {
        try{
            $module     = $this->params()->fromRoute('module');
            $pluginName = $this->params()->fromRoute('plugin');

            $this->pluginService->createPlugin($module, $pluginName);

            $this->console->write(Util::format("Controller Plugin: '$pluginName' is created"), Color::GREEN);
        }
        catch(\Exception $e){
            $this->console->write(Util::format($e->getMessage()), Color::RED);
        }
    }

}