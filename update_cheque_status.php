<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Wheel Group - Cheque Status Update</title>
    <?php include('./includes/headerTags.php');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <?php include('./includes/topNavBar.php');?>
  <?php 
  $page='';
  include('./includes/sidebar.php');?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Received Cheques Status Update</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Cheques Status Update</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        
         <!-- cheques ready for deposite table -->
        <div class="col-sm-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Cheques in hand due for Deposit</h3>
            </div>
            <div class="card-body">
              <div>
                <table class="table table-striped table-sm">
                  <thead>
                    <tr class="d-flex">
                      <th class="col-1 text-center" scope="col"></th>
                      <th class="col-2 text-left" scope="col">Cheque Date</th>
                      <th class="col-2 text-left" scope="col">Cheque Number</th>
                      <th class="col-3 text-left" scope="col">Bank / Branch</th>
                      <th class="col text-right" scope="col">Cheque Value</th>
                      <th class="col col-1 text-right" scope="col"></th>
                      
                    </tr>
                  </thead>
                  <tbody id="chqInHandList">
                        <?php 
                        $sql = 'SELECT cheques_received.chq_id, cheques_received.chq_rcvd_date, cheques_received.sale_id, cheques_received.credit_id, cheques_received.chq_no, cheques_received.chq_bank, cheques_received.chq_bank_branch, cheques_received.chq_date, cheques_received.chq_value, cheques_received.chq_status
                        FROM cheques_received 
                        LEFT JOIN credit_sales ON cheques_received.credit_id = credit_sales.credit_sale_id 
                        WHERE cheques_received.chq_status = "in-hand" AND cheques_received.chq_date <= curdate()
                        ORDER BY cheques_received.chq_date ASC';
                        $result1 = mysqli_query($con, $sql);
                        $numRows = mysqli_num_rows ( $result1 );
                        if ($numRows < 1){
                          echo '<tr>
                            <td> 
                              <div class="alert alert-primary bg-light mb-0 text-center" role="alert">
                                There are no Cheques to be Deposited today! 
                              </div>
                            </td>
                          </tr>';
                        }

                        while($row1 = mysqli_fetch_array($result1)){?>
                          <tr class="d-flex" data-chqId = <?= $row1['chq_id'] ?> style="cursor:pointer">
                            <td class="col col-1 text-center"><i class="far fa-lg fa-circle text-primary" data-value=0></i></td>
                            <td class="col col-2 text-left"><?= date_format(date_create($row1["chq_date"]), 'd-m-Y')?></td>
                            <td class="col col-2 text-left"><?=$row1["chq_no"]?> </td>
                            <td class="text-left col col-3 text-left"><?=$row1["chq_bank"]?> - <?=$row1["chq_bank_branch"]?></td>
                            <td class="text-right col "><?=number_format($row1["chq_value"],2, '.', ',')?></td>
                            <td class="text-right col-1 "></td>
                          </tr>
                        <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <div class="btn btn-primary float-right" id="btnDeposit">Bank Selected Cheques</div>
            </div>
          </div>
        </div>

        <!-- cheques deposted but not realised table -->
        <div class="col-sm-12">
          <div class="card card-success">
            <div class="card-header">
              <h3 class="card-title">Cheques Deposited and Not Realised</h3>
            </div>
            <div class="card-body">
              <div>
                <table class="table table-striped table-sm">
                  <thead>
                    <tr class="d-flex">
                      <th class="col-1 text-center" scope="col"></th>
                      <th class="col-2 text-left" scope="col">Cheque Date</th>
                      <th class="col-2 text-left" scope="col">Cheque Number</th>
                      <th class="col-3 text-left" scope="col">Bank / Branch</th>
                      <th class="col text-right" scope="col">Cheque Value</th>
                      <th class="col col-1 text-right" scope="col"></th>
                      
                    </tr>
                  </thead>
                  <tbody id="chqDeposited">
                        <?php 
                        $sql = 'SELECT cheques_received.chq_id, cheques_received.chq_rcvd_date, cheques_received.sale_id, cheques_received.credit_id, cheques_received.chq_no, cheques_received.chq_bank, cheques_received.chq_bank_branch, cheques_received.chq_date, cheques_received.chq_value, cheques_received.chq_status
                        FROM cheques_received 
                        LEFT JOIN credit_sales ON cheques_received.credit_id = credit_sales.credit_sale_id 
                        WHERE cheques_received.chq_status = "deposited" 
                        ORDER BY cheques_received.chq_date ASC';

                        $result1 = mysqli_query($con, $sql);
                        $numRows = mysqli_num_rows ( $result1 );
                        if ($numRows < 1){
                          echo '<tr>
                            <td> 
                              <div class="alert alert-success bg-light mb-0 text-center" role="alert">
                                There are no Cheques Deposited to be Realised! 
                              </div>
                            </td>
                          </tr>';
                        }

                        while($row1 = mysqli_fetch_array($result1)){?>
                          <tr class="d-flex" data-chqId = <?= $row1['chq_id'] ?> style="cursor:pointer">
                            <td class="col col-1 text-center"><i class="far fa-lg fa-circle text-success" data-value=0></i></td>
                            <td class="col col-2 text-left"><?= date_format(date_create($row1["chq_date"]), 'd-m-Y')?></td>
                            <td class="col col-2 text-left"><?=$row1["chq_no"]?> </td>
                            <td class="text-left col col-3 text-left"><?=$row1["chq_bank"]?> - <?=$row1["chq_bank_branch"]?></td>
                            <td class="text-right col "><?=number_format($row1["chq_value"],2, '.', ',')?></td>
                            <td class="text-right col-1 "></td>
                          </tr>
                        <?php } ?>

                    
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <div class="btn btn-danger float-left" id="btnBounced">Mark Bounced</div>
              <div class="btn btn-success float-right" id="btnRealised">Mark Realised</div>
            </div>
          </div>
        </div>

        <!-- cheques in hand table -->
        <div class="col-sm-12">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Cheques in Hand</h3>
            </div>
            <div class="card-body">
              <div>
                <table class="table table-striped table-sm">
                  <thead>
                    <tr class="d-flex">
                      <th class="col-1 text-center" scope="col"></th>
                      <th class="col-2 text-left" scope="col">Cheque Date</th>
                      <th class="col-2 text-left" scope="col">Cheque Number</th>
                      <th class="col-3 text-left" scope="col">Bank / Branch</th>
                      <th class="col text-right" scope="col">Cheque Value</th>
                      <th class="col col-1 text-right" scope="col"></th>
                      
                    </tr>
                  </thead>
                  <tbody id="chqInHand">
                        <?php 
                        $sql = 'SELECT cheques_received.chq_id, cheques_received.chq_rcvd_date, cheques_received.sale_id, cheques_received.credit_id, cheques_received.chq_no, cheques_received.chq_bank, cheques_received.chq_bank_branch, cheques_received.chq_date, cheques_received.chq_value, cheques_received.chq_status
                        FROM cheques_received 
                        LEFT JOIN credit_sales ON cheques_received.credit_id = credit_sales.credit_sale_id 
                        WHERE cheques_received.chq_status = "in-hand"
                        ORDER BY cheques_received.chq_date ASC';

                        $result1 = mysqli_query($con, $sql);
                        $numRows = mysqli_num_rows ( $result1 );
                        if ($numRows < 1){
                          echo '<tr>
                            <td> 
                              <div class="alert alert-secondary bg-light mb-0 text-center" role="alert">
                                There are no Cheques in Hand! 
                              </div>
                            </td>
                          </tr>';
                        }
                        while($row1 = mysqli_fetch_array($result1)){?>
                          <tr class="d-flex" data-chqId = <?= $row1['chq_id'] ?> >
                            <td class="col col-1 text-center"></td>
                            <td class="col col-2 text-left"><?= date_format(date_create($row1["chq_date"]), 'd-m-Y')?></td>
                            <td class="col col-2 text-left"><?=$row1["chq_no"]?> </td>
                            <td class="text-left col col-3 text-left"><?=$row1["chq_bank"]?> - <?=$row1["chq_bank_branch"]?></td>
                            <td class="text-right col "><?=number_format($row1["chq_value"],2, '.', ',')?></td>
                            <td class="text-right col-1 "></td>
                          </tr>
                        <?php } ?>

                    
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              
            </div>
          </div>
        </div>

        <!-- cheques realised table -->
        <div class="col-sm-12">
          <div class="card card-dark">
            <div class="card-header">
              <h3 class="card-title">Realised Cheques</h3>
            </div>
            <div class="card-body">
              <div>
                <table class="table table-striped table-sm">
                  <thead>
                    <tr class="d-flex">
                      <th class="col-1 text-center" scope="col"></th>
                      <th class="col-2 text-left" scope="col">Cheque Date</th>
                      <th class="col-2 text-left" scope="col">Cheque Number</th>
                      <th class="col-3 text-left" scope="col">Bank / Branch</th>
                      <th class="col text-right" scope="col">Cheque Value</th>
                      <th class="col col-1 text-right" scope="col"></th>
                      
                    </tr>
                  </thead>
                  <tbody id="chqRealised">
                        <?php 
                        $sql = 'SELECT cheques_received.chq_id, cheques_received.chq_rcvd_date, cheques_received.sale_id, cheques_received.credit_id, cheques_received.chq_no, cheques_received.chq_bank, cheques_received.chq_bank_branch, cheques_received.chq_date, cheques_received.chq_value, cheques_received.chq_status
                        FROM cheques_received 
                        LEFT JOIN credit_sales ON cheques_received.credit_id = credit_sales.credit_sale_id 
                        WHERE (cheques_received.chq_status = "realised" OR cheques_received.chq_status = "bounced")
                        ORDER BY cheques_received.chq_date ASC';

                        $result1 = mysqli_query($con, $sql);
                        $numRows = mysqli_num_rows ( $result1 );
                        if ($numRows < 1){
                          echo '<tr>
                            <td> 
                              <div class="alert alert-dark bg-light mb-0 text-center" role="alert">
                                There are no Realised Cheques! 
                              </div>
                            </td>
                          </tr>';
                        }

                        while($row1 = mysqli_fetch_array($result1)){
                          if ($row1["chq_status"]=='bounced'){
                            $badgeStyle = 'danger';
                          }else{
                            $badgeStyle = 'success';
                          }       
                          
                        ?>
                          <tr class="d-flex" data-chqId = <?= $row1['chq_id'] ?> style="cursor:pointer">
                            <td class="col col-1 text-center"><i class="far fa-lg fa-circle text-dark" data-value=0></i></td>
                            <td class="col col-2 text-left"><?= date_format(date_create($row1["chq_date"]), 'd-m-Y')?></td>
                            <td class="col col-2 text-left"><?=$row1["chq_no"]?> </td>
                            <td class="text-left col col-3 text-left"><?=$row1["chq_bank"]?> - <?=$row1["chq_bank_branch"]?></td>
                            <td class="text-right col "><?=number_format($row1["chq_value"],2, '.', ',')?></td>
                            <td class="text-right col-1 "><h5 class="mb-0"><span class="badge badge-<?=$badgeStyle?>"><?=strtoupper($row1["chq_status"])?></span></h5></td>
                          </tr>
                        <?php } ?>

                    
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <div class="btn btn-dark float-right" id="btnCancel">Cancel Realisation</div>
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
<script>

  const chqInHandList = document.querySelector("#chqInHandList");
  const chqDeposited = document.querySelector("#chqDeposited");
  const chqRealised = document.querySelector("#chqRealised");
  
  chqInHandList.addEventListener('click', (e)=>{
    selectRow(e);
  });
  chqDeposited.addEventListener('click', (e)=>{
    selectRow(e);
  });
  chqRealised.addEventListener('click', (e)=>{
    selectRow(e);
  });

  function selectRow(tableId){
    let tr, checkBox;
    if(tableId.target.tagName == 'I'){ //if checkbox icon
      checkBox = tableId.target;
      tr = tableId.target.parentElement.parentElement;
    }else{
      checkBox = tableId.target.parentElement.firstElementChild.firstElementChild;
      tr = tableId.target.parentElement;
    }

    if (checkBox.dataset.value==0){
        tr.classList.add('table-primary');
        checkBox.classList.remove('fa-circle');
        checkBox.classList.add('fa-check-circle');
        checkBox.dataset.value=1;
      }else{
        tr.classList.remove('table-primary');
        checkBox.classList.add('fa-circle');
        checkBox.classList.remove('fa-check-circle');

        checkBox.dataset.value=0;

    }

  }

  document.querySelector("#btnDeposit").addEventListener("click", ()=>{
    changeChequesStatuses(chqInHandList, 'deposited');
  });
  document.querySelector("#btnRealised").addEventListener("click", ()=>{
    changeChequesStatuses(chqDeposited, 'realised');
  });
  document.querySelector("#btnBounced").addEventListener("click", ()=>{
    changeChequesStatuses(chqDeposited, 'bounced');
  });
  document.querySelector("#btnCancel").addEventListener("click", ()=>{
    changeChequesStatuses(chqRealised, 'in-hand');
  });

  async function changeChequesStatuses(tableId, status){
    //console.log(chqInHandList.children[1]);
      let chequeStatusUpdate = true;
      for (let i=0; i<tableId.children.length; i++){
        const checkBox = tableId.children[i].firstElementChild.firstElementChild;
        if(checkBox.dataset.value==1){
          const chqId = tableId.children[i].dataset.chqid;
          const chqStatus = status;

          let formData = new FormData();

          formData.append("chq_id", chqId);
          formData.append("chq_status", chqStatus);
          
          const resp = await fetch("update_cheque_status_action.php", {
            method: "POST",
            body: formData,
          }).then((response) => response.json())
          .then((data) => {
            //console.log(data);
            if (data.success == false){
              console.log (data);
            }
             
          });
        }
      }
      location.reload();

  }

</script>
</body>
</html>