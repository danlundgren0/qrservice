<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "compatibility7".
 *
 * Auto generated 03-10-2020 18:02
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = array (
  'title' => 'Compatibility Mode for TYPO3 CMS 7.x',
  'description' => 'Provides an additional backwards-compatibility layer with legacy functionality for sites that haven\'t fully migrated to v8 yet.',
  'category' => 'be',
  'state' => 'stable',
  'uploadfolder' => true,
  'createDirs' => '',
  'clearCacheOnLoad' => 0,
  'author' => 'TYPO3 CMS Team',
  'author_email' => '',
  'author_company' => '',
  'version' => '8.7.1',
  'constraints' => 
  array (
    'depends' => 
    array (
      'typo3' => '8.7.0-8.7.99',
      'backend' => '8.7.0-8.7.99',
    ),
    'conflicts' => 
    array (
      'compatibility6' => '0.0.0',
    ),
    'suggests' => 
    array (
      'indexed_search' => '8.7.0-8.7.99',
    ),
  ),
  'clearcacheonload' => true,
);

