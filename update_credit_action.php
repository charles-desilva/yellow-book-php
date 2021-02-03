<?php include_once("includes/db_connect.php");

$saleId=$_POST["saleId"];
$creditValue=$_POST["creditValue"];
$creditDate=$_POST["creditDate"];
$chqStatus = 0;

$sql = "SELECT *
FROM credit_sales
WHERE sale_id = $saleId"; 
$result1 = mysqli_query($con, $sql);
//$row1 = mysqli_fetch_array($result1);

if (mysqli_num_rows($result1)==0){ 
    $sql = "INSERT INTO credit_sales (credit_sale_id, sale_id, credit_amount, credit_date, credit_status) 
    VALUES (NULL, $saleId, $creditValue, '$creditDate', $chqStatus)";

}else{
    $sql = "UPDATE credit_sales 
    SET credit_amount = $creditValue, credit_date = '$creditDate'
    WHERE  sale_id = $saleId";
}


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