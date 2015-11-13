<?php
return array(
    'controllers' => array(
        'invokables' => array(
        ),
        'factories' => array(
            'User\Controller\Auth' => 'User\Factory\Controller\AuthControllerFactory',
        ),
    ),

    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user/auth',
                    'defaults' => array(
                        'controller' => 'User\Controller\Auth',
                        'action' => 'login',
                    ),
                ),
            ),

            'authenticate' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user/auth/authenticate',
                    'defaults' => array(
                        'controller' => 'User\Controller\Auth',
                        'action' => 'authenticate',
                    ),
                ),
            ),

            'logout' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/user/auth/logout',
                    'defaults' => array(
                        'controller' => 'User\Controller\Auth',
                        'action' => 'logout',
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    )
);