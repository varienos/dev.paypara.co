const gulpConfig = {
	name: 'Metronic',
	desc: "Gulp build config file",
	version: "8.1.5",
	config: {
		debug: false,
		compile: {
			rtl: {
				enabled: false,
				skip: [],
			},
			jsMinify: true,
			cssMinify: true,
			jsSourcemaps: false,
			cssSourcemaps: false,
		},
		path: {
			src: "../template/src",
			common_src: "../template/src",
			node_modules: "node_modules",
		},
		dist: ["../template/dist"],
	},
	build: {
		base: {
			src: {
				styles: ["{$config.path.src}/sass/style.scss"],
				scripts: [
					"{$config.path.common_src}/js/components/**/*.js",
					"{$config.path.common_src}/js/layout/**/*.js",
					"{$config.path.src}/js/layout/**/*.js"
				]
			},
			dist: {
				styles: "{$config.dist}/css/style.bundle.css",
				scripts: "{$config.dist}/js/scripts.bundle.js",
			}
		},
		plugins: {
			global: {
				src: {
					mandatory: {
						jquery: {
							scripts: ["{$config.path.node_modules}/jquery/dist/jquery.js"],
						},
						"popper.js": {
							scripts: [
								"{$config.path.node_modules}/@popperjs/core/dist/umd/popper.js",
							],
						},
						bootstrap: {
							scripts: [
								"{$config.path.node_modules}/bootstrap/dist/js/bootstrap.min.js",
							],
						},
						moment: {
							scripts: [
								"{$config.path.node_modules}/moment/min/moment-with-locales.min.js",
							],
						},
						wnumb: {
							scripts: ["{$config.path.node_modules}/wnumb/wNumb.js"],
						},
					},
					optional: {
						select2: {
							styles: [
								"{$config.path.node_modules}/select2/dist/css/select2.css",
							],
							scripts: [
								"{$config.path.node_modules}/select2/dist/js/select2.full.js",
								"{$config.path.common_src}/js/vendors/plugins/select2.init.js",
							],
						},
						"datatables.net": {
							styles: [
								"{$config.path.node_modules}/datatables.net-bs5/css/dataTables.bootstrap5.css",
								"{$config.path.node_modules}/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-colreorder-bs5/css/colReorder.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-rowreorder-bs5/css/rowReorder.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-scroller-bs5/css/scroller.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-select-bs5/css/select.bootstrap5.min.css",
								"{$config.path.node_modules}/datatables.net-datetime/dist/dataTables.dateTime.min.css",
							],
							scripts: [
								"{$config.path.node_modules}/datatables.net/js/jquery.dataTables.js",
								"{$config.path.node_modules}/datatables.net-bs5/js/dataTables.bootstrap5.js",
								"{$config.path.common_src}/js/vendors/plugins/datatables.init.js",
								"{$config.path.node_modules}/jszip/dist/jszip.min.js",
								"{$config.path.node_modules}/pdfmake/build/pdfmake.min.js",
								"{$config.path.node_modules}/pdfmake/build/vfs_fonts.js",
								"{$config.path.node_modules}/datatables.net-buttons/js/dataTables.buttons.min.js",
								"{$config.path.node_modules}/datatables.net-buttons-bs5/js/buttons.bootstrap5.min.js",
								"{$config.path.node_modules}/datatables.net-buttons/js/buttons.colVis.js",
								"{$config.path.node_modules}/datatables.net-buttons/js/buttons.flash.js",
								"{$config.path.node_modules}/datatables.net-buttons/js/buttons.html5.js",
								"{$config.path.node_modules}/datatables.net-buttons/js/buttons.print.js",
								"{$config.path.node_modules}/datatables.net-colreorder/js/dataTables.colReorder.min.js",
								"{$config.path.node_modules}/datatables.net-colreorder-bs5/js/colReorder.bootstrap5.js",
								"{$config.path.node_modules}/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js",
								"{$config.path.node_modules}/datatables.net-fixedcolumns-bs5/js/fixedColumns.bootstrap5.js",
								"{$config.path.node_modules}/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js",
								"{$config.path.node_modules}/datatables.net-fixedheader-bs5/js/fixedHeader.bootstrap5.js",
								"{$config.path.node_modules}/datatables.net-responsive/js/dataTables.responsive.min.js",
								"{$config.path.node_modules}/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js",
								"{$config.path.node_modules}/datatables.net-rowgroup/js/dataTables.rowGroup.min.js",
								"{$config.path.node_modules}/datatables.net-rowgroup-bs5/js/rowGroup.bootstrap5.js",
								"{$config.path.node_modules}/datatables.net-rowreorder/js/dataTables.rowReorder.min.js",
								"{$config.path.node_modules}/datatables.net-rowreorder-bs5/js/rowReorder.bootstrap5.js",
								"{$config.path.node_modules}/datatables.net-scroller/js/dataTables.scroller.min.js",
								"{$config.path.node_modules}/datatables.net-scroller-bs5/js/dataTables.bootstrap5.js",
								"{$config.path.node_modules}/datatables.net-select/js/dataTables.select.min.js",
								"{$config.path.node_modules}/datatables.net-select-bs5/js/dataTables.bootstrap5.js",
								"{$config.path.node_modules}/datatables.net-datetime/dist/dataTables.dateTime.min.js",
								"{$config.path.node_modules}/datatables.net-plugins/features/conditionalPaging/dataTables.conditionalPaging.js",
							]
						},
						"bootstrap-maxlength": {
							"scripts": [
								"{$config.path.node_modules}/bootstrap-maxlength/src/bootstrap-maxlength.js"
							]
						},
						daterangepicker: {
							styles: [
								"{$config.path.node_modules}/bootstrap-daterangepicker/daterangepicker.css",
							],
							scripts: [
								"{$config.path.node_modules}/bootstrap-daterangepicker/daterangepicker.js",
							],
						},
						inputmask: {
							scripts: [
								"{$config.path.node_modules}/inputmask/dist/inputmask.js",
								"{$config.path.node_modules}/inputmask/dist/bindings/inputmask.binding.js"
							]
						},
						autosize: {
							scripts: [
								"{$config.path.node_modules}/autosize/dist/autosize.js",
							],
						},
						"bootstrap-multiselectsplitter": {
							scripts: [
								"{$config.path.node_modules}/bootstrap-multiselectsplitter/bootstrap-multiselectsplitter.js",
							],
						},
						"smooth-scroll": {
							scripts: [
								"{$config.path.node_modules}/smooth-scroll/dist/smooth-scroll.js",
							],
						},
						tagify: {
							styles: [
								"{$config.path.node_modules}/@yaireo/tagify/dist/tagify.css",
							],
							scripts: [
								"{$config.path.node_modules}/@yaireo/tagify/dist/tagify.polyfills.min.js",
								"{$config.path.node_modules}/@yaireo/tagify/dist/tagify.min.js",
							],
						},
						toastr: {
							styles: ["{$config.path.common_src}/plugins/toastr/build/toastr.css"],
							scripts: ["{$config.path.common_src}/plugins/toastr/build/toastr.min.js"],
						},
						apexcharts: {
							styles: [
								"{$config.path.node_modules}/apexcharts/dist/apexcharts.css",
							],
							scripts: [
								"{$config.path.node_modules}/apexcharts/dist/apexcharts.min.js",
							],
						},
						"countup.js": {
							scripts: [
								"{$config.path.node_modules}/countup.js/dist/countUp.umd.js",
							],
						},
						sweetalert2: {
							styles: [
								"{$config.path.node_modules}/sweetalert2/dist/sweetalert2.css",
							],
							scripts: [
								"{$config.path.node_modules}/es6-promise-polyfill/promise.min.js",
								"{$config.path.node_modules}/sweetalert2/dist/sweetalert2.min.js",
								"{$config.path.common_src}/js/vendors/plugins/sweetalert2.init.js",
							],
						},
						clipboard: {
							scripts: [
								"{$config.path.node_modules}/clipboard/dist/clipboard.min.js",
							],
						},
						bootbox: {
							scripts: [
								"{$config.path.node_modules}/bootbox/dist/bootbox.min.js",
							],
						},
						"bootstrap-icons": {
							styles: [
								"{$config.path.node_modules}/bootstrap-icons/font/bootstrap-icons.css",
							],
							fonts: [
								"{$config.path.node_modules}/bootstrap-icons/font/fonts/**",
							],
						},
					},
					override: {
						styles: ["{$config.path.src}/sass/plugins.scss"],
					},
				},
				dist: {
					styles: "{$config.dist}/plugins/global/plugins.bundle.css",
					scripts: "{$config.dist}/plugins/global/plugins.bundle.js",
					images: "{$config.dist}/plugins/global/images",
					fonts: "{$config.dist}/plugins/global/fonts",
				},
			},
			custom: {
				"css-element-queries": {
					src: {
						scripts: [
							"{$config.path.node_modules}/css-element-queries/src/ResizeSensor.js",
							"{$config.path.node_modules}/css-element-queries/src/ElementQueries.js"

						],
					},
					dist: {
						scripts: "{$config.dist}/plugins/custom/css-element-queries/css.element.queries.bundle.js",
					},
				},
				"davidshimjs-qrcodejs": {
					src: {
						scripts: ["{$config.path.node_modules}/davidshimjs-qrcodejs/qrcode.js"],
					},
					dist: {
						scripts: "{$config.dist}/plugins/custom/davidshimjs-qrcodejs/qrcode.bundle.js",
					},
				},
				"javascript-obfuscator": {
					src: {
						scripts: ["{$config.path.node_modules}/javascript-obfuscator/dist/index.browser.js"],
					},
					dist: {
						scripts: "{$config.dist}/plugins/custom/javascript-obfuscator/javascript.obfuscator.bundle.js",
					},
				},

			}
		},
		widgets: {
			src: {
				scripts: [
					"{$config.path.common_src}/js/widgets/**/*.js"
				]
			},
			dist: {
				scripts: "{$config.dist}/js/widgets.bundle.js",
			}
		},
		custom: {
			src: {
				styles: [
					"{$config.path.common_src}/sass/custom/**/*.scss",
					"{$config.path.src}/sass/custom/**/*.scss",
				],
				scripts: [
					"{$config.path.common_src}/js/custom/**/*.js",
					"{$config.path.src}/js/custom/**/*.js",
				],
			},
			dist: {
				styles: "{$config.dist}/css/custom/",
				scripts: "{$config.dist}/js/custom/",
			},
		},
		media: {
			src: {
				media: [
					"{$config.path.common_src}/media/**/*.*",
					"{$config.path.src}/media/**/*.*",
				],
			},
			dist: {
				media: "{$config.dist}/media/",
			},
		},
        misc: {
            src: {
                styles: [],
				media: [],
            },
            dist: {
				media: "{$config.dist}/plugins/global/sourcemaps/",
            }
        }
	}
};

export {
	gulpConfig
};