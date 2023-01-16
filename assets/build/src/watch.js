import gulp from "gulp";
import connect from "gulp-connect";
import { build } from "./build.js";
import { bundle } from "./compile.js";

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
    [build.config.path.core_path + "/js/**/*.js", build.config.path.core_path + "/css/**/*.css"],
    gulp.series(bundle)
  );
};

const watchCSS = () => {
  return gulp.watch(
    build.config.path.core_path + "/css/**/*.css",
    gulp.parallel(bundle)
  );
};

const watchJS = () => {
  return gulp.watch(
    build.config.path.core_path + "/js/**/*.js",
    gulp.parallel(bundle)
  );
};

// Exports
export {
  localhost,
  reload, watch, watchCSS, watchJS
};
