﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt

Custom Fonts
------------

Adding custom fonts is as easy as providing the path to the TTF file within your TypoScript settings.
The name of the font is automatically generated by TCPDF using the font file name. Only the characters a-z, 0-9 and _ are allowed and words like
'bold', 'oblique', 'italic' or 'regular' are replaced by 'b', 'o', 'i' or ''.

**Example**: ROBOTObold.ttf becomes robotob

TypoScript
""""""""""

::

	plugin.tx_pdfviewhelpers.settings.config.fonts {
		addTTFFont {
			roboto {
				path = typo3conf/ext/pdfviewhelpers/Resources/Public/Examples/FullFeatureShowCase/Roboto.ttf
				# it is also possible to define the type of the font
				# possible values are TrueTypeUnicode, OpenTypeUnicode, TrueType, OpenType, Type1, CID-0
				# defaults to TrueTypeUnicode anyways, so the next line is actually useless
				type = TrueTypeUnicode
			}
			opensans {
				path = typo3conf/ext/pdfviewhelpers/Resources/Public/Examples/FullFeatureShowCase/OpenSans.ttf
			}
		}
	}


TCPDF fonts
"""""""""""

TCPDF comes already with the following fonts installed: courier, helvetica, symbol, times and zapfdingbats