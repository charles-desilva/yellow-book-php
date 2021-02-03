<div class="modal fade" id="creditSaleDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Credit Sale Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php 
            $saleId = -1;
            $creditAmount = "";
            $creditDate = "";
            if(isset($_GET['sale_id'])){
              
                $saleId = $_GET['sale_id'];
                $sql = "SELECT *
                FROM credit_sales
                WHERE sale_id = $saleId"; 
                $result1 = mysqli_query($con, $sql);
                $row1 = mysqli_fetch_array($result1);
                $creditAmount = $row1["credit_amount"];
                $creditDate = $row1["credit_date"];
            }     
            
            
          ?>
          <form id=creditSaleDetailsForm>
                  <div class="form-group">
                    <label for="invoiceNumber">Credit Sale Amount</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">
                            <strong>Rs.</strong>
                        </span>
                        </div>
                        <input type="number" class="form-control" autocomplete="off" id="creditSaleDetailValue" value=<?=$creditAmount?> placeholder="0.00">
                        <div class="invalid-feedback">Please enter valid Credit Sale Value.</div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="invoiceNumber">Credit Collection Date</label>
                    <input type="date" id="creditCollectionDateField" class="form-control" autocomplete="off" placeholder="Select Date" value=<?=$creditDate?>>
                    <div class="invalid-feedback">Please select valid date for Credit Collection</div>
                  </div>
                  
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="insertCreditDetailsBtn" type="button" class="btn btn-success">Save</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    
    const insertCreditDetailsBtn = document.querySelector('#insertCreditDetailsBtn');
    const creditSaleDetailValue = document.querySelector('#creditSaleDetailValue');
    const creditCollectionDate =document.querySelector('#creditCollectionDateField');
    const creditValue =document.querySelector('#creditValue');
    
    insertCreditDetailsBtn.addEventListener('click', function(){
      let error = false;
      if (creditSaleDetailValue.value == ''){
          creditSaleDetailValue.className += ' is-invalid';
          error=true;
      }else{
          creditSaleDetailValue.className = 'form-control'
      }
      if (creditCollectionDate.value == ''){
          creditCollectionDate.className += ' is-invalid';
          error = true;
      }else{
          creditCollectionDate.className = 'form-control datetimepicker-input'
      }

      if(!error){
          creditSaleValue.value = parseFloat(creditSaleDetailValue.value).toFixed(2);
          calculateSaleTotal();
          $('#creditSaleDetails').modal('toggle');
      }

    })
    
  </script>