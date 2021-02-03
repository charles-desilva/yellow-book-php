<?php include_once("includes/db_connect.php");

$data = array(); 
$customer_name_data =  ucfirst($_POST["customerName"]);
$customer_address_data =  $_POST["customerAddress"];
$customer_phone_data =  $_POST["customerPhone"];

$sql = "INSERT INTO customers (customer_name, customer_address, customer_phone) VALUES ('$customer_name_data','$customer_address_data', '$customer_phone_data')";
//echo $sql;

if(mysqli_query($con, $sql)){
    $data['success'] = true;
    $last_id = $con->insert_id;
    $data['id'] = $last_id;
    $data['name'] = $customer_name_data;
    $data['message'] = 'Success';
    //header("location:list.php?msg=Model Added successfully!&status=successful");
}else{
    $data['success'] = false;
    $data['message'] = mysqli_error($con);
}
echo json_encode($data);
?>