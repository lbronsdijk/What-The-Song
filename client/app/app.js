$(document).ready(function(){

    require([
        '$api/models',
        '$views/image#Image',
        '$api/auth',
        '$api/facebook'
    ],
        function(models, Image, auth, facebook) {

        var navigationController = new NavigationController(models);
        var dataCalls = new DataCallsModel();

        FacebookController(auth, facebook, function(data){

            var fb = data;

            console.log(fb);

            dataCalls.accountFromFacebookID(fb.user.id, function(data){

                alert('name: ' + data.name + ' email: ' + data.email);

                var title = 'Billie Jean';
                var artist = 'Michael Jackson';

                dataCalls.searchTrack(title, artist, function(data){

                    console.log(data);

                }, models.Artist);

            }, function(errorThrown){

                alert('errorThrown: ' + errorThrown);
            });

        }, function(errorThrown){

            console.log(errorThrown);
        });
    });
});