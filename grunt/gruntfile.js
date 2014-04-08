module.exports = function(grunt) {

	// grunt.file.readJSON('package.json').version // don't forget to update your version in the package.json file

	// load dependencies
	require('load-grunt-tasks')(grunt);
	
	grunt.initConfig({

		pkg: grunt.file.readJSON('package.json'),

		// compile scss with compass
		compass: {
			dist: {
				options: {
					config: 'config.rb'
				}
			}
		},

		// chech our JS, Wordpress style (the hard WP standards way) - http://develop.svn.wordpress.org/trunk/.jshintrc
		jshint: {
			options: {
				"boss": true,
				"curly": true,
				"eqeqeq": true,
				"eqnull": true,
				"es3": true,
				"expr": true,
				"immed": true,
				"noarg": true,
				"onevar": true,
				"quotmark": "single",
				"trailing": true,
				"undef": true,
				"unused": true,

				"browser": true,

				"globals": {
					"_": false,
					"Backbone": false,
					"jQuery": false,
					"wp": false
				}
			},
			all: [ '../assets/js/jquery.portfolio.js' ]
		},

		// minify css asset files
		cssmin: {
			minify: {
				expand: true,
				cwd: '../assets/css/',
				src: ['*.css', '!*.min.css'],
				dest: '../assets/css/min/',
				ext: '.min.css'
			}
		},

		// concat and minify our JS assets
		uglify: {
			options: {
				mangle: true
			},

			dist: {
				files: {
					'../assets/js/min/jquery.portfolio.min.js': [ '../assets/js/jquery.portfolio.js']
				}
			}
		},

		// check our php, Wordpress style (the hard WP standards way)
		phpcs: {
			application: {
				dir: ['../classes/class-video-thumbnails.php']
			},
			options: {
				bin: 'phpcs',
				standard : 'Wordpress'
			}
		},

		// watch for changes for dev
		watch: {

			js: {                       
				files: [ '../assets/js/jquery.portfolio.js' ],
				tasks: [
					'jshint',
					'uglify',
					'notify:js'

				],
			},
			sass: {

				files: ['../sass/*.scss'],
				tasks: [
					'compass:dist',
					'cssmin',
					'notify:sass'
				],
			},

			css: {
				files: ['*.css']
			},

			livereload: {
				files: ['../assets/css/min/*.css'],
				options: { livereload: true }
			}

		},

		// notify cross-OS - see https://github.com/dylang/grunt-notify
		notify: {
			sass: {
				options: {
					title: 'Grunt, grunt!',
					message: 'CSS is in the house'
				}
			},
			js: {
				options: {
					title: 'Grunt, grunt!',
					message: 'JS is all good'
				}
			},
			test: {
				options: {
					title: 'Grunt, grunt!',
					message: 'Plugin folder created, ready for testing'
				}
			},
			pack: {
				options: {
					title: 'Grunt, grunt!',
					message: 'Plugin packed & ready for upload'
				}
			},
			stage: {
				options: {
					title: 'Grunt, grunt!',
					message: 'Plugin uploaded in staging server'
				}
			},
			prod: {
				options: {
					title: 'Grunt, grunt!',
					message: 'Plugin uploaded in demo server and live website'
				}
			},
			backup:{
				options: {
					title: 'Grunt, grunt!',
					message: 'Backed up in D:/Dropbox/Production/plugins/WolfPortfolio/'
				}
			},
			dist: {
				options: {
					title: 'Grunt, grunt!',
					message: 'Plugin ready to be downloaded'
				}
			}
		},

		// clean plugin folder
		clean: {
			plugin: {
				src: ['../pack/wolf-portfolio'],
				options: {
					force: true
				}
			}

		},

		// output files
		copyto: {

			// create a clean plugin folder without the junk
			plugin: {
				files: [
					{ cwd: '../', src: [ '**/*' ], dest: '../pack/wolf-portfolio/' }
				],
				options: {
					ignore: [
						'../README',
						'../LICENSE', 
						'../*.log',
						'../*.js',
						'../*.json', 
						'../*.rb',
						'../*.bat',
						'../grunt{,/**/*}',
						'../sass{,/**/*}',
						'../pack{,/**/*}'
					]
				}
			},

			backup: {
				files: [
					{ cwd: '../pack', src: [ '**/*' ], dest: 'D:/Dropbox/Production/plugins/WolfPortfolio/' }
				]
			},
			
		},

		// zip 'em up
		compress: {

			// zip the plugin folder
			plugin:{

				options: {
					archive: '../pack/dist/wolf-portfolio.zip',
					mode: 'zip'
				},
				expand: true,
				cwd: '../pack/wolf-portfolio/',
				src: ['**/*'],
				dest: 'wolf-portfolio/'

			}

		},

		ftpush: {
			// push to stage server
			stage: {
				auth: {
					host: 'wpwolf.com',
					port: 21,
					authKey: 'stageKey'
				},
				src: '../pack/wolf-portfolio',
				dest: '/stage/wp-content/plugins/wolf-portfolio',
				exclusions: ['../pack/wolf-portfolio/dist'],
				simple: false,
				useList: false
			},
			// push to production
			prod: {
				auth: {
					host: 'wpwolf.com',
					port: 21,
					authKey: 'prodKey'
				},
				src: '../pack/wolf-portfolio',
				dest: '/wpwolf.com/wp-content/plugins/wolf-portfolio',
				exclusions: ['../pack/wolf-portfolio/dist'],
				simple: false,
				useList: false
			},
			// push to demo
			demo: {
				auth: {
					host: 'wpwolf.com',
					port: 21,
					authKey: 'prodKey'
				},
				src: '../pack/wolf-portfolio',
				dest: '/demo/wp-content/plugins/wolf-portfolio',
				exclusions: ['../pack/wolf-portfolio/dist'],
				simple: false,
				useList: false
			},
			dist:{

				auth: {
					host: 'wpwolf.com',
					port: 21,
					authKey: 'prodKey'
				},
				src: '../pack/dist',
				dest: '/plugins/wolf-portfolio',
				simple: false,
				useList: false
			}
		}

	} ); // end init config


	/**
	 * Development task
	 *
	 * The main tasks for development
	 *
	 */
	grunt.registerTask( 'default', [
		'compass',
		'cssmin',
		'uglify',
	] );

	/**
	 * Validate JS and PHP for Wordpress standards
	 */
	grunt.registerTask( 'check', function() {
		grunt.task.run( [
			'jshint',
			'phpcs'
		] );
	} );

	/**
	 * Test task
	 *
	 * Clean and output your plugin folder in pack dir
	 *
	 */
	grunt.registerTask( 'test', function() {
		grunt.task.run( [
			'compass',
			'cssmin',
			'uglify',
			'clean:plugin',
			'copyto:plugin',
			'notify:test'
		] );
	} );


	/**
	 * Production task
	 *
	 * Clean, copy and zip your folders to be ready for plugin upload
	 *
	 */
	grunt.registerTask( 'pack', function() {
		grunt.task.run( [
			'compass',
			'cssmin',
			'uglify',
			'clean:plugin',
			'copyto:plugin',
			'compress:plugin',
			'notify:pack'
		] );
	} );


	/**
	 * Staging task
	 *
	 * Push your new release on your staging server to test the plugin online
	 *
	 */
	grunt.registerTask( 'stage', function() {
		grunt.task.run( [
			'compass',
			'cssmin',
			'uglify',
			'clean:plugin',
			'copyto:plugin',
			'compress:plugin',
			'ftpush:stage',
			'notify:stage'
		] );
	} );


	/**
	 * Deployment task
	 *
	 * Push your new release on your production server
	 * Push zip and changelog on upload server
	 *
	 */
	grunt.registerTask( 'deploy', function() {
		grunt.task.run( [
			'compass',
			'cssmin',
			'uglify',
			'clean:plugin',
			'copyto:plugin',
			'compress:plugin',
			'ftpush:prod',
			'ftpush:demo',
			'notify:prod',
		] );
	} );


	/**
	 * Dist task
	 *
	 */
	grunt.registerTask( 'dist', function() {
		grunt.task.run( [
			'compass',
			'cssmin',
			'uglify',
			'clean:plugin',
			'copyto:plugin',
			'compress:plugin',
			'copyto:backup',
			'notify:backup',
			'ftpush:dist',
			'notify:dist'
		] );
	} );

};