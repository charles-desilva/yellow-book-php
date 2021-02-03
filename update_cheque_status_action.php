<?php include_once("includes/db_connect.php");

if (isset($_POST["chq_id"])){
    $chqId=$_POST["chq_id"];
}
if (isset($_POST["chq_status"])){
    $chqStatus=$_POST["chq_status"];
}
    $sql = "UPDATE cheques_received 
    SET chq_status = '$chqStatus'
    WHERE chq_id = $chqId";

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