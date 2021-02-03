<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Credit Collection</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php $page='creditSalesList';
  include('./includes/sidebar.php');?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Credit Collection</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Credit Collection</li>
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
          
        <!-- credit sale details List -->
          <div class="col-md-7 col-sm-12">
            <div class="card card-dark"><!-- Sales info section -->
              <div class="card-header"><!-- card-header -->
                <h3 class="card-title">Credit Sale Details</h3>
              </div><!-- /.card-header -->
              <!-- form start -->
              <div class="card-body"><!-- card-body -->  
                <?php
                  $sales_date = "";
                  $invoice_no="";
                  $settled="0.00";
                  $paid_in_cash="0.00";
                  $paid_in_chq="0.00";
                  $credit_sale="0.00";
                  $customer_id=-1;
                  $sale_by=-1;

                  if(isset($_GET['credit_sale_id'])){
                    $credit_sale_id = $_GET['credit_sale_id'];
                    $sql = "SELECT credit_sales.credit_sale_id, credit_sales.sale_id, credit_sales.credit_date, sales.sale_date, customers.customer_name, sale_by.sale_by_name, sales.inv_no, credit_sales.credit_amount, SUM(cheques_received.chq_value) AS chq_payments, SUM(cash_register.cash_in_amount) AS cash_payments
                    FROM credit_sales 
                    LEFT JOIN sales ON credit_sales.sale_id = sales.sales_id
                    LEFT JOIN sale_by ON sales.sale_by = sale_by.sale_by_id 
                    LEFT JOIN customers ON sales.customer_id = customers.customer_id
                    LEFT JOIN cheques_received ON credit_sales.credit_sale_id = cheques_received.credit_id
                    LEFT JOIN cash_register ON credit_sales.credit_sale_id = cash_register.credit_id
                    WHERE credit_sales.credit_sale_id = $credit_sale_id";

                    $result1 = mysqli_query($con, $sql);
                    $row1 = mysqli_fetch_array($result1);
                    $sales_date=date_format(date_create($row1['sale_date']), 'd-m-Y');
                    $credit_sale_date = date_format(date_create($row1["credit_date"]), 'd-m-Y');
                    $invoice_no=$row1['inv_no'];
                    $credit_sale=$row1['credit_amount'];
                    $total_payments = $row1['chq_payments'];
                    $customer_name=$row1['customer_name'];
                    $sale_by=$row1['sale_by_name'];
                    $sale_id=$row1['sale_id'];
                  }
                ?>
                
                <div class="form-group row mb-0"><!-- Date Field -->
                  <label class="col-sm-3 col-form-label">Sale Date:</label>
                  <div class="col-sm-3">
                    <input id="saleDate" disabled type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Select Date" value=<?=$sales_date?>>
                  </div>
                  <label class="col-sm-3 col-form-label text-right">Due Date:</label>
                  <div class="col-sm-3">
                    <input id="dueDate" disabled type="text" class="form-control form-control-sm" autocomplete="off" placeholder="Select Date" value=<?=$credit_sale_date?>>
                  </div>
                </div>
                <div class="form-group row mb-0"><!-- Customer -->
                  <label for="customersList" class="col-sm-3 col-form-label-sm">Customer</label>
                  <div class="input-group col-sm-6 pr-0">
                    <input id="customerName" disabled type="text" class="form-control form-control-sm" value="<?=$customer_name?>">
                  </div>
                  <div class="col-sm-3">
                    <input id="sale-by" disabled type="text" class="form-control form-control-sm" autocomplete="off" value=<?=$sale_by?>>
                  </div>
                </div>
                <div class="form-group row mb-0"><!-- Invoice Number -->
                  <label for="invoiceNumber" class="col-sm-3 col-form-label-sm">Invoice Number</label>
                  <div class="col-sm-9">
                    <input type="text" disabled class="form-control form-control-sm" id="invoiceNumber" autocomplete="off" value=<?=$invoice_no?>>
                    <div class="invalid-feedback">Please enter Invoice Number </div>
                  </div>
                </div>
                
              </div><!-- /.card-body -->
            </div> <!-- /Sales info section -->

            <div class="card card-dark"> <!-- Pyaments rececieved list -->
              <div class="card-header">
                <h3 class="card-title">Payments Related to above Credit Sale</h3>
                
              </div>
              <div class="card-body">
                <div>
                  <?php 
                    $credit_id = -1;
                    $chequesPaidValue = 0;
                    $cashPaidValue = 0;
                    $settled = 0;
                    $totalDue = 0;

                    if(isset($_GET['credit_sale_id'])){
                      $credit_id = $_GET['credit_sale_id'];
                    }

                    $sql = "SELECT null as cash_reg_id, cheques_received.chq_rcvd_date as payment_date, null as cash, cheques_received.chq_value as cheques, cheques_received.chq_status as chq_status, cheques_received.chq_no, cheques_received.chq_bank, cheques_received.chq_bank_branch, cheques_received.chq_date, cheques_received.chq_id
                            FROM cheques_received WHERE cheques_received.credit_id = $credit_id
                            UNION
                            SELECT cash_register.cash_reg_id, cash_register.cash_rcvd_date as payment_date, cash_register.cash_in_amount as cash, null as cheques, null as chq_status, null as chq_no, null as chq_bank, null as chq_bank_branch, null as chq_date, null as chq_id
                            FROM   cash_register WHERE cash_register.credit_id = $credit_id
                            ORDER BY payment_date";

                    $result1 = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result1)!=0){
                  ?>
                    <table class="table table-striped table-sm">
                      <thead>
                        <tr class="d-flex">
                          <th class="col-2" scope="col">Payment Date</th>
                          <th class="col-2 text-center" scope="col">Paid by</th>
                          <th class="col-2 text-right" scope="col">Amount</th>
                          <th class="col-3 text-right" scope="col"></th>
                          <th class="col-3 text-right" scope="col"></th>
                        </tr>
                      </thead>
                      <tbody id="paymentList">
                          <?php
                            
                            while($row1 = mysqli_fetch_array($result1)){
                              $amount = 0;
                              $paidInCheques = 0;
                              $paidInCash = 0;
                              $chqBouncedFlag = "";
                              $chqStatus = "";
                              if($row1["cheques"]!=NULL){
                                $paidInCheques = $amount = $row1["cheques"];
                                $chqStatus = $row1["chq_status"];
                                $paidByFlag = '<h5><span class="badge badge-success">CHEQUE</span></h5> ';

                                if($chqStatus == 'bounced'){
                                  $chqBouncedFlag .= '<span class="badge badge-danger">BOUNCED</span> ';
                                  $paidInCheques = 0;       // made zero to exclude from the total checques paid value                         
                                }
                                if($chqStatus == 'in-hand'){
                                  $chqBouncedFlag .= '<span class="badge badge-secondary">IN HAND</span> ';
                                  //$paidInCheques = 0;
                                }
                                if($chqStatus == 'deposited'){
                                  $chqBouncedFlag .= '<span class="badge badge-warning">DEPOSITED (not realised)</span> ';
                                  //$paidInCheques = 0;
                                }
                                if($chqStatus == 'realised'){
                                  $chqBouncedFlag .= '<span class="badge badge-success">REALISED</span> ';
                                  $paidInCheques = $row1["cheques"];
                                }

                              }else{
                                $paidInCash = $amount = $row1["cash"];
                                $paidByFlag = '<h5><span class="badge badge-secondary">CASH</span></h5> ';
                              }

                              $cashPaidValue = $cashPaidValue + $paidInCash;
                              $chequesPaidValue = $chequesPaidValue + $paidInCheques;
                              $settled = $settled +  $paidInCash + $paidInCheques;
                              $totalDue = $credit_sale - $settled;

                            ?>
                              <tr class="d-flex <?php //if($row1["id"]==$credit_id){echo "table-primary";} ?>">
                                <td class="col col-2"><?=date_format(date_create($row1["payment_date"]), 'd-m-Y')?></td>
                                <td class="text-center col col-2"><?=$paidByFlag?></td>
                                <td class="text-right col col-2"><?=number_format($amount,2, '.', ',')?></td>
                                <td class="text-left col col-3"><?=$chqBouncedFlag?></td>
                                <td class="text-right col col-3 font-weight-bold">
                                <button type="button" class="btn btn-primary btn-sm" 
                                  data-action="edit"
                                  <?php if($paidInCash > 0){?>
                                    data-paidin="cash"
                                    data-paiddate="<?=$row1['payment_date']?>"
                                    data-paidamount="<?=number_format($amount,2, '.', ',')?>"
                                    data-cashregid="<?=$row1['cash_reg_id']?>"
                                    
                                  <?php }else { ?>
                                    data-paidin="cheque"
                                    data-chqrcvddate="<?=$row1['payment_date']?>"
                                    data-chqnum="<?=$row1['chq_no']?>"
                                    data-bank="<?=$row1['chq_bank']?>"
                                    data-branch="<?=$row1['chq_bank_branch']?>"
                                    data-chqdate="<?=$row1['chq_date']?>"
                                    data-chqvalue="<?=number_format($amount,2, '.', ',')?>"
                                    data-chqid="<?=$row1['chq_id']?>"

                                  <?php } ?>  
                                > Edit </button>
                                <button class="btn btn-danger btn-sm ml-2"
                                  data-action="delete"
                                  <?php if($paidInCash > 0){?>
                                    data-paidin="cash"
                                    data-cashregid="<?=$row1['cash_reg_id']?>"
                                    data-creditsaleid="<?=$_GET['credit_sale_id']?>"
                                  <?php }else { ?>
                                    data-paidin="cheque"
                                    data-chequeid="<?=$row1['chq_id']?>"
                                    data-creditsaleid="<?=$_GET['credit_sale_id']?>"
                                  <?php } ?> 
                                >Delete</button>
                                  
                                </td>
                              </tr>
                          <?php } ?>
                      </tbody>
                    </table>
                  <?php } else {?>
                    <div class="alert alert-warning bg-light" role="alert">
                      There are no Payments recieved for this Credit Sale!
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
              
          <div class="col-md-5 col-sm-12">
            <!-- Sale Form -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Credit Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
            <div class="card-body">
                <!-- Payment values -->
                  <div class="form-group row">
                    <label for="totalSale" class="col-sm-4 col-form-label ">Credit Value</label>
                    <div class="col-sm-8">
                      <!-- Total Credit Value -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <strong>Rs.</strong>
                          </span>
                        </div>
                        <input type="text" class="form-control form-control-lg bg-white" id="creditValue" readonly autocomplete="off" value=<?=number_format($credit_sale,2,'.','')?>>
                        
                      </div>
                    </div>
                  </div>    
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Paid in Cash</label>
                    <div class="col-sm-8">
                      <!-- Total Sale Value -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <strong>Rs.</strong>
                          </span>
                        </div>
                        <input type="text" class="form-control form-control-lg bg-white" id="totalCashReceived" readonly autocomplete="off" value=<?=number_format($cashPaidValue,2,'.','')?>>
                        <div class="input-group-append">
                          <button type="button" id="addCashButton" class="btn btn-dark" <?php if ($totalDue<=0 && $settled !=0){echo "disabled";}?> >
                            Add
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>    
                  <div class="form-group row">
                    <div class="col-sm-4">
                      <label class="col-form-label mb-0 p-0">Paid in Cheques</label><br />
                      <span class="small mt-0">(Excluding bounced cheques)</span>
                    </div>
                    
                    
                    <div class="col-sm-8">
                      <!-- Total Sale Value -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <strong>Rs.</strong>
                          </span>
                        </div>
                        <input type="text" class="form-control form-control-lg bg-white" id="totalChequesReceived" readonly autocomplete="off" value=<?=number_format($chequesPaidValue,2,'.','')?>>
                        <div class="input-group-append">
                          <button type="button" id="addChequeButton" class="btn btn-success" <?php if ($totalDue<=0 && $settled !=0){echo "disabled";}?>>
                            Add
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>    
                  <div class="form-group row">
                    <label for="totalSale" class="col-sm-4 col-form-label">Total Settled</label>
                    <div class="col-sm-8">
                      <!-- Total Sale Value -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <strong>Rs.</strong>
                          </span>
                        </div>
                        <input type="text" class="form-control form-control-lg bg-white" id="totalReceived" readonly autocomplete="off" value=<?=number_format($settled,2,'.','')?>>
                        
                      </div>
                    </div>
                  </div>    
                  <div class="form-group row">
                    <label for="totalSale" class="col-sm-4 col-form-label">Total Due</label>
                    <div class="col-sm-8">
                      <!-- Total Sale Value -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <strong>Rs.</strong>
                          </span>
                        </div>
                        <input type="text" class="form-control form-control-lg <?php if ($totalDue>0){echo "bg-warning";}else{echo "bg-success";}?>" id="totalDue" readonly autocomplete="off" value=<?=number_format($totalDue,2,'.','')?>>
                        
                      </div>
                    </div>
                  </div>    
                  <div class="form-group row">
                    
                    <div class="col-sm-3">
                      
                      
                    </div>
                   
                  </div>    
                  
                 
                    
                                    
                </div>
                <!-- /.card-body -->
                
              
            </div>
          </div>
          
          <!-- /.container-fluid -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- Modals -->
  <?php 
  include("./includes/modals/cheque_list_debtor_payments.php");
  include("./includes/modals/cash_debtor_payments.php");
  //include("./includes/modals/cheque_list.php");                            
  include("./includes/modals/confirmation.php");                            
  ?>
  
  <!-- /.content-wrapper -->
  <?php include("./includes/footer.php"); ?>
</div>
<!-- ./wrapper -->

<?php include("./includes/footerTags.php"); ?>


</body>
<script>
 
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

document.querySelector("#addCashButton").addEventListener("click", function(){
  clearCashPaymentFields();
  resetCashPaymentFields();
  $('#insertCashDetailsBtn').removeClass("d-none")
  $('#updateCashDetailsBtn').addClass("d-none")
  $('#cashDebtorPayment').modal("show");
})
document.querySelector("#addChequeButton").addEventListener("click", function(){
  clearFields();
  resetFields();
  $('#insertChequeDetailsBtn').removeClass("d-none")
  $('#updateChequeDetailsBtn').addClass("d-none")
  $('#chequeDebtorPayment').modal("show");
})

 document.querySelector("#paymentList").addEventListener("click", function(e){
   //console.log(e.target);
    if(e.target.dataset.action == "edit"){
      if(e.target.dataset.paidin == "cash"){

        $('#cashInDate').val(e.target.dataset.paiddate);
        $('#cashInAmount').val(e.target.dataset.paidamount);
        $('#cashRegId').val(e.target.dataset.cashregid);

        $('#updateCashDetailsBtn').removeClass("d-none");
        $('#insertCashDetailsBtn').addClass("d-none");

        $('#cashDebtorPayment').modal("show");
        //alert(e.target.dataset.paiddate);
      }else if(e.target.dataset.paidin == "cheque"){
        $('#chq_id').val(e.target.dataset.chqid);
        $('#chqRcvdDate').val(e.target.dataset.chqrcvddate);
        $('#chqNum').val(e.target.dataset.chqnum);
        $('#bank').val(e.target.dataset.bank);
        $('#branch').val(e.target.dataset.branch);
        $('#chqDate').val(e.target.dataset.chqdate);
        $('#chqValue').val(e.target.dataset.chqvalue);

        $('#updateChequeDetailsBtn').removeClass("d-none");
        $('#insertChequeDetailsBtn').addClass("d-none");

        $('#chequeDebtorPayment').modal("show");
      }
    }else if (e.target.dataset.action == "delete"){
      if(e.target.dataset.paidin == "cash"){
        document.querySelector("#confirm-modal-title").textContent = "Confirm Delete";
        document.querySelector("#confirm-modal-body").textContent = "Are you sure to delete this Debtor Cash Payment?";
        document.querySelector("#confirm-modal-button").textContent = "Yes";
        document.querySelector("#confirm-modal-button").setAttribute('onclick',`window.location = "new_cash_in_action.php?credit_sale_id=${e.target.dataset.creditsaleid}&action=delete&cash_reg_id=${e.target.dataset.cashregid}"`);
        //document.querySelector("#confirm-modal-button").setAttribute('onclick',`alert(${e.target.dataset.cashregid})`);
      
        $('#confirmModal').modal('show');
      }else if(e.target.dataset.paidin == "cheque"){
        document.querySelector("#confirm-modal-title").textContent = "Confirm Delete";
        document.querySelector("#confirm-modal-body").textContent = "Are you sure to delete this Debtor Cheque Payment?";
        document.querySelector("#confirm-modal-button").textContent = "Yes";
        document.querySelector("#confirm-modal-button").setAttribute('onclick',`window.location = "new_cheque_action.php?credit_sale_id=${e.target.dataset.creditsaleid}&action=delete&chq_id=${e.target.dataset.chequeid}"`);
        //document.querySelector("#confirm-modal-button").setAttribute('onclick',`alert(${e.target.dataset.cashregid})`);
      
        $('#confirmModal').modal('show');
      }
    }
 })

</script>
</html>