function HomeController(models, Image){

    var dropBox = new DropBoxModel(document.querySelector('.drop-box'), null, null, function(e){

        var dataCalls = new DataCallsModel();

        dataCalls.trackInfoForTracksFromPlaylist(e.dataTransfer.getData('text'), models, function(tracks){

            console.log(tracks);
        });

    });
}