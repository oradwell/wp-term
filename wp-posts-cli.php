<?php

require __DIR__ . '/bootstrap.php';

function json_response($array)
{
    header('Content-Type: application/json');
    echo json_encode($array);

    exit;
}

$cmd = isset($_GET['cmd']) ? $_GET['cmd'] : '';

use Ockcyp\WpPostsCli\Parser\Command as CommandParser;

$commandParser = new CommandParser;
if (!$commandParser->parse($cmd)) {
    json_response(array('msg' => "Please provide command in 'cmd' parameter."));
}

$command = $commandParser->get();
if (!$command) {
    json_response(array('msg' => "Invalid command '$cmd'"));
}

$result = $command->execute();
json_response($result);
