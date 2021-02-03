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
  $page='debtors';
  include('./includes/sidebar.php');
  
  $customer_id = 0;
  $credit_status = "";
  $status = "";

  if(isset($_GET['customer_id'])){
    $customer_id = $_GET['customer_id'];
  }
  if(isset($_GET['credit_status'])){
    $customer_id = $_GET['credit_status'];
  }
  if(isset($_GET['status'])){
    $status = $_GET['status'];
  }
  

  ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Debtors Book</h1>
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
                
                
                <div class="row">
                  <!-- filter fields -->
                  <div class="card border-dark mb-3 col-md-6 col-sm-12">
                    <div class="card-body text-dark">
                      <form action="" method="get" >
                        <div class="row">
                          <div class="col">
                            <label for="status" class="text-sm">Credit Status</label>
                            <select class="form-control select2 form-control-sm" id="status" name="status">
                              <option selected value=0>All Statuses</option>
                              <option value="past_due" <?php if($status=="past_due"){echo "selected";}?>>Past Due Date</option>
                              <option value="not_due" <?php if($status=="not_due"){echo "selected";}?>>Not Past Due</option>
                            </select>
                          </div>
                          <div class="col">
                            <label for="customer_id" class="text-sm">Customer Name</label>
                            <select class="form-control select2 form-control-sm" id="customer_id" name="customer_id">
                              <option selected value=0>All Customers</option>
                              <?php 
                              $sql = "SELECT * FROM customers ORDER BY customer_name"; 
                              $result1 = mysqli_query($con, $sql);

                              while($row1 = mysqli_fetch_array($result1)){?>
                              <option value="<?=$row1["customer_id"]?>" <?php if($row1["customer_id"]==$customer_id){echo "selected";}?>><?=$row1["customer_name"]?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-3" >
                            <label for="startDate"  class="text-sm" >&nbsp;</label>
                            <div>
                              <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                              <a href="debtors.php" class="btn btn-secondary ml-1 btn-sm">Clear</a>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- total debtors at hand -->
                  <div class="col card border-dark mb-3 ml-2 bg-secondary ">
                    <div class="card-body text-light p-3">
                      <div class="text-right">
                        <span class="h5">
                          <strong>Net Receivables</strong>
                        </span> 
                        <div class="text-sm"> 
                          <em>(Including unrealised Debtor payments)</em>
                        </div>
                      </div>
                      <div class="h3 text-right mb-0">
                        <strong><?=number_format(getTotaReceivables(),2, '.', ',')?></strong>
                      </div>
                    </div>
                  </div>
                  <!-- total debtors past due -->
                  <div class="col card border-dark mb-3 ml-2 bg-warning">
                    <div class="card-body text-dark p-3">
                      <div class="text-right">
                        <span class="h5">
                          <strong>Receivables Past Due date </strong>
                        </span> 
                        <div class="text-sm">
                          <em>(Including unrealised Debtor payments)</em>
                        </div>
                      </div>
                      <div class="h3 text-right mb-0">
                        <strong><?=number_format(getTotalChequesDeposited(),2, '.', ',')?></strong>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <table class="table table-striped table-sm">
                    <thead>
                      <tr class="d-flex">
                        <th class="col-1" scope="col">Inv Date</th>
                        <th class="col-1" scope="col">Invoice #</th>
                        <th class="col-3" scope="col">Customer</th>
                        <th class="col-1 text-right" scope="col">Due Date</th>
                        <th class="col-2 text-right" scope="col">Amount</th>
                        <th class="col-1 text-right" scope="col">Paid by Cash</th>
                        <th class="col-1 text-right" scope="col">Paid by Chq</th>
                        <th class="col-1 text-right" scope="col">Total Paid</th>
                        <th class="col-1 text-center" scope="col"></th>
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

                          // $sql = "SELECT * FROM credit_sales"; 
                          // $result1 = mysqli_query($con, $sql);
                          // $number_of_result = mysqli_num_rows($result1);  
                          // $number_of_page = ceil ($number_of_result / $results_per_page);  
                          
                          $where_conditions = "";
                          if($customer_id != 0){
                            $where_conditions .= "sales.customer_id =" . $customer_id;
                          }
                          if($status == "past_due"){
                            if ($where_conditions !=""){ $where_conditions .= " AND ";}
                            $where_conditions .= 'credit_sales.credit_date < curdate()'.' AND 
                            IF(
                                    (SELECT SUM(cash_register.cash_in_amount) FROM cash_register WHERE cash_register.credit_id = credit_sales.credit_sale_id)
                                    +(SELECT SUM(cheques_received.chq_value) FROM cheques_received WHERE cheques_received.credit_id = credit_sales.credit_sale_id AND cheques_received.chq_status <> "bounced")
                                    < credit_sales.credit_amount, "un-settled", "settled") <>"settled"';
                          }else if($status == "not_due"){
                            if ($where_conditions !=""){ $where_conditions .= " AND ";}
                            $where_conditions .= "credit_sales.credit_date >= curdate()";
                          }

                          if ($where_conditions !=""){ $where_conditions = "WHERE (" . $where_conditions . ")";}
                          //echo NOW();

                          $sql = 'SELECT credit_sales.credit_sale_id, sales.inv_no, sales.sales_id, credit_sales.credit_amount, credit_sales.credit_date, sales.sale_date, customers.customer_name, sale_by.sale_by_name, sales.inv_no, 
                                  (SELECT SUM(cash_register.cash_in_amount) FROM cash_register WHERE cash_register.credit_id = credit_sales.credit_sale_id) AS cash_payments,
                                  (SELECT SUM(cheques_received.chq_value) FROM cheques_received WHERE cheques_received.credit_id = credit_sales.credit_sale_id AND cheques_received.chq_status <> "bounced") AS chq_payments
                                  
                                  FROM credit_sales 
                                  LEFT JOIN sales ON credit_sales.sale_id = sales.sales_id
                                  LEFT JOIN sale_by ON sales.sale_by = sale_by.sale_by_id 
                                  LEFT JOIN customers ON sales.customer_id = customers.customer_id
                                  LEFT JOIN cheques_received ON credit_sales.credit_sale_id = cheques_received.credit_id
                                  ' . $where_conditions . '
                                  GROUP BY credit_sales.credit_sale_id';
                                  
                        // echo $sql;

                          $result1 = mysqli_query($con, $sql);
                          $number_of_result = mysqli_num_rows($result1);  
                          $number_of_page = ceil ($number_of_result / $results_per_page);  

                          $sql .=' LIMIT ' . $page_first_result . ',' . $results_per_page;
                          $result1 = mysqli_query($con, $sql);
                          
                          if ($number_of_result < 1){
                            echo '<tr>
                              <td> 
                                <div class="alert alert-secondary bg-light mb-0 text-center" role="alert">
                                  <em>There are no Credit sales for given the criteria!</em> 
                                </div>
                              </td>
                            </tr>';
                          }

                          while($row1 = mysqli_fetch_array($result1)){
                          $colour = $statusText = "";
                          $status = '';

                          if(($row1["cash_payments"]+$row1["chq_payments"])>=$row1["credit_amount"]){
                              $colour .= "success";
                              $statusText = "SETTLED";
                          }else if($row1["credit_date"]<date("Y-m-d")) {
                              $colour .= "danger";
                              $statusText = "PAST-DUE";  
                          }else{

                          }
                          //$status = $row1["pd_status "];
                          
                          $paidInCash = $row1["cash_payments"];
                          $paidInCheque = $row1["chq_payments"];
                          $totalPaid = $paidInCash + $paidInCheque;
                          $creditAmount = $row1["credit_amount"];
                          $totalDue = $creditAmount - $totalPaid;
                          ?>
                            <tr class="d-flex table-<?=$colour?>">
                              
                              
                              <td class="col col-1">
                                  <?=date_format(date_create($row1["sale_date"]), 'd-m-Y')?>
                              </td>
                              <td class="col col-1">
                                <a href="new_sale.php?sale_id=<?=$row1["sales_id"]?>" class="ml-2">
                                  <?=$row1["inv_no"]?>
                                </a>
                                
                              </td>
                              
                              <td class="col col-3">
                                  <?=$row1["customer_name"]?>                               
                                  <div class="badge bg-warning ml-2"><?=$row1["sale_by_name"]?></div>
                              </td>
                              <td class="text-right col col-1">
                                  <?=date_format(date_create($row1["credit_date"]), 'd-m-Y')?>
                              </td>
                              <td class="text-right col col-2">
                                  <div><?=number_format($row1["credit_amount"],2, '.', ',')?></div>
                              </td>
                              <td class="text-right col col-1">
                                  <?=number_format($paidInCash,2, '.', ',')?>
                              </td>
                              <td class="text-right col col-1">
                                  <?=number_format($paidInCheque,2, '.', ',')?>
                              </td>
                              <td class="text-right col col-1">
                                  <?=number_format($paidInCash+$paidInCheque,2, '.', ',')?>
                              </td>
                              
                              <td class="text-center col col-1"><h5 class="mb-0"><span class="badge badge-<?=$colour?>"><?=$statusText?></span></h5></td>    
                              
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
                      <a class="page-link" href="<?=addOrUpdateUrlParam('page', $page-1)?>" tabindex="-1">Previous</a>
                    </li>
                    <?php 
                    for($i=1; $i<=$number_of_page; $i++){ ?>
                      <li class="page-item <?php if($i==$page){echo "active";}?>">
                        <a class="page-link" href="<?=addOrUpdateUrlParam('page', $i)?>"><?=$i?></a>
                      </li>
                    <?php } ?>
                    
                    <li class="page-item  <?php if($page>=$number_of_page){echo "disabled";}?>">
                      <a class="page-link" href="<?=addOrUpdateUrlParam('page', $page+1)?>">Next</a>
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