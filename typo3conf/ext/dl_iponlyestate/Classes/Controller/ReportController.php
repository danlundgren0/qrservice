<?php
namespace DanLundgren\DlIponlyestate\Controller;
require '/var/www/vendor/autoload.php';
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use ZipStream;
//use SimpleExcel\SimpleExcel;
//use SimpleExcel\SimpleExcel\Parser;
use DanLundgren\DlIponlyestate\Utility\ReportUtility as ReportUtil;

//require_once('typo3conf/ext/simple_excel/src/SimpleExcel/SimpleExcel.php');
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

/**
 * ReportController
 */
class ReportController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * controlPointRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ControlPointRepository
     * @inject
     */
    protected $controlPointRepository = NULL;
    
    /**
     * dynamicColumnRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\DynamicColumnRepository
     * @inject
     */
    protected $dynamicColumnRepository = NULL;
    
    /**
     * estateRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\EstateRepository
     * @inject
     */
    protected $estateRepository = NULL;
    
    /**
     * measurementValuesRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\MeasurementValuesRepository
     * @inject
     */
    protected $measurementValuesRepository = NULL;
    
    /**
     * nodeTypeRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NodeTypeRepository
     * @inject
     */
    protected $nodeTypeRepository = NULL;
    
    /**
     * noteRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\NoteRepository
     * @inject
     */
    protected $noteRepository = NULL;
    
    /**
     * questionRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\QuestionRepository
     * @inject
     */
    protected $questionRepository = NULL;
    
    /**
     * reportedMeasurementRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportedMeasurementRepository
     * @inject
     */
    protected $reportedMeasurementRepository = NULL;
    
    /**
     * reportRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\ReportRepository
     * @inject
     */
    protected $reportRepository = NULL;
    
    /**
     * technicianRepository
     *
     * @var \DanLundgren\DlIponlyestate\Domain\Repository\TechnicianRepository
     * @inject
     */
    protected $technicianRepository = NULL;
    
    /**
     * estateAreaPIDs
     *
     * @var array
     */
    protected $estateAreaPIDs = NULL;
    
    /**
     * @param $a
     * @param $b
     */
    public function cmp($a, $b)
    {
        if ($a->getUid() == $b->getUid()) {
            return 0;
        }
        return $a->getUid() > $b->getUid() ? -1 : 1;
    }
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        /*
        $report = $this->reportRepository->findByUid(52);
        $report2 = $this->reportRepository->findByUid(53);
        $estate = $this->estateRepository->findByUid(25);
        $completeReportArr = ReportUtil::getCompleteReport($report, $estate);
        $completeReportArr2 = ReportUtil::getCompleteReport($report2, $estate);
        */
        
        //header("Content-Type: text/html");
        //header_remove('Content-Disposition');
        $reportsByEstate = array();
        $arguments = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_dliponlyestate_reportsearch');
        if ($arguments && count($arguments) > 1) {
            $searchCriterias = new \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias($arguments['fromDate'], $arguments['endDate'], $arguments['nodeTypes'], $arguments['estates'], $arguments['cities'], $arguments['notes'], $arguments['technicians'], $arguments['freeSearch'], $arguments['area']);
            $latestReports = $this->reportRepository->searchReports($searchCriterias);
        }
        //} else {
            /*if (is_array($arguments) && count($arguments) == 1 && $arguments['xls'] == '1') {
                $searchCriterias = new \DanLundgren\DlIponlyestate\Domain\Model\SearchCriterias();
                $latestReports = $this->reportRepository->searchReports($searchCriterias);
            }*/
        //}
        if ($arguments['xls'] == '1') {
            //$this->excelAction($latestReports, $arguments);
            $this->spreadSheetAction($latestReports, $arguments);
        }
        $this->view->assign('latestReports', $latestReports);
    }
    
    /**
     * action search
     *
     * @return void
     */
    public function searchAction()
    {
        $arguments = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_dliponlyestate_reportsearch');
        $this->view->assign('arguments', $arguments);
        $this->view->assign('estates', $this->getEstates());
        $this->view->assign('area', $this->getArea());
        $this->view->assign('cities', $this->getEstateCities());
        //$estate = $this->estateRepository->findByUid(13);
        //$this->view->assign('technicians', $this->getTechnicians($estate));
        $this->view->assign('technicians', $this->getTechnicians());
        $this->view->assign('nodeTypes', $this->getNodeTypes());
        $this->view->assign('notes', $this->getNotes());
    }
    
    public function getControlPoints()
    {
        return $this->controlPointRepository->findAll();
    }
    
    public function getDynamicColumns()
    {
        
    }
    
    public function getEstateCities()
    {
        $estates = $this->estateRepository->findAll();
        $cities = array('-1' => 'Alla');
        foreach ($estates as $estate) {
            if (!in_array($estate->getCity(), $cities) && $estate->getCity() != '') {
                $cities[$estate->getCity()] = $estate->getCity();
            }
        }
        ksort($cities);
        return $cities;
    }
    
    /**
     * @param $estate
     */
    public function getTechnicians($estate = NULL)
    {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $technicianRepository = $objectManager->get('TYPO3\\CMS\\Extbase\\Domain\\Repository\\FrontendUserRepository');
        $estates = $this->estateRepository->findAll();
        $technicians = array();
        $technicians['-1'] = 'Alla';
        if ($estate === NULL) {
            foreach ($estates as $estate) {
                if ($estate->getResponsibleTechnician() != 0) {
                    $technician = $technicianRepository->findByUid((int) $estate->getResponsibleTechnician());
                    if (!in_array($technician->getName(), $technicians)) {
                        $technicians[$technician->getUid()] = $technician->getName();
                    }
                }
            }
        } else {
            if ($estate->getResponsibleTechnician() != 0) {
                $technician = $technicianRepository->findByUid((int) $estate->getResponsibleTechnician());
                if (!in_array($technician->getName(), $technicians)) {
                    $technicians[$technician->getUid()] = $technician->getName();
                }
            }
        }
        return $technicians;
    }
    
    public function getArea()
    {
        $areaArr = array('-1' => 'Alla');
        if (is_array($this->estateAreaPIDs) && count($this->estateAreaPIDs) > 0) {
            /*
            $estateAreaPIDs = join(',', $this->estateAreaPIDs);
            $select = ' title,uid ';
            $from = ' pages ';
            $where = ' hidden = 0 AND deleted = 0 AND uid IN (' . $estateAreaPIDs . ')';
            $orderBy = ' title ASC ';
            $areaRes = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select, $from, $where, '', $orderBy);
            while ($areaRow = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($areaRes)) {
                $areaArr[$areaRow['uid']] = $areaRow['title'];
            }
            */

            $estateAreaPIDs = join(',', $this->estateAreaPIDs);
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            $queryBuilder
               ->getRestrictions()
               ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
            ;
            $queryBuilder->select('title','uid')
            ->from('pages')
            ->where(
               $queryBuilder->expr()->in('uid', $estateAreaPIDs)
            );
            $queryBuilder->orderBy('title','ASC');
            $statement = $queryBuilder->execute();
            while ($areaRow = $statement->fetch()) {
               $areaArr[$areaRow['uid']] = $areaRow['title'];
            }

        }
        return $areaArr;
    }
    
    public function getEstates()
    {
        $this->estateAreaPIDs = array();
        $estates = $this->estateRepository->findAll();
        $estatesArr = array('-1' => 'Alla');
        foreach ($estates as $estate) {
            if (!in_array($estate->getPid(), $this->estateAreaPIDs)) {
                $this->estateAreaPIDs[] = $estate->getPid();
            }
            $estatesArr[$estate->getUid()] = $estate->getName();
        }
        return $estatesArr;
    }
    
    public function getFileReferences()
    {
        
    }
    
    public function getMeasurementValues()
    {
        
    }
    
    public function getNodeTypes()
    {
        $nodeTypes = $this->nodeTypeRepository->findAll();
        //$nodeTypesArr['-1'] = 'Alla';
        $nodeTypesArr = array('-1' => 'Alla');
        foreach ($nodeTypes as $nodeType) {
            $nodeTypesArr[$nodeType->getUid()] = $nodeType->getName();
        }
        return $nodeTypesArr;
    }
    
    public function getNotes()
    {
        $notes = array();
        $notes[0] = 'Alla';
        //$notes[1] = 'Ok';
        $notes[2] = 'Kritiska';
        $notes[3] = 'Anmärkningar';
        $notes[4] = 'Inköp/Meddelanden';
        return $notes;
    }
    
    public function getQuestions()
    {
        
    }
    
    public function getReports()
    {
        
    }
    
    public function getReportedMeasurements($latestReports)
    {
        
    }

    /**
     * action spreadSheet
     *
     * @param $latestReports
     * @param $arguments
     * @return void
     */
    public function spreadSheetAction($latestReports, $arguments = NULL)
    {
        $fileName = 'qrservice';
		ob_clean();
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        //$sheet->setCellValue('A1', 'HEJ VÅÄÖRLD !');
        $tmpexcelArr = $this->getSpreadSheetArray($latestReports);
        $sheet->setCellValue('A1', $tmpexcelArr[0][0]);
        $sheet->setCellValue('B1', $tmpexcelArr[0][1]);
        $sheet->setCellValue('C1', $tmpexcelArr[0][2]);
        $sheet->setCellValue('D1', $tmpexcelArr[0][3]);
        $sheet->setCellValue('E1', $tmpexcelArr[0][4]);
        $sheet->setCellValue('F1', $tmpexcelArr[0][5]);
        $sheet->setCellValue('G1', $tmpexcelArr[0][6]);
        $sheet->setCellValue('H1', $tmpexcelArr[0][7]);
        $sheet->setCellValue('I1', $tmpexcelArr[0][8]);
        for($i=2;$i<=count($tmpexcelArr);$i++) {
	        $sheet->setCellValue('A'.$i, $tmpexcelArr[$i]['Typ']);
	        $sheet->setCellValue('B'.$i, $tmpexcelArr[$i]['Benämning']);
	        $sheet->setCellValue('C'.$i, $tmpexcelArr[$i]['Rapport']);
	        $sheet->setCellValue('D'.$i, $tmpexcelArr[$i]['Ansvarig tekniker']);
	        $sheet->setCellValue('E'.$i, $tmpexcelArr[$i]['Utförande tekniker']);
	        $sheet->setCellValue('F'.$i, $tmpexcelArr[$i]['Kontrollpunkt']);
	        $sheet->setCellValue('G'.$i, $tmpexcelArr[$i]['Delpunkt']);
	        $sheet->setCellValue('H'.$i, $tmpexcelArr[$i]['Status']);
	        $sheet->setCellValue('I'.$i, $tmpexcelArr[$i]['Notering']);
        }
/*
\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump(
 array(
  'class' => __CLASS__,
  'function' => __FUNCTION__,
  'tmpexcelArr' => $tmpexcelArr,
 ),'','20'
);
*/
	
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'.xlsx"');
        $writer->save('php://output');
        exit();
    
    }
    
    public function getSpreadSheetArray($latestReports) {
        $tmpexcelArr = array();
        $i = 1;
        $tmpexcelArr[0][] = 'Typ';
        $tmpexcelArr[0][] = 'Benämning';
        $tmpexcelArr[0][] = 'Rapport';
        $tmpexcelArr[0][] = 'Ansvarig tekniker';
        $tmpexcelArr[0][] = 'Utförande tekniker';
        $tmpexcelArr[0][] = 'Kontrollpunkt';
        $tmpexcelArr[0][] = 'Delpunkt';
        $tmpexcelArr[0][] = 'Status';
        $tmpexcelArr[0][] = 'Notering';
        foreach ($latestReports['level1'] as $estate) {
            if (!$estate['level2']) {
                $tmpexcelArr[$i]['Typ'] = $estate['nodeTypeName'];
                $tmpexcelArr[$i]['Benämning'] = $estate['estateName'];
                $tmpexcelArr[$i]['Rapport'] = 'Ingen rapport';
                $tmpexcelArr[$i]['Ansvarig tekniker'] = $report['respTechnicianName'];
                $tmpexcelArr[$i]['Utförande tekniker'] = '';
                $tmpexcelArr[$i]['Kontrollpunkt'] = '';
                $tmpexcelArr[$i]['Delpunkt'] = '';
                $tmpexcelArr[$i]['Status'] = '';
                $tmpexcelArr[$i]['Notering'] = '';
                $i += 1;
            } else {
                foreach ($estate['level2'] as $report) {
                    if (!$report['level3']) {
                        unset($tmpexcelArr[$i]);
                        continue;
                    }
                    foreach ($report['level3'] as $controlPoint) {
                        foreach ($controlPoint['level4'] as $question) {
                            $tmpexcelArr[$i]['Typ'] = $estate['nodeTypeName'];
                            $tmpexcelArr[$i]['Benämning'] = $estate['estateName'];
                            $tmpexcelArr[$i]['Rapport'] = $report['reportName'];
                            $tmpexcelArr[$i]['Ansvarig tekniker'] = $report['respTechnicianName'];
                            $tmpexcelArr[$i]['Utförande tekniker'] = $report['execTechnicianName'];
                            $tmpexcelArr[$i]['Kontrollpunkt'] = $controlPoint['cpName'];
                            $tmpexcelArr[$i]['Delpunkt'] = $question['questionName'];
                            switch ($question['remarkType']) {
                                case '1':    $tmpexcelArr[$i]['Status'] = 'Ok';
                                    break;
                                case '2':    $tmpexcelArr[$i]['Status'] = 'Kritisk';
                                    break;
                                case '3':    $tmpexcelArr[$i]['Status'] = 'Anmärkning';
                                    break;
                                case '4':    $tmpexcelArr[$i]['Status'] = 'Meddelande';
                                    break;
                                case '88':    $tmpexcelArr[$i]['Status'] = 'Tidigare anmärkning';
                                    break;
                                case '99':    $tmpexcelArr[$i]['Status'] = 'Mätvärde';
                                    break;
                                default:    $tmpexcelArr[$i]['Status'] = 'Ej kontrollerad';
                            }
                            $newlines = array('\r\n', '\n', '\r');
                            //$updated = str_replace($newlines, ' ', strip_tags(stripslashes($question['comment'])));
                            $commentNoLineBreaks = preg_replace('/\r\n|\n\r|\n|\r/', ' ', $question['comment']);
                            $tmpexcelArr[$i]['Notering'] = $commentNoLineBreaks;
                            $i += 1;
                        }
                    }
                }
            }
        }
        return $tmpexcelArr;
    }

    /**
     * action excel
     *
     * @param $latestReports
     * @param $arguments
     * @return void
     */
    public function excelAction($latestReports, $arguments = NULL)
    {
        $tmpexcelArr = array();
        $i = 0;
        foreach ($latestReports['level1'] as $estate) {
            if (!$estate['level2']) {
                $tmpexcelArr[$i]['Typ'] = $estate['nodeTypeName'];
                $tmpexcelArr[$i]['Benämning'] = $estate['estateName'];
                $tmpexcelArr[$i]['Rapport'] = 'Ingen rapport';
                $tmpexcelArr[$i]['Ansvarig tekniker'] = $report['respTechnicianName'];
                $tmpexcelArr[$i]['Utförande tekniker'] = '';
                $tmpexcelArr[$i]['Kontrollpunkt'] = '';
                $tmpexcelArr[$i]['Delpunkt'] = '';
                $tmpexcelArr[$i]['Status'] = '';
                $tmpexcelArr[$i]['Notering'] = '';
                $i += 1;
            } else {
                foreach ($estate['level2'] as $report) {
                    if (!$report['level3']) {
                        unset($tmpexcelArr[$i]);
                        continue;
                    }
                    foreach ($report['level3'] as $controlPoint) {
                        foreach ($controlPoint['level4'] as $question) {
                            $tmpexcelArr[$i]['Typ'] = $estate['nodeTypeName'];
                            $tmpexcelArr[$i]['Benämning'] = $estate['estateName'];
                            $tmpexcelArr[$i]['Rapport'] = $report['reportName'];
                            $tmpexcelArr[$i]['Ansvarig tekniker'] = $report['respTechnicianName'];
                            $tmpexcelArr[$i]['Utförande tekniker'] = $report['execTechnicianName'];
                            $tmpexcelArr[$i]['Kontrollpunkt'] = $controlPoint['cpName'];
                            $tmpexcelArr[$i]['Delpunkt'] = $question['questionName'];
                            switch ($question['remarkType']) {
                                case '1':    $tmpexcelArr[$i]['Status'] = 'Ok';
                                    break;
                                case '2':    $tmpexcelArr[$i]['Status'] = 'Kritisk';
                                    break;
                                case '3':    $tmpexcelArr[$i]['Status'] = 'Anmärkning';
                                    break;
                                case '4':    $tmpexcelArr[$i]['Status'] = 'Meddelande';
                                    break;
                                case '88':    $tmpexcelArr[$i]['Status'] = 'Tidigare anmärkning';
                                    break;
                                case '99':    $tmpexcelArr[$i]['Status'] = 'Mätvärde';
                                    break;
                                default:    $tmpexcelArr[$i]['Status'] = 'Ej kontrollerad';
                            }
                            $newlines = array('\r\n', '\n', '\r');
                            //$updated = str_replace($newlines, ' ', strip_tags(stripslashes($question['comment'])));
                            $commentNoLineBreaks = preg_replace('/\r\n|\n\r|\n|\r/', ' ', $question['comment']);
                            $tmpexcelArr[$i]['Notering'] = $commentNoLineBreaks;
                            $i += 1;
                        }
                    }
                }
            }
        }
        $filename = 'website_data_' . date('Ymd') . '.xls';
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        ////header("Content-Type: application/vnd.ms-excel");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        ////echo pack("CCC",0xef,0xbb,0xbf);
        $flag = false;
        foreach ($tmpexcelArr as $row) {
            if (!$flag) {
                // display field/column names as first row
                echo implode('	', array_keys($row)) . '
';
                ////echo '<br>';
                $flag = true;
            }
            ////array_walk($row, __NAMESPACE__ . '\cleanData');
            ////array_walk($row, '$this->cleanData';
            array_walk($row, array($this, 'cleanData'));
            echo implode('	', array_values($row)) . '
';
        }
        die;
    }
    
    /**
     * @param $str
     */
    private function cleanData($str)
    {
        $str = preg_replace('/	/', '\\t', $str);
        $str = preg_replace('/
?
/',
            '\\n', $str
        );
        $str = str_replace(',', ' ', $str);
        if (strstr($str, '"')) {
            $str = '"' . str_replace('"', '""', $str) . '"';
        }
        ////echo $str;
        //$str = mb_convert_encoding($str,'utf-16','utf-8');
        ////$str = utf8_encode($str);
        $str = mb_convert_encoding($str, 'utf-8');
    }

}