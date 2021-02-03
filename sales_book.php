<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Sales Book</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php 
  $page='salesBook';
  include('./includes/sidebar.php');
  
    $customer_id = 0;
    $start_date = "1990-01-01";
    $end_date = "3000-12-31";
    $start_date_field = "";
    $end_date_field = "";
    $saleById = "";

    $status = "";

    if(isset($_GET['customer_id'])){
        $customer_id = $_GET['customer_id'];
    }
    if(isset($_GET['start_date']) && $_GET['start_date'] !=""){
        $start_date = $start_date_field = $_GET['start_date'];
        
    }
    if(isset($_GET['end_date']) && $_GET['end_date'] !=""){
        $end_date = $end_date_field = $_GET['end_date'];
    }
    if(isset($_GET['status'])){
        $status = $_GET['status'];
    }
    if(isset($_GET['sale_by_id'])){
        $saleById = $_GET['sale_by_id'];
    }
  

  ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Sales Book</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Sales Book</li>
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
              <h3 class="card-title">Sales History</h3>
            </div>
            <div class="card-body">
              <form class="card-body pl-0 pt-0" action="" method="get">
                <div class="form-row">
                  <div class="col-2">
                    <label for="start_date" >Sales from Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?=$start_date_field?>">
                  </div>
                  <div class="col-2">
                    <label for="end_date" >Sales to Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?=$end_date_field?>">
                  </div>
                  <div class="col-2">
                    <label for="startDate" >Customer</label>
                    <select class="form-control select2" id="customer_id" name="customer_id">
                        <option selected value=0>All Customers</option>
                        <?php 
                        $sql = "SELECT * FROM customers ORDER BY customer_name"; 
                        $result1 = mysqli_query($con, $sql);

                        while($row1 = mysqli_fetch_array($result1)){?>
                        <option value="<?=$row1["customer_id"]?>" <?php if($row1["customer_id"]==$customer_id){echo "selected";}?>><?=$row1["customer_name"]?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="col-2">
                    <label for="startDate" >Sale By</label>
                    <select class="form-control select2" id="sale_by_id" name="sale_by_id">
                        <option selected value="">All Channels</option>
                        <?php 
                        $sql = "SELECT * FROM sale_by ORDER BY sale_by_name"; 
                        $result1 = mysqli_query($con, $sql);

                        while($row1 = mysqli_fetch_array($result1)){?>
                        <option value="<?=$row1["sale_by_id"]?>" <?php if($row1["sale_by_id"]==$saleById){echo "selected";}?>><?=$row1["sale_by_name"]?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="col-4" >
                    <label >&nbsp; </label>
                    <div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="sales_book.php" class="btn btn-secondary ml-1">Clear</a>
                    </div>
                  </div>
                </div>
              </form>

            <div>
              <table class="table table-striped">
                <thead>
                  <tr class="d-flex">
                    <th class="col-1" scope="col">Sale Date</th>
                    <th class="col-1 text-center" scope="col">Inv #</th>
                    <th class="col-5" scope="col">Customer</th>
                    <th class="col text-right" scope="col">Cash Sale</th>
                    <th class="col text-right" scope="col">Chq Sale</th>
                    <th class="col text-right" scope="col">Credit Sale</th>
                    <th class="col text-right" scope="col">Total Sale</th>
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

                      // getting the number of sales record in DB
                      $sql = "SELECT * FROM sales"; 
                      $result1 = mysqli_query($con, $sql);
                      $number_of_result = mysqli_num_rows($result1);  
                      $number_of_page = ceil ($number_of_result / $results_per_page);  
                      


                      $where_conditions = "";
                      if($customer_id != 0){
                        $where_conditions .= "sales.customer_id =" . $customer_id;
                      }

                      if($where_conditions==""){
                          $where_conditions .= ' DATE(sales.sale_date) BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
                      }else{
                          $where_conditions .= ' AND DATE(sales.sale_date) BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
                      }

                      if($saleById != ""){
                        if($where_conditions==""){
                            $where_conditions .= ' sales.sale_by =' . $saleById;
                        }else{
                            $where_conditions .= ' AND sales.sale_by =' . $saleById;
                        }
                      }
                      if ($where_conditions !=""){ $where_conditions = "WHERE (" . $where_conditions . ")";}

                      $sql = 'SELECT sales.sales_id, sales.sale_date, sales.inv_no, sales.cash_sale, sales.chq_sale, sales.credit_sale, customers.customer_name, sale_by.sale_by_name, credit_sales.credit_sale_id
                      FROM sales 
                      INNER JOIN customers ON sales.customer_id = customers.customer_id 
                      INNER JOIN sale_by ON sales.sale_by = sale_by.sale_by_id 
                      LEFT JOIN credit_sales ON sales.sales_id = credit_sales.sale_id
                      ' . $where_conditions . '
                      ORDER BY sales.sale_date DESC
                      LIMIT ' . $page_first_result . ',' . $results_per_page; 
                      // echo $sql;
                      // die();
                      $result1 = mysqli_query($con, $sql);
                      $numRows = mysqli_num_rows ( $result1 );

                    

                      while($row1 = mysqli_fetch_array($result1)){?>
                        <tr class="d-flex">
                          <td class="col col-1"><?=date_format(date_create($row1["sale_date"]), 'd-m-Y')?></td>
                          <td class="col col-1 text-center"><?=$row1["inv_no"]?></td>
                          <td class="col col-5"><?=$row1["customer_name"]?> <span class="badge bg-warning"><?=$row1["sale_by_name"]?></span></td>
                          <td class="text-right col vol-2"><?=number_format($row1["cash_sale"],2, '.', ',')?></td>
                          <td class="text-right col vol-2"><?=number_format($row1["chq_sale"],2, '.', ',')?></td>
                          <td class="text-right col vol-2"><?=number_format($row1["credit_sale"],2, '.', ',')?><a href="new_credit_collection.php?credit_sale_id=<?=$row1["credit_sale_id"]?>" class=" btn btn-sm p-0 <?php if($row1["credit_sale"]<1){echo 'invisible';}?>"><i class="fas fa-info-circle ml-1 text-warning"></i></a></td>
                          <td class="text-right col vol-2"><?=number_format($row1["cash_sale"]+$row1["chq_sale"]+$row1["credit_sale"],2, '.', ',')?></td>
                        </tr>
                      <?php } ?>

                  
                  
                </tbody>
              </table>
              <?php 
                    if ($numRows < 1){
                          echo '<div class="alert alert-warning bg-light" role="alert">
                              There are no sales records matching your search criteria!<br />Press "Clear" button to reset.
                          </div>';
                      }
              
              ?>

            </div>
          </div>
          <div class="card-footer">
            <?php if ($numRows > 0){ ?>
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
            <?php } ?>
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