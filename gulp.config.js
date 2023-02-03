const config = {
  name: "Paypara",
  desc: "Gulp build config",
  version: "8.1.6",
  config: {
    debug: false,
    compile: {
      jsMinify: true,
      cssMinify: true,
    },
    path: {
      src: "assets/build/src",
      core_path: "assets/core",
      common_src: "assets/build/src",
      node_modules: "node_modules",
    },
    dist: ["assets/build/dist"],
  },
  build: {
    base: {
      src: {
        styles: ["{$config.path.src}/sass/style.scss"],
        scripts: [
          "{$config.path.common_src}/js/components/**/*.js",
          "{$config.path.common_src}/js/layout/**/*.js",
          "{$config.path.src}/js/layout/**/*.js",
        ],
      },
      dist: {
        styles: "{$config.dist}/css/style.bundle.css",
        scripts: "{$config.dist}/js/scripts.bundle.js",
      },
    },
    plugins: {
      global: {
        src: {
          mandatory: {
            jquery: {
              scripts: ["{$config.path.node_modules}/jquery/dist/jquery.js"],
            },
            popperjs: {
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
                "{$config.path.node_modules}/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css",
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
                "{$config.path.node_modules}/datatables.net-buttons/js/buttons.html5.js",
                "{$config.path.node_modules}/datatables.net-responsive/js/dataTables.responsive.min.js",
                "{$config.path.node_modules}/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js",
              ],
            },
            daterangepicker: {
              styles: [
                "{$config.path.node_modules}/bootstrap-daterangepicker/daterangepicker.css",
              ],
              scripts: [
                "{$config.path.node_modules}/bootstrap-daterangepicker/daterangepicker.js",
              ],
            },
            clipboard: {
              scripts: [
                "{$config.path.node_modules}/clipboard/dist/clipboard.min.js",
              ],
            },
            smoothscroll: {
              scripts: [
                "{$config.path.node_modules}/smooth-scroll/dist/smooth-scroll.js",
              ],
            },
            toastr: {
              styles: [
                "{$config.path.common_src}/plugins/toastr/build/toastr.css",
              ],
              scripts: [
                "{$config.path.common_src}/plugins/toastr/build/toastr.min.js",
              ],
            },
            apexcharts: {
              styles: [
                "{$config.path.node_modules}/apexcharts/dist/apexcharts.css",
              ],
              scripts: [
                "{$config.path.node_modules}/apexcharts/dist/apexcharts.min.js",
              ],
            },
            countupjs: {
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
            "bootstrap-icons": {
              styles: [
                "{$config.path.node_modules}/bootstrap-icons/font/bootstrap-icons.css",
              ],
              fonts: [
                "{$config.path.node_modules}/bootstrap-icons/font/fonts/**",
              ],
            },
            bootbox: {
              scripts: [
                "{$config.path.node_modules}/bootbox/dist/bootbox.min.js",
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
    },
    media: {
      src: {
        media: ["{$config.path.src}/media/**/*.*"],
        iframe: ["{$config.path.core_path}/iframe/images/**/*.*"],
      },
      dist: {
        media: "{$config.dist}/media/",
        iframe: "{$config.dist}/iframe/images/",
      },
    },
  },
  compile: {
    core: {
      src: {
        styles: [
          "{$config.path.core_path}/css/app.css"
        ],
        scripts: [
          "{$config.path.core_path}/js/2fa.js",
          "{$config.path.core_path}/js/app.js",
        ],
      },
      dist: {
        styles: "{$config.dist}/css/",
        scripts: "{$config.dist}/js/",
      },
    },
    iframe: {
      src: {
        styles: [
          "{$config.path.core_path}/iframe/css/app.css"
        ],
        scripts: [
          "{$config.path.core_path}/iframe/js/app.js",
          "{$config.path.core_path}/iframe/js/demo.js",
          "{$config.path.core_path}/iframe/js/imask.min.js",
          "{$config.path.core_path}/iframe/js/qrcode.min.js",
        ],
      },
      dist: {
        styles: "{$config.dist}/iframe/css/",
        scripts: "{$config.dist}/iframe/js/",
      },
    },
  }
};

export { config };
