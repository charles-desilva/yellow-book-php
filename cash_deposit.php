<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Cash Deposit to Bank</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php $page='cashDeposit';
  include('./includes/sidebar.php');?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">
              <?php echo(isset($_GET['cash_reg']))?"Edit Cash in Hand Deposit to Bank":"New Cash in Hand Deposit to Bank"?>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Record Cash in Hand Deposit to Bank</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-7 col-sm-12">
          <!-- Sale Form -->
            <div class="card card-primary">
              <form method="post" action="cash_deposit_action.php"><!-- form start -->
                <div class="card-header bg-success">
                  <h3 class="card-title">Cash in Hand Deposit to Bank Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <?php
                  $cash_reg_id = "";
                  $deposit_date = "";
                  $deposit_value="0.00";
                  $deposit_desc = "deposit";

                  if(isset($_GET['cash_reg'])){
                    $cash_reg_id = $_GET['cash_reg'];
                    $sql = "SELECT cash_reg_id, cash_rcvd_date, cash_out_amount, cash_out_description 
                    FROM cash_register 
                    WHERE cash_reg_id = $cash_reg_id"; 
                    $result1 = mysqli_query($con, $sql);
                    $row1 = mysqli_fetch_array($result1);
                    
                    $deposit_date=$row1['cash_rcvd_date'];
                    $deposit_value=number_format($row1['cash_out_amount'],2,'.','');
                    $deposit_desc=$row1['cash_out_description'];
                    
                  }
                  ?>

                  <input id="cashRegId" name="cashRegId" type="hidden" value=<?=$cash_reg_id?>>
                  
                  <!-- Date Field -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Date:</label>
                    <div class="col-sm-9">
                      <input id="depositDate" name="depositDate" type="date" class="form-control" autocomplete="off" placeholder="Select Date" value=<?=$deposit_date?>>
                      <div class="invalid-feedback">Please select valid date for in Hand Deposit to Bank</div>
                    </div>
                  </div>
                  <!-- Expense value -->
                  <div class="form-group row">
                    <label for="depositValue" class="col-sm-3 col-form-label">Deposit Value</label>
                    <div class="col-sm-5">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <strong>Rs.</strong>
                          </span>
                        </div>
                        <input id="depositValue" name="depositValue" type="number" class="form-control form-control-lg" autocomplete="off" value="<?php echo ($deposit_value!="0.00")?$deposit_value:null?>">
                        <span class="invalid-feedback">Invalid Deposit amount</span>
                      </div>
                    </div>
                  </div>
                  
                </div><!-- /.card-body -->
                <div class="card-footer">
                  <input type="submit" id="depositInsertButton" name="depositInsertButton" type="submit" onclick="return insertDeposit()" class="float-right btn btn-primary <?php echo ($cash_reg_id != "")?"d-none":null?>" value="Insert Expense">
                  <input type="submit" id="depositUpdateButton" name="depositUpdateButton" type="submit" onclick="return insertDeposit()" class="float-right btn btn-warning <?php echo ($cash_reg_id == "")?"d-none":null?>" value="Update Expense">
                  <input type="submit" id="depositDeleteButton" name="depositDeleteButton" type="submit" onclick="return insertDeposit()" class="float-right mr-2 btn btn-danger <?php echo ($cash_reg_id == "")?"d-none":null?>" value="Delete Expense">
                  <input type="button" onClick='location.href="cash_deposit.php"' class="float-right btn btn-secondary mr-2" value="Cancel" />
                </div><!-- /.card-footer -->
              </form><!-- form end -->
            </div>
          </div>
          <!-- Expense List -->
          <div class="col-md-5 col-sm-12">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Cash in Hand Deposit to Bank History</h3>
              </div>
              <div class="card-body">
              <div>
                <table class="table table-striped table-sm small">
                  <thead>
                    <tr class="d-flex">
                      <th class="col-2" scope="col">Date</th>
                      <th class="col-7 text-left" scope="col">Description</th>
                      <th class="col-2 text-right" scope="col">Value</th>
                      <th class="col-1 text-right" scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $sql = 'SELECT cash_reg_id, cash_rcvd_date, cash_out_amount, cash_out_description 
                        FROM cash_register 
                        WHERE (cash_out_description = "deposit")
                        ORDER BY cash_rcvd_date DESC'; 
                        $result1 = mysqli_query($con, $sql);

                        while($row1 = mysqli_fetch_array($result1)){?>
                          <tr class="d-flex">
                            <td class="col col-2"><?=date_format(date_create($row1["cash_rcvd_date"]), 'd-m-Y')?></td>
                            <td class="col col-7 text-left"><?=$row1["cash_out_description"]?></td>
                            <td class="col col-2 text-right"><?=number_format($row1["cash_out_amount"],2, '.', ',')?></td>
                            <td class="col col-1"><a href="?cash_reg=<?=$row1["cash_reg_id"]?>"><i class="far fa-edit text-success"></i></a></td>
                          </tr>
                        <?php } ?>

                    
                    
                  </tbody>
                </table>
              
              </div>
            </div>
          </div>

        </div><!-- /.container-fluid -->
      </div>
    </section>
    <!-- /.content -->
  </div>
 
  <!-- /.content-wrapper -->
  <?php include("./includes/footer.php"); ?>
</div>
<!-- ./wrapper -->

<?php include("./includes/footerTags.php"); ?>


</body>
<script>
  depositDate = document.querySelector('#depositDate');
  depositValue = document.querySelector('#depositValue');
  depositReason = document.querySelector('#depositReason');
  
  function validateDepositFields(){
        let error = false;
        if (depositDate.value == ''){
            depositDate.classList.add("is-invalid");
            error=true;
        }else{
            depositDate.classList.remove("is-invalid");
        }
        if (depositValue.value == ''){
            depositValue.classList.add("is-invalid");
            error = true;
        }else{
            depositValue.classList.remove("is-invalid");
        }
        if (depositReason.value == ''){
            depositReason.classList.add("is-invalid");
            error = true;
        }else{
            depositReason.classList.remove("is-invalid");
        }

        return error;
    }

    function insertDeposit(){
        //return true;
        if(!validateDepositFields()){
            return true;
        }else{
            return false;
        }
    }
</script>
</html>