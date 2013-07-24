<?php

require_once('../bootstrap.php');

if ($_GET['apiKey'] != "testUpdate") {
    header("401 Access Denied");
    exit;
}

$game = "";
if (isset($_GET['game']))
    $game = $_GET['game'];

$score = new \jaludo\score\Score();

if (!($PUT = json_decode(fread(fopen("php://input", "r"), 255))))
    throw new Exception("Can't get PUT data.");

$_PUT['game'] = $game;
$_PUT['user'] = $PUT->user;
$_PUT['score'] = $PUT->score;

try {
    $score->setScore($_PUT);
} catch (Exception $e) {
    header("404 Not found");
    echo "{\"error\":[{\"msg\":\"Unable to match request to data.\"}]}";
    exit;
}

echo '{"OK":[{"msg":"Success"}';