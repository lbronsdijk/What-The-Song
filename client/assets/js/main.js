$(document).ready(function(){

    window.location.href = "spotify:app:what-the-song";

    require([
        '$api/models',
        '$views/image#Image',
        '$api/auth',
        '$api/facebook'
    ],
        function(models, Image, auth, facebook) {

            fbLogin(auth, facebook, function(data){

                var fb = data;

                //console.log(fb);

                accountFromFacebookID(fb.user.id, function(data){

                    alert('name: ' + data.name + ' email: ' + data.email);

                    // When application has loaded, run pages function
                    models.application.load('arguments').done(function(){

                        //fake
                        var key = '123456';

                        // initialize functions
                        initLanding(models, key);
                        initUserSearches();
                        initToggles();
                    });

                     var title = 'Billie Jean';
                     var artist = 'Michael Jackson';

                     searchTrack(title, artist, function(data){

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