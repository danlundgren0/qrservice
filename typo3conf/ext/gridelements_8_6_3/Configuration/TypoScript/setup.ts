// stdWrap functions being applied to each element
lib.gridelements.defaultGridSetup {
	columns {
		default {
			renderObj = COA
			renderObj {
			    # You can use registers to i.e. provide different image settings for each column
				# 10 = LOAD_REGISTER
				20 =< tt_content
			    # And you can reset the register later on
				# 30 = RESTORE_REGISTER
			}
		}
		#2 < .default
		#2 {
		#}
	}
	# if you want to provide your own templating, just insert a cObject here
	# this will prevent the collected content from being rendered directly
	# i.e. cObject = TEMPLATE or cObject = FLUIDTEMPLATE will be available from the core
	# the content will be available via fieldnames like
	# tx_gridelements_view_columns (an array containing each column)
	# or tx_gridelements_view_children (an array containing each child)
	# tx_gridelements_view_column_123 (123 is the number of the column)
	# or tx_gridelements_view_child_123 (123 is the UID of the child)
}

tt_content.gridelements_pi1 = COA
tt_content.gridelements_pi1 {
	#10 =< lib.stdheader
	20 = COA
	20 {
		10 = USER
		10 {
			userFunc = GridElementsTeam\Gridelements\Plugin\Gridelements->main
			setup {
				default < lib.gridelements.defaultGridSetup
			}
		}
	}
}

tt_content.gridelements_view < tt_content.gridelements_pi1

lib.tt_content.shortcut.pages = COA
lib.tt_content.shortcut.pages {
	5 = LOAD_REGISTER
	5 {
		tt_content_shortcut_recursive.field = recursive
	}
	10 = USER
	10 {
		userFunc = GridElementsTeam\Gridelements\Plugin\Gridelements->user_getTreeList
	}
	20 = CONTENT
	20 {
		table = tt_content
		select {
			pidInList.data = register:pidInList
			selectFields.dataWrap = *,FIND_IN_SET(pid,{register:pidInList}) AS gridelements_shortcut_page_order_by
			where = colPos >= 0
			languageField = sys_language_uid
			orderBy = gridelements_shortcut_page_order_by,colPos,sorting
		}
	}
	30 = RESTORE_REGISTER
}

[userFunc = TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('fluid_styled_content')]
	tt_content.shortcut.variables.shortcuts {
		tables := addToList(pages)
		conf.pages < lib.tt_content.shortcut.pages
	}
[global]

[userFunc = TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('css_styled_content')]
	tt_content.shortcut {
		20 {
			tables := addToList(pages)
			conf.pages < lib.tt_content.shortcut.pages
		}
	}
[global]
