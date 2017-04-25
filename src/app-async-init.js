/**
 * Simple async point zero loader sugar.
 *
 * Dependency: https://github.com/muicss/loadjs
 *
 * @type {{push, loadAndRun}}
 */
var appAsyncInit = (function(loadjs){
    "use strict";

    var stack = [];
    var wasStarted = false;
    var loadedAndRanAlready = false;

    var done = function(){
        stack.forEach(function(fn){ fn(); }); // fifo
    };

    return {

        /**
         * @param cb
         */
        push: function(cb) {
            if (loadedAndRanAlready) { return cb ? cb() : null; }
            stack.push(cb);
        },

        /**
         * @param urls
         * @param preRunCheckCb "ak vrati falsey, tak sa nic zo stacku nevykona"
         */
        loadAndRun: function(urls, preRunCheckCb) {
            if (wasStarted) {
                return console.error("appAsyncInit: has already started loading");
            }
            if (Object.prototype.toString.call(urls) !== '[object Array]') {
                return console.error("appAsyncInit: expecting array of urls");
            }
            wasStarted = true;

            if (!urls.length) { return done(); }

            // order of urls is significant
            loadjs(urls, {
                // Fetch files in parallel and load them in series (loadjs is cool!)
                async: false,

                success: function() {
                    if (preRunCheckCb && !preRunCheckCb()) {
                        return console.error("appAsyncInit: pre-run check failure; skipping execution...");
                    }
                    loadedAndRanAlready = true;
                    return done();
                },

                error: function(pathsNotFound) {
                    console.error("appAsyncInit: load error", pathsNotFound);
                }
            });

        }

    }

})(loadjs);

