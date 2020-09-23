<?php
return [
    'BE' => [
        'debug' => true,
        'explicitADmode' => 'explicitAllow',
        'installToolPassword' => '$P$CVw.zyPN.aHREOuuSpvl9pK6oJqDPO/',
        'lockSSL' => true,
        'loginSecurityLevel' => 'rsa',
        'versionNumberInFilename' => '0',
    ],
    'DB' => [
        'Connections' => [
            'Default' => [
                'charset' => 'utf8',
                'dbname' => 'iponly_se',
                'driver' => 'mysqli',
                'host' => '127.0.0.1',
                'password' => 'lQrRUyQEBQ',
                'port' => 3306,
                'user' => 'iponly_se',
            ],
        ],
    ],
    'EXT' => [
        'extConf' => [
            'bootstrap_grids' => 'a:1:{s:19:"enableGridSimpleRow";s:1:"0";}',
            'bsdist' => 'a:0:{}',
            'dl_iponlyestate' => 'a:3:{s:22:"responsibleTechnicians";s:1:"2";s:7:"ftpUser";s:0:"";s:7:"ftpPass";s:0:"";}',
            'dl_qrcodesgenerator' => 'a:0:{}',
            'extension_builder' => 'a:3:{s:15:"enableRoundtrip";s:1:"1";s:15:"backupExtension";s:1:"1";s:9:"backupDir";s:35:"uploads/tx_extensionbuilder/backups";}',
            'gridelements' => 'a:2:{s:20:"additionalStylesheet";s:0:"";s:19:"nestingInListModule";s:1:"0";}',
            'ke_search' => 'a:11:{s:20:"multiplyValueToTitle";s:1:"1";s:16:"searchWordLength";s:1:"4";s:16:"enablePartSearch";s:1:"1";s:17:"enableExplicitAnd";s:1:"0";s:18:"finishNotification";s:1:"0";s:21:"notificationRecipient";s:0:"";s:18:"notificationSender";s:19:"no_reply@domain.com";s:19:"notificationSubject";s:32:"[KE_SEARCH INDEXER NOTIFICATION]";s:13:"pathPdftotext";s:9:"/usr/bin/";s:11:"pathPdfinfo";s:9:"/usr/bin/";s:10:"pathCatdoc";s:9:"/usr/bin/";}',
            'pdfviewhelpers' => 'a:0:{}',
            'realurl' => 'a:7:{s:10:"configFile";s:26:"typo3conf/realurl_conf.php";s:14:"enableAutoConf";s:1:"1";s:14:"autoConfFormat";s:1:"0";s:17:"segTitleFieldList";s:0:"";s:12:"enableDevLog";s:1:"0";s:10:"moduleIcon";s:1:"0";s:19:"enableChashUrlDebug";s:1:"0";}',
            'rsaauth' => 'a:1:{s:18:"temporaryDirectory";s:0:"";}',
            'saltedpasswords' => 'a:2:{s:3:"BE.";a:4:{s:21:"saltedPWHashingMethod";s:41:"TYPO3\\CMS\\Saltedpasswords\\Salt\\PhpassSalt";s:11:"forceSalted";i:0;s:15:"onlyAuthService";i:0;s:12:"updatePasswd";i:1;}s:3:"FE.";a:5:{s:7:"enabled";i:1;s:21:"saltedPWHashingMethod";s:41:"TYPO3\\CMS\\Saltedpasswords\\Salt\\PhpassSalt";s:11:"forceSalted";i:0;s:15:"onlyAuthService";i:0;s:12:"updatePasswd";i:1;}}',
            'vhs' => 'a:0:{}',
        ],
    ],
    'EXTCONF' => [
        'lang' => [
            'availableLanguages' => [],
        ],
    ],
    'FE' => [
        'debug' => true,
        'loginSecurityLevel' => 'rsa',
    ],
    'GFX' => [
        'jpg_quality' => '80',
        'processor' => 'GraphicsMagick',
        'processor_allowTemporaryMasksAsPng' => '',
        'processor_colorspace' => 'RGB',
        'processor_effects' => '-1',
        'processor_enabled' => '1',
        'processor_path' => '/usr/bin/',
        'processor_path_lzw' => '/usr/bin/',
    ],
    'INSTALL' => [],
    'MAIL' => [
        'transport' => 'mail',
        'transport_sendmail_command' => '/usr/sbin/sendmail -t -i',
        'transport_smtp_encrypt' => '',
        'transport_smtp_password' => '',
        'transport_smtp_server' => 'localhost:25',
        'transport_smtp_username' => '',
    ],
    'SYS' => [
        'caching' => [
            'cacheConfigurations' => [
                'extbase_object' => [
                    'backend' => 'TYPO3\\CMS\\Core\\Cache\\Backend\\Typo3DatabaseBackend',
                    'frontend' => 'TYPO3\\CMS\\Core\\Cache\\Frontend\\VariableFrontend',
                    'groups' => [
                        'system',
                    ],
                    'options' => [
                        'defaultLifetime' => 0,
                    ],
                ],
            ],
        ],
        'devIPmask' => '*',
        'displayErrors' => 1,
        'enableDeprecationLog' => 'file',
        'encryptionKey' => 'abbd72cf16ead6bc99ce5903d5c466adb3d704ee34f4acc8e950618f014e15c5eee86c78ddb63d03253a0198071e97e9',
        'exceptionalErrors' => 28674,
        'isInitialDatabaseImportDone' => true,
        'isInitialInstallationInProgress' => false,
        'sitename' => 'IP-Only',
        'sqlDebug' => 1,
        'systemLogLevel' => 0,
    ],
];
