function NavigationController(models){

    function tabs(){

        var args = models.application.arguments;

        if (args.length == 0) args = ['home', 'index'];

        console.log('args: ' + args);

        // compose file
        var file = args.length == 1 ? (args[0] + '.html') : '/app/views/' + args.slice(0, args.length).join('/') + '.html';

        console.log('file: ' + file);

        var controllerClassName = args[0].charAt(0).toUpperCase() + args[0].slice(1) + 'Controller';

        console.log('controllerClassName: ' + controllerClassName);

        $( "#content" ).load(file, function() {

            var controller = new window[controllerClassName](models, Image);
        });
    }

    // When application has loaded, run pages function
    models.application.load('arguments').done(tabs);

    // When arguments change, run pages function
    models.application.addEventListener('arguments', tabs);
}