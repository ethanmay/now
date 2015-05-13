module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {
      options: {
        // includePaths: ['bower_components/foundation/scss']
      },
      dist: {
        options: {
          // outputStyle: 'compressed'
        },
        files: {
          'css/styles.css' : 'scss/styles.scss'
        }        
      }
    },

    jshint: {
        options: {
            jshintrc: '.jshintrc'
        },
        all: [
            'js/scripts.js',
        ]
    },

    watch: {
      grunt: { files: ['Gruntfile.js'] },

      sass: {
        files: 'scss/**/*.scss',
        tasks: ['sass']
      },

      jshint: {
        files: 'js/scripts.js',
        tasks: ['jshint']
      },

      uglify: {
        files: 'js/scripts.js',
        tasks: ['uglify']
      }
    },

    uglify: {
      options: {
        mangle: false
      },
      all: {
        files: {
          'js/scripts.min.js': ['js/scripts.js']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-sass');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-uglify');

  grunt.registerTask('test', ['sass, jshint']);
  grunt.registerTask('default', ['sass','jshint','uglify']);
}