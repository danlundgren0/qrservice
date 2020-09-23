<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function ($extConfString) {

        // Default bsdist page TSconfig
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:bsdist/Configuration/TypoScript/tsconfig.ts">');

        // Create .htaccess (after installation, for realurl)
        if (TYPO3_MODE === 'BE') {
            // Creates a .htaccess file
            $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher');
            $signalSlotDispatcher->connect(
                'TYPO3\\CMS\\Extensionmanager\\Service\\ExtensionManagementService',
                'hasInstalledExtensions',
                'Laxap\\Bsdist\\Service\\InstallService',
                'generateConfigFiles'
            );
        }

        // Get ext configuration
        strlen($extConfString)?$extConf = unserialize($extConfString):$extConf = array();

        // custom ckeditor
        if ( isset($extConf['addCustomCKEditorConfig']) && $extConf['addCustomCKEditorConfig'] ) {
            if ( isset($extConf['customCKEditorConfigPath']) && strlen($extConf['customCKEditorConfigPath']) ) {
                $GLOBALS['TYPO3_CONF_VARS']['RTE']['Presets']['custom'] = $extConf['customCKEditorConfigPath'];
            }
        }


    },$_EXTCONF
);

?>