<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>App async init example</title>
    <script><?php echo file_get_contents('./loadjs.min.js') ?></script>
    <script><?php echo file_get_contents('../dist/app-async-init.min.js') ?></script>
    <script><?php echo file_get_contents('../dist/app-callback-stack.min.js') ?></script>
    <style>
        body {padding: 3em;}
    </style>
</head>
<body>

<div id="app">Loading, please wait...</div>

<script>
    appAsyncInit.push(function(){
        // everything we critically need is loaded, any optional sanity checks are made,
        // and we are safe to start running our app
        app.initialize($('#app'));
    })
</script>

<script>
    var urls = [
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css",
        "https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js",
        "https://code.jquery.com/jquery-3.1.1.slim.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js",
        "https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js",
        "app.js"
    ];
    //
    appAsyncInit.loadAndRun(urls, function() {
        // this callback is optional...

        // idea is to do any additional checks here, and if any problems are found
        // we may return false and none of the registered callbacks (via appAsyncInit.push)
        // will be executed

        // to illustrate the above, let's make sure we run our app only if
        // jQuery and underscore are loaded properly
        return ($ && _);
    })
</script>

<script>
    // this example ilustrate the usage of appCallbackStack, which is especially usefull
    // for the usage of third party libs... the scenario is:
    // 1. we have to load 3rd party libs via theirs own async loading, but we dont
    //    want to include this 3rd party as a hard dependency
    // 2. we want to have conventional and transparent machanism of handling these cases...
    //
    // e.g. Facebook SDK, Google auth, ...
    //
    window.fooAsyncInit = function() { // looks familiar? ;)
        FOO.init();
        appCallbackStack.init('foo');
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "foo-sdk.php";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'foo-jssdk'));
</script>

<p style="margin-top: 3em;"><small>
    Source on <a href="https://github.com/marianmeres/app-async-init">GitHub</a>
</small></p>

<script>
    appAsyncInit.push(function(){
        console.log('this is to illustrate that you may register the "init callbacks" anywhere');
    })
</script>

</body>
</html>