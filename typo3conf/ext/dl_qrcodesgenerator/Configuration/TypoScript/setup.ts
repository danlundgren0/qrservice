
plugin.tx_dlqrcodesgenerator_qrcodesgenerator {
    view {
        templateRootPaths.0 = EXT:dl_qrcodesgenerator/Resources/Private/Templates/
        templateRootPaths.1 = {$plugin.tx_dlqrcodesgenerator_qrcodesgenerator.view.templateRootPath}
        partialRootPaths.0 = EXT:dl_qrcodesgenerator/Resources/Private/Partials/
        partialRootPaths.1 = {$plugin.tx_dlqrcodesgenerator_qrcodesgenerator.view.partialRootPath}
        layoutRootPaths.0 = EXT:dl_qrcodesgenerator/Resources/Private/Layouts/
        layoutRootPaths.1 = {$plugin.tx_dlqrcodesgenerator_qrcodesgenerator.view.layoutRootPath}
    }
    persistence {
        storagePid = {$plugin.tx_dlqrcodesgenerator_qrcodesgenerator.persistence.storagePid}
        #recursive = 1
    }
    features {
        #skipDefaultArguments = 1
        # if set to 1, the enable fields are ignored in BE context
        ignoreAllEnableFieldsInBe = 0
        # Should be on by default, but can be disabled if all action in the plugin are uncached
        requireCHashArgumentForActionArguments = 1
    }
    mvc {
        #callDefaultActionIfActionCantBeResolved = 1
    }
}

# these classes are only used in auto-generated templates
plugin.tx_dlqrcodesgenerator._CSS_DEFAULT_STYLE (
    textarea.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    input.f3-form-error {
        background-color:#FF9F9F;
        border: 1px #FF0000 solid;
    }

    .tx-dl-qrcodesgenerator table {
        border-collapse:separate;
        border-spacing:10px;
    }

    .tx-dl-qrcodesgenerator table th {
        font-weight:bold;
    }

    .tx-dl-qrcodesgenerator table td {
        vertical-align:top;
    }

    .typo3-messages .message-error {
        color:red;
    }

    .typo3-messages .message-ok {
        color:green;
    }
)

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder
page.includeJSFooter.qrcode = EXT:dl_qrcodesgenerator/Resources/Public/Js/qrcode.js
page.includeJSFooter.makeCode = EXT:dl_qrcodesgenerator/Resources/Public/Js/makeCode.js


#page.includeJS.QRious = EXT:dl_qrcodesgenerator/Resources/Public/Js/QRious.js

qrcodeRender = PAGE
qrcodeRender {
  10 = USER
  10 {
    userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
    extensionName = DlQrcodesgenerator
    pluginName = Qrcodesgenerator
    #extensionName = NzNazartravel
    #pluginName = Bookingmytrip
    vendorName = DanLundgren
    switchableControllerActions.QRcodesGenerator.1 = list
    #switchableControllerActions.Booking.1 = resebevis
  }
  typeNum = 532532
  config {
    #disableAllHeaderCode = 1
    #xhtml_cleaning = 0
    admPanel = 0
    #debug = 1
    no_cache = 1
  }
}