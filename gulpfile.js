import gulp from "gulp";
import { clean } from "./assets/build/src/clean.js";
import { bundleTasks as bundle, compile } from "./assets/build/src/compile.js";
import { localhost, reload, watch, watchCSS, watchJS } from "./assets/build/src/watch.js";

// Clean tasks:
export { clean };

// Watch tasks:
export { localhost };
export { reload };
export { watch };
export { watchCSS };
export { watchJS };

// Main tasks:
export { bundle };
export { compile };

// Entry point:
export default gulp.series([bundle, compile]);