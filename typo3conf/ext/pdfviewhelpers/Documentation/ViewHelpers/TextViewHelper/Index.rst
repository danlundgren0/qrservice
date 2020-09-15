﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


TextViewHelper
--------------

Rendering text using the settings for text.

**Basic Usage**
::

	<pdf:text>Title</pdf:text>
	<pdf:text text="Alternative syntax"/>

**Advanced Usage**
::

	<pdf:text
		trim="0"
		color="#333"
		fontFamily="arial"
		fontSize="22"
		fontStyle="B"
		alignment="R"
		padding="{top:1, right:0, bottom:0, left:0}"
		>Title</pdf:text>
