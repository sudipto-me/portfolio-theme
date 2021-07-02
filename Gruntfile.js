module.exports = function (grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            dist: {
                options: {
                    style: 'compressed',
                    sourceMap: true
                },
                files: {
                    'scss/main.css': 'scss/main.scss'
                }
            }
        },

        cssmin: {
            options: {
                mergeIntoShorthands: false,
                roundingPrecision: -1
            },
            target: {
                files: {
                    'scss/main.css': ['scss/main.css']
                }
            }
        },

        /*Autoprefixer*/
        autoprefixer: {
            options: {
                browsers: ['last 8 versions', 'Chrome > 25', 'Safari > 6', 'iOS 7', 'Firefox > 25', 'ie 8', 'ie 9']
            },
            main: {
                files: {
                    'assets/css/main.css': 'scss/main.css',
                }
            },
        },

        /*Watch task*/
        watch: {
            css: {
                files: '**/*.scss',
                tasks: ['sass', 'cssmin', 'autoprefixer']
            }
        }
    });

    grunt.loadNpmTasks('grunt-sass');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.registerTask('default', ['watch']);
};