<?php
/**
 * Created by PhpStorm.
 * User: vukasin
 * Date: 13.11.15.
 * Time: 12.26
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Web\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
);