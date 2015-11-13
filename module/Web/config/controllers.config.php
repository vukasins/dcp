<?php
/**
 * Created by PhpStorm.
 * User: vukasin
 * Date: 13.11.15.
 * Time: 12.29
 */

return array(
    'controllers' => array(
        'invokables' => array(
            'Web\Controller\Index' => 'Web\Controller\IndexController',
        ),
        'factories' => array(
            'Web\Controller\Auth' => 'Web\Factory\Controller\AuthControllerFactory',
        ),
    )
);