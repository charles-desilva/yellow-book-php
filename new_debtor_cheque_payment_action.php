<?php include_once("includes/db_connect.php");

$paymentDate = $_POST['paymentDate'];
$creditSaleId=$_POST["credit_sale_id"];
$chequeNo=$_POST["chequeNo"];
$bank=$_POST["bank"];
$branch=$_POST["branch"];
$chequeDate=$_POST["chequeDateField1"];
$chequeValue=$_POST["chequeValue"];
$status='in-hand';

$sql = "INSERT INTO cheques_received (credit_sale_id, sale_id, credit_amount, credit_date, credit_status) VALUES (NULL, $saleId, $creditValue, '$creditDate', $chqStatus)";
//echo $sql;

if(mysqli_query($con, $sql)){
    $data['success'] = true;
    //$data['insertChqId'] = $con->insert_id;
}else{
    $data['success'] = false;
    $data['sql'] = $sql;
    $data['error'] = mysqli_error($con);
}
echo json_encode($data);
?>