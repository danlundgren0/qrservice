<?php
namespace GridElementsTeam\Gridelements\Backend\ItemsProcFuncs;

/***************************************************************
 *  Copyright notice
 *  (c) 2013 Jo Hasenau <info@cybercraft.de>
 *  (c) 2013 Stefan froemken <froemken@gmail.com>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use GridElementsTeam\Gridelements\Helper\Helper;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Database\QueryGenerator;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Class/Function which offers TCE main hook functions.
 *
 * @author Jo Hasenau <info@cybercraft.de>
 * @package TYPO3
 * @subpackage tx_gridelements
 */
abstract class AbstractItemsProcFunc implements SingletonInterface
{
    /**
     * @var DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * @var LanguageService
     */
    protected $languageService;

    /**
     * @var QueryGenerator
     */
    protected $tree;

    /**
     * initializes this class
     *
     * @param int $pageUid
     */
    public function init($pageUid = 0)
    {
        $this->setDatabaseConnection($GLOBALS['TYPO3_DB']);
        $this->setLanguageService($GLOBALS['LANG']);
    }

    /**
     * Gets the selected backend layout
     *
     * @param int $id The uid of the page we are currently working on
     *
     * @return array|null An array containing the data of the selected backend layout as well as a parsed version of the layout configuration
     */
    public function getSelectedBackendLayout($id)
    {
        return Helper::getInstance()->getSelectedBackendLayout($id);
    }

    /**
     * This method is a wrapper for unitTests because of the static method
     *
     * @param int $pageUid
     *
     * @return array
     */
    public function getRootline($pageUid)
    {
        return BackendUtility::BEgetRootLine($pageUid);
    }

    /**
     * setter for databaseConnection object
     *
     * @param DatabaseConnection $databaseConnection
     *
     * @return void
     */
    public function setDatabaseConnection(DatabaseConnection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * getter for databaseConnection
     *
     * @return DatabaseConnection databaseConnection
     */
    public function getDatabaseConnection()
    {
        return $this->databaseConnection;
    }

    /**
     * getter for databaseConnection
     *
     * @return LanguageService $languageService
     */
    public function getLanguageService()
    {
        return $this->languageService;
    }

    /**
     * setter for databaseConnection object
     *
     * @param LanguageService $languageService
     *
     * @return void
     */
    public function setLanguageService(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     * Gets the current backend user.
     *
     * @return \TYPO3\CMS\Core\Authentication\BackendUserAuthentication
     */
    public function getBackendUser()
    {
        return $GLOBALS['BE_USER'];
    }

}
