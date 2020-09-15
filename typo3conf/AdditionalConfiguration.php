<?php
$customChanges = array(
    'DB' => [
        'database' => 'iponly_se',
        'host' => '127.0.0.1',
        'password' => 'lQrRUyQEBQ',
        'port' => 3306,
        'username' => 'iponly_se',
    ],
);
$GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive($GLOBALS['TYPO3_CONF_VARS'], (array)$customChanges);	