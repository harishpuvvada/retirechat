Fixed MTurk Worker IDs for completed HITs.
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: text/plain");

require_once("Turk50.php");
include "include.php";


$AWSAccessKeyId = "AKIAIV26QZMS5FZ6C5CQ";
$AWSSecretAccessKeyId = "veASbo5iJhLN6GTcEOeT4lFJSccnCKlkTm4ny8Ow";

$turk50 = new Turk50($AWSAccessKeyId, $AWSSecretAccessKeyId, array("trace" => FALSE, "sandbox" => FALSE));

//$hitId = "3ATYLI1PRT230EUOI1ZD2RK345DOJX";
//$hitId = "3OID399FXG7WRFH392UCCZGDOWKDFO";
$hitId = "3OID399FXG7WRFH392UCCZGDOWKDFO";

$pageSize = 100;
$page = 1;

$Request = array(
 "HITId" => $hitId,
 "PageSize" => $pageSize,
 "PageNumber" => $page
);

$Response = $turk50->GetAssignmentsForHIT($Request);
$Assignments = $Response->GetAssignmentsForHITResult->Assignment;
$TotalNumResults = $Response->GetAssignmentsForHITResult->TotalNumResults;

$n = 1;
$pages = ceil($TotalNumResults/$pageSize);

printAssignments($conn, $Assignments);
while ($page < $pages) {
  $page++;
  $Request = array(
    "HITId" => $hitId,
    "PageSize" => $pageSize,
    "PageNumber" => $page
  );
  $Response = $turk50->GetAssignmentsForHIT($Request);
  $Assignments = $Response->GetAssignmentsForHITResult->Assignment;
  printAssignments($conn, $Assignments);
}

function printAssignments($conn, $arr) {
  if (count($arr) == 1) {
    $arr = array($arr);
  }
  foreach ($arr as $value) {
    if ($value && $value->WorkerId) {
      $assignmentId = $value->AssignmentId;
      $workerId = $value->WorkerId;
      $workerId = (strlen($workerId) > 14) ? substr($workerId,0,14) : $workerId;
      $workerId = preg_replace("/[^A-Za-z0-9 ]/", '', $workerId);
      $workerId = preg_replace("/\s+/", '', $workerId);
      $xml = simplexml_load_string($value->Answer);
      $usercode = $xml->Answer->FreeText;
      $usercode = (strlen($usercode) > 14) ? substr($usercode,0,14) : $usercode;
      $usercode = preg_replace("/[^A-Za-z0-9 ]/", '', $usercode);
      $usercode = preg_replace("/\s+/", '', $usercode);
      $acceptTime = $value->AcceptTime;
      printWorker($conn, $GLOBALS['n'], $workerId, $usercode, $assignmentId);
      $GLOBALS['n']++;
    }
  }
}

function printWorker($conn, $i, $workerId, $usercode,$assignmentId) {
  $stmt = mysqli_prepare($conn, "UPDATE user SET mtwid = ? WHERE usercode = ?");

  mysqli_stmt_bind_param($stmt, "ss", $workerId, $usercode);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo "$i,\t$workerId,\t$usercode,\t$assignmentId\n";
}

?>
