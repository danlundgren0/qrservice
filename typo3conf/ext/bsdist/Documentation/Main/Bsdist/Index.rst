.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


For website development
=======================

The assets installed with the bsdist distribution were copied to /fileadmin/bsdist/.


The theme directory
-------------------

The theme directory holds all website-specific files - templates, resources, scripts and typoscript code.
The path to the theme directory is set in the constant plugin.tx_bsdist.theme.baseDir.

.. figure:: ../Images/fileadmin-bsdist-theme.png
   :align: left


Page setup, templates and backend layouts
-----------------------------------------

The files *constants.ts*, *setup.ts* and *tsconfig.ts* are the starting point to modify the default TYPO3 website setup defined by bsdist.
The bsdist package has already set some config properties and defined a basic page object.

.. figure:: ../Images/bsdist-typoscript.png
   :align: left

In the file *theme/typoscript/setup.ts* the main page object is redefined. The template file part is extended to provide a third template with a sidebar column and an empty template.

.. code-block:: typoscript

	page = PAGE
	page {
		typeNum = 0
		10 = FLUIDTEMPLATE
		10 {
			layoutRootPath = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/Layouts/
			partialRootPath = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/Partials/

			file.cObject = CASE
			file.cObject {
				key.data = levelfield:-1, backend_layout_next_level, slide
				key.override.field = backend_layout
				default = TEXT
				default.value = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/tmpl_default.html
				2 = TEXT
				2.value       = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/tmpl_home.html
				3 = TEXT
				3.value       = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/tmpl_empty.html
			}

			variables {
				content < styles.content.get
				content_sidebar < styles.content.get
				content_sidebar.select.where = colPos=1
			}
		}
	}



Templates
^^^^^^^^^
The templates **tmpl_default.html** and **tmpl_home.html** as well as the layout template **default.html** are the main
starting point to change the html markup of the website.

.. figure:: ../Images/bsdist-tmpl-backendlayouts.png
   :align: left


Backend layouts
^^^^^^^^^^^^^^^
The backend layouts are not defined as records anymore. See theme/typoscript/pagets/backendlayouts.ts


Adding another page template
^^^^^^^^^^^^^^^^^^^^^^^^^^^^
To add another page template

- create a new html template (e.g. with 3 content columns, tmpl_3cols.html)
- create a new backend layout in backendlayouts.ts, e.g. with name 'threecols'
- add typoscript in *setup.ts* to assign the html template to the new backend layout

.. code-block:: typoscript

	file.cObject {
		pagets__threecols = TEXT
		pagets__threecols.value = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/tmpl_3cols.html
	}

- if you created a template with a 3rd content slot, assign the content from the new slot (e.g. colPos=2) to a new variable. Use this variable in your html template.

.. code-block:: typoscript

	variables {
		content_leftcol < styles.content.get
		content_leftcol.select.where = colPos=2
	}

