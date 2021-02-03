<?php include_once("includes/db_connect.php");

$saleId=$_POST["saleId"];
$creditValue=$_POST["creditValue"];
$creditDate=$_POST["creditDate"];
$chqStatus=$_POST["chqStatus"];

$sql = "INSERT INTO credit_sales (credit_sale_id, sale_id, credit_amount, credit_date, credit_status) VALUES (NULL, $saleId, $creditValue, '$creditDate', $chqStatus)";
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