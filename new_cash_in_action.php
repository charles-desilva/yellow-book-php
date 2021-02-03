<?php 
include_once("includes/db_connect.php");
$data = array(); 

$cashInAmount="NULL";
$cashOutAmount="NULL";
$saleId="NULL";
$purchaseId="NULL";
$creditId="NULL";
$chequeId="NULL";
$cashRegId = "NULL";
$action = "";

if (isset($_POST["insertCashDetailsBtn"])){
    $action = "insert";
}else{
    $action = "update";
}

if (isset($_GET["action"])){
    if (isset($_GET["action"])=="delete"){
        $action = "delete";
        $cashRegId=$_GET["cash_reg_id"];
        $creditId=$_GET["credit_sale_id"];
    }
}


if (isset($_POST["cashInDate"])){
    $cashInDate=$_POST["cashInDate"];
}
if (isset($_POST["cashRegId"])){
    $cashRegId=$_POST["cashRegId"];
}
if (isset($_POST["cashInAmount"])){
    $cashInAmount=$_POST["cashInAmount"];
}
if (isset($_POST["cashOutAmount"])){
    $cashOutAmount=$_POST["cashOutAmount"];
}
if (isset($_POST["saleId"])){
    $saleId=$_POST["saleId"];
}
if (isset($_POST["purchaseId"])){
    $purchaseId=$_POST["purchaseId"];
}
if (isset($_POST["creditId"])){
    $creditId=$_POST["creditId"];
}
if (isset($_POST["chequeId"])){
    $chequeId=$_POST["chequeId"];
}

if($action == "insert"){
    $sql2 = "INSERT INTO cash_register (cash_rcvd_date, cash_in_amount, cash_out_amount, sale_id, purchase_id, 	credit_id, cheq_id) 
    VALUES ('$cashInDate', $cashInAmount, $cashOutAmount, $saleId, $purchaseId, $creditId, $chequeId)";
}else if($action == "update"){
    $sql2 = "UPDATE cash_register 
    SET cash_rcvd_date='$cashInDate', cash_in_amount=$cashInAmount
    WHERE cash_reg_id = $cashRegId";
}if($action == "delete"){
    $sql2 = "DELETE from cash_register 
    WHERE cash_reg_id = $cashRegId";
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

if ((isset($_POST["creditId"]) || $action == "delete" ) && $data['success'] = true){
    header("Location: new_credit_collection.php?credit_sale_id=$creditId");
}

echo json_encode($data);

?>