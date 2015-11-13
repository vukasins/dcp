<?php
namespace Acl;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module{
    
    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ),
            ),
        );
    }
    
    public function onBootstrap($e){
        $app      = $e->getTarget();
        $services = $app->getServiceManager();
        $events   = $app->getEventManager();

        $events->attach($services->get('Acl\Listeners\AclListener'));
    }
}