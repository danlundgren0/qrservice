<?php
namespace DanLundgren\DlIponlyestate\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use DanLundgren\DlIponlyestate\Utility\ErrorUtility as errorUtil;
//use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Dan Lundgren <danlundgren0@gmail.com>, Dan Lundgren
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

/**
 * The repository for Reports
 */
class ReportRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias
     */
    public function searchReports(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $searchCriterias)
    {

        $queryBuilderReport = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_report');
        $queryBuilderReport->select('reports.*');
        $queryBuilderReport->where('1=1');
        $queryBuilderEstate = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_estate');        
        $queryBuilderEstate->where('1=1');
        //$queryBuilderEstate->select('tx_dliponlyestate_domain_model_estate estate estate');

        

        //$expressionBuilder = $queryBuilder->expr();
        //$expressionBuilder = GeneralUtility::makeInstance(\TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder);
        /*
        $queryBuilder
           ->getRestrictions()
           ->removeAll()
           ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
        ;
        */

        $reportArr = array();
        $and = '';
        $from = 'tx_dliponlyestate_domain_model_report reports ';
        $additionalWhere = '';
        $additionalOrderBy = '';
        $addEstateNoReportWhereFromDate = '';
        $addEstateNoReportWhereToDate = '';
        $addEstateNoReportWhere = '';
        if ((int) $searchCriterias->getNodeType() > 0) {
            $additionalWhere .= ' AND nodeType.uid =  ' . $searchCriterias->getNodeType();
            $addAND .= ' AND nodeType.uid =  ' . $searchCriterias->getNodeType();
            $queryBuilderReport->andWhere($queryBuilderReport->expr()->eq('nodeType.uid', '"'.$searchCriterias->getNodeType().'"'));
            $queryBuilderEstate->andWhere($queryBuilderEstate->expr()->eq('nodeType.uid', '"'.$searchCriterias->getNodeType().'"'));
        }
        if ($searchCriterias->getCity() != -1) {

            $additionalWhere .= ' AND estate.city =  "' . $searchCriterias->getCity() . '"';
            $addAND .= ' AND estate.city = "' . $searchCriterias->getCity() . '"';
            $queryBuilderReport->andWhere($queryBuilderReport->expr()->eq('estate.city', $searchCriterias->getCity()));            
            $queryBuilderEstate->andWhere($queryBuilderEstate->expr()->eq('estate.city', $searchCriterias->getCity()));
        }
        if ($searchCriterias->getArea() != '-1') {
            $additionalWhere .= ' AND estate.pid =  "' . $searchCriterias->getArea() . '"';
            $addAND .= ' AND estate.pid = "' . $searchCriterias->getArea() . '"';
            $queryBuilderReport->andWhere($queryBuilderReport->expr()->eq('estate.pid', '"'.$searchCriterias->getArea().'"'));            
            $queryBuilderEstate->andWhere($queryBuilderEstate->expr()->eq('estate.pid', '"'.$searchCriterias->getArea().'"'));
			//print($queryBuilderReport->getSQL());
        }
        if ((int) $searchCriterias->getTechnician() > 0) {
            $additionalWhere .= ' AND estate.responsible_technician =  ' . $searchCriterias->getTechnician();
            $addAND .= ' AND feuser.uid = ' . $searchCriterias->getTechnician();
            $queryBuilderReport->andWhere($queryBuilderReport->expr()->eq('estate.responsible_technician', $searchCriterias->getTechnician()));
            $queryBuilderEstate->andWhere($queryBuilderEstate->expr()->eq('estate.responsible_technician', $searchCriterias->getTechnician()));
        }
        if ($searchCriterias->getNoteType() > 0) {
            /*
            $from .= ' LEFT JOIN tx_dliponlyestate_domain_model_note note ON note.state = ' . $searchCriterias->getNoteType() . '
             AND reports.uid = note.report AND note.is_complete=0';
            $and = ' AND ';
	        */

	        //TODO: See if this switch is needed
            switch ($searchCriterias->getNoteType()) {
                case '2':    $additionalWhere .= ' AND reports.no_of_critical_remarks > 0 ';
                	$queryBuilderReport->leftJoin('reports','tx_dliponlyestate_domain_model_note','note', 'reports.uid = note.report AND note.is_complete=0 AND reports.no_of_critical_remarks > 0');
                    //TODO: Activate if Lina request it
                    //$additionalOrderBy .= ' reports.no_of_critical_remarks DESC, ';
                    break;
                case '3':    $additionalWhere .= ' AND reports.no_of_remarks > 0 ';
                	$queryBuilderReport->leftJoin('reports','tx_dliponlyestate_domain_model_note','note', 'reports.uid = note.report AND note.is_complete=0 AND reports.no_of_remarks > 0');
                    //TODO: Activate if Lina request it
                    //$additionalOrderBy .= ' reports.no_of_remarks DESC, ';
                    break;
                case '4':    $additionalWhere .= ' AND reports.no_of_purchases > 0 ';
                	$queryBuilderReport->leftJoin('reports','tx_dliponlyestate_domain_model_note','note', 'reports.uid = note.report AND note.is_complete=0 AND reports.no_of_purchases > 0');
                    //TODO: Activate if Lina request it
                    //$additionalOrderBy .= ' reports.no_of_purchases DESC, ';
                    break;
                default:    break;
            }
        }
        if ($searchCriterias->getFromDate() != '') {
            $additionalWhere .= ' AND reports.date>=\'' . $searchCriterias->getFromDate() . '\' ';
            $addEstateNoReportWhereFromDate = '\'' . $searchCriterias->getFromDate() . '\' ';
            $queryBuilderReport->andWhere($queryBuilderReport->expr()->gte('reports.date', $searchCriterias->getFromDate()));            
            $queryBuilderEstate->andWhere($queryBuilderEstate->expr()->gte('reports.date', $searchCriterias->getFromDate()));
        }
        if ($searchCriterias->getToDate() != '') {
            $additionalWhere .= ' AND reports.date<=\'' . $searchCriterias->getToDate() . '\' ';
            $addEstateNoReportWhereToDate = '\'' . $searchCriterias->getToDate() . ' 23:59:59\'';
            $queryBuilderReport->andWhere($queryBuilderReport->expr()->lte('reports.date', '\'' . $searchCriterias->getToDate() . ' 23:59:59\''));            
            $queryBuilderEstate->andWhere($queryBuilderEstate->expr()->lte('reports.date', '\'' . $searchCriterias->getToDate() . ' 23:59:59\''));
        }
        if ($searchCriterias->getFreeSearch() != '') {
            $additionalWhere .= '
				AND (
				 	(estate.name LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.estate = estate.uid)
				 	OR (feuser2.username LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.executive_technician = feuser2.uid)
				 	OR (remarks.comment LIKE \'%' . $searchCriterias->getFreeSearch() . '%\' AND reports.uid = remarks.report)
				)
            ';
            /*
            $orCondition = $expressionBuilder->orX();
            $orCondition->add(
                $queryBuilderReport->expr()->like('estate.name', $queryBuilderReport->createNamedParameter('%' . $queryBuilderReport->escapeLikeWildcards($searchCriterias->getFreeSearch()) . '%')),
                $queryBuilderReport->expr()->eq('reports.estate', 'estate.uid')
            );
            */
            $queryBuilderReport->andWhere(
                $queryBuilderReport->expr()->orX(                  
    				$queryBuilderReport->expr()->andX(
    			        $queryBuilderReport->expr()->like('estate.name', $queryBuilderReport->createNamedParameter('%' . $queryBuilderReport->escapeLikeWildcards($searchCriterias->getFreeSearch()) . '%')),
    			        $queryBuilderReport->expr()->eq('reports.estate', 'estate.uid')
                    )
    			),
                $queryBuilderReport->expr()->orX(
					$queryBuilderReport->expr()->andX(
				    	$queryBuilderReport->expr()->like('feuser2.username', $queryBuilderReport->createNamedParameter('%' . $queryBuilderReport->escapeLikeWildcards($searchCriterias->getFreeSearch()) . '%')),
				    	$queryBuilderReport->expr()->eq('reports.executive_technician', 'feuser2.uid')
					),
                ),
                $queryBuilderReport->expr()->orX(
					$queryBuilderReport->expr()->andX(
				    	$queryBuilderReport->expr()->like('remarks.comment', $queryBuilderReport->createNamedParameter('%' . $queryBuilderReport->escapeLikeWildcards($searchCriterias->getFreeSearch()) . '%')),
				    	$queryBuilderReport->expr()->eq('reports.uid', 'remarks.report')
					)
    			)
			);
        }
        if ($from == '') {
            $from = 'tx_dliponlyestate_domain_model_report reports ';
        }
        $where = ' reports.deleted=0 AND reports.hidden=0 AND estate.deleted=0 AND estate.hidden=0  ';
        $where .= $additionalWhere;
        $groupBy = 'reports.uid';

        $queryBuilderReport->groupBy('reports.uid');
        $queryBuilderReport->orderBy('respTechnicianName', 'ASC');
        $queryBuilderReport->addOrderBy('nodeTypeName', 'ASC');
        $queryBuilderReport->addOrderBy('reports.name', 'DESC');

        $orderBy = $additionalOrderBy . ' respTechnicianName ASC , nodeTypeName ASC , reports.name DESC';

        
        
        $queryBuilderReport->addSelect('estate.name AS estateName')        
        ->addSelect('estate.uid AS estateUid')
        ->addSelect('estate.page_link AS pageLink')
        ->addSelect('nodeType.uid AS nodeTypeUid')
        ->addSelect('nodeType.name AS nodeTypeName')
        ->addSelect('feuser.name AS respTechnicianName')
        ->addSelect('feuser2.name AS execTechnicianName')

		->addSelectLiteral('COUNT(CASE WHEN remarks.remark_type = 3 AND remarks.is_complete = 0 THEN remarks.remark_type END) AS noOfRemarks')
		->addSelectLiteral('COUNT(CASE WHEN remarks.remark_type = 2 AND remarks.is_complete = 0 THEN remarks.remark_type END) AS noOfCriticalRemarks')
        ->addSelectLiteral('COUNT(CASE WHEN remarks.is_complete = 1 THEN remarks.remark_type END) AS noOfCompletedNotes')
        ->addSelectLiteral('COUNT(CASE WHEN remarks.remark_type = 4 AND remarks.is_complete = 0 THEN remarks.remark_type END) AS noOfPurchases')
        ->addSelectLiteral('COUNT(CASE WHEN remarks.remark_type = 1 THEN remarks.remark_type END) AS getNoOfOk')
        ->addSelectLiteral('(reports.no_of_notes+reports.reported_measurement) AS NoOfReportedNotesAndMeas, 
            (
                SELECT SUM(cp.questions)
                FROM tx_dliponlyestate_domain_model_controlpoint cp, tx_dliponlyestate_estate_controlpoint_mm estate_cp_mm
                WHERE cp.uid = estate_cp_mm.uid_foreign AND estate.uid = estate_cp_mm.uid_local
            ) AS noOfTotalNotesAndMeas ')
        ->from('tx_dliponlyestate_domain_model_report', 'reports')
        ->leftJoin('reports','tx_dliponlyestate_domain_model_note', 'remarks', 
            $queryBuilderReport->expr()->eq(
                'reports.uid',
                'remarks.report'
            )
        )
        ->leftJoin('reports','tx_dliponlyestate_domain_model_estate', 'estate', 
            $queryBuilderReport->expr()->eq(
                'reports.estate',
                'estate.uid'
            )
        )
        ->leftJoin('estate','tx_dliponlyestate_domain_model_nodetype', 'nodeType', 
            $queryBuilderReport->expr()->eq(
                'estate.node_type',
                'nodeType.uid'
            )
        )
        ->leftJoin('estate','fe_users', 'feuser', 
            $queryBuilderReport->expr()->eq(
                'estate.responsible_technician',
                'feuser.uid'
            )
        )
        ->leftJoin('reports','fe_users', 'feuser2', 
            $queryBuilderReport->expr()->eq(
                'reports.executive_technician',
                'feuser2.uid'
            )
        );
        /*->where(
           $queryBuilderReport->expr()->eq($where)
        ); */
        //$queryBuilderReport->setMaxResults(2);
        $estateUidsWithReportsArr = [];
        $searchRes = $queryBuilderReport->execute();
        $nodeTypeArr = $this->getNodeTypes();
        $reportsByEstate = [];
        while ($row = $searchRes->fetch()) {
            if ((int) $row['estate'] > 0) {
            	if(!in_array($row['estate'], $estateUidsWithReportsArr)) {
            		$estateUidsWithReportsArr[] = $row['estate'];	
            	}            	
                $reportsByEstate[$row['estate']][] = $row;
				$nodeTypeUid = $row['nodeTypeUid'];
				$estateUid = $row['estate'];
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstates'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstates'] = 0;
				}
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'] = 0;
				}				
                if(!in_array($estateUid, $nodeTypeArr[$nodeTypeUid]['estateUids'])) {
                	$nodeTypeArr[$nodeTypeUid]['estateUids'][] = $estateUid;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstates'] += 1;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstatesWithReport'] += 1;
                }                
            }
        }
        $estateUidsWithReports = implode(',',$estateUidsWithReportsArr);
        //Above replaces this
        //$searchRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $from, $where, $groupBy, $orderBy);
		//print($queryBuilderReport->getSQL());
		//debug($queryBuilderReport->getSQL());

