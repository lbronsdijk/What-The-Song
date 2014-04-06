<?php

//require files

require_once 'connection.php';

//validation check

if(isset($_POST['call']) === false || empty($_POST['call']) === true){

    error('No data call requested');
}

//data calls

function accountFromFacebookID($fbid){

    $account = selectQuery(
        'SELECT * FROM accounts WHERE fbid=:fbid',
        array(':fbid' => $fbid),
        false
    );

    response(array('fbid' => $account->fbid, 'name' => $account->name, 'email' => $account->email));
}

function checkStatus($key){

    $result = selectQuery(
        'SELECT title, artist FROM results WHERE rid=:rid',
        array(':rid' => $key),
        false
    );

    if($result && $result->title != null && $result->artist != null){

        response(array('status' => 'found result', 'title' => $result->title, 'artist' => $result->artist));

    } else if($result && ($result->title == null || $result->artist == null)) {

        response(array('status' => 'no result'));

    } else {

        response(array('status' => 'thinking'));
    }
}

//call processor

switch($_POST['call']){

    default:
        error('Invalid data call');
        break;

    case 'accountFromFacebookID':
        $fbid = $_POST['data']['fbid'];
        accountFromFacebookID($fbid);
        break;

    case 'checkStatus':
        $key = $_POST['data']['key'];
        checkStatus($key);
        break;
}

// server response

function response($data){

    echo json_encode($data);
    exit;
}

function error($message){

    response(array('error' => $message));
}