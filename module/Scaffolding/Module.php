<?php

namespace Scaffolding;

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements ConsoleUsageProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';

    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getConsoleUsage(AdapterInterface $console)
    {
        return [
            'Create module:'            => 'create:module -m "ModuleName" -s "0|1"',
            'Create controller:'        => 'create:controller -m "ModuleName" -c "ControllerName"',
            'Create controller action:' => 'create:action -m "ModuleName" -c "ControllerName" -a "ActionName"',
            'Create entity:'            => 'create:entity -t "table_name" -p "src/Entity/TableNameEntity.php" -n "Account\Entity"',
            'Create mapper:'            => 'create:mapper -t "table_name" -p "src/Mapper/TableNameMapper.php" -n "Account\Mapper" -p "AbstractMapper" -m "UserMapper"',
            'Create service:'           => 'create:service -m "Wallet" -n "Wallet\Service" ServiceName',
            'Create view helper:'       => 'create:helper -m "ModuleName" -h "HelperName"',
            'Create controller plugin:' => 'create:plugin -m "ModuleName" -p "PluginName"',
            'Remove module:'            => 'remove:module -m "ModuleName"',

            ['--namespace|-n', 'Namespace for entity'],
            ['--module|-m', 'Module name'],
            ['--contr|-c', 'Controller name'],  // "controller" is reserved word, so we must use different one
            ['--act|-a', 'Action name'],        // "action" is reserved word, so we must use different one
            ['--table|-t', 'Table name'],
            ['--path|-p', 'Full path, ex: src/Entity/UserEntity.php'],
            ['--parent|-p', 'Parent class'],
            ['--mapper|-m', 'Mapper class name'],
            ['--name|-n', 'View Helper class name'],
            ['--plugin|-p', 'Controller Plugin class name'],
            ['--mvc|-s', 'use 0 to create service module OR 1 for MVC module']
        ];
    }

}
