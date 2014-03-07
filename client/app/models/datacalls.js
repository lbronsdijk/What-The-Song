function DataCallsModel(){

    // server url is a php file that handles data call requests
    var serverURL = 'http://prj03:8888/server.php';

    /*
     / login data call
     / retrieves user data
     / parameters needed: user(string), pass(string)
    */
    this.login = function login(user, pass, sHandler, eHandler){

        dataCall('login', {user: user, pass: pass}, sHandler, eHandler);
    };

    /*
     / facebook user data call
     / retrieves facebook user data
     / parameters needed: accessToken($api/auth token)
    */
    this.facebookUser = function facebookUser(accessToken, sHandler){

        var source = 'https://graph.facebook.com/me?access_token=' + accessToken + '&callback=?';
        $.getJSON(source, function(data){sHandler(data)});
    };

    /*
     / facebook friends data call
     / retrieves facebook friends data
     / parameters needed: accessToken($api/auth token)
    */
    this.facebookFriends = function facebookFriends(accessToken, sHandler){

        var source = 'https://graph.facebook.com/me/friends?access_token=' + accessToken + '&callback=?';
        $.getJSON(source, function(data){sHandler(data)});
    };

    /*
     / track info data call
     / retrieves information for a specific track
     / parameters needed: uri($api/models#Track uri)
    */
    this.trackInfo = function trackInfo(uri, sHandler){

        var source = 'http://ws.spotify.com/lookup/1/.json?uri=' + uri;
        $.getJSON(source, function(data){sHandler(data)});
    };

    /*
     / track info for tracks from a playlist data call
     / retrieves information for all tracks within a playlist
     / parameters needed: uri($api/models#Playlist uri), models($api/models)
    */
    this.trackInfoForTracksFromPlaylist = function trackInfoForTracksFromPlaylist(uri, models, sHandler){

        var playlist = models.Playlist.fromURI(uri);

        playlist.load('tracks').done(function(playlist) {

            playlist.tracks.snapshot().done(function(trackSnapshot){

                var tracks = trackSnapshot.toArray();
                sHandler(tracks);
            });
        });
    };

    /*
     / generate json data
     / returns a json object to be send to the server
     / parameters needed: call(string), data(array)
    */
    function generateJSONData(call, data){

        var dataStr = '';

        for (var key in data){

            if (data.hasOwnProperty(key)) {

                if(dataStr !== '') dataStr += ',';

                dataStr += '"' + key + '": "' + data[key] + '"';
            }
        }

        return JSON.parse('{"call": "' + call + '", "data": {' + dataStr + '}}');
    }

    /*
     / request data from the server
     / sends a data call request to the server and returns data or an error
     / parameters needed: call(string), data(array), sHandler(function), eHandler(function)
    */
    function dataCall(call, data, sHandler, eHandler){

        var JSONData = generateJSONData(call, data);

        $.post(serverURL, JSONData, function(data){

            data = JSON.parse(data);
            data.hasOwnProperty('error') ? eHandler(data.error) : sHandler(data);
        });
    }
}