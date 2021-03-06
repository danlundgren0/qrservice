<?php
$EM_CONF[$_EXTKEY] = [
    'title' => 'Fluid Templating Engine',
    'description' => 'Fluid is a next-generation templating engine which makes the life of extension authors a lot easier!',
    'category' => 'fe',
    'author' => 'Sebastian Kurfürst, Bastian Waidelich',
    'author_email' => 'sebastian@typo3.org, bastian@typo3.org',
    'author_company' => '',
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '8.7.3',
    'constraints' => [
        'depends' => [
            'extbase' => '8.7.0-8.7.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
