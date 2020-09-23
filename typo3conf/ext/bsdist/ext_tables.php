<?php
defined('TYPO3_MODE') || die('Access denied.');

// extension configuration
$extConf = array();
if ( strlen($_EXTCONF) ) {
    $extConf = unserialize($_EXTCONF);
}

// default typoscript configuration
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Bootstrap Kickstart Distribution');

// if enabled, add reponsive visibility field
if ( isset($extConf['enableResponsiveVisibilityField']) && $extConf['enableResponsiveVisibilityField'] ) {

    // field definition
    $tempColumn = array(
        'tx_bsdist_visibility' => array (
            'exclude' => 0,
            'displayCond' => 'FIELD:section_frame:!=:66',
            'label' => 'LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bsdist_visibility',
            'config' => array (
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array(
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.visibility.notset',  ''),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.visible.xs',	'visible-xs-block'),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.visible.sm-xs','visible-xs-block visible-sm-block'),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.visible.md-lg','visible-md-block visible-lg-block'),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.visible.lg',   'visible-lg-block'),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.hidden.xs', 	'hidden-xs'),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.hidden.sm-xs', 'hidden-xs hidden-sm'),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.hidden.md-lg', 'hidden-md hidden-lg'),
                    array('LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.hidden.lg', 	'hidden-lg')
                ),
                'size' => 1,
                'maxitems' => 1,
            )
        ),
    );

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('tt_content', $tempColumn);

    $ctypes = trim($extConf['showResponsiveVisibilityFieldInCTypes']);
    $ctypes = ($ctypes == '')?'textmedia':$ctypes;
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('tt_content', 'tx_bsdist_visibility;LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tt_content.tx_bsdist_visibility', $ctypes, 'after:layout');
}