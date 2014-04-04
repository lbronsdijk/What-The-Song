function DataCallsModel(){

    // server url is a php file that handles data call requests
    var serverURL = 'http://wts:8888/server/server.php';

    /*
     / login data call
     / retrieves user data
     / parameters needed: user(string), pass(string)
    */
    this.accountFromFacebookID = function accountFromFacebookID(fbid, sHandler, eHandler){

        dataCall('accountFromFacebookID', {fbid: fbid}, sHandler, eHandler);
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
     / search track data call
     / retrieves information for a specific track
     / parameters needed: title, artistName, sHandler, artistModel($api/models#Artist)
    */
    this.searchTrack = function searchTrack(title, artistName, sHandler, artistModel){

        var source = 'http://ws.spotify.com/search/1/track.json?q=' + title;

        var tracks = [];

        $.getJSON(source, function(data){

            for(var i = 0; i < data.tracks.length; i++){

                for(var j = 0; j < data.tracks[i].artists.length; j++){

                    if(data.tracks[i].artists[j].name == artistName){

                        data.tracks[i].artist = data.tracks[i].artists[j];
                        break;
                    }
                }

                delete data.tracks[i].artists;
                tracks.push(data.tracks[i]);
            }

            var track = null;
            var popularity = 0;

            for(var i = 0; i < tracks.length; i++){

                if(tracks[i].popularity > popularity){
                    track = tracks[i];
                    popularity = tracks[i].popularity;
                }
            }

            if(track.artist.name == artistName){

                artistModel.fromURI(track.artist.href).load('name', 'image').done(function(artist) {

                    track.artist = artist;
                    sHandler(track);
                });
            }
        });
    }

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