<?php
namespace Scaffolding\Factory\Controller;

use Scaffolding\Controller\MapperController;
use Scaffolding\Service\Mapper\CreateMapperService;
use Zend\Console\Adapter\Posix;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MapperControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        /** @var CreateMapperService $createMapperService */
        $createMapperService = $sm->get(CreateMapperService::class);

        /** @var Posix $console */
        $console = $serviceLocator->getServiceLocator()->get('console');

        return new MapperController($createMapperService, $console);
    }

}