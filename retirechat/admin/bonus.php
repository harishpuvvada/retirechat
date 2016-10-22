<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
header("Content-Type: text/plain");

require_once("Turk50.php");

include "include.php";

$AWSAccessKeyId = "AKIAIV26QZMS5FZ6C5CQ";
$AWSSecretAccessKeyId = "veASbo5iJhLN6GTcEOeT4lFJSccnCKlkTm4ny8Ow";

$turk50 = new Turk50($AWSAccessKeyId, $AWSSecretAccessKeyId, array("trace" => FALSE, "sandbox" => FALSE));

//$hitId = "3ATYLI1PRT230EUOI1ZD2RK345DOJX";
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

//print_r($Assignments);
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
//     print_r($Assignments);

}


function printAssignments($conn, $arr) {
  #print_r($arr);
  if (count($arr) == 1) {
    $arr = array($arr);
  }
  foreach ($arr as $value) {
    if ($value && $value->WorkerId) {
      $assignmentId = $value->AssignmentId;
      $workerId = $value->WorkerId;
      $xml = simplexml_load_string($value->Answer);
      $usercode = $xml->Answer->FreeText;
      $acceptTime = $value->AcceptTime;
      $bonusAmount = getBonusAmount($conn, $usercode);
      $bonus = getBonus($assignmentId);
//      echo $workerId, ",\t", $bonus,"\n";
      printWorker($conn, $workerId, $usercode, $assignmentId, $bonusAmount, $bonus);
    }
  }
}

//Determines how much was already given
function getBonus($assignmentId) {
  $bonusAmount = 0;
  $Request = array(
    "Operation" => "GetBonusPayments",
    "AssignmentId" => $assignmentId
  );
  $Response = $GLOBALS['turk50']->GetBonusPayments($Request);

  //print_r($Response);

  if (isset($Response->GetBonusPaymentsResult->BonusPayment->BonusAmount->Amount)) {
    $bonusAmount = $Response->GetBonusPaymentsResult->BonusPayment->BonusAmount->Amount;
  }
  return $bonusAmount;
}

//Checks through the database how many times the user has already been bonused
function checkIfBonused($conn, $usercode) {
  $bonused = 1;

  $stmt = mysqli_prepare($conn, "SELECT awarded FROM user WHERE usercode = ?");
  mysqli_stmt_bind_param($stmt, "s", $usercode);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $bonused);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  return $bonused;
}

function getBonusAmount($conn, $usercode) {
  $bonusAmount = 0;

  $stmt = mysqli_prepare($conn, "SELECT reward FROM user WHERE usercode = ?");
  mysqli_stmt_bind_param($stmt, "s", $usercode);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $bonusAmount);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  //echo "$usercode\t$bonusAmount\n";

  return $bonusAmount;
}

function grantBonus($conn, $wrkrId, $usercode, $assignId, $amount, $timesBonused) {
  $timesBonused++;

  $bonusAmount = array(
    "Amount" => $amount,
    "CurrencyCode" => "USD",
  );

  $Request = array(
    "Operation" => "GrantBonus",
    "WorkerId" => $wrkrId,
    "AssignmentId" => $assignId,
    "BonusAmount" => $bonusAmount,
    "Reason" => "Completed retirement investment study"
  );

  $Response = $GLOBALS['turk50']->GrantBonus($Request);

  $stmt = mysqli_prepare($conn, "UPDATE user SET awarded = ? WHERE usercode = ?");
  mysqli_stmt_bind_param($stmt, "is", $timesBonused, $usercode);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

}


function printWorker($conn, $workerId, $usercode,$assignmentId,$bonusAmount, $bonus) {
  //$bonusEqual = false;
  $timesBonused = checkIfBonused($conn, $usercode);
  if ($bonusAmount == $bonus || $timesBonused > 0) {
    //$bonusEqual = true;
    echo "$workerId,\t$usercode,\t$assignmentId,\t$bonusAmount,\t$bonus,\tAlready bonused!\n";
  } else {
    grantBonus($conn, $workerId, $usercode, $assignmentId, $bonusAmount, $timesBonused);
    echo "$workerId,\t$usercode,\t$assignmentId,\t$bonusAmount,\t$bonus,\tJust bonused!\n";

  }
  //echo "$workerId,\t$usercode,\t$assignmentId,\t$bonusAmount,\t$bonus,\t$bonusEqual\n";
}

?>
