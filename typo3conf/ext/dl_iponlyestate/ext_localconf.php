<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Cp',
	array(
		'ControlPoint' => 'list, show, upload',
		
	),
	// non-cacheable actions
	array(
		'ControlPoint' => 'list, show, upload',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Estate',
	array(
		'Estate' => 'list, show',
		
	),
	// non-cacheable actions
	array(
		'Estate' => 'list, show',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Ajaxrequest',
	array(
		'AjaxRequest' => 'getJson',
		
	),
	// non-cacheable actions
	array(
		'AjaxRequest' => 'getJson',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Reportsearch',
	array(
		'Report' => 'search',
		
	),
	// non-cacheable actions
	array(
		'Report' => 'search',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Reportlist',
	array(
		'Report' => 'list',
		
	),
	// non-cacheable actions
	array(
		'Report' => 'list',
		
	)
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'DanLundgren.' . $_EXTKEY,
	'Pdf',
	array(
		'Pdf' => 'pdfcomplete, pdfcritical, pdfremark, pdfpurchase, pdfoldremarks',
		
	),
	// non-cacheable actions
	array(
		'Pdf' => 'pdfcomplete, pdfcritical, pdfremark, pdfpurchase, pdfoldremarks',
		
	)
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

//EXAMPLE FROM NEWS
//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearCachePostProc'][] = \GeorgRinger\News\Utility\ClassCacheManager::class . '->reBuild';


//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \GeorgRinger\News\Utility\ClassCacheManager::class . '->reBuild';

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = \DanLundgren\DlIponlyestate\Hooks\InjectCopyAndPaste::class;


//$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:dl_iponlyestate/Classes/Hooks/copyPageTree.php:DanLundgren\DlIponlyestate\Hooks\injectCopyAndPaste';

$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed'][] = \DanLundgren\DlIponlyestate\Hooks\SetLoginCookie::class . '->setLoginCookie';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['logout_confirmed'][] = \DanLundgren\DlIponlyestate\Hooks\SetLoginCookie::class . '->delLoginCookie';
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['beforeRedirect'][] = \DanLundgren\DlIponlyestate\Hooks\SetLoginCookie::class . '->delLoginCookie';

//THIS IS FROM OLD SITE
/*
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed'][] = 'EXT:dl_iponlyestate/Classes/Hooks/SetLoginCookie.php:DanLundgren\DlIponlyestate\Hooks\SetLoginCookie->setLoginCookie';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['logout_confirmed'][] = 'EXT:dl_iponlyestate/Classes/Hooks/SetLoginCookie.php:DanLundgren\DlIponlyestate\Hooks\SetLoginCookie->delLoginCookie';
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['beforeRedirect'][] = 'EXT:dl_iponlyestate/Classes/Hooks/SetLoginCookie.php:DanLundgren\DlIponlyestate\Hooks\SetLoginCookie->delLoginCookie';
*/