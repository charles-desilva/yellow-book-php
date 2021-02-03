<div class="modal fade" id="newCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add New Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id=newCustomerForm>
                  <div class="form-group">
                    <label for="invoiceNumber">Customer Name</label>
                    <input type="text" class="form-control" id="customerName" placeholder="Enter Customer Name">
                  </div>
                  <div class="form-group">
                    <label for="invoiceNumber">Customer Address</label>
                    <input type="text" class="form-control" id="customerAddress" placeholder="Enter Customer Address">
                  </div>
                  <div class="form-group">
                    <label for="invoiceNumber">Customer Phone</label>
                    <input type="text" class="form-control" id="customerPhone" placeholder="Enter Customer Phone">
                  </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button id="btn-saveCustomer" type="button" class="btn btn-primary">Save Customer</button>
        </div>
      </div>
    </div>
  </div>
  <script>

  document.querySelector('#btn-saveCustomer').addEventListener('click', function() {
    customerName = document.querySelector('#customerName');
    customerAddress = document.querySelector('#customerAddress');
    customerPhone =  document.querySelector('#customerPhone');
    customerList = document.querySelector('#customersList');

    var formData = {
          'customerName' : customerName.value,
          'customerAddress': customerAddress.value,
          'customerPhone': customerPhone.value,
    };
      $.ajax({
          url: 'new_customer_action.php',
          type: 'POST',
          data: formData,
          dataType : 'json',
          encode:true,
      }).done(function(data){
        //alert(data.success);
        if(data.success==true){
          var option = document.createElement('option');
          //console.log(data.message);
          option.text = data.name;
          option.value = data.id;
          customerList.add(option, 1);
          customerList.selectedIndex = 1;

          customerName.value = '';
          customerAddress.value = '';
          customerPhone.value = '';

          $('#newCustomerModal').modal('toggle');
        }else{
          alert ("failed");
        }
        console.log(data);
      });
  
  });
      
 // });
</script>