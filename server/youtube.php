<?php

if (!isset($_GET['title']) || !isset($_GET['artist']))
    exit();

// Call set_include_path() as needed to point to your client library.
require_once 'google/client.php';
require_once 'google/service/Google_YouTubeService.php';

/* Set $DEVELOPER_KEY to the "API key" value from the "Access" tab of the
Google APIs Console <http://code.google.com/apis/console#access>
Please ensure that you have enabled the YouTube Data API for your project. */
$DEVELOPER_KEY = 'AIzaSyDwWG3yyOZ7PwcspzPx65xfPiQp7QPlIz8';

$client = new Google_Client();
$client->setDeveloperKey($DEVELOPER_KEY);

$youtube = new Google_YoutubeService($client);

$searchResponse = $youtube->search->listSearch('id,snippet', array(
    'q' => $_GET['title'] . '+by+' . $_GET['artist'],
    'maxResults' => 1,
    'type' => 'video',
    'order' => 'viewCount'
));

$videoID = (isset($searchResponse['items'][0])) ? $searchResponse['items'][0]['id']['videoId'] : '';
$videoImage = $searchResponse['items'][0]['snippet']['thumbnails']['high']['url'];

if($videoID != ''):
?>
<!doctype html>
<html>
<head>
    <title>Youtube</title>
    <script src="tubeplayer/libs/jquery/jquery.js"></script>
    <script src="tubeplayer/jQuery.tubeplayer.min.js"></script>
    <script>
        function iFrame(){
            try {
                return window.self !== window.top;
            } catch (e) {
                return true;
            }
        }

        $(document).ready(function(){

            var width = $(window).innerWidth();
            var height = $(window).innerHeight();

            if(!iFrame()){

                jQuery("#player").tubeplayer({

                    width: width, // the width of the player
                    height: height, // the height of the player
                    allowFullScreen: "true", // true by default, allow user to go full screen
                    initialVideo: "<?php print $videoID; ?>", // the video that is loaded into the player
                    preferredQuality: "hd720",// preferred quality: default, small, medium, large, hd720
                    autoPlay: true, // whether the player should autoplay the video, 0 or 1
                    showControls: false, // whether the player should have the controls visible, 0 or 1
                    modestbranding: true, // specify to include/exclude the YouTube watermark
                    annotations: false, // show annotations?
                    onPlay: function(id){}, // after the play method is called
                    onPause: function(){}, // after the pause method is called
                    onStop: function(){}, // after the player is stopped
                    onSeek: function(time){}, // after the video has been seeked to a defined point
                    onMute: function(){}, // after the player is muted
                    onUnMute: function(){} // after the player is unmuted
                });

            } else {

                var thumbnail = jQuery("#thumbnail");

                thumbnail.attr('src', '<?php print $videoImage ?>');
                thumbnail.attr('width', width);
                thumbnail.attr('height', height);
            }
        });

        $(window).resize(function(){

            var width = $(window).innerWidth();
            var height = $(window).innerHeight();

            if(!iFrame()){

                jQuery("#player").tubeplayer("size",{width:width,height:height});

            } else {

                var thumbnail = jQuery("#thumbnail");

                thumbnail.attr('src', '<?php print $videoImage ?>');
                thumbnail.attr('width', width);
                thumbnail.attr('height', height);
            }
        });
    </script>
    <style>
        html, body{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div id='player'>
        <img id='thumbnail'/>
    </div>
</body>
</html>
<?php endif; ?>