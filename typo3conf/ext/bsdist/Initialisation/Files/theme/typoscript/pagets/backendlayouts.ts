mod.web_layout.BackendLayouts {

    # default page
    default {
        title = Default
        #icon = fileadmin/bsdist/img/backend/pagelayouts/default.gif
        config {
            backend_layout {
                colCount = 3
                rowCount = 1
                rows {
                    1 {
                        columns {
                            1 {
                                name = Content
                                colspan = 2
                                colPos = 0
                            }
                            2 {
                                name = Sidebar
                                colPos = 1
                            }
                        }
                    }
                }
            }
        }
    }

    # home page
    home {
        title = Home
        config {
            backend_layout {
                colCount = 1
                rowCount = 1
                rows {
                    1 {
                        columns {
                            1 {
                                name = Content
                                colPos = 0
                            }
                        }
                    }
                }
            }
        }
    }

    #empty < .home
    #empty.title = Empty
}

# only for footer page
[PIDupinRootline = 3]
mod.web_layout.BackendLayouts {
    footer {
        title = Footer
        config {
            backend_layout {
                colCount = 3
                rowCount = 1
                rows {
                    1 {
                        columns {
                            1 {
                                name = Footer Left
                                colPos = 10
                            }
                            2 {
                                name = Footer Center
                                colPos = 11
                            }
                            3 {
                                name = Footer Right
                                colPos = 12
                            }
                        }
                    }
                }
            }
        }
    }
}
[global]