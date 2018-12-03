<?php

return [
	//MainController
	'' => [
		'controller' => 'main',
		'action' => 'index',
	],
	'about' => [
		'controller' => 'main',
		'action' => 'about',
	],
    //AccountController
    'account/login' => [
        'controller' => 'account',
        'action' => 'login',
    ],
    'account/register' => [
        'controller' => 'account',
        'action' => 'register',
    ],
    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout',
    ],
    'account/add' => [
        'controller' => 'account',
        'action' => 'add',
    ],
    'account/edit/{id:\d+}' => [
        'controller' => 'account',
        'action' => 'edit',
    ],
    'account/delete/{id:\d+}' => [
        'controller' => 'account',
        'action' => 'delete',
    ],
    'account/posts' => [
        'controller' => 'account',
        'action' => 'posts',
    ],
	//AdminController
	'admin/login' => [
		'controller' => 'admin',
		'action' => 'login',
	],
	'admin/logout' => [
		'controller' => 'admin',
		'action' => 'logout',
	],
    'admin' => [
        'controller' => 'admin',
        'action' => 'index',
    ],
    'admin/export' => [
        'controller' => 'admin',
        'action' => 'export',
    ]
];
