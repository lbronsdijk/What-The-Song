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

//call processor

switch($_POST['call']){

    default:
        error('Invalid data call');
        break;

    case 'accountFromFacebookID':
        $fbid = $_POST['data']['fbid'];
        accountFromFacebookID($fbid);
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