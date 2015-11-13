<?php
/**
 * Created by PhpStorm.
 * User: vukasin
 * Date: 13.11.15.
 * Time: 10.51
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController
{
    private $authService = null;

    public function __construct($authService)
    {
        $this->authService = $authService;
    }

    public function loginAction()
    {
        $this->layout('layout/login');

        return new ViewModel();
    }

    public function authenticateAction()
    {
        $username = $this->params()->fromPost('username');
        $password = $this->params()->fromPost('password');

        if (!$username || !$password) {
            $this->flashMessenger()->addErrorMessage('All fields are required');

            return $this->redirect()->toRoute('login');
        }

        $this->authService->getAdapter()->setIdentity($username)->setCredential($password);

        if (!$this->authService->authenticate()->isValid()) {
            $this->flashMessenger()->addErrorMessage('Wrong credentials');

            return $this->redirect()->toRoute('login');
        }

        $user = $this->authService->getAdapter()->getResultRowObject(null, 'password');
        $this->authService->getStorage()->write($user);

        return $this->redirect()->toRoute('home');
    }

    public function logoutAction()
    {
        $this->authService->clearIdentity();

        return $this->redirect()->toRoute('login');
    }
}
