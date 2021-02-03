<div class="modal fade" id="chequeSaleDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Cheques Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <div class="row">
                            <div class="col-2">
                                <label>Cheque No.</label>
                                <input type="number" id="chequeNo" class="form-control"  autocomplete="off">
                            </div>
                            <div class="col-2">
                                <label>Bank</label>
                                <input type="text" id="bank" class="form-control" >
                            </div>
                            <div class="col-2">
                                <label>Branch</label>
                                <input type="text" id="branch" class="form-control" >
                            </div>
                            <div class="col-3">
                                <label>Date</label>
                                <input type="date" id="chequeDateField1" class="form-control" autocomplete="off" >
                            </div>
                                <div class="col-2">
                                    <label>Value</label>
                                    <input id="chequeValue" type="number" class="form-control">
                                </div>
                                <div class="col-1">
                                    <label>Action</label>
                                    <div class="btn btn-warning " id="insertChequeDetailsBtn"><i class="fa fa-plus-square"></i></div>
                                    <div class="btn btn-success d-none" data-row=0 id="updateChequeDetailsBtn"><i class="fa fa-check-circle"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <tbody id="chequeList">
                             <?php 
                             $saleId = -1;
                             $saleTotal=0.00;
                            if(isset($_GET['sale_id'])){
                                $saleId = $_GET['sale_id'];
                            }     
                            
                            $sql = "SELECT *
                            FROM cheques_received
                            WHERE sale_id = $saleId"; 

                            $result1 = mysqli_query($con, $sql);
                            
                            while($row1 = mysqli_fetch_array($result1)){
                                $saleTotal += $row1["chq_value"];
                                ?>
                            <tr class="d-flex">
                                <td class="col-2"><?=$row1["chq_no"]?></td>
                                <td class="col-2"><?=$row1["chq_bank"]?></td>
                                <td class="col-2"><?=$row1["chq_bank_branch"]?></td>
                                <td class="col-3"><?=$row1["chq_date"]?></td>
                                <td class="col-2"><?=$row1["chq_value"]?></td>
                                <td class="col-1"><div class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle fa-lg"></i></div></td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <div class="mr-3 h5">Cheque Total (Rs.): </div><div class="h5" id='cheque-total'><?=number_format($saleTotal,2,'.',',')?></div>
                </div>
            <!-- /.card -->
            </div>
        </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="insertChequeModalBtn" type="button" class="btn btn-warning">Save</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    
    const chequeNoInput = document.querySelector('#chequeNo');
    const bankInput = document.querySelector('#bank');
    const branchInput =document.querySelector('#branch');
    const chequeDateField =document.querySelector('#chequeDateField1');
    const chequeValueField =document.querySelector('#chequeValue');
    const insertChequeDetailsBtn =document.querySelector('#insertChequeDetailsBtn');
    const updateChequeDetailsBtn =document.querySelector('#updateChequeDetailsBtn');
    const chequeList = document.querySelector('#chequeList');
    const chequeTotalDiv = document.querySelector('#cheque-total');
    const insertChequeModalBtn = document.querySelector('#insertChequeModalBtn');
    const chequeSaleValue = document.querySelector('#chequeSaleValue')

    function validateFields(){
        let error = false;
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

    insertChequeModalBtn.addEventListener('click', function(){
        chequeSaleValue.value = chequeTotalDiv.textContent;
        calculateSaleTotal();
        clearFields();
        updateChequeDetailsBtn.setAttribute('data-row', -1);
        clearRowHighlights();
        updateChequeDetailsBtn.classList.add('d-none');
        insertChequeDetailsBtn.classList.remove('d-none');
        resetFields();
        $('#chequeSaleDetails').modal('toggle');
    });

    insertChequeDetailsBtn.addEventListener('click', function(){
        if(!validateFields()){
            createChequeRow(chequeNoInput.value, bankInput.value, branchInput.value, chequeDateField.value, chequeValueField.value);
        }

    });

    updateChequeDetailsBtn.addEventListener('click', function(e){
        
        if(!validateFields()){
            let row = -1;
            if(e.target.nodeName == "DIV"){
                row = e.target.dataset.row;
            }else {
                row = e.target.parentElement.dataset.row;
            }
            updateChequeRow(chequeNoInput.value, bankInput.value, branchInput.value, chequeDateField.value, chequeValueField.value, row);
            
        }

    });

    function createChequeRow(chqNo, bank, branch,date,value){
        //let tr = document.createElement('tr');
        
        const row = document.createElement('tr');
        row.className="d-flex";
        row.innerHTML = `<td class="col-2">${chqNo}</td>
                        <td class="col-2">${bank}</td>
                        <td class="col-2">${branch}</td>
                        <td class="col-3">${date}</td>
                        <td class="col-2">${parseFloat(value).toFixed(2)}</td>
                        <td class="col-1"><div class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle fa-lg"></i></div></td>`;
        chequeList.appendChild(row);
        calculateTotal();
        clearFields();
    }

    function updateChequeRow(chqNo, bank, branch,date,value,row){
        chequeList.children[row].innerHTML = `<td class="col-2">${chqNo}</td>
                        <td class="col-2">${bank}</td>
                        <td class="col-2">${branch}</td>
                        <td class="col-3">${date}</td>
                        <td class="col-2">${parseFloat(value).toFixed(2)}</td>
                        <td class="col-1"><div class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle fa-lg"></i></div></td>`;
        insertChequeModalBtn.disabled=false;
        calculateTotal();
        clearFields();
        updateChequeDetailsBtn.setAttribute('data-row', -1);
        clearRowHighlights();
        updateChequeDetailsBtn.classList.add('d-none');
        insertChequeDetailsBtn.classList.remove('d-none');
    }

    function clearFields(){
        chequeNoInput.value ='';
        bankInput.value ='';
        branchInput.value ='';
        chequeDateField.value ='';
        chequeValueField.value ='';
    }

    function clearRowHighlights(){
        let nextSibling = chequeList.firstElementChild;
        while(nextSibling) {
            nextSibling.classList.remove('table-info')
            nextSibling = nextSibling.nextElementSibling;
        }
    }
    function calculateTotal(){
        let nextSibling = chequeList.firstElementChild;
        let total = 0.00;
        console.log(nextSibling);
        while(nextSibling) {
            total += parseFloat(nextSibling.children[4].textContent);
            nextSibling = nextSibling.nextElementSibling;
        }
        chequeTotalDiv.textContent =  parseFloat(total).toFixed(2);
    }

    function resetFields(){
        chequeNoInput.classList.remove('is-invalid');
        bankInput.classList.remove('is-invalid');
        branchInput.classList.remove('is-invalid');
        chequeDateField.classList.remove('is-invalid');
        chequeValueField.classList.remove('is-invalid');
        
    }

    function deleteCheque(row){
        row.remove();
        clearFields();
        updateChequeDetailsBtn.classList.add('d-none');
        insertChequeDetailsBtn.classList.remove('d-none');
        calculateTotal();
    }

    chequeList.addEventListener('click', function(e){
        if(e.target.nodeName == "TD"){
            insertChequeModalBtn.disabled=true;
            const elementIndex = Array.prototype.indexOf.call(e.target.parentElement.parentElement.children, e.target.parentElement);
                        
            chequeNoInput.value =e.target.parentElement.children[0].textContent;
            bankInput.value =e.target.parentElement.children[1].textContent;
            branchInput.value =e.target.parentElement.children[2].textContent;
            chequeDateField.value = e.target.parentElement.children[3].textContent;
            chequeValueField.value =e.target.parentElement.children[4].textContent;

            updateChequeDetailsBtn.setAttribute('data-row', elementIndex);
            clearRowHighlights();
            e.target.parentElement.classList.add('table-info');
            updateChequeDetailsBtn.classList.remove('d-none');
            insertChequeDetailsBtn.classList.add('d-none');
            resetFields();

        }else if(e.target.nodeName == "DIV"){
            deleteCheque(e.target.parentElement.parentElement);
        }else{
            deleteCheque(e.target.parentElement.parentElement.parentElement);
        }
    })
    
    
  </script>

