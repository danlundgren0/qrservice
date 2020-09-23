TCEFORM.pages {
    layout {
        altLabels.0 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.pages.layout.0
    }

    backend_layout {
        # storagepage of backend layouts
        PAGE_TSCONFIG_ID = 2
        # hide no backend layout label
        removeItems = -1
        # instead of empty label
        altLabels.0 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.pages.belayout.0
    }

    backend_layout_next_level {
        PAGE_TSCONFIG_ID = 2
        removeItems = -1
        altLabels.0 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.pages.belayoutnext.0
    }

    TSconfig.config.cols = 50
}

TCEFORM.tt_content {
    frame_class {
        addItems {
            jumbotron = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.frame_class.jumbotron
            well = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.frame_class.well
            alert-info = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.frame_class.alert-info
            alert-success = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.frame_class.alert-success
            alert-warning = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.frame_class.alert-warning
            alert-danger = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.frame_class.alert-danger
        }
    }
    layout {
        types {

            textmedia {
                altLabels.1 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.images.1
                altLabels.2 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.images.2
                altLabels.3 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.images.3
                addItems {
                    4 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.images.4
                    5 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.images.5
                    6 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.images.6
                    7 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.images.7
                }
            }
            textpic < .textmedia
            image < .textmedia

            menu_pages {
                altLabels.1 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.menu.1
                altLabels.2 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.menu.2
                altLabels.3 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.menu.3
                addItems {
                    4 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.menu.4
                }
            }
            menu_subpages < .menu_pages
            menu_recently_updated < .menu_pages
            menu_related_pages < .menu_pages
            menu_categorized_content < .menu_pages
            menu_categorized_pages < .menu_pages

            table {
                altLabels.1 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.table.1
                altLabels.2 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.table.2
                altLabels.3 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.table.3
                addItems {
                    4 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.table.4
                    5 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.table.5
                    6 = LLL:EXT:bsdist/Resources/Private/Language/locallang_db.xlf:tceform.tt_content.layout.table.6
                }
            }
        }
    }
}

TCEMAIN.table {
    pages.disablePrependAtCopy = 1
    tt_content.disablePrependAtCopy = 1
}