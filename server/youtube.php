<?php

if (isset($_GET['title']) && isset($_GET['artist'])) {
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
        'q' => $_GET['title'] . ' by ' . $_GET['artist'],
        'maxResults' => 10
    ));

    $videoID = '';
    $mostViews = 0;

    foreach ($searchResponse['items'] as $searchResult) {
        switch ($searchResult['id']['kind']) {
            case 'youtube#video':

                $JSON = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$searchResult['id']['videoId']}?v=2&alt=json");
                $JSON_Data = json_decode($JSON);

                $views = $JSON_Data->{'entry'}->{'yt$statistics'}->{'viewCount'};

                if($views > $mostViews){
                    $videoID = $searchResult['id']['videoId'];
                    $mostViews = $views;
                }

                break;
        }
    }

    if($videoID != '')
        print '<iframe width="560" height="315" src="//www.youtube.com/embed/'.$videoID.'?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>';
    else
        print 'no videos were found :(';
}