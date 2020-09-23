# --------------------------------------------------------------------- #
# To use these templates (paths) uncomment the root paths for           #
# tx_indexedsearch in theme/typoscript/ext/indexed_search/setup.ts.     #
# --------------------------------------------------------------------- #

plugin.tx_indexedsearch {
  view {
    templateRootPaths.100 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/indexed_search/Templates/
    partialRootPaths.100 = {$plugin.tx_bsdist.theme.baseDir}/tmpl/indexed_search/Partials/
  }
}