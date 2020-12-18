<?php
    namespace DanLundgren\DlIponlyestate\Hooks;
    use TYPO3\CMS\Core\Database\ConnectionPool;
    use TYPO3\CMS\Core\Database\Query\QueryBuilder;
    use TYPO3\CMS\Core\Utility\GeneralUtility;
    use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
    use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
    class InjectCopyAndPaste {
        protected  $rootPageIsSelected = FALSE;

        /*
        *  $status      new, updated
        *  $table       fe_users
        *  $id          new: NEW5691208b2428b763522287 updated: 4
        *  $fieldArray  feuser data
        *  $pObj        ?
         */
        public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj) {
            //Separate reportPids not in use anymore
            /*
            if($table == 'tx_dliponlyestate_domain_model_report') {
                $GLOBALS['DanLundgren']['reportPid'] = $fieldArray['pid'];
                $GLOBALS['DanLundgren']['hasEcexuted'] = FALSE;
            }
            */
        }
        public function processDatamap_afterAllOperations(&$pObj) {
            if(isset($GLOBALS['DanLundgren']['mainPid']) && (int)$GLOBALS['DanLundgren']['mainPid']>1) {
                //$this->setTxRealurlPathsegment();
                $this->setSlug();
            } 
        }
        public function processDatamap_afterDatabaseOperations($status, $table, $rawId, $fieldArray, $pObj) {
            if($table == 'pages' && !isset($GLOBALS['DanLundgren']['mainPid'])) {
                $GLOBALS['DanLundgren']['mainPid'] = $pObj->substNEWwithIDs[$rawId];
            }
        }
        private function setTxRealurlPathsegment() {
            $pageId = (int)$GLOBALS['DanLundgren']['mainPid'];
            //No md5 on mainPid, because technincion should find this page easily
            $mainPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('title', 'pages', 'uid='.$pageId);
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($mainPageRes)) {
                $md5 = md5($row['title'].''.$pageId);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('pages', 'uid='.$pageId, array('tx_realurl_pathsegment' => $md5));
            }
            $subPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,title', 'pages', 'pid='.$pageId);
            while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($subPageRes)) {
                $md5 = md5($row['title'].''.$row['uid']);
                $GLOBALS['TYPO3_DB']->exec_UPDATEquery('pages', 'uid='.$row['uid'], array('tx_realurl_pathsegment' => $md5));
            }
        }

        private function setSlug() {
            $pageId = (int)$GLOBALS['DanLundgren']['mainPid'];
            $queryBuilderPages = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $queryBuilderPages->getRestrictions()->removeAll();
            $queryBuilderSubPages = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $queryBuilderSubPages->getRestrictions()->removeAll();
            $queryBuilderPages->select('pid')
            ->addSelect('title')
            ->from('pages')
            ->where(
                $queryBuilderPages->expr()->eq('uid', $pageId)
            );
            $mainPageRes = $queryBuilderPages->execute();
            //$mainPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('title', 'pages', 'uid='.$pageId);
            //while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($mainPageRes)) {
            while ($row = $mainPageRes->fetch()) {
                $ppSlug = $this->getParentPageSlug($row['pid']);
                $md5 = md5($row['title'].''.$pageId);
                $fullMd5 = $ppSlug.'/'.$md5;
                //$GLOBALS['TYPO3_DB']->exec_UPDATEquery('pages', 'uid='.$pageId, array('tx_realurl_pathsegment' => $md5));
                $queryBuilderPages
                   ->update('pages')
                   ->where(
                      $queryBuilderPages->expr()->eq('uid', $pageId)
                   )
                   ->set('slug', $fullMd5)
                   ->execute();
            }
            //$subPageRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid,title', 'pages', 'pid='.$pageId);
            $queryBuilderSubPages->select('uid')
            ->addSelect('title')
            ->addSelect('pid')
            ->from('pages')
            ->where(
                $queryBuilderSubPages->expr()->eq('pid', $pageId)
            );
            $subPageRes = $queryBuilderSubPages->execute();
            //while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($subPageRes)) {
            while ($row = $subPageRes->fetch()) {
                $ppSlug = $this->getParentPageSlug($row['pid']);
                $md5 = md5($row['title'].''.$row['uid']);
                $fullMd5 = $ppSlug.'/'.$md5;
                //$GLOBALS['TYPO3_DB']->exec_UPDATEquery('pages', 'uid='.$row['uid'], array('tx_realurl_pathsegment' => $md5));
                $queryBuilderPages
                   ->update('pages')
                   ->where(
                      $queryBuilderPages->expr()->eq('uid', $row['uid'])
                   )
                   ->set('slug', $fullMd5)
                   ->execute();
            }
        }
        private function getParentPageSlug($pid) {
            $queryBuilderParentPageSlug = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $queryBuilderParentPageSlug->getRestrictions()->removeAll();
            $queryBuilderParentPageSlug->select('slug')
            ->from('pages')
            ->where(
                $queryBuilderParentPageSlug->expr()->eq('uid', $pid)
            );
            $slugRes = $queryBuilderParentPageSlug->execute();
            while ($row = $slugRes->fetch()) {
                return $row['slug'];
            }
            return 'ERROR';
        }
    }