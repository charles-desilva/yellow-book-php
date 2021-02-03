<?php
// function to get the total value of the cheques in hand
function getTotalChequesInHand(){
  global $con;
  $sql ='SELECT SUM(cheques_received.chq_value) as inhand FROM cheques_received WHERE cheques_received.chq_status = "in-hand"';
  $result1 = mysqli_query($con, $sql);
  $row1 = mysqli_fetch_array($result1);
  return $row1["inhand"];
}

// function to get the total value of the cheques deposited
function getTotalChequesDeposited(){
  global $con;
  $sql ='SELECT SUM(cheques_received.chq_value) as inhand FROM cheques_received WHERE cheques_received.chq_status = "deposited"';
  $result1 = mysqli_query($con, $sql);
  $row1 = mysqli_fetch_array($result1);
  return $row1["inhand"];
}

// function to to get the url parameters add / update with new
function addOrUpdateUrlParam($name, $value){
    $params = $_GET;
    unset($params[$name]);
    $params[$name] = $value;
    return basename($_SERVER['PHP_SELF']).'?'.http_build_query($params);
}

// function to get total recievables 
function getTotaReceivables(){
  global $con;

  $sqlCredit = 'SELECT SUM(credit_sales.credit_amount) as totalReceivables FROM credit_sales'; 
  $sqlCash = 'SELECT SUM(cash_register.cash_in_amount) as totalCashPayments FROM cash_register WHERE cash_register.credit_id IS NOT NULL';
  $sqlCheque = 'SELECT SUM(cheques_received.chq_value) as totalChequesReceived FROM cheques_received WHERE (cheques_received.credit_id IS NOT NULL AND cheques_received.chq_status <> "bounced")';
  
  $result1 = mysqli_query($con, $sqlCredit);
  $row1 = mysqli_fetch_array($result1);
  $totalReceivables = $row1["totalReceivables"];

  $result1 = mysqli_query($con, $sqlCash);
  $row1 = mysqli_fetch_array($result1);
  $totalPaidInCash = $row1["totalCashPayments"];

  $result1 = mysqli_query($con, $sqlCheque);
  $row1 = mysqli_fetch_array($result1);
  $totalPaidInCheque = $row1["totalChequesReceived"];

  $netReceivables = $totalReceivables - $totalPaidInCash - $totalPaidInCheque;
  return $netReceivables;
}

function updateCashInHand($startDate){
  global $con;

  $sql ='SELECT cash_reg_id, cash_rcvd_date, cash_in_hand 
  FROM cash_register 
  WHERE DATE(cash_rcvd_date) < "'. $startDate .'"
  ORDER BY cash_rcvd_date DESC
  LIMIT 1';

  $result1 = mysqli_query($con, $sql);
  $row1 =mysqli_fetch_array($result1);
  $currentCashInHand = $row1['cash_in_hand'];
  //echo $sql;
  //die();

  $sql ='SELECT cash_rcvd_date, cash_reg_id, cash_in_amount, cash_out_amount, cash_in_hand 
  FROM cash_register 
  WHERE DATE(cash_register.cash_rcvd_date) >= "'. $startDate .'" 
  ORDER BY cash_rcvd_date ASC, cash_reg_id ASC';

  $result1 = mysqli_query($con, $sql);
  //$currentCashInHand = 0;
  while($row1 = mysqli_fetch_array($result1)){
    $cashIn = (float)($row1['cash_in_amount']);
    $cashOut = (float)($row1['cash_out_amount']);
    //echo $cashIn . " " . $cashOut . " " . $currentCashInHand . "<br />";

    $updatedCashInHand = $currentCashInHand = (float)$currentCashInHand + (float)$cashIn - (float)$cashOut;
    $sql = 'UPDATE cash_register 
    SET cash_in_hand = '.$updatedCashInHand.'
    WHERE cash_reg_id = '.$row1['cash_reg_id'];
    $result2 = mysqli_query($con, $sql);
     
  }
  //die();
}

?>