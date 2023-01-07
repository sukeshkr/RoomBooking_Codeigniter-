 <header class="main-header">

        <!-- Logo -->

        <a href="<?php echo base_url();?>welcome" class="logo">

          <!-- mini logo for sidebar mini 50x50 pixels -->

          <span class="logo-mini"><b>Admin</b></span>

          <!-- logo for regular state and mobile devices -->

          <span class="logo-lg"><b>Admin</b></span>

        </a>

        <!-- Header Navbar: style can be found in header.less -->

        <nav class="navbar navbar-static-top" role="navigation">

          <!-- Sidebar toggle button-->

          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

            <span class="sr-only">Toggle navigation</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

          </a>

          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">

              <!-- Messages: style can be found in dropdown.less-->

              <li class="dropdown messages-menu">

              <li class="dropdown messages-menu">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                  <i class="fa fa-envelope-o"></i>

                  <span class="label label-success">4</span>

                </a>

                

              </li>

              <!-- Notifications: style can be found in dropdown.less -->

              

              <!-- Tasks: style can be found in dropdown.less -->

              

              <!-- User Account: style can be found in dropdown.less -->

                  

                <li class="dropdown user user-menu">

                    <!-- Menu Toggle Button -->

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

                        <!-- The user image in the navbar-->

                        <img src="<?php echo base_url();?>assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">

                        <!-- hidden-xs hides the username on small devices so only the image appears. -->

                        <span class="hidden-xs">
                          <?php $session_data=$this->session->userdata('userDetails');
                                $username=ucfirst($session_data->branch_name);
                                print_r($username);
                          ?>      
                        </span>

                    </a>

                    <ul class="dropdown-menu">

                        <!-- The user image in the menu -->

                        <li class="user-header">

                            <img src="<?php echo base_url();?>assets/dist/img/avatar2.png" class="img-circle" alt="User Image">

                            <p><?php print_r($username);?> <small></small>

                            <a href="<?= CUSTOM_BASE_URL .'User/changepassword'?>" class="btn-primary">Change Password</a>
                        </li>

                        <!-- Menu Footer-->

                        <li class="user-footer">

                            <div class="pull-left">
                              <?php
                               if($session_data->branch_name=='Admin') { ?>
                                <a href="<?= CUSTOM_BASE_URL .'User'?>" class="btn btn-default btn-flat">Profile</a>
                              <?php } else { ?> 
                               <a href="" class="btn btn-default btn-flat">Profile</a>
                               <?php } ?>
                            </div>


                            <div class="pull-right">

                                <a href="<?= CUSTOM_BASE_URL;?>login/logout" class="btn btn-default btn-flat">Sign out</a>

                            </div>

                        </li>

                    </ul>

                </li>

                              <!-- Control Sidebar Toggle Button -->

              <li>

<!--                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->

              </li>

            </ul>

          </div>

        </nav>

      </header>    





<aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->

        <section class="sidebar">

          <!-- Sidebar user panel -->

          <div class="user-panel">

            <div class="pull-left image">

              <img src="<?php echo base_url();?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

            </div>

            <div class="pull-left info">

              <p> <?php print_r($username);?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>

            </div>

          </div>

          <!-- search form -->

          <form action="#" method="get" class="sidebar-form">

            <div class="input-group">

              <input type="text" name="q" class="form-control" placeholder="Search...">

              <span class="input-group-btn">

                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>

              </span>

            </div>

          </form>


          <?php 
            $directoryURI = $_SERVER['REQUEST_URI'];
            $path = parse_url($directoryURI, PHP_URL_PATH);
            $components = explode('/', $path);
            $first_part = strtolower($components[2]);

            print_r($first_part);
          ?>

          <!-- /.search form -->

          <!-- sidebar menu: : style can be found in sidebar.less -->

          <ul class="sidebar-menu">

            <li class="<?php if ($first_part=="check_in") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>check_in"><i class="fa fa-book"></i> <span>Check In

            <li class="<?php if ($first_part=="check_out") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>check_out"><i class="fa fa-book"></i> <span>Check Out</span></a></li>

            <li class="<?php if ($first_part=="facility") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>facility"><i class="fa fa-book"></i> <span>Room Facilities</span></a></li>

            <li class="<?php if ($first_part=="room_type") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>room_type"><i class="fa fa-book"></i> <span>Room Types</span></a></li>

            <li class="<?php if ($first_part=="booking_type") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>booking_type"><i class="fa fa-book"></i> <span>Booking Types</span></a></li>

            <?php if(($this->userDetails->role == 'super_admin')) { ?>

            <li class="<?php if ($first_part=="branch") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>branch"><i class="fa fa-book"></i> <span>Branches</span></a></li>

            <?php } ?>

            <li class="<?php if ($first_part=="room") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>room"><i class="fa fa-book"></i> <span>Rooms</span></a></li>

             <li class="<?php if ($first_part=="customer") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>customer"><i class="fa fa-book"></i> <span>Customer</span></a></li>

             <li class="<?php if ($first_part=="service") {echo "active"; } else  {echo "";}?>"><a href="<?php echo base_url();?>service"><i class="fa fa-book"></i> <span>Service</span></a></li>

        <li class="treeview <?php if ($first_part=="cart_orders") {echo "active"; } else  {echo "";}?>">
              <a href="#">
                <i class="fa fa-file-text-o"></i> <span>Accounts</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <li><a href="<?= CUSTOM_BASE_URL;?>daybook"><i class="fa fa-circle-o text-aqua"></i> Daybook</a></li>
              </ul>
          </li>

          <li class="treeview <?php if ($first_part=="cart_orders") {echo "active"; } else  {echo "";}?>">
              <a href="#">
                <i class="fa fa-file-text-o"></i> <span>Report</span> <i class="fa fa-angle-right pull-right"></i>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <li><a href="<?= CUSTOM_BASE_URL;?>reports/checkin"><i class="fa fa-circle-o text-aqua"></i> Checkin</a></li>
                <li><a href="<?= CUSTOM_BASE_URL;?>reports/checkout"><i class="fa fa-circle-o text-aqua"></i> Checkout</a></li>
                 <li><a href="<?= CUSTOM_BASE_URL;?>reports/customers"><i class="fa fa-circle-o text-aqua"></i> Customers</a></li>
                <li><a href="<?= CUSTOM_BASE_URL;?>reports/booking_type"><i class="fa fa-circle-o text-aqua"></i>Booking Type</a></li>
                <li><a href="<?= CUSTOM_BASE_URL;?>reports/day_book"><i class="fa fa-circle-o text-aqua"></i>Day Book</a></li>
              </ul>
          </li>


          </ul>

        </section>

        <!-- /.sidebar -->

      </aside>

