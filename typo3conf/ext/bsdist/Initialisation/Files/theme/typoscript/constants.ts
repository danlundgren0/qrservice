/*
* Definition of custom subcategories
*/
# customsubcategory=domain=Domain(s) of website
# customsubcategory=layout=Layout settings
# customsubcategory=language=Language settings
# customsubcategory=extension=Extension settings
# customsubcategory=video=Video settings


/* ----------------------------------------
* Site & theme default typo3 constants
*/

#content {
	#defaultHeaderType = 2

	# remove tt_address (if not used for direct_mail)
	# direct mail does not require tt_address (in 4.0.0), but creates the table columns anyway
	#shortcut.tables := removeFromList(tt_address)
#}
styles.content {
	textmedia {
		maxW = 1140
		maxWInText = 750
		textMargin = 20
		columnSpacing = 30
		rowSpacing = 30

		linkWrap {
			width = 1000m
			height = 600m
			lightboxEnabled = 1
			lightboxCssClass = lightbox
			lightboxRelAttribute >
			lightboxAttributes = data-featherlight="image"
		}
	}
}


/* ----------------------------------------
* Site & theme constants
*/
plugin.tx_bsdist {
	theme {
		#baseDir = fileadmin/bsdist/theme
		#jQueryJsFile = {$plugin.tx_bsdist.theme.baseDir}/js/lib/jquery.min.js
	}

	website {
		# cat=tx_bsdist.website/domain/010; type=string; label=Website domain: The domain without the protocol, e.g. www.example.com. Only used for direct_mail and news rss feed.
		domain =

		# change lang locale
		#lang.locale = de_DE.UTF-8
		#lang.localeShort = de

		metaNav {
			# cat=tx_bsdist.website/layout/010; type=string; label=Meta navigation page id
			pageId = 5
		}
		footer {
			# cat=tx_bsdist.website/layout/010; type=string; label=Page id with footer content (for static footer content)
			pageId = 4
			# cat=tx_bsdist.website/layout/011; type=string; label=Left footer colPos
			leftColPos = 10
			# cat=tx_bsdist.website/layout/012; type=string; label=Center footer colPos
			centerColPos = 11
			# cat=tx_bsdist.website/layout/013; type=string; label=Right footer colPos
			rightColPos = 12
		}
	}
}


# --- Additional extension constants (see setup.ts) ---
#
# indexed_search
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/indexed_search/constants.ts">
# felogin
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/felogin/constants.ts">