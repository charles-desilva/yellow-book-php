<?php include_once("includes/db_connect.php");
    $data = array(); 
    $saleDate=$_POST["saleDate"];
    $saleBy=$_POST["saleBy"];
    $invoiceNo=$_POST["invoiceNo"];
    $customerId=$_POST["customerId"];
    $cashSale=$_POST["cashSale"];
    $chequeSale=$_POST["chequeSale"];
    $creditSale=$_POST["creditSale"];
    $saleId=$_POST["saleId"];

    if ($cashSale==''){$cashSale=0;}

    $sql = "UPDATE sales 
    SET sale_date='$saleDate', sale_by=$saleBy, inv_no='$invoiceNo', customer_id=$customerId, cash_sale=$cashSale, chq_sale=$chequeSale, credit_sale=$creditSale
    WHERE sales_id = $saleId";


    if(mysqli_query($con, $sql)){
        $data['success'] = true;
        $data['query'] = $sql;

        $sql2 = "UPDATE cash_register 
                SET cash_in_amount=$cashSale, cash_rcvd_date='$saleDate'
                WHERE  sale_id = $saleId";
        mysqli_query($con, $sql2);
        
    }else{
        $data['success'] = false;
        $data['query'] = $sql;
        $data['error'] = mysqli_error($con);
    }
    echo json_encode($data);
?>