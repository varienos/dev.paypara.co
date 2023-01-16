import { clean } from "./assets/build/src/clean.js";
import { bundle } from "./assets/build/src/compile.js";
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

// Entry point:
export default bundle;
