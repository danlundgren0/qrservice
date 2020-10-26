<?php
namespace DanLundgren\DlIponlyestate\Domain\Repository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

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
 * The repository for ControlPoints
 */
class ControlPointRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var array
     */
    protected $defaultOrderings = array(
        'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );
    
    /**
     * @param $estate
     */
    public function findSubPagesByParentPid($pid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_dliponlyestate_domain_model_controlpoint');
        $queryBuilder
           ->getRestrictions()
           ->removeAll()
           ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
        ;
        $queryBuilder->select('uid','title','doktype')
        ->from('pages')
        ->where(
           $queryBuilder->expr()->eq('pid', $pid)
        );        
        $subPages = array();
        $statement = $queryBuilder->execute();
        while ($row = $statement->fetch()) {
           $subPages[] = $row;
        }
        return $subPages;
    }
    
    /**
     * @param $estate
     */
    public function findCpByPid($pid)
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder
           ->getRestrictions()
           ->removeAll()
           ->add(GeneralUtility::makeInstance(DeletedRestriction::class))
        ;
        $queryBuilder->select('uid','pi_flexform')
        ->from('tt_content')
        ->where(
            $queryBuilder->expr()->eq('list_type', '"dliponlyestate_cp"'),
            $queryBuilder->expr()->eq('pid', $pid)
        );
        $statement = $queryBuilder->execute();
        $cp = NULL;
        while ($row = $statement->fetch()) {
           $cp = $row;
        }
        return $cp;
    }

}