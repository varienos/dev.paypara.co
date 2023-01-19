import fs from "fs";
import _ from "lodash";
import gulp from "gulp";
import merge from "merge-stream";
import { clean } from "./clean.js";
import { build as buildMaster } from "./build.js";
import { argv, objectWalkRecursive, outputFunc, bundler } from "./helpers.js";

// merge with default parameters
const args = Object.assign(
  {
    prod: false,
    path: "",
  },
  argv
);

const tasks = [];
var build = buildMaster;

if (args.prod !== false) {
  // force disable debug for production
  build.config.debug = false;
  // force assets minification for production
  build.config.compile.jsMinify = true;
  build.config.compile.cssMinify = true;
}

// task to bundle js/css
let bundle = (cb) => {
  var streams = [];
  objectWalkRecursive(build.build, function (val, key) {
    if (val.hasOwnProperty("src") && val.hasOwnProperty("dist")) {
      if (["core", "iframe", "custom", "media"].indexOf(key) !== -1) {
        outputFunc(val);
      } else {
        streams = bundler(val);
      }
    }
  });
  cb();
  return merge(streams);
};

// don't clean assets if compile only 1 type
if (!args.css && !args.js && !args.media && !args.compile) {
  tasks.push(clean);
}

tasks.push(bundle);

if (args.presets && fs.existsSync(build.config.path.src + '/sass/presets')) {
  const presets = fs.readdirSync(build.config.path.src + '/sass/presets');

  objectWalkRecursive(build.build, function (val, key) {
    if (val.hasOwnProperty("src") && val.hasOwnProperty("dist")) {
      if (["core", "iframe", "custom", "media"].indexOf(key) !== -1) {
      } else {
        // build for presets
        if (typeof val.src.styles !== 'undefined') {
          if (val.src.styles[0].indexOf('style.scss') !== -1) {
            presets.forEach(preset => {
              let buildStylePresetTask = (cb) => {
                val.src.styles[0] = '{$config.path.src}/sass/presets/' + preset + '/style.scss';
                val.dist.styles = '{$config.dist}/css/style.' + preset + '.bundle.css';
                bundle(val);
                cb();
              };
              tasks.push(buildStylePresetTask);
            });
          }
        }

        if (typeof val.src.override !== 'undefined' && val.src.override.styles[0].indexOf('plugins.scss') !== -1) {
          presets.forEach(preset => {
            let buildPluginPresetTask = (cb) => {
              val.src.styles.forEach((file, i) => {
                if (file.indexOf('plugins.scss') !== -1) {
                  val.src.styles[i] = '{$config.path.src}/sass/presets/' + preset + '/plugins.scss';
                  val.dist.styles = '{$config.dist}/plugins/global/plugins.' + preset + '.bundle.css';
                  bundle(val);
                  cb();
                }
              });
            };
            tasks.push(buildPluginPresetTask);
          });
        }
      }
    }
  }, build.build);
}

// entry point
export const bundleTasks = gulp.series(...tasks);

// task to compile core assets
export let compile = (cb) => {
  var streams = [];
  objectWalkRecursive(build.compile, function (val, key) {
    if (val.hasOwnProperty("src") && val.hasOwnProperty("dist")) {
      outputFunc(val);
    }
  });
  cb();
  return merge(streams);
};