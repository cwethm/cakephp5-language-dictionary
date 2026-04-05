<?php
declare(strict_types=1);

use Cake\Routing\RouteBuilder;

/** @var \Cake\Routing\RouteBuilder $routes */
$routes->plugin(
    'LanguageDictionary',
    ['path' => '/language-dictionary'],
    function (RouteBuilder $builder) {
        $builder->connect('/', ['controller' => 'Words', 'action' => 'index']);
        $builder->resources('Words');
        $builder->resources('Translations');
        $builder->fallbacks();
    }
);
