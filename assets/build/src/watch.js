import gulp from "gulp";
import connect from "gulp-connect";
import { build } from "./build.js";
import { compile } from "./compile.js";

// localhost site
const localhost = (cb) => {
  connect.server({
    root: "..",
    livereload: true,
  });
  cb();
};

const reload = (cb) => {
  connect.reload();
  cb();
};

const watch = () => {
  return gulp.watch(
    [
      build.config.path.core_path + "/js/**/*.js",
      build.config.path.core_path + "/css/**/*.css",
      build.config.path.core_path + "/iframe/js/**/*.js",
      build.config.path.core_path + "/iframe/css/**/*.css"
    ],

    gulp.series(compile)
  );
};

const watchCSS = () => {
  return gulp.watch(
    build.config.path.core_path + "/css/**/*.css",
    gulp.parallel(compile)
  );
};

const watchJS = () => {
  return gulp.watch(
    build.config.path.core_path + "/js/**/*.js",
    gulp.parallel(compile)
  );
};

// Exports
export {
  localhost,
  reload, watch, watchCSS, watchJS
};
