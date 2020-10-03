<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'DanLundgren.DlQrcodesgenerator',
            'Qrcodesgenerator',
            [
                'QRcodesGenerator' => 'list, link'
            ],
            // non-cacheable actions
            [
                'QRcodesGenerator' => 'list, link'
            ]
        );

    // wizards
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    qrcodesgenerator {
                        iconIdentifier = dl_qrcodesgenerator-plugin-qrcodesgenerator
                        title = LLL:EXT:dl_qrcodesgenerator/Resources/Private/Language/locallang_db.xlf:tx_dl_qrcodesgenerator_qrcodesgenerator.name
                        description = LLL:EXT:dl_qrcodesgenerator/Resources/Private/Language/locallang_db.xlf:tx_dl_qrcodesgenerator_qrcodesgenerator.description
                        tt_content_defValues {
                            CType = list
                            list_type = dlqrcodesgenerator_qrcodesgenerator
                        }
                    }
                }
                show = *
            }
       }'
    );
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
		
			$iconRegistry->registerIcon(
				'dl_qrcodesgenerator-plugin-qrcodesgenerator',
				\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
				['source' => 'EXT:dl_qrcodesgenerator/Resources/Public/Icons/user_plugin_qrcodesgenerator.svg']
			);
		
    }
);
## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder