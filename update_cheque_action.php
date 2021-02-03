<?php include_once("includes/db_connect.php");

$saleId=$_POST["saleId"];
$chqRcvdDate=$_POST["chqRcvdDate"];
$chqNum=$_POST["chqNum"];
$bank=$_POST["bank"];
$branch=$_POST["branch"];
$chqDate=$_POST["chqDate"];
$chqValue=$_POST["chqValue"];
$chqStatus=$_POST["chqStatus"];
$chqCreditId=$_POST["chqCreditId"];

$sql = "INSERT INTO cheques_received (sale_id, chq_rcvd_date, chq_no, chq_bank, chq_bank_branch, chq_date, chq_value, chq_status, credit_id) 
VALUES ($saleId, '$chqRcvdDate', $chqNum, '$bank', '$branch', '$chqDate', $chqValue, '$chqStatus', $chqCreditId)";

// $sql = "UPDATE cheques_received 
// SET chq_no = $chqNum, chq_bank='$bank', chq_bank_branch='$branch', chq_date='$chqDate', chq_value=$chqValue, chq_status=$chqStatus 
// WHERE sale_id =$saleId";
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