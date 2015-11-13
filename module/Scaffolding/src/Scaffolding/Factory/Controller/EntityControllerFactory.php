<?php
namespace Scaffolding\Factory\Controller;

use Scaffolding\Controller\EntityController;
use Scaffolding\Service\Entity\CreateEntityService;
use Zend\Console\Adapter\Posix;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EntityControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm = $serviceLocator->getServiceLocator();
        /** @var CreateEntityService $createEntityService */
        $createEntityService = $sm->get(CreateEntityService::class);

        /** @var Posix $console */
        $console = $serviceLocator->getServiceLocator()->get('console');

        return new EntityController($createEntityService, $console);
    }

}