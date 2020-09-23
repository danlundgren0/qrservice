module.exports = function(grunt) {

    require('time-grunt')(grunt);
    require('load-grunt-tasks')(grunt);
    //require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        paths: {
            bower: 'bower_components',
            theme: 'theme'
        },

        copy: {
            toTheme: {
                files: [
                    /* jquery min */
                    {
                        expand: true,
                        src: ['<%= paths.bower %>/jquery/dist/jquery.min.*'],
                        dest: '<%= paths.theme %>/js/lib/',
                        flatten: true
                    },
                    /* orig bootstrap scss (as reference for customized setups) */
                    {
                        src: '<%= paths.bower %>/bootstrap-sass/assets/stylesheets/_bootstrap.scss',
                        dest: '<%= paths.theme %>/scss/_bootstrap.scss'
                    },
                    /* bootstrap fonts */
                    {
                        expand: true,
                        src: ['<%= paths.bower %>/bootstrap-sass/assets/fonts/bootstrap/*'],
                        dest: '<%= paths.theme %>/fonts/bootstrap/',
                        flatten: true
                    },
                    /* featherlight css */
                    {
                        expand: true,
                        src: ['<%= paths.bower %>/featherlight/src/featherlight*.css'],
                        dest: '<%= paths.theme %>/css/featherlight/',
                        flatten: true
                    },
                    /* featherlight js */
                    {
                        expand: true,
                        src: ['<%= paths.bower %>/featherlight/src/featherlight*.js'],
                        dest: '<%= paths.theme %>/js/lib/featherlight/',
                        flatten: true
                    }
                    /* fontawesome */
                    /*
                    ,{
                        expand: true,
                        src: '<%= paths.bower %>/font-awesome/css/font-awesome.min.css',
                        dest: '<%= paths.theme %>/css/',
                        flatten: true
                    },
                    {
                        expand: true,
                        src: ['<%= paths.bower %>/font-awesome/fonts/*'],
                        dest: '<%= paths.theme %>/fonts/',
                        flatten: true
                    }
                    */
                ]
            }
        },

        sass: {
            options: {
                style: 'compact',
                unixNewlines: true
            },
            bootstrap: {
                options: {
                    style: 'compressed',
                    loadPath: '<%= paths.bower %>/bootstrap-sass/assets/stylesheets'
                },
                files: [
                    {
                        src: '<%= paths.theme %>/scss/_bootstrap-custom.scss',
                        dest: '<%= paths.theme %>/css/bootstrap.css'
                    }
                ]
            },
            theme: {
                options: {
                    style: 'compressed',
                    loadPath: '<%= paths.bower %>/bootstrap-sass/assets/stylesheets'
                },
                files: [
                    {
                        expand: true,
                        cwd: '<%= paths.theme %>/scss',
                        src: ['styles.scss'],
                        dest: '<%= paths.theme %>/css',
                        ext: '.css'
                    }
                ]
            },
            rte: {
                options: {
                    style: 'compressed',
                    loadPath: '<%= paths.bower %>/bootstrap-sass/assets/stylesheets'
                },
                files: [
                    {
                        '<%= paths.theme %>/css/rte/content.css': '<%= paths.theme %>/scss/rte/content.scss'
                    }
                ]
            }
        },
        concat: {
            options: {
                separator: ';'
            },
            lib: {
                src: [
                    '<%= paths.bower %>/bootstrap-sass/assets/javascripts/bootstrap.min.js',
                    '<%= paths.bower %>/featherlight/src/featherlight.js',
                    '<%= paths.bower %>/featherlight/src/featherlight.gallery.js'
                ],
                dest: '<%= paths.theme %>/js/_libs.js'
            },
            theme: {
                src: ['<%= paths.theme %>/js/includes/*.js'],
                dest: '<%= paths.theme %>/js/_includes.js'
            }
        },
        uglify: {
            scripts: {
                src: ['<%= paths.theme %>/js/_libs.js','<%= paths.theme %>/js/_includes.js'],
                dest: '<%= paths.theme %>/js/scripts.min.js'
            }
        },
        cssmin: {
            theme: {
                files: [
                    {
                        '<%= paths.theme %>/css/all.min.css':
                            [
                                '<%= paths.bower %>/featherlight/src/featherlight.css',
                                '<%= paths.bower %>/featherlight/src/featherlight.gallery.css',
                                '<%= paths.theme %>/css/styles.css'
                            ]
                    }
                ]
            }
        }
    });

    // default
    grunt.registerTask('default', [
        'sass:theme',
        'sass:rte',
        'concat:theme',
        'uglify',
        'cssmin'
    ]);

    // full
    grunt.registerTask('full', [
        'sass',
        'concat',
        'uglify',
        'cssmin'
    ]);

    // only for initialization or after lib updates
    grunt.registerTask('init', [
        'copy:toTheme',
        'sass:bootstrap'
    ]);
};