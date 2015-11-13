<?php
namespace Scaffolding\Factory\Controller;

use Scaffolding\Controller\ModuleController;
use Scaffolding\Service\Module\CreateModuleService;
use Zend\Console\Adapter\Posix;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModuleControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        /** @var CreateModuleService $createModuleService */
        $createModuleService = $sm->get(CreateModuleService::class);

        /** @var Posix $console */
        $console = $serviceLocator->getServiceLocator()->get('console');

        return new ModuleController($createModuleService, $console);
    }

}