<?php
namespace Acl\Listeners;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class AclListener extends AbstractListenerAggregate
{

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE, __CLASS__ . '::checkPermission', -100);
    }

    public static function checkPermission(MvcEvent $e)
    {
        $auth = $e->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService');

        $isLogin = $e->getRouteMatch()->getMatchedRouteName() === 'login' ||
                   $e->getRouteMatch()->getMatchedRouteName() === 'authenticate';

        if(!$auth->hasIdentity() && !$isLogin){
            $url      = $e->getRouter()->assemble([], ['name' => 'login']);
            $response = $e->getResponse();

            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();

            return $response;
        }
    }
}