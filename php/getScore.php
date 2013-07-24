<?php

if(file_exists('../bootstrap.php'))
    require_once('../bootstrap.php');

if(file_exists('./bootstrap.php'))
    require_once('./bootstrap.php');


if (!isset($_GET['apiKey']) || $_GET['apiKey'] != "testUpdate") {
    header("401 Access Denied");
    exit;
}

$game = "";
if (isset($_GET['game']))
    $game = $_GET['game'];

/*
if($game == "" || $game == 'undefined') {
    echo "{\"error\":[{\"msg\":\"You didn't want to do that Dave.\"}]}";
    exit;
}
*/
$score = new jaludo\score\Score();
try{
echo json_encode($score->getScoresByGame($game));
} catch (Exception $e) {
    header("404 Not found");
    echo "{\"error\":[{\"msg\":\"You didn't want to do that Dave.\"}]}";
}

