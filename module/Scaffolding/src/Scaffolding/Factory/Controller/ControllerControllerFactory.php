<?php
namespace Scaffolding\Factory\Controller;

use Scaffolding\Controller\ControllerController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $console           = $serviceLocator->getServiceLocator()->get('console');
        $controllerService = $serviceLocator->getServiceLocator()->get('Scaffolding\Service\Controller\CreateControllerService');
        $actionService     = $serviceLocator->getServiceLocator()->get('Scaffolding\Service\Controller\CreateActionService');

        return new ControllerController($console, $controllerService, $actionService);
    }

}