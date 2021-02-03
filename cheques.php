<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Cheque Registry</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php 
  $page='cheques';
  include('./includes/sidebar.php');
  
  $customer_id = 0;
  $status = "";

  if(isset($_GET['customer_id'])){
    $customer_id = $_GET['customer_id'];
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
            <h1 class="m-0">Received Cheques Registry</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Cheques Registry</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
        <!-- cheques in hand table -->
        <div class="col-sm-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Cheques in Hand</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="card border-dark mb-3 col-md-6 col-sm-12">
                  <div class="card-body text-dark">
                    <form action="" method="get" >
                      <div class="row">
                        <div class="col">
                          <label for="status" class="text-sm">Cheque Status</label>
                          <select class="form-control select2 form-control-sm" id="status" name="status">
                              <option selected value="">All Statuses</option>
                              <option value="in-hand" <?php if($status=="in-hand"){echo "selected";}?>>In Hand</option>
                              <option value="deposited" <?php if($status=="deposited"){echo "selected";}?>>Deposited (Not Realised)</option>
                              <option value="realised" <?php if($status=="realised"){echo "selected";}?>>Realised</option>
                              <option value="bounced" <?php if($status=="bounced"){echo "selected";}?>>Bounced</option>
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
                            <a href="cheques.php" class="btn btn-secondary ml-1 btn-sm">Clear</a>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col card border-dark mb-3 ml-2 bg-secondary ">
                  <div class="card-body text-light p-3">
                    <div class="text-right">
                      <span class="h5">
                        <strong>Cheques in Hand</strong>
                      </span> 
                      <div class="text-sm"> 
                        <em>(Excluding Deposited Cheques)</em>
                      </div>
                    </div>
                    <div class="h3 text-right mb-0">
                      <strong><?=number_format(getTotalChequesInHand(),2, '.', ',')?></strong>
                    </div>
                  </div>
                </div>
                <div class="col card border-dark mb-3 ml-2 bg-warning">
                  <div class="card-body text-dark p-3">
                    <div class="text-right">
                      <span class="h5">
                        <strong>Cheques Deposited</strong>
                      </span> 
                      <div class="text-sm">
                        <em>(Unrealised Cheques in Bank)</em>
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
                      <th class="col-1 text-left" scope="col">Date</th>
                      <th class="col-1 text-left" scope="col">Cheque #</th>
                      <th class="col-2 text-left" scope="col">Bank / Branch</th>
                      <th class="col-3 text-left" scope="col">Customer</th>
                      <th class="col-2 text-right pr-5" scope="col">Value</th>
                      <th class="col-1 text-center" scope="col">Cheque Date</th>
                      <th class="col-2 text-right" scope="col">Status</th>
                      
                    </tr>
                  </thead>
                  <tbody id="chqInHand">
                        <?php 

                        $results_per_page = 15;
                        $page = 1;
                        if (isset ($_GET['page']) ) {  
                           $page = $_GET['page'];   
                        } 
                        $page_first_result = ($page-1) * $results_per_page;  

                        $where_conditions = "";
                        if($customer_id != 0){
                          $where_conditions .= " sales.customer_id =" . $customer_id;
                        }
                        if($status != ""){
                          if ($where_conditions !=""){ $where_conditions .= " AND ";}
                          $where_conditions .= " cheques_received.chq_status ='" .$status . "'";
                        }
                        
                        if ($where_conditions !=""){ $where_conditions = " WHERE (" . $where_conditions . ")";}
                        //echo NOW();


                        $sql = 'SELECT cheques_received.chq_id, cheques_received.chq_rcvd_date, cheques_received.sale_id, cheques_received.credit_id, cheques_received.chq_no, cheques_received.chq_bank, cheques_received.chq_bank_branch, cheques_received.chq_date, cheques_received.chq_value, cheques_received.chq_status, sales.customer_id, customers.customer_name, sale_by.sale_by_name 
                        FROM cheques_received 
                        LEFT JOIN credit_sales ON cheques_received.credit_id = credit_sales.credit_sale_id 
                        INNER JOIN sales ON cheques_received.sale_id = sales.sales_id 
                        INNER JOIN customers ON sales.customer_id = customers.customer_id 
                        INNER JOIN sale_by ON sales.sale_by = sale_by.sale_by_id' .
                        $where_conditions
                        . ' ORDER BY cheques_received.chq_rcvd_date DESC ';

                        $result1 = mysqli_query($con, $sql);
                        $number_of_result = mysqli_num_rows($result1);  
                        $number_of_page = ceil ($number_of_result / $results_per_page);  

                        $sql .='LIMIT ' . $page_first_result . ',' . $results_per_page;

                        $result1 = mysqli_query($con, $sql);

                        //echo($sql);

                        if ($number_of_result < 1){
                          echo '<tr>
                            <td> 
                              <div class="alert alert-secondary bg-light mb-0 text-center" role="alert">
                                <em>There are no Cheques in Hand!</em>
                              </div>
                            </td>
                          </tr>';
                        }
                        while($row1 = mysqli_fetch_array($result1)){
                          
                          switch ($row1["chq_status"]) {
                            case "in-hand":
                              $badgeStyle = "secondary";
                              break;
                            case "deposited":
                              $badgeStyle = "warning";
                              break;
                            case "realised":
                              $badgeStyle = "success";
                              break;
                            case "bounced":
                              $badgeStyle = "danger";
                              break;
                          }
                          
                          ?>
                          <tr class="d-flex" data-chqId = <?= $row1['chq_id'] ?> >
                            <td class="col col-1 text-left"><?= date_format(date_create($row1["chq_rcvd_date"]), 'd-m-Y')?></td>
                            <td class="col col-1 text-left"><?=$row1["chq_no"]?> </td>
                            <td class="col-2 text-left"><?=$row1["chq_bank"]?> - <?=$row1["chq_bank_branch"]?></td>
                            <td class="col-3 text-left "><?=$row1["customer_name"]?> <span class="badge badge-secondary ml-4"><?=$row1["sale_by_name"] ?></span></td>
                            <td class="col-2 text-right pr-5"><?=number_format($row1["chq_value"],2, '.', ',')?></td>
                            <td class="col-1 text-center"><?= date_format(date_create($row1["chq_date"]), 'd-m-Y')?></td>
                            <td class="col-2 text-right"><h5 class="mb-0"><span class="badge badge-<?=$badgeStyle?>"><?= strtoupper($row1["chq_status"]) ?></span></h5></td>
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