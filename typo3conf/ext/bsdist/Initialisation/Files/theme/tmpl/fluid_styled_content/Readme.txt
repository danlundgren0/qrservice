# --------------------------------------------------------------------- #
# To use these templates (paths) uncomment the root paths for           #
# lib.fluidContent and lib.contentElement in theme/typoscript/setup.ts. #
# --------------------------------------------------------------------- #

lib {
    fluidContent {
        # use templates in theme directory
        templateRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Templates/
        layoutRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Layouts/
        partialRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Partials/
    }

    contentElement {
        # use templates in theme directory
        templateRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Templates/
        layoutRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Layouts/
        partialRootPaths.20 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/fluid_styled_content/Partials/
    }
}