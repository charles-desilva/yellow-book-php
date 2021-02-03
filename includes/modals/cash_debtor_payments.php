<div class="modal fade" id="cashDebtorPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-secondary">
          <h5 class="modal-title" id="exampleModalLongTitle">Cash Payment by Debtor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post"  action="new_cash_in_action.php">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <input type="hidden" id="creditId" name="creditId" value=<?=$_GET['credit_sale_id']?>>
                                <input type="hidden" id="cashRegId" name="cashRegId" value="">
                                <div class="form-group row">
                                    <label for="cashInDate" class="col-sm-3 col-form-label">Payment Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" id="cashInDate" name="cashInDate" class="form-control"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cash Amount</label>
                                    <div class="col-sm-9">
                                        <input id="cashInAmount" name="cashInAmount" type="number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <input type="submit" onclick="return insertDebtorCashPayment()" class="btn btn-primary " id="insertCashDetailsBtn" name="insertCashDetailsBtn" value="Save" />
                <input type="submit" onclick="return insertDebtorCashPayment()" class="btn btn-warning d-none" data-row=0 id="updateCashDetailsBtn" name="updateCashDetailsBtn" value="Update" />
            </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    
    const cashPaymentDate = document.querySelector('#cashInDate');
    const cashValueField =document.querySelector('#cashInAmount');
    const insertCashDetailsBtn =document.querySelector('#insertCashDetailsBtn');
    const updateCashDetailsBtn =document.querySelector('#updateCashDetailsBtn');

   

    function validateCashPaymentFields(){
        let error = false;
        if (cashPaymentDate.value == ''){
            cashPaymentDate.className += ' is-invalid';
            error=true;
        }else{
            cashPaymentDate.className = 'form-control'
        }
        if (cashValueField.value == ''){
            cashValueField.className += ' is-invalid';
            error = true;
        }else{
            cashValueField.className = 'form-control datetimepicker-input'
        }
        return error;
    }

    function insertDebtorCashPayment(){
        if(!validateCashPaymentFields()){
            return true
        }else{
            return false;
        }
    }

    // insertCashDetailsBtn.addEventListener('click', function(){
    //     if(!validateCashPaymentFields()){
    //         //createChequeRow(chequeNoInput.value, bankInput.value, branchInput.value, chequeDateField.value, chequeValueField.value);
    //         submitChequePayment()
    //     }

    // });
    
    
    function clearCashPaymentFields(){
        cashPaymentDate.value ='';
        cashValueField.value ='';
    }

 

    function resetCashPaymentFields(){
        cashPaymentDate.classList.remove('is-invalid');
        cashValueField.classList.remove('is-invalid');
    }

 

   
    
  </script>

