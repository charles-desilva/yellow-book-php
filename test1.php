<form method="post"  action="new_cheque_action.php">
            
                                        <input type="date" name="chqRcvdDate" class="form-control"  autocomplete="off">
                                   
                                        <input type="number" id="chqNum" class="form-control"  autocomplete="off">
                                  
                                        <input type="text" id="bank" class="form-control" >
                                  
                                        <input type="text" id="branch" class="form-control" >
                                
                                        <input type="date" id="chqDate" class="form-control" autocomplete="off" >
                               
                                        <input id="chqValue" type="number" class="form-control">
                                
                <input type="submit" class="btn btn-warning " id="insertChequeDetailsBtn" value="Save">
               
        </form>

        <form action="/action_page.php">
  <label for="fname">First name:</label><br>
  <input type="text" id="chqRcvdDate" name="fname" value="John"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname" value="Doe"><br><br>
  <input type="submit" value="Submit">
</form>