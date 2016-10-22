<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
header("Content-Type: text/plain");

require_once("Turk50.php");

include "include.php";

$AWSAccessKeyId = "AKIAIV26QZMS5FZ6C5CQ";
$AWSSecretAccessKeyId = "veASbo5iJhLN6GTcEOeT4lFJSccnCKlkTm4ny8Ow";

$turk50 = new Turk50($AWSAccessKeyId, $AWSSecretAccessKeyId, array("trace" => FALSE, "sandbox" => FALSE));

$response = $turk50->GetAccountBalance();
print_r($response);

?>
