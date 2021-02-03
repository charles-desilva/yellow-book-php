<?php 
include_once("includes/db_connect.php");
$data = array(); 

$cash_reg_id = "";
$deposit_date = "";
$deposit_value="0.00";
$deposit_desc = "deposit";
$action = "";




if (isset($_POST["depositInsertButton"])){
    $action = "insert";
}else if (isset($_POST["depositUpdateButton"])) {
    $action = "update";
} else {
  $action = "delete";
}

if (isset($_POST["cashRegId"])){
    $cash_reg_id=$_POST["cashRegId"];
}
if (isset($_POST["depositDate"])){
    $deposit_date=$_POST["depositDate"];
}
if (isset($_POST["depositValue"])){
    $deposit_value=$_POST["depositValue"];
}

if($action == "insert"){
    $sql2 = "INSERT INTO cash_register (cash_rcvd_date, cash_out_amount, cash_out_description) 
    VALUES ('$deposit_date', $deposit_value, '$deposit_desc')";
}else if($action == "update"){
    $sql2 = "UPDATE cash_register 
    SET cash_rcvd_date='$deposit_date', cash_out_amount=$deposit_value
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

if ($data['success'] == true){
   header("Location: cash_deposit.php");
}else{
  echo mysqli_error($con) . "<br />";
  echo $sql2;
}

//echo json_encode($data);

?>