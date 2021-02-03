<div class="modal fade" id="chequeDebtorPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h5 class="modal-title" id="exampleModalLongTitle">Cheques Payment by Debtor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="post"  action="new_cheque_action.php">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <input type="hidden" id="chqCreditId" name="chqCreditId" value=<?=$_GET['credit_sale_id']?>>
                                <input type="hidden" id="chq_id" name="chq_id" value="">
                                <input type="hidden" id="saleId" name="saleId" value="<?=$sale_id?>">
                                <input type="hidden" id="creditSale" name="creditSale" value="true">
                                <div class="form-group row">
                                    <label for="chqRcvdDate" class="col-sm-3 col-form-label">Payment Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" id="chqRcvdDate" name="chqRcvdDate" class="form-control"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="chqNum" class="col-sm-3 col-form-label">Cheque No.</label>
                                    <div class="col-sm-9">
                                        <input type="number" id="chqNum" name="chqNum" class="form-control"  autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Bank</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="bank" name="bank" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Branch</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="branch" name="branch" class="form-control" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cheque Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" id="chqDate" name="chqDate" class="form-control" autocomplete="off" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Cheque Amount</label>
                                    <div class="col-sm-9">
                                        <input id="chqValue" name="chqValue" type="number" class="form-control">
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
                <input type="submit" onclick="return insertChequePayment()" class="btn btn-warning " id="insertChequeDetailsBtn" name="insertChequeDetailsBtn" value="Save" />
                <input type="submit" onclick="return insertChequePayment()" class="btn btn-success d-none" data-row=0 id="updateChequeDetailsBtn" name="updateChequeDetailsBtn" value="Update" />
            </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    
    const paymentDate = document.querySelector('#chqRcvdDate');
    const chequeNoInput = document.querySelector('#chqNum');
    const bankInput = document.querySelector('#bank');
    const branchInput =document.querySelector('#branch');
    const chequeDateField =document.querySelector('#chqDate');
    const chequeValueField =document.querySelector('#chqValue');
    const insertChequeDetailsBtn =document.querySelector('#insertChequeDetailsBtn');
    const updateChequeDetailsBtn =document.querySelector('#updateChequeDetailsBtn');

   

    function validateFields(){
        let error = false;
        if (paymentDate.value == ''){
            paymentDate.className += ' is-invalid';
            error=true;
        }else{
            paymentDate.className = 'form-control'
        }
        if (chequeNoInput.value == ''){
            chequeNoInput.className += ' is-invalid';
            error=true;
        }else{
            chequeNoInput.className = 'form-control'
        }
        if (bankInput.value == ''){
            bankInput.className += ' is-invalid';
            error = true;
        }else{
            bankInput.className = 'form-control datetimepicker-input'
        }
        if (branchInput.value == ''){
            branchInput.className += ' is-invalid';
            error = true;
        }else{
            branchInput.className = 'form-control datetimepicker-input'
        }
        if (chequeDateField.value == ''){
            chequeDateField.className += ' is-invalid';
            error = true;
        }else{
            chequeDateField.className = 'form-control datetimepicker-input'
        }
        if (chequeValueField.value == ''){
            chequeValueField.className += ' is-invalid';
            error = true;
        }else{
            chequeValueField.className = 'form-control datetimepicker-input'
        }
        return error;
    }

    function insertChequePayment(){
        if(!validateFields()){
            return true
        }else{
            return false;
        }
    }

    function clearFields(){
        paymentDate.value ='';
        chequeNoInput.value ='';
        bankInput.value ='';
        branchInput.value ='';
        chequeDateField.value ='';
        chequeValueField.value ='';
    }

    function resetFields(){
        paymentDate.classList.remove('is-invalid');
        chequeNoInput.classList.remove('is-invalid');
        bankInput.classList.remove('is-invalid');
        branchInput.classList.remove('is-invalid');
        chequeDateField.classList.remove('is-invalid');
        chequeValueField.classList.remove('is-invalid');
        
    }

 

   
    
  </script>

