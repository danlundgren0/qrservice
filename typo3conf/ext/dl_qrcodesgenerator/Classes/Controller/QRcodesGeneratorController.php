<?php
namespace DanLundgren\DlQrcodesgenerator\Controller;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/***
 *
 * This file is part of the "QRcodes Generator" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2020 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
 *
 ***/

/**
 * QRcodesGeneratorController
 */
class QRcodesGeneratorController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        //<script type="text/javascript" src="//www.shieldui.com/shared/components/latest/js/jquery-1.11.1.min.js"></script>
        //$GLOBALS['TSFE']->getPageRenderer()->addJsFooterInlineCode('jquery', 'var tag = document.createElement(\'script\');tag.src = \'https://www.shieldui.com/shared/components/latest/js/jquery-1.11.1.min.js\';var firstScriptTag = document.getElementsByTagName(\'script\')[0];firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);');
        $pageRenderer = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Page\\PageRenderer');
        $pageRenderer->addJsFooterFile('typo3conf/ext/dl_qrcodesgenerator/Resources/Public/Js/jquery-1.11.1.min.js');
        $pageRenderer->addJsFooterFile('typo3conf/ext/dl_qrcodesgenerator/Resources/Public/Js/shieldui-all.min.js');
        $pageRenderer->addJsFooterFile('typo3conf/ext/dl_qrcodesgenerator/Resources/Public/Js/dl_qrcodesgenerator.js');

        $i = 0;
        $parentPid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pid');
        $librarytest = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('libtest');
        $parentPage = $this->getParentPage();
        $subPages = $this->getSubPages();
        $rootlineUtility = new \TYPO3\CMS\Core\Utility\RootlineUtility($parentPid);
        $rootlineArr = $rootlineUtility->get();
        $tmpUrl = '';
        $estateTypePageUid = null;
        if((is_array($rootlineArr) && isset($rootlineArr[1]) && intval($rootlineArr[1])>0) && is_array($parentPage)) {
            $estateTypePageUid = $rootlineArr[1]['uid'];
        }
        
        $tmpUrl = $this->getModifiedUrl($parentPage, $estateTypePageUid);
        $qrUrl = $this->request->getBaseUri() . '' . $tmpUrl;
        $qrPages = [];
        $qrPages[$i]['qrUrl'] = $qrUrl;
        $qrPages[$i]['parentPage'] = $parentPage['title'];
        $i += 1;
        foreach ($subPages as $subPage) {
            $tmpUrl = $this->getModifiedUrl($subPage, $estateTypePageUid);
            $qrUrl = $this->request->getBaseUri() . '' . $tmpUrl;
            $qrPages[$i]['qrUrl'] = $qrUrl;
            $qrPages[$i]['parentPage'] = $parentPage['title'];
            $qrPages[$i]['subPage'] = $subPage['title'];
            $i += 1;
        }
        $this->view->assign('qrPages', $qrPages);
        $this->view->assign('librarytest', $librarytest);
    }

    private function getModifiedUrl($pageArr = [], $estateTypePageUid = null) {
        if($estateTypePageUid && count($pageArr)>0) {
            $urlArr = explode('/', $pageArr['slug']);
            $urlArr[1] = (strlen($urlArr[1])<30) ? $estateTypePageUid:$urlArr[1];
            //if($urlArr[1])
            //$replaceTitleWUidArr = str_replace($urlArr[1], $estateTypePageUid, $urlArr);
            $newUrl = substr(implode('/', $urlArr),1);
            return $newUrl;
        }
        return null;
    }
    private function getParentPage() {
        $parentPid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pid');
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->select('uid','title','slug')
        ->from('pages')
        ->where(
           $queryBuilder->expr()->eq('uid', $parentPid)
        )
        ->andWhere(
            $queryBuilder->expr()->eq('doktype', 1)
        );
        $statement = $queryBuilder->execute();
        while ($row = $statement->fetch()) {
           $parentPage = $row;
        }
        return $parentPage;        
    }

    private function getSubPages() {
        $parentPid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pid');
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->select('uid','title','slug')
        ->from('pages')
        ->where(
           $queryBuilder->expr()->eq('pid', $parentPid)
        )
        ->andWhere(
            $queryBuilder->expr()->eq('doktype', 1)
        )
        ->orderBy('sorting');;        
        $statement = $queryBuilder->execute();
        while ($row = $statement->fetch()) {
           $subPages[] = $row;
        }
        return $subPages;

    }

    private function getEstateSlugOrUid() {
        $parentPid = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('pid');
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
        $queryBuilder->select('uid','title','slug')
        ->from('pages')
        ->where(
           $queryBuilder->expr()->eq('uid', $parentPid)
        )
        ->andWhere(
            $queryBuilder->expr()->eq('doktype', 1)
        );
        $statement = $queryBuilder->execute();
        while ($row = $statement->fetch()) {
           $parentPage = $row;
        }
        return $parentPage;         
    }

    /**
     * @param $uid
     */
    private function getFullUrl($uid)
    {
        return $this->controllerContext->getUriBuilder()->reset()->setTargetPageUid($uid)->buildFrontendUri();
    }

    /**
     * action link
     *
     * @return void
     */
    public function linkAction()
    {
        $this->view->assign('pid', $GLOBALS['TSFE']->id);
    }
}
