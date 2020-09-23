# --- mod.SHARED ---
#
/*
mod.SHARED {
    # Language configuration
    defaultLanguageLabel = Deutsch
    defaultLanguageFlag = de
}
*/

# --- TCEMAIN ---
#
# Default backend usergroup and rights for new pages
TCEMAIN {
    permissions {
        # default begroup owner of new pages
        groupid = 1
        # allowed actions: show,edit,delete,new,editcontent
        user = show,edit,delete,new,editcontent
        group = show,edit,delete,new,editcontent
        everybody =
    }
    clearCacheCmd = all
    #translateToHidden = 1
}

# --- TCEFORM.pages ---
#
TCEFORM.pages {
    # sysfolder with backend layout records (not needed if defined by pagets)
    #backend_layout.PAGE_TSCONFIG_ID = 99
    #backend_layout_next_level.PAGE_TSCONFIG_ID = 99

    /*
    layout {
        # disable or
        #disabled = 1
        # change & remove
        altLabels.0 = Standard
        removeItems = 1,2,3
    }
    */
}

TCEFORM.tt_content {
    # support only bootstrap 12er grid cols
    imagecols {
        removeItems = 5,7,8
        addItems {
            12 = 12
        }
    }
}

# --- RTE ---
#
RTE.default.preset = minimal
# minimal, default, full
RTE.config.tt_content.bodytext.preset = default

# custom ckeditor: enable it in the bsdist extension configuration!
# see theme/typoscript/pagets/custom.yaml for custom configuration
#RTE.config.tt_content.bodytext.preset = custom
# e.g. for news
#RTE.config.tx_news_domain_model_news.bodytext.preset = custom


# --- TCEFORM.tt_content ---
#
TCEFORM.tt_content {
    header_layout {
        # 0 = 1 (H1), 100 hidden (todo: recheck 0,0 because only 0 did not work)
        removeItems = 0,0
        #removeItems = 0,100
        altLabels {
            1 = H1
            2 = H2
            3 = H3
            4 = H4
            5 = H5
        }
        #addItems.6 = H3 (special)

    }

}

# --- TCAdefaults.tt_content ---
#
TCAdefaults.tt_content {
    # Default header layout is h2
    #header_layout = 2
    # show in section menu
    sectionIndex = 1
    # default frame_class
    #frame_class = none
    # default image cols (instead of 2)
    imagecols = 1
}



<INCLUDE_TYPOSCRIPT: source="FILE:fileadmin/bsdist/theme/typoscript/pagets/backendlayouts.ts">