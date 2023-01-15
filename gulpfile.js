import { clean } from "./assets/build/src/clean.js";
import { compileTask } from "./assets/build/src/compile.js";
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
export { compileTask as compile };

// Entry point:
export default compileTask;
