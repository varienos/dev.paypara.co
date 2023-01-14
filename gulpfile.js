import { cleanTask } from "./assets/build/src/clean.js";
import {
  localHostTask,
  reloadTask,
  watchTask,
  watchSCSSTask,
  watchJSTask,
} from "./assets/build/src/watch.js";
import {
  // rtlTask,
  // buildBundleTask,
  compileTask,
} from "./assets/build/src/compile.js";

// Clean tasks:
export { cleanTask as clean };

// Watch tasks:
export { localHostTask as localhost };
export { reloadTask as reload };
export { watchTask as watch };
export { watchSCSSTask as watchSCSS };
export { watchJSTask as watchJS };

// Main tasks:
// export { rtlTask as rtl };
// export { buildBundleTask as buildBundle };
export { compileTask as compile };

// Entry point:
export default compileTask;
