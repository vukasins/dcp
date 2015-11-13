<?php
/**
 * Created by PhpStorm.
 * User: vukasin
 * Date: 2.11.15.
 * Time: 15.09
 */
namespace Scaffolding\Controller;

use Scaffolding\Service\Service\CreateServiceService;
use Zend\Console\Adapter\Posix;
use Zend\Console\ColorInterface as Color;
use \Scaffolding\Service\Common\Util;
use Zend\Mvc\Controller\AbstractActionController;

class ServiceController extends AbstractActionController
{

    private $console = null;
    private $createServiceService = null;

    public function __construct(Posix $console, CreateServiceService $createServiceService)
    {
        $this->console = $console;
        $this->createServiceService = $createServiceService;
    }

    public function createServiceAction()
    {
        $module = $this->params()->fromRoute('module');
        $namespace = $this->params()->fromRoute('namespace');
        $serviceName = $this->params()->fromRoute('service');

        try {
            $this->createServiceService->createService($module, $namespace, $serviceName);
            $this->console->write(Util::format("Service: '$serviceName' is created"), Color::GREEN);
        }
        catch(\Exception $e){
            $this->console->write(Util::format($e->getMessage()), Color::RED);
        }
    }

}