import gulp from "gulp";
import connect from "gulp-connect";
import { build } from "./build.js";
import { bundleTask } from "./compile.js";

// localhost site
const localHostTask = (cb) => {
  connect.server({
    root: "..",
    livereload: true,
  });
  cb();
};

const reloadTask = (cb) => {
  connect.reload();
  cb();
};

const watchTask = () => {
  return gulp.watch(
    [build.config.path.src + "/**/*.js", build.config.path.src + "/**/*.scss"],
    gulp.series(bundleTask)
  );
};

const watchSCSSTask = () => {
  return gulp.watch(
    build.config.path.src + "/**/*.scss",
    gulp.parallel(bundleTask)
  );
};

const watchJSTask = () => {
  return gulp.watch(
    build.config.path.src + "/**/*.js",
    gulp.parallel(bundleTask)
  );
};

// Exports
export {
  localHostTask,
  reloadTask, watchTask, watchSCSSTask, watchJSTask
};
