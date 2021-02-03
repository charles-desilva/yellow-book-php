<?php 
include_once("includes/db_connect.php");
include_once("includes/functions.php");
$data = array(); 

$cash_reg_id = "";
$withdraw_date = "";
$withdraw_value="0.00";
$withdraw_desc = "";
$action = "";




if (isset($_POST["withdrawInsertButton"])){
    $action = "insert";
}else if (isset($_POST["withdrawUpdateButton"])) {
    $action = "update";
} else {
  $action = "delete";
}

if (isset($_POST["cashRegId"])){
    $cash_reg_id=$_POST["cashRegId"];
}
if (isset($_POST["withdrawDate"])){
    $withdraw_date=$_POST["withdrawDate"];
}
if (isset($_POST["withdrawValue"])){
    $withdraw_value=$_POST["withdrawValue"];
}
if (isset($_POST["withdrawReason"])){
    $withdraw_desc=$_POST["withdrawReason"];
}

if($action == "insert"){
    $sql2 = "INSERT INTO cash_register (cash_rcvd_date, cash_in_amount, cash_in_description) 
    VALUES ('$withdraw_date', $withdraw_value, '$withdraw_desc')";
}else if($action == "update"){
    $sql2 = "UPDATE cash_register 
    SET cash_rcvd_date='$withdraw_date', cash_in_amount=$withdraw_value, cash_in_description= '$withdraw_desc'
    WHERE cash_reg_id = $cash_reg_id";
}if($action == "delete"){
    $sql2 = "DELETE from cash_register 
    WHERE cash_reg_id = $cash_reg_id";
}
//echo $sql2; 
//die();

if(mysqli_query($con, $sql2)){
    $data['success'] = true;
    $data['insertSaleId'] = $con->insert_id;
}else{
    $data['success'] = false;
    $data['cashInQuery'] = $sql2;
}

updateCashInHand($withdraw_date);

if ($data['success'] == true){
   header("Location: cash_withdraw.php");
}else{
  echo mysqli_error($con) . "<br />";
  echo $sql2;
}

//echo json_encode($data);

?>