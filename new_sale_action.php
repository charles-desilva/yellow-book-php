<?php include_once("includes/db_connect.php");
$data = array(); 
$saleDate=$_POST["saleDate"];
$saleBy=$_POST["saleBy"];
$invoiceNo=$_POST["invoiceNo"];
$customerId=$_POST["customerId"];
$cashSale=$_POST["cashSale"];
$chequeSale=$_POST["chequeSale"];
$creditSale=$_POST["creditSale"];

if ($cashSale==''){$cashSale=0;}

$sql = "INSERT INTO sales (sales_id, sale_date, sale_by, inv_no, customer_id, cash_sale, chq_sale, credit_sale) 
VALUES (NULL, '$saleDate', $saleBy, '$invoiceNo', $customerId, $cashSale, $chequeSale, $creditSale)";

if(mysqli_query($con, $sql)){
    $data['success'] = true;
    $data['insertSaleId'] = $con->insert_id;

    if ($cashSale != 0){

        $sql2 = "INSERT INTO cash_register (cash_in_amount, sale_id, cash_rcvd_date) 
        VALUES ($cashSale, $con->insert_id, '$saleDate')";

        if(mysqli_query($con, $sql2)){
            $data['success'] = true;
            $data['insertSaleId'] = $con->insert_id;
        }else{

            $sql3 = "DELETE FROM sales 
                WHERE sales_id = $con->insert_id";

            if(mysqli_query($con, $sql)){
                $data['success'] = true;
            }else{
                $data['success'] = false;
                $data['saleDelQuery'] = $sql3;
            }

            $data['success'] = false;
            $data['cashInQuery'] = $sql2;
        }

    }

}else{
    $data['success'] = false;
    $data['saleQuery'] = $sql;
    $data['error'] = mysqli_error($con);
}
echo json_encode($data);
?>