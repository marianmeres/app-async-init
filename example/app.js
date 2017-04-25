
var app = {

    initialize: function($root) {
        $root.html([
            '<p><b>',
                'Dependencies are loaded, app is initialized, we\'re safe to start...',
            '</b></p>'
        ].join(""));

        this.$fooButton = $('<button disabled>...in the meantime we\'re still waiting for Foo</button>')
            .appendTo($root);

        // this is critical to the example
        appCallbackStack.push('foo', this.onFooLoad.bind(this));

        // this actually makes no sense, point is to illustrate that the callbacks
        // are executed even after the "loadAndRun" was executed
        appAsyncInit.push(function(){
            console.log('this is to illustrate that you may register the "init callbacks" anywhere 2');
        })
    },

    onFooLoad: function() {
        this.$fooButton
            .on('click', function(){ alert('bar') })
            .prop('disabled', false)
            .html('Foo ready!');
    }

};
