<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Cash Withdraw</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php $page='cashWithdraw';
  include('./includes/sidebar.php');?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">
              <?php echo(isset($_GET['cash_reg']))?"Edit Cash Withdrawal":"New Cash Withdrawal"?>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Record Cash Withdrawal</li>
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
              <form method="post" action="new_cash_withdraw_action.php"><!-- form start -->
                <div class="card-header bg-dark">
                  <h3 class="card-title">Cash Withdrawal Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                  <?php
                  $cash_reg_id = "";
                  $withdraw_date = "";
                  $withdraw_value="0.00";
                  $withdraw_desc = "";

                  if(isset($_GET['cash_reg'])){
                    $cash_reg_id = $_GET['cash_reg'];
                    $sql = "SELECT cash_reg_id, cash_rcvd_date, cash_in_amount, cash_in_description 
                    FROM cash_register 
                    WHERE cash_reg_id = $cash_reg_id"; 
                    $result1 = mysqli_query($con, $sql);
                    $row1 = mysqli_fetch_array($result1);
                    
                    $withdraw_date=$row1['cash_rcvd_date'];
                    $withdraw_value=number_format($row1['cash_in_amount'],2,'.','');
                    $withdraw_desc=$row1['cash_in_description'];
                    
                  }
                  ?>

                  <input id="cashRegId" name="cashRegId" type="hidden" value=<?=$cash_reg_id?>>
                  
                  <!-- Date Field -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Date:</label>
                    <div class="col-sm-9">
                      <input id="withdrawDate" name="withdrawDate" type="date" class="form-control" autocomplete="off" placeholder="Select Date" value=<?=$withdraw_date?>>
                      <div class="invalid-feedback">Please select valid date for Withdrawal</div>
                    </div>
                  </div>
                  <!-- Expense value -->
                  <div class="form-group row">
                    <label for="withdrawValue" class="col-sm-3 col-form-label">Withdraw Value</label>
                    <div class="col-sm-5">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <strong>Rs.</strong>
                          </span>
                        </div>
                        <input id="withdrawValue" name="withdrawValue" type="number" class="form-control form-control-lg" autocomplete="off" value="<?php echo ($withdraw_value!="0.00")?$withdraw_value:null?>">
                        <span class="invalid-feedback">Invalid Withdraw amount</span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Withdraw Reason:</label>
                    <div class="col-sm-9">
                      <input id="withdrawReason" name="withdrawReason" type="text" class="form-control" autocomplete="off" placeholder="Expense description" value="<?=$withdraw_desc?>">
                      <div class="invalid-feedback">Please enter reason for Withdrawal</div>
                    </div>
                  </div>
                </div><!-- /.card-body -->
                <div class="card-footer">
                  <input type="submit" id="withdrawInsertButton" name="withdrawInsertButton" type="submit" onclick="return insertWithdrawal()" class="float-right btn btn-primary <?php echo ($cash_reg_id != "")?"d-none":null?>" value="Insert Withdrwal">
                  <input type="submit" id="withdrawUpdateButton" name="withdrawUpdateButton" type="submit" onclick="return insertWithdrawal()" class="float-right btn btn-warning <?php echo ($cash_reg_id == "")?"d-none":null?>" value="Update Withdrawal">
                  <input type="submit" id="withdrawDeleteButton" name="withdrawDeleteButton" type="submit" onclick="return insertWithdrawal()" class="float-right mr-2 btn btn-danger <?php echo ($cash_reg_id == "")?"d-none":null?>" value="Delete Withdrwal">
                  <input type="button" onClick='location.href="cash_withdraw.php"' class="float-right btn btn-secondary mr-2" value="Cancel" />
                </div><!-- /.card-footer -->
              </form><!-- form end -->
            </div>
          </div>
          <!-- Expense List -->
          <div class="col-md-5 col-sm-12">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Cash Withdrawal History</h3>
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
                        $sql = 'SELECT cash_reg_id, cash_rcvd_date, cash_in_amount, cash_in_description 
                        FROM cash_register 
                        WHERE (cash_in_description IS NOT NULL)
                        ORDER BY cash_rcvd_date DESC'; 
                        $result1 = mysqli_query($con, $sql);

                        while($row1 = mysqli_fetch_array($result1)){?>
                          <tr class="d-flex">
                            <td class="col col-2"><?=date_format(date_create($row1["cash_rcvd_date"]), 'd-m-Y')?></td>
                            <td class="col col-7 text-left"><?=$row1["cash_in_description"]?></td>
                            <td class="col col-2 text-right"><?=number_format($row1["cash_in_amount"],2, '.', ',')?></td>
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
  withdrawDate = document.querySelector('#withdrawDate');
  withdrawValue = document.querySelector('#withdrawValue');
  withdrawReason = document.querySelector('#withdrawReason');
  
  function validateWithdrawalFields(){
        let error = false;
        if (withdrawDate.value == ''){
            withdrawDate.classList.add("is-invalid");
            error=true;
        }else{
            withdrawDate.classList.remove("is-invalid");
        }
        if (withdrawValue.value == ''){
            withdrawValue.classList.add("is-invalid");
            error = true;
        }else{
            withdrawValue.classList.remove("is-invalid");
        }
        if (withdrawReason.value == ''){
            withdrawReason.classList.add("is-invalid");
            error = true;
        }else{
            withdrawReason.classList.remove("is-invalid");
        }

        return error;
    }

    function insertWithdrawal(){
        //return true;
        if(!validateWithdrawalFields()){
            return true;
        }else{
            return false;
        }
    }
</script>
</html>