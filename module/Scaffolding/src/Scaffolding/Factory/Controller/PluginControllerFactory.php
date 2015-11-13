<?php
namespace Scaffolding\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Scaffolding\Controller\PluginController;

class PluginControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $console       = $serviceLocator->getServiceLocator()->get('console');
        $pluginService = $serviceLocator->getServiceLocator()->get('Scaffolding\Service\Controller\CreatePluginService');

        return new PluginController($console, $pluginService);
    }

}