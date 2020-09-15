<?php

namespace Bithost\Pdfviewhelpers\ViewHelpers;

/* * *
 *
 * This file is part of the "PDF ViewHelpers" Extension for TYPO3 CMS.
 *
 *  (c) 2016 Markus Mächler <markus.maechler@bithost.ch>, Bithost GmbH
 *           Esteban Marin <esteban.marin@bithost.ch>, Bithost GmbH
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
 * * */

/**
 * TextViewHelper
 *
 * @author Markus Mächler <markus.maechler@bithost.ch>, Esteban Marin <esteban.marin@bithost.ch>
 */
class TextViewHelper extends AbstractTextViewHelper {

	/**
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		if (strlen($this->settings['text']['trim'])) {
			$this->overrideArgument('trim', 'boolean', '', FALSE, (boolean) $this->settings['text']['trim']);
		}
		if (strlen($this->settings['text']['removeDoubleWhitespace'])) {
			$this->overrideArgument('removeDoubleWhitespace', 'boolean', '', FALSE, (boolean) $this->settings['text']['removeDoubleWhitespace']);
		}
		if (!empty($this->settings['text']['color'])) {
			$this->overrideArgument('color', 'string', '', FALSE, $this->settings['text']['color']);
		}
		if (!empty($this->settings['text']['fontFamily'])) {
			$this->overrideArgument('fontFamily', 'string', '', FALSE, $this->settings['text']['fontFamily']);
		}
		if (!empty($this->settings['text']['fontSize'])) {
			$this->overrideArgument('fontSize', 'integer', '', FALSE, $this->settings['text']['fontSize']);
		}
		if (!empty($this->settings['text']['fontStyle'])) {
			$this->overrideArgument('fontStyle', 'string', '', FALSE, $this->settings['text']['fontStyle']);
		}
		if (!empty($this->settings['text']['alignment'])) {
			$this->overrideArgument('alignment', 'string', '', FALSE, $this->settings['text']['alignment']);
		}
		if (!empty($this->settings['text']['paragraphSpacing'])) {
			$this->overrideArgument('paragraphSpacing', 'float', '', FALSE, $this->settings['text']['paragraphSpacing']);
		}
	}

	/**
	 * @return void
	 */
	public function initialize() {
		parent::initialize();

		if (!is_array($this->arguments['padding'])) {
			if (!empty($this->settings['text']['padding'])) {
				$this->arguments['padding'] = $this->settings['text']['padding'];
			} else {
				$this->arguments['padding'] = $this->settings['generalText']['padding'];
			}
		}

		if ($this->isValidPadding($this->arguments['padding'])) {
			$this->getPDF()->setCellPaddings(
					$this->arguments['padding']['left'], $this->arguments['padding']['top'], $this->arguments['padding']['right'], $this->arguments['padding']['bottom']
			);
		}
	}

}
