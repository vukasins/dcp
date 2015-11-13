<?php
/**
 * Created by PhpStorm.
 * User: vukasin
 * Date: 13.11.15.
 * Time: 13.50
 */

namespace Web\Factory\Controller;

use Zend\Authentication\Adapter\DbTable\CallbackCheckAdapter;
use Zend\Crypt\Password\Bcrypt;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Web\Controller\AuthController;

class AuthControllerFactory implements FactoryInterface {
    /**
     * @param ServiceLocatorInterface $controllerManager
     * @return LoginController
     */
    public function createService(ServiceLocatorInterface $controllerManager) {
        $sm = $controllerManager->getServiceLocator();
        $authService = $sm->get('Zend\Authentication\AuthenticationService');

        $zendDb = $sm->get('Zend\Db\Adapter\Adapter');
        $authAdapter = new CallbackCheckAdapter($zendDb, 'user', 'username', 'password', self::class . "::checkPass");

        $authService->setAdapter($authAdapter);

        return new AuthController($authService);
    }

    /**
     * Function will check user input with password from DB which is BCRYPTED
     *
     * @param $hash     Password(hash) from DB
     * @param $password User input
     * @return bool
     */
    public static function checkPass($hash, $password) {
        $bcrypt = new Bcrypt();

        return $bcrypt->verify($password, $hash);
    }
}