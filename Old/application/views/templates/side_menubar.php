<aside class="main-sidebar" style="background-color: #322fbf;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        
        <li id="dashboardMainMenu">
          <a href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>

        <li class="treeview" id="mainJobsNav">
          <a href="#">
            <i class="fa fa-sitemap"></i>
            <span>UID Jobs</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li id="manageJobsNav"><a href="<?php echo base_url('jobs') ?>"><i class="fa fa-circle-o"></i> UID Register</a></li>
            <li id="createJobsNav"><a href="<?php echo base_url('jobs/create') ?>"><i class="fa fa-circle-o"></i> Create UID Job</a></li>
          </ul>
        </li>

        <?php if($user_permission): ?>
          <?php if(in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
            <li class="treeview" id="mainUserNav">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>Users</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('createUser', $user_permission)): ?>
              <li id="createUserNav"><a href="<?php echo base_url('users/create') ?>"><i class="fa fa-circle-o"></i> Add User</a></li>
              <?php endif; ?>

              <?php if(in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
              <li id="manageUserNav"><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> Manage Users</a></li>
            <?php endif; ?>
            </ul>
          </li>
          <?php endif; ?>

          <?php if(in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Groups</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createGroup', $user_permission)): ?>
                  <li id="addGroupNav"><a href="<?php echo base_url('groups/create') ?>"><i class="fa fa-circle-o"></i> Add Group</a></li>
                <?php endif; ?>
                <?php if(in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('groups') ?>"><i class="fa fa-circle-o"></i> Manage Groups</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>

        <?php if(in_array('createRegistration', $user_permission) || in_array('updateRegistration', $user_permission) || in_array('viewRegistration', $user_permission) || in_array('deleteRegistration', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Client Registration</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 
                <?php if(in_array('updateRegistration', $user_permission) || in_array('viewRegistration', $user_permission) || in_array('deleteRegistration', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('registration/') ?>"><i class="fa fa-circle-o"></i> Manage Registration</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
          
            <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Lab Reports</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('createOrder', $user_permission)): ?>
                  <li id="addGroupNav"><a href="<?php echo base_url('cubereport/') ?>"><i class="fa fa-circle-o"></i> CC Cube</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('bitumencore/') ?>"><i class="fa fa-circle-o"></i> Bitumen Core</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('bitumenloose/') ?>"><i class="fa fa-circle-o"></i> Bitumen Loose</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('interlockingtiles/') ?>"><i class="fa fa-circle-o"></i> Interlocking Tiles</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('concretecore/') ?>"><i class="fa fa-circle-o"></i> Concrete Core</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('water/') ?>"><i class="fa fa-circle-o"></i>Water</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('mainholecover/') ?>"><i class="fa fa-circle-o"></i>Main Hole Cover</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('ferrocover/') ?>"><i class="fa fa-circle-o"></i>Ferrocover</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('concretebeam/') ?>"><i class="fa fa-circle-o"></i>Concrete Beam</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('bricks/') ?>"><i class="fa fa-circle-o"></i>Bricks</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('mes/') ?>"><i class="fa fa-circle-o"></i>Mes</a></li>
                  <li id="addGroupNav"><a href="<?php echo base_url('sand/') ?>"><i class="fa fa-circle-o"></i>Sand</a></li>
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>
           
          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
           <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Manage ULR</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('updateBilling', $user_permission) || in_array('viewRegistration', $user_permission) || in_array('deleteRegistration', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('ulrlink/') ?>"><i class="fa fa-circle-o"></i> ADD ULR</a></li>
                <li><a href="<?php echo base_url('ulrlink/ulr_register/') ?>"><i class="fa fa-files-o"></i> <span>Manage ULR Register</span></a></li>
                
                
                <?php endif; ?>
              </ul>
            </li>
            
            
          
          <?php endif; ?>
          <?php if(in_array('createOrder', $user_permission) || in_array('updateOrder', $user_permission) || in_array('viewOrder', $user_permission) || in_array('deleteOrder', $user_permission)): ?>
            <?if($this->session->userdata('id') == 1){?>
            <li><a href="<?php echo base_url('finallabreports/') ?>"><i class="fa fa-files-o"></i> <span>Final Reports</span></a></li>
            <? } ?>
          <?php endif; ?>
          
          <?php if(in_array('createBilling', $user_permission) || in_array('updateBilling', $user_permission) || in_array('viewBilling', $user_permission) || in_array('deleteBilling', $user_permission)): ?>
            <li class="treeview" id="mainGroupNav">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Billing</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                 
                <?php if(in_array('updateBilling', $user_permission) || in_array('viewRegistration', $user_permission) || in_array('deleteRegistration', $user_permission)): ?>
                <li id="manageGroupNav"><a href="<?php echo base_url('billing/') ?>"><i class="fa fa-circle-o"></i> All Bills</a></li>
                <li id="manageGroupNav"><a href="<?php echo base_url('billing/duebilling') ?>"><i class="fa fa-circle-o"></i>Due Bills</a></li>
                <li id="manageGroupNav"><a href="<?php echo base_url('billing/dueBillingreport') ?>"><i class="fa fa-circle-o"></i> Due Bills Attached Report</a></li>
                
                <li id="manageGroupNav"><a href="<?php echo base_url('billing/paymentnotupdate') ?>"><i class="fa fa-circle-o"></i> Not Update Bills</a></li>
                
                
                <?php endif; ?>
              </ul>
            </li>
            <li id="companyNav"><a href="<?php echo base_url('/duereports') ?>"><i class="fa fa-circle-o"></i>Uid w/o Report</a></li>
            <?php endif; ?>
          <?php if(in_array('createBilling', $user_permission) || in_array('updateBilling', $user_permission) || in_array('viewBilling', $user_permission) || in_array('deleteBilling', $user_permission)): ?>
            
            <li id="companyNav"><a href="<?php echo base_url('dailyexpenses/') ?>"><i class="fa fa-files-o"></i> <span>Daily Expenses</span></a></li>
          <?php endif; ?>
            <?php if(in_array('createBilling', $user_permission) || in_array('updateBilling', $user_permission) || in_array('viewBilling', $user_permission) || in_array('deleteBilling', $user_permission)): ?>
            
            <li id="companyNav"><a href="<?php echo base_url('purchaseorder/') ?>"><i class="fa fa-files-o"></i> <span>Purchase Order</span></a></li>
          <?php endif; ?>
            <?php if(in_array('createBilling', $user_permission) || in_array('updateBilling', $user_permission) || in_array('viewBilling', $user_permission) || in_array('deleteBilling', $user_permission)): ?>
            
            <li id="companyNav"><a href="<?php echo base_url('invoice/') ?>"><i class="fa fa-files-o"></i> <span>Invoice</span></a></li>
          <?php endif; ?>
            <?php if(in_array('updateCompany', $user_permission)): ?>
            <li id="companyNav"><a href="<?php echo base_url('company/') ?>"><i class="fa fa-files-o"></i> <span>Company</span></a></li>
          <?php endif; ?>
          

        <!-- <li class="header">Settings</li> -->

        <?php if(in_array('viewProfile', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/profile/') ?>"><i class="fa fa-user-o"></i> <span>Profile</span></a></li>
        <?php endif; ?>
        <?php if(in_array('updateSetting', $user_permission)): ?>
          <li><a href="<?php echo base_url('users/setting/') ?>"><i class="fa fa-wrench"></i> <span>Setting</span></a></li>
        <?php endif; ?>

        <?php endif; ?>
        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
