import { clean } from "./assets/build/src/clean.js";
import { bundleTask } from "./assets/build/src/compile.js";
import { localHostTask, reloadTask, watchTask, watchSCSSTask, watchJSTask } from "./assets/build/src/watch.js";

// Clean tasks:
export { clean };

// Watch tasks:
export { localHostTask as localhost };
export { reloadTask as reload };
export { watchTask as watch };
export { watchSCSSTask as watchSCSS };
export { watchJSTask as watchJS };

// Main tasks:
export { bundleTask as bundle };

// Entry point:
export default bundleTask;
