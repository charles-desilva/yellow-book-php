<?php include_once("includes/db_connect.php");

$action = "";
$saleId="NULL";
$chqRcvdDate="NULL";
$chqNum="NULL";
$bank="NULL";
$branch="NULL";
$chqDate="NULL";
$chqValue="NULL";
$chqStatus="in-hand";
$chqCreditId="NULL";
$chqId="NULL";

if (isset($_POST["insertChequeDetailsBtn"]) || $_POST["action"] == "insert"){
    $action = "insert";
}else if(isset($_POST["updateChequeDetailsBtn"])) {
    $action = "update";
}else if (isset($_GET["action"])){
    if (isset($_GET["action"])=="delete"){
        $action = "delete";
        $chqId=$_GET["chq_id"];
        $chqCreditId=$_GET["credit_sale_id"];
    }
}


if (isset($_POST["saleId"])){
    $saleId=$_POST["saleId"];
}
if (isset($_POST["chqCreditId"])){
    $chqCreditId=$_POST["chqCreditId"];
}
if (isset($_POST["chqRcvdDate"])){
    $chqRcvdDate=$_POST["chqRcvdDate"];
}
if (isset($_POST["chqNum"])){
    $chqNum=$_POST["chqNum"];
}
if (isset($_POST["bank"])){
    $bank=$_POST["bank"];
}
if (isset($_POST["branch"])){
    $branch=$_POST["branch"];
}
if (isset($_POST["chqDate"])){
    $chqDate=$_POST["chqDate"];
}
if (isset($_POST["chqValue"])){
    $chqValue=$_POST["chqValue"];
}
if (isset($_POST["chqStatus"])){
    $chqStatus=$_POST["chqStatus"];
}
if (isset($_POST["chq_id"])){
    $chqId=$_POST["chq_id"];
}


if($action == "insert"){
    $sql = "INSERT INTO cheques_received (sale_id, chq_rcvd_date, chq_no, chq_bank, chq_bank_branch, chq_date, chq_value, chq_status, credit_id) 
        VALUES ($saleId, '$chqRcvdDate', $chqNum, '$bank', '$branch', '$chqDate', $chqValue, '$chqStatus', $chqCreditId)";
}else if($action == "update"){
    $sql = "UPDATE cheques_received 
    SET chq_rcvd_date = '$chqRcvdDate', chq_no=$chqNum, chq_bank='$bank', chq_bank_branch='$branch', chq_date='$chqDate', chq_value=$chqValue
    WHERE chq_id = $chqId";
}if($action == "delete"){
    $sql = "DELETE from cheques_received 
    WHERE chq_id = $chqId";
}


if(mysqli_query($con, $sql)){
    $data['success'] = true;
    //$data['insertChqId'] = $con->insert_id;
}else{
    $data['success'] = false;
    $data['sql'] = $sql;
    $data['error'] = mysqli_error($con);
}

//$data['sql'] = $data['success'];
// echo json_encode($data);
// die();
if ( (isset($_POST["creditSale"]) || $action == "delete" ) && $data['success'] == true){
    header("Location: new_credit_collection.php?credit_sale_id=$chqCreditId");
}

echo json_encode($data);
?>