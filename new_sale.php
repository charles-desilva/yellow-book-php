<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Enter Sale</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php $page='newsale';
  include('./includes/sidebar.php');?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php
              if(isset($_GET['sale_id'])){
                echo "Edit Sale";
              }else{
                echo "New Sale";
              }?>
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sale</li>
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
              <div class="card-header">
                <h3 class="card-title">Sale Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              
                <div class="card-body">

               <?php
               $sales_date = "";
               $invoice_no="";
               $total_sale="0.00";
               $cash_sale="0.00";
               $chq_sale="0.00";
               $credit_sale="0.00";
               $customer_id=-1;
               $sale_by=-1;

                  if(isset($_GET['sale_id'])){
                    $sale_id = $_GET['sale_id'];
                    $sql = "SELECT sales.sale_date, sales.inv_no, sales.cash_sale, sales.chq_sale, sales.credit_sale, sales.customer_id, sales.sale_by 
                    FROM sales 
                    WHERE sales.sales_id = $sale_id"; 
                    $result1 = mysqli_query($con, $sql);
                    $row1 = mysqli_fetch_array($result1);
                    $sales_date=$row1['sale_date'];
                    $invoice_no=$row1['inv_no'];
                    $cash_sale=number_format($row1['cash_sale'],2,'.','');
                    $chq_sale=number_format($row1['chq_sale'],2,'.','');
                    $credit_sale=number_format($row1['credit_sale'],2,'.','');
                    $total_sale=number_format($cash_sale+$chq_sale+$credit_sale,2,'.',',');
                    $customer_id=$row1['customer_id'];
                    $sale_by=$row1['sale_by'];
                  }
                ?>

               
                <!-- Date Field -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Date:</label>
                    <div class="col-sm-9">
                      <input id="saleDate" type="date" class="form-control" autocomplete="off" placeholder="Select Date" value=<?=$sales_date?>>
                      <div class="invalid-feedback">Please select valid date for Sale</div>
                    </div>
                  </div>
                <!-- Sale By -->
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sale By</label>
                    <div class="col-sm-9">
                      <select id="saleBy" class="form-control select2" style="width: 100%;">
                      <option value="0">Select Sale By</option>
                      <?php 
                        $sql = "SELECT * FROM sale_by"; 
                        $result1 = mysqli_query($con, $sql);

                        while($row1 = mysqli_fetch_array($result1)){?>
                        <option value="<?=$row1["sale_by_id"]?>" <?php if($row1["sale_by_id"]==$sale_by){echo "selected";}?>><?=$row1["sale_by_name"]?></option>
                        <?php } ?>
                      </select>
                      <div class="invalid-feedback">Please select Sales Channel</div>
                    </div>
                  </div>
                <!-- Invoice Number -->
                  <div class="form-group row">
                    <label for="invoiceNumber" class="col-sm-3 col-form-label">Invoice Number</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="invoiceNumber" placeholder="Enter Invoice Number" autocomplete="off" value=<?=$invoice_no?>>
                      <div class="invalid-feedback">Please enter Invoice Number </div>
                    </div>
                  </div>
                <!-- Customer -->
                  <div class="form-group row">
                    <label for="customersList" class="col-sm-3 col-form-label">Customer</label>
                    <div class="input-group col-sm-9">
                      <select class="form-control select2" id="customersList">
                        <option selected value=0>Choose Customer...</option>
                        <?php 
                        $sql = "SELECT * FROM customers ORDER BY customer_name"; 
                        $result1 = mysqli_query($con, $sql);

                        while($row1 = mysqli_fetch_array($result1)){?>
                        <option value="<?=$row1["customer_id"]?>" <?php if($row1["customer_id"]==$customer_id){echo "selected";}?>><?=$row1["customer_name"]?></option>
                        <?php } ?>
                      </select>
                      <div class="input-group-append">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#newCustomerModal"><i class="fas fa-user-plus"></i> </button>
                      </div>
                      <div class="invalid-feedback">Please select Customer</div>
                    </div>
                  </div>
                <!-- Sale values -->
                  <div class="form-group row">
                    <label for="totalSale" class="col-sm-3 col-form-label">Total Sales</label>
                    <!-- Total Sale Value -->
                      <div class="col-sm-5">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <strong>Rs.</strong>
                            </span>
                          </div>
                          <input type="text" class="form-control form-control-lg" id="totalSale" readonly autocomplete="off" value=<?=$total_sale?>>
                          <span class="invalid-feedback">Invalid Sales amount</span>
                        </div>
                      </div>
                    <div class="col-4" >
                    <!-- Cash Sale Value -->
                      <div div class="form-group">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              Cash
                            </span>
                          </div>
                          <input id='cashSaleValue' type="number" style="text-align:right" class="form-control" autocomplete="off" placeholder='0.00' value=<?=$cash_sale?>>
                          <div class="input-group-append">
                            <div class="input-group-text"><i class="fas fa-money-bill-alt"></i></div>
                          </div>
                        </div>
                      </div>
                    <!-- Cheque Sale Value -->
                      <div class="form-group">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text bg-success">
                              Cheques
                            </span>
                          </div>
                          <input id='chequeSaleValue' style="text-align:right" type="number" value="<?=$chq_sale?>" class="form-control" autocomplete="off" readonly>
                          <div class="input-group-append">
                            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#chequeSaleDetails"><i class="fas fa-money-check"></i></button>
                          </div>
                        </div>
                      </div>
                    <!-- Credit Sale Value -->
                      <div class="form-group">
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text bg-warning">
                                Credit
                              </span>
                            </div>
                            <input type="number" id="creditSaleValue" style="text-align:right" class="form-control" autocomplete="off" readonly value=<?=$credit_sale?>>
                            <div class="input-group-append">
                              <button class="btn btn-warning" type="button" data-toggle="modal" data-target="#creditSaleDetails"><i class="far fa-credit-card"></i></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button id="saleFormSubmit" type="submit" class="float-right btn btn-primary <?php if(isset($_GET['sale_id'])){echo "d-none";}?>">Insert Sale</button>
                  <button id="saleFormSubmitUpdate" type="submit" class="float-right btn btn-warning <?php if(!isset($_GET['sale_id'])){echo "d-none";}?>" data-saleID=<?=$_GET['sale_id']?>>Update Sale</button>
                  <button onClick='window.location.href = "new_sale.php"' id="saleFormSubmitCancel" type="submit" class="float-right btn btn-secondary mr-2 <?php if(!isset($_GET['sale_id'])){echo "d-none";}?>" data-saleID=<?=$_GET['sale_id']?>">Cancel</button>
                  <button id="saleFormSubmitDelete" type="submit" class="float-left btn btn-danger <?php if(!isset($_GET['sale_id'])){echo "d-none";}?>" data-saleID=<?=$_GET['sale_id']?>>Delete Sale</button>
                </div>
              
            </div>
          </div>
          <!-- Sales List -->
          <div class="col-md-5 col-sm-12">
            <div class="card card-secondary">
              <div class="card-header">
                <h3 class="card-title">Sales History</h3>
              </div>
              <div class="card-body">
              <div>
                <table class="table table-striped table-sm small">
                  <thead>
                    <tr class="d-flex">
                      <th class="col-2" scope="col">Date</th>
                      <th class="col-2 text-center" scope="col">Inv #</th>
                      <th class="col-5" scope="col">Customer</th>
                      <th class="col-2 text-right" scope="col">Inv. Total</th>
                      <th class="col-1 text-right" scope="col"></th>
                    </tr>
                  </thead>
                  <tbody>
                        <?php 
                        $sql = "SELECT sales.sales_id, sales.sale_date, sales.inv_no, sales.cash_sale, sales.chq_sale, sales.credit_sale, customers.customer_name, sale_by.sale_by_name
                        FROM sales 
                        INNER JOIN customers ON sales.customer_id = customers.customer_id 
                        INNER JOIN sale_by ON sales.sale_by = sale_by.sale_by_id 
                        ORDER BY sales.sale_date DESC
                        "; 

                        $result1 = mysqli_query($con, $sql);

                        while($row1 = mysqli_fetch_array($result1)){?>
                          <tr class="d-flex">
                            <td class="col col-2"><?=$row1["sale_date"]?></td>
                            <td class="col col-2 text-center"><?=$row1["inv_no"]?></td>
                            <td class="col col-5"><?=$row1["customer_name"]?> <span class="badge bg-warning"><?=$row1["sale_by_name"]?></span></td>
                            <td class="text-right col vol-2"><?=number_format($row1["cash_sale"]+$row1["chq_sale"]+$row1["credit_sale"],2, '.', ',')?></td>
                            <td class="col col-1"><a href="?sale_id=<?=$row1["sales_id"]?>"><i class="far fa-edit text-success"></i></a></td>
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
  <!-- Modals -->
  <?php 
  include("./includes/modals/customer_details.php");
  include("./includes/modals/credit_sale_details.php");
  include("./includes/modals/cheque_list.php");                            
  include("./includes/modals/confirmation.php");                            
  ?>
  
  <!-- /.content-wrapper -->
  <?php include("./includes/footer.php"); ?>
</div>
<!-- ./wrapper -->

<?php include("./includes/footerTags.php"); ?>


</body>
<script>
  dateInput = document.querySelector('#saleDate');
  saleByInput = document.querySelector('#saleBy');
  invoiceNumberInput = document.querySelector('#invoiceNumber');
  customersListInput = document.querySelector('#customersList');
  totalSaleInput = document.querySelector('#totalSale');

  cashInput = document.querySelector('#cashSaleValue');
  creditInput = document.querySelector('#creditSaleValue');
  chequeInput = document.querySelector('#chequeSaleValue');
  saleFormSubmitBtn = document.querySelector('#saleFormSubmit');
  
  function calculateSaleTotal(){
    //console.log(cashInput.value);
    const cashSale = parseFloat(cashInput.value==''?0:cashInput.value)
    const creditSale = parseFloat(creditInput.value)
    const chequeSale = parseFloat(chequeInput.value)
    console.log(cashSale, creditSale, chequeSale );
    totalSaleInput.value = numberWithCommas(parseFloat(cashSale + creditSale + chequeSale).toFixed(2));
    //validateSalesFormFields();
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  saleFormSubmitBtn.addEventListener('click', function(){
    if (!validateSalesFormFields()){
      submitSaleDetails();
    }
  });

  saleFormSubmitUpdate.addEventListener('click', function(e){
    if (!validateSalesFormFields()){
      updateSaleDetails(e.target.dataset.saleid);
    }
  });

  saleFormSubmitDelete.addEventListener('click', function(e){
    //alert("dgsd") ; 
    document.querySelector("#confirm-modal-title").textContent = "Confirm Delete";
    document.querySelector("#confirm-modal-body").textContent = "Are you sure to delete this Sale record?";
    document.querySelector("#confirm-modal-button").textContent = "Yes";
    document.querySelector("#confirm-modal-button").setAttribute('onclick',`deleteSaleDetails(${e.target.dataset.saleid})`);
    
    $('#confirmModal').modal('show');
      //deleteSaleDetails(e.target.dataset.saleid);
    
  });

  function validateSalesFormFields(){
    let error = false;
    if (dateInput.value == ''){
      dateInput.classList.add('is-invalid');
      error=true;
    }else{
      dateInput.classList.remove('is-invalid');
    }
    if (saleByInput.value == 0){
      saleByInput.classList.add('is-invalid');
      error=true;
    }else{
      saleByInput.classList.remove('is-invalid');
    }
    if (invoiceNumberInput.value == ''){
      invoiceNumberInput.classList.add('is-invalid');
      error=true;
    }else{
      invoiceNumberInput.classList.remove('is-invalid');
    }
    if (customersListInput.value == 0){
      customersListInput.classList.add('is-invalid');
      error=true;
    }else{
      customersListInput.classList.remove('is-invalid');
    }
    if (totalSaleInput.value == '0.00'){
      totalSaleInput.classList.add('is-invalid');
      error=true;
    }else{
      totalSaleInput.classList.remove('is-invalid');
    }
    
    return error;
  }
  
  async function submitSaleDetails(){
    const sale = new Sale(dateInput.value, saleByInput.value, invoiceNumberInput.value, customersListInput.value, cashInput.value, chequeInput.value, creditInput.value);
    let saleId = -1;
    let saleInsert=true, chequeInsert=true, creditInsert=true;
    
    let response = await sale.saveSaleToDB()
      .then((response) => response.json())
      .then((data) => {
        saleId = data.insertSaleId;
        console.log(data);
        saleInsert = data.success;
      });
    
    if (chequeInput.value != '0.00'){
      for (let i=0; i<chequeList.children.length; i++){
        const chqRcvdDate = dateInput.value;
        const chqNo = chequeList.children[i].children[0].textContent;
        const chqBnk = chequeList.children[i].children[1].textContent;
        const chqBranch = chequeList.children[i].children[2].textContent;
        const chqDate = chequeList.children[i].children[3].textContent;
        const chqAmount = chequeList.children[i].children[4].textContent;
        
        const cheq = new Cheque(saleId, chqRcvdDate, chqNo, chqBnk, chqBranch, chqDate, chqAmount);
        const response = await cheq.saveChequeToDB()
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          chequeInsert = data.success;
        });
      }
    }

    if (creditInput.value != '0.00'){
      console.log(creditInput.value);
      const credit = new Credit(saleId, creditSaleDetailValue.value, creditCollectionDate.value);
      response = await credit.saveCreditToDB()
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          creditInsert = data.success;
        });
    }

    if(saleInsert==chequeInsert==creditInsert==true){
      location.reload();
    }
    
  }

  async function updateSaleDetails(saleId){
    const sale = new Sale(dateInput.value, saleByInput.value, invoiceNumberInput.value, customersListInput.value, cashInput.value, chequeInput.value, creditInput.value);
    let saleInsert=true, chequeInsert=true, creditInsert=true;
    let response = await sale.updateSaleToDB(saleId)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        //saleInsert = data.success;
      });
    
    if (chequeInput.value != '0.00'){
      response = await Cheque.deleteChequeBySaleId(saleId)
       .then(async function(){
          for (let i=0; i<chequeList.children.length; i++){
            const chqRcvdDate = dateInput.value;
            const chqNo = chequeList.children[i].children[0].textContent;
            const chqBnk = chequeList.children[i].children[1].textContent;
            const chqBranch = chequeList.children[i].children[2].textContent;
            const chqDate = chequeList.children[i].children[3].textContent;
            const chqAmount = chequeList.children[i].children[4].textContent;
            
            const cheq = new Cheque(saleId, chqRcvdDate, chqNo, chqBnk, chqBranch, chqDate, chqAmount);
            const response = await cheq.updateChequeToDB()
            .then((response) => response.json())
            .then((data) => {
              console.log(data);
              chequeInsert = data.success;
            });
          }
        })
      
    }

    if (creditInput.value != '0.00'){
      const credit = new Credit(saleId, creditSaleDetailValue.value, creditCollectionDate.value);
      response = await credit.updateCreditToDB()
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
        });
    }else if(creditInput.value == '0.00'){
      Credit.deleteCreditBySaleId(saleId);
    }

    if(saleInsert==chequeInsert==creditInsert==true){
      window.location.href = "new_sale.php";
    }
    
  }

  async function deleteSaleDetails(saleId){
    
    Sale.deleteSaleFromDB(saleId)
    .then(Credit.deleteCreditBySaleId(saleId))
    .then(Cheque.deleteChequeBySaleId(saleId))
    .then(()=>window.location.href = "new_sale.php")
   
  }

  cashInput.addEventListener('change', function(){
    cashInput.value = parseFloat(cashInput.value).toFixed(2) 
    calculateSaleTotal();
    
    
  });
  chequeInput.addEventListener('change', function(){
    calculateSaleTotal();
  });
  creditInput.addEventListener('change', function(){
    calculateSaleTotal();
  });


</script>
</html>