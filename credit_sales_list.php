<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Debtors Register</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php 
  $page='creditSalesList';
  include('./includes/sidebar.php');?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Credit Sales List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Credit Sales List</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="col-md-12 col-sm-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Debtors History</h3>
              </div>
              <div class="card-body">
              <div>
                <table class="table table-striped table-sm">
                  <thead>
                    <tr class="d-flex">
                      <th class="col-1 text-left" scope="col">Status</th>
                      <th class="col-1" scope="col">Invoice</th>
                      <th class="col-3" scope="col">Customer</th>
                      <th class="col-2 text-right" scope="col">Credit Amount</th>
                      <th class="col-1 text-right" scope="col">Received</th>
                      <th class="col-2 text-center" scope="col"></th>
                      <th class="col-2 text-center" scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $results_per_page = 15;
                        $page = 1;
                        if (isset ($_GET['page']) ) {  
                           $page = $_GET['page'];   
                        } 
                        $page_first_result = ($page-1) * $results_per_page;  

                        $sql = "SELECT * FROM credit_sales"; 
                        $result1 = mysqli_query($con, $sql);
                        $number_of_result = mysqli_num_rows($result1);  
                        
                        $number_of_page = ceil ($number_of_result / $results_per_page);  
                        
                        $sql = "SELECT credit_sales.credit_sale_id, sales.inv_no, sales.sales_id, credit_sales.credit_amount, credit_sales.credit_date, sales.sale_date, customers.customer_name, sale_by.sale_by_name, sales.inv_no, 
                                (SELECT SUM(cash_register.cash_in_amount) FROM cash_register WHERE cash_register.credit_id = credit_sales.credit_sale_id) AS cash_payments,
                                (SELECT SUM(cheques_received.chq_value) FROM cheques_received WHERE cheques_received.credit_id = credit_sales.credit_sale_id AND cheques_received.chq_status <> 'bounced') AS chq_payments
                                FROM credit_sales 
                                LEFT JOIN sales ON credit_sales.sale_id = sales.sales_id
                                LEFT JOIN sale_by ON sales.sale_by = sale_by.sale_by_id 
                                LEFT JOIN customers ON sales.customer_id = customers.customer_id
                                LEFT JOIN cheques_received ON credit_sales.credit_sale_id = cheques_received.credit_id
                                GROUP BY credit_sales.credit_sale_id
                                LIMIT " . $page_first_result . ',' . $results_per_page;

                        $result1 = mysqli_query($con, $sql);
                        
                        while($row1 = mysqli_fetch_array($result1)){
                        $rowClasses = "";
                        //$status = '<h5><span class="badge badge-secondary">DUE</span></h5>';
                        $status = '';

                        if(($row1["cash_payments"]+$row1["chq_payments"])>=$row1["credit_amount"]){
                            $rowClasses .= "table-success";
                            $status = '<h5><span class="badge badge-success">SETTLED</span></h5>';
                        }else if($row1["credit_date"]<date("Y-m-d")) {
                            $status = '<h5><span class="badge badge-danger">PAST-DUE</span></h5>';
                            $rowClasses .= "table-danger";
                        }
                        
                        $paidInCash = $row1["cash_payments"];
                        $paidInCheque = $row1["chq_payments"];
                        $totalPaid = $paidInCash + $paidInCheque;
                        $creditAmount = $row1["credit_amount"];
                        $totalDue = $creditAmount - $totalPaid;
                        ?>
                          <tr class="d-flex <?php echo $rowClasses;?> ">
                            <td class="text-left col col-1"><?=$status?></td>
                            
                            <td class="col col-1">
                                <div><?=date_format(date_create($row1["sale_date"]), 'd-m-Y')?></div>
                                <div>
                                    <strong>#</strong>
                                    <a href="new_sale.php?sale_id=<?=$row1["sales_id"]?>" class="ml-2">
                                        <?=$row1["inv_no"]?>
                                    </a>
                                </div>
                            </td>
                            
                            <td class="col col-4">
                                <div><?=$row1["customer_name"]?></div>                                
                                <div class="badge bg-warning"><?=$row1["sale_by_name"]?></div>
                            </td>
                            <td class="text-right col col-1">
                                <div><?=number_format($row1["credit_amount"],2, '.', ',')?></div>
                                <div class="small">Due: <?=date_format(date_create($row1["credit_date"]), 'd-m-y')?></div>
                            </td>
                            <td class="text-right col col-1">
                                <div>
                                    <?=number_format($totalPaid,2, '.', ',')?>
                                    
                                </div>
                            </td>
                            <td class="col col-2">
                              
                                </div>
                                    <div>
                                        <?php if($paidInCash>0){?><span class="badge badge-secondary">IN CASH <?=number_format($paidInCash,2, '.', ',')?></span><br /><?php }?>
                                        
                                        <?php if($paidInCheque>0){?><span class="badge badge-success">IN  CHQ <?=$paidInCheque?></span><?php }?>
                                        
                                    </div>
                                    
                                <div>
                            </td>    
                            <td class="col col-2 text-center">
                                <a href="new_credit_collection.php?credit_sale_id=<?=$row1["credit_sale_id"]?>" class="btn btn-<?php if($totalDue>0){echo "primary";}else{echo "success";}?> btn-sm">
                                    <?php if($totalDue>0){echo "Add Payments";}else{echo "Edit Payments";}?>
                                </a>
                            </td>    
                            
                          </tr>
                        <?php } ?>

                    
                    
                  </tbody>
                </table>
              
              </div>
              </div>
              <div class="card-footer">
                <nav aria-label="...">
                  <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($page==1){echo "disabled";}?>">
                      <a class="page-link" href="?page=<?=$page-1?>" tabindex="-1">Previous</a>
                    </li>
                    <?php 
                    for($i=1; $i<=$number_of_page; $i++){ ?>
                      <li class="page-item <?php if($i==$page){echo "active";}?>">
                        <a class="page-link" href="?page=<?=$i?>"><?=$i?></a>
                      </li>
                    <?php } ?>
                    
                    <li class="page-item  <?php if($page>=$number_of_page){echo "disabled";}?>">
                      <a class="page-link" href="?page=<?=$page+1?>">Next</a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include("./includes/footer.php"); ?>
</div>
<!-- ./wrapper -->

<?php include("./includes/footerTags.php"); ?>
</body>
</html>