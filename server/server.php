<?php

//validation check

if(isset($_POST['call']) === false || empty($_POST['call']) === true){

    echo json_encode(array('error' => 'No data call requested'));
    exit;
}

//data calls

function loginDataCall($user, $pass){

    echo json_encode(array('user' => $user, 'pass' => $pass));
}

//call processor

switch($_POST['call']){

    default:
        echo json_encode(array('error' => 'Invalid data call'));
        exit;

    case 'login':
        $user = $_POST['data']['user'];
        $pass = $_POST['data']['pass'];
        loginDataCall($user, $pass);
        break;
}