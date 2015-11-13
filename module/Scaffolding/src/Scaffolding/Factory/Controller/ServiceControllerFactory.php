<?php
/**
 * Created by PhpStorm.
 * User: vukasin
 * Date: 2.11.15.
 * Time: 15.13
 */
namespace Scaffolding\Factory\Controller;

use Scaffolding\Controller\ServiceController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


class ServiceControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $console             = $serviceLocator->getServiceLocator()->get('console');
        $createServiceService = $serviceLocator->getServiceLocator()->get('Scaffolding\Service\Service\CreateServiceService');

        return new ServiceController($console, $createServiceService);
    }



}