//die('queryBuilderReport');

        //$queryBuilderEstate

        //THIS SQL selects all estates without any report within the set daterange
        $estateUidArr = array();
        $estateUidSelect = 'estate.uid AS estate,estate.name AS estateName, nodeType.uid AS nodeTypeUid, nodeType.name AS nodeTypeName, estate.page_link AS pageLink, feuser.name AS respTechnicianName, "noReport"';

        //TODO: Find out what to do with "noReport" above
        $queryBuilderEstate->addSelect('estate.uid AS estate')
        ->addSelect('estate.name AS estateName')
        ->addSelect('nodeType.uid AS nodeTypeUid')
        ->addSelect('nodeType.name AS nodeTypeName')
        ->addSelect('estate.page_link AS pageLink')
        ->addSelect('feuser.name AS respTechnicianName')
        ->addSelectLiteral('"noReport"')
        ->from('tx_dliponlyestate_domain_model_report', 'reports')
        ->from('tx_dliponlyestate_domain_model_estate', 'estate');

        $queryBuilderEstate->leftJoin('estate','tx_dliponlyestate_domain_model_nodetype', 'nodeType', 
            $queryBuilderEstate->expr()->eq(
                'nodeType.uid',
                'estate.node_type'
            )
        );
        $queryBuilderEstate->leftJoin('estate','fe_users', 'feuser', 
            $queryBuilderReport->expr()->eq(
                'feuser.uid',
                'estate.responsible_technician'
            )
        );
        if(is_array($estateUidsWithReportsArr) && count($estateUidsWithReportsArr)>0) {
	        $queryBuilderEstate->andWhere(
	            $queryBuilderEstate->expr()->notIn('estate.uid', $estateUidsWithReports)
	        );        	
        }

