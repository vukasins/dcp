<?php
namespace Scaffolding\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Scaffolding\Controller\HelperController;

class HelperControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $console       = $serviceLocator->getServiceLocator()->get('console');
        $helperService = $serviceLocator->getServiceLocator()->get('Scaffolding\Service\Controller\CreateHelperService');

        return new HelperController($console, $helperService);
    }

}