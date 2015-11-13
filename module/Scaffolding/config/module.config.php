<?php

return [
    'console'         => [
        'router' => [
            'routes' => [
                'create-entity'     => [
                    'options' => [
                        'route'    => 'create:entity [--table|-t] <table> [--path|-p] <path> [--namespace|-n] <namespace>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Entity',
                            'action'     => 'createEntity'
                        ]
                    ]
                ],
                'create-mapper'     => [
                    'options' => [
                        'route'    => 'create:mapper [--table|-t] <table> [--path|-p] <path> [--namespace|-n] <namespace> [--parent|-pr] <parent> [--mapper|-m] <mapper>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Mapper',
                            'action'     => 'createMapper'
                        ]
                    ]
                ],
                'create-module'     => [
                    'options' => [
                        'route'    => 'create:module [--module|-m] <module> [--mvc|-s] <mvc>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Module',
                            'action'     => 'createModule'
                        ]
                    ]
                ],
                'create-controller' => [
                    'options' => [
                        'route'    => 'create:controller [--module|-m] <module> [--contr|-c] <contr>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Controller',
                            'action'     => 'createController'
                        ]
                    ]
                ],
                'create-controller-action' => [
                    'options' => [
                        'route'    => 'create:action [--module|-m] <module> [--contr|-c] <contr> [--act|-a] <act>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Controller',
                            'action'     => 'createAction'
                        ]
                    ]
                ],
                'create-service'    => [
                    'options' => [
                        'route'    => 'create:service [--module|-m] <module> [--namespace|-n] <namespace> <service>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Service',
                            'action'     => 'createService'
                        ]
                    ]
                ],
                'create-helper'    => [
                    'options' => [
                        'route'    => 'create:helper [--module|-m] <module> [--helper|-h] <helper>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Helper',
                            'action'     => 'createHelper'
                        ]
                    ]
                ],
                'create-plugin'    => [
                    'options' => [
                        'route'    => 'create:plugin [--module|-m] <module> [--plugin|-p] <plugin>',
                        'defaults' => [
                            'controller' => 'Scaffolding\Controller\Plugin',
                            'action'     => 'createPlugin'
                        ]
                    ]
                ],
                'remove-module'     => [
                    'options' => [
                        'route'     => 'remove:module [--module|-m] <module>',
                        'defaults'  => [
                            'controller' => 'Scaffolding\Controller\Module',
                            'action'     => 'removeModule',
                        ],
                    ],
                ],
            ]
        ]
    ],
    'controllers'     => [
        'factories' => [
            'Scaffolding\Controller\Entity'     => 'Scaffolding\Factory\Controller\EntityControllerFactory',
            'Scaffolding\Controller\Mapper'     => 'Scaffolding\Factory\Controller\MapperControllerFactory',
            'Scaffolding\Controller\Module'     => 'Scaffolding\Factory\Controller\ModuleControllerFactory',
            'Scaffolding\Controller\Controller' => 'Scaffolding\Factory\Controller\ControllerControllerFactory',
            'Scaffolding\Controller\Service'    => 'Scaffolding\Factory\Controller\ServiceControllerFactory',
            'Scaffolding\Controller\Helper'     => 'Scaffolding\Factory\Controller\HelperControllerFactory',
            'Scaffolding\Controller\Plugin'     => 'Scaffolding\Factory\Controller\PluginControllerFactory',
        ]
    ],
    'service_manager' => [
        'invokables'         => [
            'Scaffolding\Service\Controller\CreateControllerService' => 'Scaffolding\Service\Controller\CreateControllerService',
            'Scaffolding\Service\Controller\CreateActionService'     => 'Scaffolding\Service\Controller\CreateActionService',
            'Scaffolding\Service\Mapper\CreateMapperService'         => 'Scaffolding\Service\Mapper\CreateMapperService',
            'Scaffolding\Service\Module\CreateModuleService'         => 'Scaffolding\Service\Module\CreateModuleService',
            'Scaffolding\Service\Controller\CreateHelperService'     => 'Scaffolding\Service\Controller\CreateHelperService',
            'Scaffolding\Service\Service\CreateServiceService'       => 'Scaffolding\Service\Service\CreateServiceService',
            'Scaffolding\Service\Controller\CreatePluginService'     => 'Scaffolding\Service\Controller\CreatePluginService',
        ],
        'factories'          => [
            'Scaffolding\Service\Entity\CreateEntityService' => 'Scaffolding\Factory\Service\CreateEntityServiceFactory'
        ],
        'abstract_factories' => [

        ],
        'aliases'            => [

        ],
        'services'           => [

        ],
        'initializers'       => [

        ],
        'shared'             => [

        ],
    ],

];