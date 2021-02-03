<?php 
include_once("includes/db_connect.php");
include_once("includes/functions.php");

$data = array(); 

$cash_reg_id = "";
$exp_date = "";
$expense_value="0.00";
$exp_desc = "";
$action = "";




if (isset($_POST["expInsertButton"])){
    $action = "insert";
}else if (isset($_POST["expUpdateButton"])) {
    $action = "update";
} else {
  $action = "delete";
}

if (isset($_POST["cashRegId"])){
    $cash_reg_id=$_POST["cashRegId"];
}
if (isset($_POST["expDate"])){
    $exp_date=$_POST["expDate"];
}
if (isset($_POST["expenseValue"])){
    $expense_value=$_POST["expenseValue"];
}
if (isset($_POST["expDesc"])){
    $exp_desc=$_POST["expDesc"];
}

if($action == "insert"){
    $sql2 = "INSERT INTO cash_register (cash_rcvd_date, cash_out_amount, cash_out_description) 
    VALUES ('$exp_date', $expense_value, '$exp_desc')";
}else if($action == "update"){
    $sql2 = "UPDATE cash_register 
    SET cash_rcvd_date='$exp_date', cash_out_amount=$expense_value, cash_out_description= '$exp_desc'
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

updateCashInHand($exp_date);

if ($data['success'] == true){
   header("Location: new_expense.php");
}else{
  echo mysqli_error($con) . "<br />";
  echo $sql2;
}

//echo json_encode($data);

?>