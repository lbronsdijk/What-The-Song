<?php

if (!isset($_GET['title']))
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
    'q' => $_GET['title'],
    'maxResults' => 1,
    'type' => 'video',
    'order' => 'viewCount'
));

$videoID = (isset($searchResponse['items'][0])) ? $searchResponse['items'][0]['id']['videoId'] : '';

if($videoID != ''):
?>
<!doctype html>
<html>
<head>
    <title></title>
</head>
<body>
    <iframe width="560" height="315" src="//www.youtube.com/embed/<?php print $videoID; ?>?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>
</body>
</html>
<?php endif; ?>