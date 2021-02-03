<?php include_once("includes/db_connect.php");
    $data = array(); 
    
    $saleId=$_POST["saleId"];

    if ($cashSale==''){$cashSale=0;}

    $sql = "DELETE FROM sales 
    WHERE sales_id = $saleId";


    if(mysqli_query($con, $sql)){
        $data['success'] = true;
        
    }else{
        $data['success'] = false;
        $data['query'] = $sql;
        $data['error'] = mysqli_error($con);
    }
    
    echo json_encode($data);
?>