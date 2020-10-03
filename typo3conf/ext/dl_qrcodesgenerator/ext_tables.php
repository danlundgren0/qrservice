<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'DanLundgren.DlQrcodesgenerator',
            'Qrcodesgenerator',
            'QRcodesGenerator'
        );

        $pluginSignature = str_replace('_', '', 'dl_qrcodesgenerator') . '_qrcodesgenerator';
        $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:dl_qrcodesgenerator/Configuration/FlexForms/flexform_qrcodesgenerator.xml');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('dl_qrcodesgenerator', 'Configuration/TypoScript', 'QRcodes Generator');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_dlqrcodesgenerator_domain_model_qrcodesgenerator', 'EXT:dl_qrcodesgenerator/Resources/Private/Language/locallang_csh_tx_dlqrcodesgenerator_domain_model_qrcodesgenerator.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_dlqrcodesgenerator_domain_model_qrcodesgenerator');

    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder