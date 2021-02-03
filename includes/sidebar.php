<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index1.php" class="brand-link">
      <img src="dist/img/gwg-logo.svg" alt="Green Wheel Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Green Wheel Group</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- SidebarSearch Form -->
      <!-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
            <li class="nav-item">
            <a href="./index.php" class="nav-link <?php if($page==='dashboard'){echo "active";}?>">
                <i class="fa fa-tachometer-alt nav-icon"></i>
                <p>Dashboard</p>
            </a>
            </li>

            <li class="nav-header">Record Transactions</li>
               
            <li class="nav-item">
                <a href="./new_sale.php" class="nav-link <?php if($page==='newsale'){echo "active";}?>">
                    <i class="fas fa-file-invoice-dollar nav-icon"></i>
                    <p>Enter New Sale</p>
                </a>
            </li>
            <li class="nav-item">
              <a href="./credit_sales_list.php" class="nav-link <?php if($page==='creditSalesList'){echo "active";}?>">
                  <i class="far fa-credit-card nav-icon"></i>
                  <p>New Credit Collection</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./new_expense.php" class="nav-link <?php if($page==='newExpense'){echo "active";}?>">
                  <i class="fas fa-cash-register nav-icon"></i>
                  <p>Enter New Expenses</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./cash_deposit.php" class="nav-link <?php if($page==='cashDeposit'){echo "active";}?>">
                  <i class="fas fa-piggy-bank nav-icon"></i>
                  <p>Deposit Cash to Bank</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="./cash_withdraw.php" class="nav-link <?php if($page==='cashWithdraw'){echo "active";}?>">
                  <i class="fas fa-wallet nav-icon"></i>
                  <p>Withdraw Cash From Bank</p>
              </a>
            </li>
            <li class="nav-item">
                <a href="./new_purchase.php" class="nav-link <?php if($page==='newpurchase'){echo "active";}?>">
                    <i class="fas fa-shopping-basket nav-icon"></i>
                    <p>Enter New Purchase</p>
                </a>
            </li>
           
            <li class="nav-item">
              <a href="./update_cheque_status.php" class="nav-link <?php if($page==='chequeStatus'){echo "active";}?>">
                  <i class="far fa-credit-card nav-icon"></i>
                  <p>Update Cheque Status</p>
              </a>
            </li>
            <li class="nav-header">Reports</li>
            <li class="nav-item">
                <a href="./yellowbook.php" class="nav-link">
                    <i class="fa fa-book nav-icon"></i>
                    <p>Yellow Book</p>
                </a>
            </li>
           
            <li class="nav-item">
                <a href="./sales_book.php" class="nav-link <?php if($page==='salesBook'){echo "active";}?>">
                    <i class="fas fa-file-invoice-dollar nav-icon"></i>
                    <p>Sales Book</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="./debtors.php" class="nav-link <?php if($page==='debtors'){echo "active";}?>">
                    <i class="fa fa-briefcase nav-icon"></i>
                    <p>Debtors Book</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="./creditors.php" class="nav-link">
                    <i class="fa fa-users nav-icon"></i>
                    <p>Creditors Book</p>
                </a>
            </li>
             <!-- <li class="nav-item">
                <a href="./sales.php" class="nav-link">
                    <i class="fa fa-shopping-cart nav-icon"></i>
                    <p>Sales Register</p>
                </a>
            </li> -->
            <li class="nav-item">
                <a href="./cheques.php" class="nav-link <?php if($page==='cheques'){echo "active";}?>">
                    <i class="fa fa-university nav-icon"></i>
                    <p>Cheques Register</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="./expences.php" class="nav-link">
                    <i class="fas fa-wallet nav-icon"></i>
                    <p>Expences Register</p>
                </a>
            </li>
            
              
                

            

            
              
          
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>