//print('<br>--------------------------<br>');      
//print($queryBuilderEstate->getSQL());
		$estateUidRes = $queryBuilderEstate->execute();
//die('queryBuilderEstate');

        //$estateUidRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($estateUidSelect, $estateUidFrom, $estateUidWhere);        
        $debugQuery = 'SELECT ' . $estateUidSelect . ' FROM ' . $estateUidFrom . ' WHERE ' . $estateUidWhere;
        //print('<br>-------------<br>');
        
        //print($debugQuery);
        $reportUids = array();
        
        //if ($searchCriterias->getSearchAll()) {
            //while ($estateUidRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($estateUidRes)) {
            while ($estateUidRow = $estateUidRes->fetch()) {
                //$estateUidArr[] = $estateUidRow['uid'];
                $reportsByEstate[$estateUidRow['uid']][] = $estateUidRow;

				$nodeTypeUid = $estateUidRow['nodeTypeUid'];
				$estateUid = $estateUidRow['estate'];
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstates'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstates'] = 0;
				}
				if(!isset($nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'])) {
					$nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'] = 0;
				}
                if(!in_array($estateUid, $nodeTypeArr[$nodeTypeUid]['estateUids'])) {
                	$nodeTypeArr[$nodeTypeUid]['estateUids'][] = $estateUid;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstates'] += 1;
                	$nodeTypeArr[$nodeTypeUid]['noOfEstatesNoReport'] += 1;
                }
            }
        //}
        
        

        $searchedReports = $this->getSearchedReports($reportsByEstate);
        $searchedReports['statistics'] = $nodeTypeArr;
        return $searchedReports;
    }

    private function getNodeTypes() {
        //$nodeTypeRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('name, uid', 'tx_dliponlyestate_domain_model_nodetype', 'deleted = 0 and hidden = 0');
    	$nodeTypeArr = [];
        $queryBuilderNodetype = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_nodetype');
        $queryBuilderNodetype->from('tx_dliponlyestate_domain_model_nodetype');
        $queryBuilderNodetype->where('1=1');
        $queryBuilderNodetype->addSelect('name');
        $queryBuilderNodetype->addSelect('uid');
    	$nodeTypeRes = $queryBuilderNodetype->execute();
        //while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($nodeTypeRes)) {
        while ($row = $nodeTypeRes->fetch()) {
            if (!array_key_exists($row['uid'], $nodeTypeArr)) {
                $nodeTypeArr[$row['uid']]['nodeTypeName'] = $row['name'];
                $nodeTypeArr[$row['uid']]['estateUids'] = [];
            	$nodeTypeArr[$row['uid']]['noOfEstates'] = 0;
            	$nodeTypeArr[$row['uid']]['noOfEstatesWithReport'] = 0;
            	$nodeTypeArr[$row['uid']]['noOfEstatesNoReport'] = 0;
            }
        }
        return $nodeTypeArr;
    }
    
    /**
     * @param $reportsByEstate
     */
    private function getSearchedReports($reportsByEstate)
    {
        $returnArr = array();
        foreach ($reportsByEstate as $estateArr) {
            $hasReports = true;
            $totalNoOfCriticalRemarks = 0;
            $totalNoOfRemarks = 0;
            $totalNoOfPurchases = 0;
            $totalNoOfCompletedNotes = 0;
            foreach ($estateArr as $reportsArr) {
                $noOfTotalNotesAndMeas = 0;
                //TODO: Kolla ifall denna behövs ReportUtility rad: 494
                /*
                foreach($report->getEstate()->getControlPoints() as $cp) {
                    $noOfTotalNotesAndMeas += count($cp->getQuestions());
                }
                */
                
                $noOfScannedNotesAndMeas = 0;
                $isAtLeastPartlyChecked = FALSE;
                $levelOneIdentifier = 'estate_' . $reportsArr['estate'];
                if ($reportsArr['noReport']) {
                    $returnArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                    $returnArr['level1'][$levelOneIdentifier]['estateName'] = $reportsArr['estateName'];
                    $returnArr['level1'][$levelOneIdentifier]['estateUid'] = $reportsArr['estateUid'];
                    $returnArr['level1'][$levelOneIdentifier]['noReport'] = $reportsArr['noReport'];
                    $returnArr['level1'][$levelOneIdentifier]['pageLink'] = errorUtil::linkTYPO3Ver9BugFix($reportsArr['pageLink']);
                    $returnArr['level1'][$levelOneIdentifier]['respTechnicianName'] = $reportsArr['respTechnicianName'];
                    //$returnArr['level1'][$levelOneIdentifier]['respTechnicianName'] = 'ZZZ';
                    $hasReports = false;
                    continue;
                }
                $totalNoOfCriticalRemarks += $reportsArr['no_of_critical_remarks'];
                //->getNoOfCriticalRemarks();
                $totalNoOfRemarks += $reportsArr['no_of_remarks'];
                $totalNoOfPurchases += $reportsArr['no_of_purchases'];
                //TODO: Implement in main query
                //$noteRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery('notes.*', 'tx_dliponlyestate_domain_model_note notes', 'report = ' . $reportsArr['uid'] . ' and is_complete = 1 ', '', '');

                $queryBuilderNote = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_note');
				$totalNoOfCompletedNotesCount = $queryBuilderNote->select('notes.*')
					->from('tx_dliponlyestate_domain_model_note', 'notes')
					->where($queryBuilderNote->expr()->eq('report', $reportsArr['uid']))
					->andWhere($queryBuilderNote->expr()->eq('is_complete', 1));
				$noteRes = $queryBuilderNote->execute();
                //$totalNoOfCompletedNotes += $GLOBALS['TYPO3_DB']->sql_num_rows($noteRes);
                //$totalNoOfCompletedNotes = $GLOBALS['TYPO3_DB']->sql_num_rows($noteRes);
                $totalNoOfCompletedNotes = $queryBuilderNote->execute()->fetchColumn();
                $reportsArr['totalNoOfCompletedNotes'] = $totalNoOfCompletedNotes;
                $returnArr['level1'][$levelOneIdentifier]['estateUid'] = $reportsArr['estateUid'];
                //$estate->getUid();
                $returnArr['level1'][$levelOneIdentifier]['pageLink'] = errorUtil::linkTYPO3Ver9BugFix($reportsArr['pageLink']);
                //$estate->getPageLink();
                $returnArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                //$estate->getNodeType()->getName();
                $returnArr['level1'][$levelOneIdentifier]['respTechnicianName'] = strlen($reportsArr['respTechnicianName']) > 0 ? $reportsArr['respTechnicianName'] : 'Tekniker saknas på fastigheten';
                //$estate->getRespTechnicianName();
                $returnArr['level1'][$levelOneIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                $returnArr['level1'][$levelOneIdentifier]['hasReports'] = count($reportsArr);
                $levelTwoIdentifier = 'report_' . $reportsArr['uid'];

                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasAdminNote'] = $reportsArr['has_admin_note'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['adminNoteIsChecked'] = $reportsArr['admin_note_is_checked'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['adminNote'] = $reportsArr['admin_note'];

                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportUid'] = $reportsArr['uid'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfCompletedNotes'] = $totalNoOfCompletedNotes;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfCriticalRemarks'] = $totalNoOfCriticalRemarks;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfRemarks'] = $totalNoOfRemarks;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['totalNoOfPurchases'] = $totalNoOfPurchases;
                $returnArr['level1'][$levelOneIdentifier]['estateName'] = $reportsArr['estateName'];
                $returnArr['level1'][$levelOneIdentifier]['estateUid'] = $reportsArr['estateUid'];
                $returnArr['level1'][$levelOneIdentifier]['pageLink'] = errorUtil::linkTYPO3Ver9BugFix($reportsArr['pageLink']);
                $returnArr['level1'][$levelOneIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['nodeTypeName'] = $reportsArr['nodeTypeName'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['respTechnicianName'] = strlen($reportsArr['respTechnicianName']) > 0 ? $reportsArr['respTechnicianName'] : 'Tekniker saknas på fastigheten';
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['execTechnicianName'] = $reportsArr['execTechnicianName'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['dateVersion'] = date('Y-m-d', strtotime($reportsArr['date'])) . ' Nr ' . $reportsArr['version'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['dateString'] = date('Y-m-d', strtotime($reportsArr['date']));
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['versionWithLabel'] = ' Nr ' . $reportsArr['version'];
                $queryBuilderNote2 = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_note');
				$queryBuilderNote2->select('notes.*')
					->from('tx_dliponlyestate_domain_model_note', 'notes')
					->where($queryBuilderNote2->expr()->eq('report', $reportsArr['uid']));					
				//$noteRes2 = $queryBuilderNote2->execute();
                //$noteRes2 = $GLOBALS['TYPO3_DB']->exec_SELECTquery('notes.*', 'tx_dliponlyestate_domain_model_note notes', 'report = ' . $reportsArr['uid'], '', '');
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasNotes'] = $queryBuilderNote2->execute()->fetchColumn();
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportUid'] = $reportsArr['uid'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['reportName'] = $reportsArr['name'];
                if (strlen($reportsArr['start_date']) > 0) {
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['startDate'] = date('Y-m-d H:i', strtotime($reportsArr['start_date']));
                }
                if (strlen($reportsArr['end_date']) > 0) {
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['endDate'] = date('Y-m-d H:i', strtotime($reportsArr['end_date']));
                }
                //TODO: Check Multi Joins if note remarks is wrong
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCriticalRemarks'] = $reportsArr['noOfCriticalRemarks'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfRemarks'] = $reportsArr['noOfRemarks'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfCompletedNotes'] = $reportsArr['noOfCompletedNotes'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfNotes'] = $reportsArr['notes'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfPurchases'] = $reportsArr['noOfPurchases'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                $returnArr['level1'][$levelOneIdentifier]['hasReports'] = count($estateArr);
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['hasNotes'] = $reportsArr['no_of_notes'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['getNoOfOk'] = $reportsArr['getNoOfOk'];
                /*
                //With images - comented because it only select those with images
                $noteSelect = ' note.control_point AS cpUid,
                                note.question AS quUid, note.comment AS comment,
                                note.remark_type AS remarkType,
                                image.identifier AS image, cp.NAME AS cpName,
                                qu.NAME AS questionName ';
                $noteFrom = ' tx_dliponlyestate_domain_model_note note
                            RIGHT JOIN tx_dliponlyestate_domain_model_controlpoint cp ON note.control_point = cp.uid
                            RIGHT JOIN tx_dliponlyestate_domain_model_question qu ON note.question = qu.uid
                            RIGHT JOIN sys_file_reference ref ON note.uid = ref.uid_foreign AND ref.tablenames = "tx_dliponlyestate_domain_model_note"
                            RIGHT JOIN sys_file image ON image.uid = ref.uid_local
                            ';
                */
                /*
                $noteSelect = ' note.control_point AS cpUid, 
                                note.question AS quUid, note.comment AS comment, 
                                note.remark_type AS remarkType, note.is_complete as isComplete, 
                                cp.NAME AS cpName, 
                                qu.NAME AS questionName ';
                $noteFrom = ' tx_dliponlyestate_domain_model_note note 
                            RIGHT JOIN tx_dliponlyestate_domain_model_controlpoint cp ON note.control_point = cp.uid
                            RIGHT JOIN tx_dliponlyestate_domain_model_question qu ON note.question = qu.uid
                            ';
                $noteWhere = ' report=' . $reportsArr['uid'];
                $debugSQL = 'SELECT ' . $noteSelect . ' FROM ' . $noteFrom . ' WHERE ' . $noteWhere;
                //print($debugSQL);
                
                $noteRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($noteSelect, $noteFrom, $noteWhere, '', '');
				*/
				$queryBuilderNoteSelect = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_note');
				$queryBuilderNoteSelect->select('note.control_point AS cpUid')
				->addSelect('note.question AS quUid')
				->addSelect('note.comment AS comment')
				->addSelect('note.remark_type AS remarkType')
				->addSelect('note.is_complete as isComplete')
				->addSelect('cp.NAME AS cpName')
				->addSelect('qu.NAME AS questionName')
		        ->rightJoin('note','tx_dliponlyestate_domain_model_controlpoint', 'cp', 
		            $queryBuilderNoteSelect->expr()->eq(
		                'note.control_point',
		                'cp.uid'
		            )
		        )
		        ->rightJoin('note','tx_dliponlyestate_domain_model_question', 'qu', 
		            $queryBuilderNoteSelect->expr()->eq(
		                'note.question',
		                'qu.uid'
		            )
		        )
		        ->where(
            		$queryBuilderNoteSelect->expr()->eq('note.report', $reportsArr['uid'])
        		)
				->from('tx_dliponlyestate_domain_model_note', 'note');
				
				$noteRes = $queryBuilderNoteSelect->execute();
                while ($note = $noteRes->fetch()) {
                    $isAtLeastPartlyChecked = TRUE;
                    $noOfScannedNotesAndMeas += 1;
                    if ($note['cpUid'] === null || (int) $note['cpUid'] == 0) {
                        continue;
                    }
                    $levelThreeIdentifier = 'cp_' . $note['cpUid'];
                    if ($note['quUid'] === null || (int) $note['quUid'] == 0) {
                        continue;
                    }
                    $levelFourIdentifier = 'quest_' . $note['quUid'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['cpName'] = $note['cpName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['questionName'] = $note['questionName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['comment'] = $note['comment'];
                    if ($note['isComplete'] == 0) {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['remarkType'] = $note['remarkType'];
                    } else {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['remarkType'] = '88';
                    }
                    if ($note['image'] && strlen($note['image']) > 0) {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['image'] = 'fileadmin' . $note['image'];
                    }
                }
                /*
                $measureSelect = ' reported_measurement.control_point AS cpUid, 
                                    reported_measurement.question AS quUid, 
                                    reported_measurement.unit AS unit, 
                                    reported_measurement.value AS value, 
                                    reported_measurement.page_id AS page_id,
                                    cp.NAME AS cpName, 
                                    qu.NAME AS questionName 
                                ';
                $measureFrom = '    tx_dliponlyestate_domain_model_reportedmeasurement reported_measurement 
                                    RIGHT JOIN tx_dliponlyestate_domain_model_controlpoint cp ON reported_measurement.control_point = cp.uid 
                                    RIGHT JOIN tx_dliponlyestate_domain_model_question qu ON reported_measurement.question = qu.uid
                            ';
                $measureWhere = ' report=' . $reportsArr['uid'];
                $debugSQL = 'SELECT ' . $measureSelect . ' FROM ' . $measureFrom . ' WHERE ' . $measureWhere;
                $measureRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($measureSelect, $measureFrom, $measureWhere, '', '');
                */
                $queryBuilderMeasure = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_reportedmeasurement');
				$queryBuilderMeasure->select('reported_measurement.control_point AS cpUid')
				->addSelect('reported_measurement.question AS quUid')
				->addSelect('reported_measurement.unit AS unit')
				->addSelect('reported_measurement.value AS value')
				->addSelect('reported_measurement.page_id AS page_id')
				->addSelect('cp.NAME AS cpName')
				->addSelect('qu.NAME AS questionName')
		        ->rightJoin('reported_measurement','tx_dliponlyestate_domain_model_controlpoint', 'cp', 
		            $queryBuilderMeasure->expr()->eq(
		                'reported_measurement.control_point',
		                'cp.uid'
		            )
		        )
		        ->rightJoin('reported_measurement','tx_dliponlyestate_domain_model_question', 'qu', 
		            $queryBuilderMeasure->expr()->eq(
		                'reported_measurement.question',
		                'qu.uid'
		            )
		        )
		        ->where(
            		$queryBuilderMeasure->expr()->eq('report', $reportsArr['uid'])
        		)
				->from('tx_dliponlyestate_domain_model_reportedmeasurement', 'reported_measurement');
				$measureRes = $queryBuilderMeasure->execute();

                $noOfMeasurements = 0;
                while ($measurement = $measureRes->fetch()) {
                    $isAtLeastPartlyChecked = TRUE;
                    $noOfMeasurements += 1;
                    $noOfScannedNotesAndMeas += 1;
                    if ($measurement['cpUid'] === null || (int) $measurement['cpUid'] == 0) {
                        continue;
                    }
                    $levelThreeIdentifier = 'cp_' . $measurement['cpUid'];
                    if ($measurement['quUid'] === null || (int) $measurement['quUid'] == 0) {
                        continue;
                    }
                    $levelFourIdentifier = 'quest_' . $measurement['quUid'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['cpName'] = $measurement['cpName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['questionName'] = $measurement['questionName'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['comment'] = $measurement['value'];
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['level3'][$levelThreeIdentifier]['level4'][$levelFourIdentifier]['remarkType'] = '99';
                }                
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfMeasurements'] = $noOfMeasurements;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfScannedNotesAndMeas'] = $noOfScannedNotesAndMeas;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['NoOfReportedNotesAndMeas'] = $reportsArr['NoOfReportedNotesAndMeas'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['noOfTotalNotesAndMeas'] = $reportsArr['noOfTotalNotesAndMeas'];
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['allCheckedAndOk'] = FALSE;
                $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['partlyCheckedAndOk'] = FALSE;
                //$reportsArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = FALSE;
                if ((int) $reportsArr['NoOfReportedNotesAndMeas'] >= (int) $reportsArr['noOfTotalNotesAndMeas']) {
                    $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['allCheckedAndOk'] = TRUE;
                } else {
                    if ((int) $reportsArr['NoOfReportedNotesAndMeas'] > 0 && (int) $reportsArr['NoOfReportedNotesAndMeas'] < (int) $reportsArr['noOfTotalNotesAndMeas']) {
                        $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['partlyCheckedAndOk'] = TRUE;
                    } else {
                        if (!$isAtLeastPartlyChecked) {
                            $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['newOrNotCheckedAtAll'] = TRUE;
                        }
                    }
                }
                $tmpNoOfOk = $returnArr['level1'][$levelOneIdentifier]['level2'][$levelTwoIdentifier]['getNoOfOk'];
            }
        }
        return $returnArr;
    }
    
    /**
     * @param $a
     * @param $b
     */
    public function cmpDesc($a, $b)
    {
        if ($a->getUid() == $b->getUid()) {
            //if ($a['uid'] == $b['uid']) {
            return 0;
        }
        return $a->getUid() > $b->getUid() ? -1 : 1;
    }
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand
     */
    public function findEstates(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand)
    {
        $query = $this->createQuery();
        $constraints = array();
        if ($demand->getEstate() != 0) {
            $constraints[] = $query->matching($query->equals('estate', $demand->getEstate()));
        } else {
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
            $estateRepository = $objectManager->get('DanLundgren\\DlIponlyestate\\Domain\\Repository\\EstateRepository');
            $estates = $estateRepository->findAll();
            $constraints[] = $estateRepository->findAll();
        }
        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }
    
    /**
     * @param \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand
     */
    public function findBySearchWord(\DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias $demand)
    {
        $query = $this->createQuery();
        $constraints = array();
        if (is_string($demand->getFreeSearch()) && strlen($demand->getFreeSearch()) > 0) {
            if (count($demand->getNotes()) > 0) {
                foreach ($demand->getNotes() as $note) {
                    $constraints[] = $query->like($note->getComment(), '%' . $demand->getFreeSearch . '%');
                }
            }
        }
        //$query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }
}