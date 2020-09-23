/* --------------------
 * Page
 */
page = PAGE
page {
    #typeNum = 0
    10 = FLUIDTEMPLATE
    10 {
        #templateRootPaths.10 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout
        #layoutRootPaths.10 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/Layouts/
        #partialRootPaths.10 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/Partials/

        file.cObject = CASE
        file.cObject {
            #key.data = levelfield:-1, backend_layout_next_level, slide
            #key.override.field = backend_layout
            #default = TEXT
            #default.value = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/tmpl_main.html
            pagets__home = TEXT
            pagets__home.value = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/tmpl_home.html
            pagets__empty = TEXT
            pagets__empty.value = {$plugin.tx_bsdist.theme.baseDir}/tmpl/backend_layout/tmpl_empty.html
        }

        variables {
            content < styles.content.get
            content_sidebar < styles.content.get
            content_sidebar.select.where = colPos=1
        }

    }

    meta {
        author   =
        robots   = index,follow
    }

    includeCSS {
        # see condition applicationContext for development settings
        bootstrap >
        lightbox >
        custom = {$plugin.tx_bsdist.theme.baseDir}/css/all.min.css
    }
    includeJSLibs {
        jquery = {$plugin.tx_bsdist.theme.jQueryJsFile}
    }
    includeJSFooterlibs {
        # see condition applicationContext below for development settings
        bootstrap >
        lightbox >
        custom = {$plugin.tx_bsdist.theme.baseDir}/js/scripts.min.js
    }

}


/* --------------------
* Snippets
*/
lib {
    # fluid content
    fluidContent {
        # use templates in theme directory
        #templateRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Templates/
        #layoutRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Layouts/
        #partialRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Partials/

        settings {
            media {
                popup {
                    linkParams.ATagParams.dataWrap = class="{$styles.content.textmedia.linkWrap.lightboxCssClass}" {$styles.content.textmedia.linkWrap.lightboxAttributes}
                }
            }
        }
    }

    contentElement {
        # use templates in theme directory
        #templateRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Templates/
        #layoutRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Layouts/
        #partialRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Partials/
    }

    logo = COA
    logo.wrap = <div class="logo">|</div>
    logo {
        10 = TEXT
        10.value = <img src="{$plugin.tx_bsdist.theme.baseDir}/img/logo.png" class="logo img-responsive" />
        10.typolink.parameter = 1
    }

    footerContent = COA
    footerContent.wrap = <div class="container"><div class="row">|</div></div>
    footerContent {
        # left footer col
        10 < styles.content.get
        10 {
            select.pidInList = {$plugin.tx_bsdist.website.footer.pageId}
            #slide = -1
            select.where = colPos={$plugin.tx_bsdist.website.footer.leftColPos}
            stdWrap.wrap = <div class="col-md-4 col-sm-4">|</div>
        }
        # center
        20 < .10
        20.select.where = colPos={$plugin.tx_bsdist.website.footer.centerColPos}
        20.stdWrap.wrap = <div class="col-md-4 col-sm-4 text-center">|</div>
        # right
        30 < .10
        30.select.where = colPos={$plugin.tx_bsdist.website.footer.rightColPos}
        30.stdWrap.wrap = <div class="col-md-4 col-sm-4 text-right">|</div>
    }

    copyright = COA
    copyright {
        10 = TEXT
        10.data = date:U
        10.strftime = %Y
        10.wrap =  &copy; Copyright&nbsp;|&nbsp;Firma AG

        20 = HMENU
        20.wrap = &nbsp; &#124; &nbsp;|
        20 {
            entryLevel = 0
            #excludeUidList = 11
            1 = TMENU
            1 {
                wrap = |
                expAll = 1
                NO = 1
                NO.allWrap >
                NO.wrapItemAndSub = | |*| &nbsp;-&nbsp;| |*| &nbsp;-&nbsp;|
            }
        }
    }
}


/* --------------------
* Conditional stuff
*/
# Development Environment
#
[applicationContext = Development*]
    config {
        admPanel = 1
    }
    page {
        meta {
            robots   = noindex,nofollow
        }
        includeCSS {
            bootstrap = {$plugin.tx_bsdist.theme.bootstrapCssFile}
            lightbox = {$plugin.tx_bsdist.theme.lightboxCssFile}
            # fix order
            custom >
            custom = fileadmin/bsdist/theme/css/styles.css
        }
        includeJSFooterlibs {
            bootstrap = {$plugin.tx_bsdist.theme.bootstrapJsFile}
            lightbox = {$plugin.tx_bsdist.theme.lightboxJsFile}
            # fix order
            custom >
            custom = fileadmin/bsdist/theme/js/_includes.js
        }
    }
[global]


/*
# On home
[globalVar = TSFE:id = 1]
# change site/page title order
config.pageTitleFirst = 0
[global]
*/


/* --------------------
* Additional configurations
*/
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/nav/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/lang/multilang.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/lang/langnav.ts">


# --- Extension setups (see constants.ts) ---
#
<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/form/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/indexed_search/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/felogin/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/grids/setup.ts">
#<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/ext/form/setup.ts">