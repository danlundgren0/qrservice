# Changelog for TYPO3 CMS Extension pdfviewhelpers

## 1.3.0, April 23, 2017
- Adds support for TYPO3 8.7 LTS, [#18](https://github.com/bithost-gmbh/pdfviewhelpers/issues/18)
- Adds PageBreakViewHelper, [#16](https://github.com/bithost-gmbh/pdfviewhelpers/issues/16)
- Adds possibility to load html styles from external file, [#14](https://github.com/bithost-gmbh/pdfviewhelpers/issues/14)
- Adds orientation to PageViewHelper
- Adds fontStyle to text
- Adds a TypoScript way for adding custom fonts, [#9](https://github.com/bithost-gmbh/pdfviewhelpers/issues/9)
- Adds minor improvements on text handling
- Updates documentation 

## 1.2.3, March 21, 2017
- Fixes configuration manager initialization error, [#19](https://github.com/bithost-gmbh/pdfviewhelpers/issues/19)

## 1.2.2 - March 16, 2017
- Fixes PHP 5.4 compatibility issue, [#17](https://github.com/bithost-gmbh/pdfviewhelpers/issues/17)
- Fixes typo3/cms composer dependency error, [#17](https://github.com/bithost-gmbh/pdfviewhelpers/issues/17)

## 1.2.1 - January 14, 2017
- Adds support for backend usage, [#15](https://github.com/bithost-gmbh/pdfviewhelpers/pull/15) (Thanks [@Gernott](https://github.com/gernott))
- Changes default class to EmptyFPDI, [#12](https://github.com/bithost-gmbh/pdfviewhelpers/issues/12)

## 1.2.0 - September 18, 2016
- Adds FPDI Support (use existing PDFs as template), [#7](https://github.com/bithost-gmbh/pdfviewhelpers/issues/7)

## 1.1.0 - August 24, 2016
- Adds HTML ViewHelper, [#3](https://github.com/bithost-gmbh/pdfviewhelpers/issues/3)
- Disables TYPO3 frontend caching by default, [#5](https://github.com/bithost-gmbh/pdfviewhelpers/issues/5)
- Fixes Bug with generalText alignment and paragraphSpacing settings, [#6](https://github.com/bithost-gmbh/pdfviewhelpers/issues/6)
- Adds composer.json, [#4](https://github.com/bithost-gmbh/pdfviewhelpers/issues/4)

## 1.0.1 - August 17, 2016
- Initial version of pdfviewhelpers. Updated documentation.

## 1.0.0 - August 16, 2016
- Initial version of pdfviewhelpers. This is an extension that provides various Fluid ViewHelpers to generate PDF documents.