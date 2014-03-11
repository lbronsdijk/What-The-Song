$(document).ready(function(){

    require([
        '$api/models',
        '$views/image#Image',
        '$api/auth',
        '$api/facebook'
    ], function(models, Image, auth, facebook) {

        var fb = new FacebookController(auth, facebook, function(data){

            console.log(data);

            var navigationController = new NavigationController(models);

            var dataCalls = new DataCallsModel();

            dataCalls.accountFromFacebookID('100001566806807', function(data){

                alert('name: ' + data.name + ' email: ' + data.email);

            }, function(errorThrown){

                alert('errorThrown: ' + errorThrown);
            });

        }, function(errorThrown){

            console.log(errorThrown);
        });
    });
});