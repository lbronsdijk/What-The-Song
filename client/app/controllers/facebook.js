function FacebookController(auth, fb, sHandler, eHandler){

    auth.authenticateWithFacebook(
        //APP ID
        '221631931359668',
        //Permissions
        ['user_about_me', 'user_checkins']
    ).done(function(params){

        if (params.accessToken){

            var user, friends;
            var accessToken = params.accessToken;
            var session = fb.session;

            var dataCalls = new DataCallsModel();

            dataCalls.facebookUser(accessToken, function(data){

                user = data;

                dataCalls.facebookFriends(accessToken,function(data){

                    friends = data;

                    sHandler({user: user, friends: friends, accessToken: accessToken, session: session});
                });
            });

        } else {

            eHandler('No access token returned');

        }}).fail(function(request, error) {

            eHandler('The Authentication request ' + request + ' failed with error: ' + error);

        }
    );
}