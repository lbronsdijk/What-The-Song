<?php
require_once 'connection.php';

if(isset($_FILES['file']) && !$_FILES['file']['error']
    && isset($_POST['filename'])
    && isset($_POST['key'])){

    //post parameters
    $fbid = $_POST['fbid'];
    $filename = $_POST['filename'];
    $key =  $_POST['key'];

    //check if key already exists in database
    $num_of_keys = selectQuery(
       'SELECT rid FROM results WHERE rid=:rid',
        array(':rid' => $key)
    );

    if(count($num_of_keys) > 0){
        echo json_encode(array('error' => 'Key already exists'));
        exit;
    }

    // execute echoprint-codegen bin through php
    // using ./echoprint-codegen
    $json = shell_exec('./echoprint-codegen ' . $_FILES['file']['tmp_name']);

    //echonest api call
    $url = "http://developer.echonest.com/api/v4/song/identify";
    $api_key = 'YZ5AQSBJDZXKCJ8A8';

    $data = array(
        'api_key'=>$api_key,
        'query'=>$json
    );

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

    $result = json_decode(curl_exec($ch));

    if(isset($result->response->songs) && count($result->response->songs) > 0){

        $title = $result->response->songs[0]->title;
        $artist = $result->response->songs[0]->artist_name;

        //save result with key in database
        transactionQuery(
            'INSERT INTO results (rid, fbid, title, artist) VALUES (:rid, :fbid, :title, :artist)',
            array(':rid' => $key, ':fbid' => $fbid, ':title' => $title, ':artist' => $artist)
        );

        //echo success message
        echo json_encode(array('success' => 'Found a result! Successfully stored in the database with key: ' . $key));

    } else {

        //save result with key in database
        transactionQuery(
            'INSERT INTO results (rid, fbid) VALUES (:rid, :fbid)',
            array(':rid' => $key, ':fbid' => $fbid)
        );

        //echo success message
        echo json_encode(array('error' => 'Could not found a result! Successfully stored in the database with key: ' . $key));
    }

} else {

    //echo error message
    echo json_encode(array('error' => 'Missing or invalid post parameters'));
    exit;
}