$(document).ready(function(){

    //fix for record button not resetting
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

                accountFromFacebookID(fb.user.id, function(data){

                    alert('name: ' + data.name + ' email: ' + data.email);

                    // When application has loaded, run pages function
                    models.application.load('arguments').done(function(){

                        //generate key
                        getKey(function(data){

                            var key = data.key;

                            // initialize functions
                            initLanding(models, key, fb, Image);
                            initUserSearches();
                            initToggles();

                        }, function(errorThrown){

                            alert('errorThrown: ' + errorThrown);
                        });
                    });
                }, function(errorThrown){

                    alert('errorThrown: ' + errorThrown);
                });
            }, function(errorThrown){

                alert('errorThrown: ' + errorThrown);
            });
        });
});