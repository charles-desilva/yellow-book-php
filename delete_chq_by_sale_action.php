<?php include_once("includes/db_connect.php");
    $data = array(); 
    
    $saleId=$_POST["saleId"];

    $sql = "DELETE FROM cheques_received 
    WHERE sale_id = $saleId";


    if(mysqli_query($con, $sql)){
        $data['success'] = true;
        
    }else{
        $data['success'] = false;
        $data['query'] = $sql;
        $data['error'] = mysqli_error($con);
    }
    
    echo json_encode($data);
?>