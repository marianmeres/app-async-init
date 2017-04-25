<?php
    // this is to illustrate slow loading of 3rd party lib...
    sleep(5);
    header("Content-type: application/javascript");
?>

window.FOO = {
    init: function() {
        console.log('FOO has initialized');
    }
};

fooAsyncInit && fooAsyncInit();
