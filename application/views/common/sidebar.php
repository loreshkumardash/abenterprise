<header class="main-header">
    <a href="<?php echo site_url(); ?>" class="logo" style="display:flex; align-items:center;">
        <span class="logo-mini">
            <img src="<?php echo base_url('assets/logo.png'); ?>" alt="AB Logo" style="height:55px;">
        </span>
        <span class="logo-lg" style="display:flex; align-items:center;">
            <img src="<?php echo base_url('assets/logo.png'); ?>" alt="AB Logo" style="height:95px;">
        </span>

    </a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <?php if ($this->session->userdata("usertype") == 'Admin' || $this->session->userdata("usertype") == 'Teacher') { ?>
                    <li>

                    </li>
                <?php } ?>
                <li class="dropdown user user-menu" style="background-color: #fff;">
                    <a href="#" class="sidebar-toggle" data-toggle="dropdown" style="color: #000;">
                        <span
                            class="hidden-xs"><?php echo $this->session->userdata("firstname") . ' ' . $this->session->userdata("lastname"); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
                            <p>
                                <?php echo $this->session->userdata("firstname") . ' ' . $this->session->userdata("lastname"); ?>
                                <small>Last Login on <b><?= $this->session->userdata("last_login_on") ?></b> from
                                    <b><?= $this->session->userdata("last_login_ip") ?></b></small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo site_url("login/logout"); ?>" class="btn btn-default btn-flat">Sign
                                    out</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href=""><i class="fa fa-refresh"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel" style="padding-bottom: 36px;">
            <div class="pull-left info">
                <a href="#"><i class="fa fa-circle text-success"></i>
                    <?php echo $this->session->userdata("session_name"); ?></a>
            </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <li class="<?php echo isset($activemenu) && $activemenu == 'dashboard' ? 'active' : '' ?>"><a
                    href="<?php echo site_url("dashboard"); ?>"><i class="fa fa-dashboard"></i>
                    <span>Dashboard</span></a></li>
            <?php
            if ($this->session->userdata('access_menus')) {
                $accessar = json_decode($this->session->userdata('access_menus'));
            } else {
                $accessar = array();
            }
            ?>
            <?php if (in_array('masterview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                <li class="<?php echo isset($activemenu) && $activemenu == 'masters' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-cubes"></i> <span>Master data</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (in_array('sessionsview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'sessions' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("masters/sessions"); ?>"><i class="fa fa-clock-o"></i> Sessions</a>
                            </li>
                        <?php } ?>

                        <!-- <?php if (in_array('categoryview', $accessar) || $this->session->userdata('usertype') == 'Admin' || $this->session->userdata('usertype') == 'Accounts') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'subcategory' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/subcategory"); ?>"><i class="fa fa-archive"></i>Category</a></li>
                    <?php } ?>

                    <?php if (in_array('accountgroupview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'group' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/group"); ?>"><i class="fa fa-archive"></i>Account Group</a></li>
                    <?php } ?>
                    
                    <?php if (in_array('ledgerview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                        <li class="<?php echo isset($mainmenu) && $mainmenu == 'ledger' ? 'active' : '' ?> treeview">
                            <a href="javascript:;">
                            <i class="fa fa-archive"></i> <span>Ledger</span>
                                <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">

                                <?php if (in_array('ledgeradd', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                                <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'add_ledger' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/add_ledger"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Add New</a></li>
                                <?php } ?>

                                <?php if (in_array('ledgerview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                                <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'list_ledger' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/list_ledger"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> List Ledger</a></li>
                                <?php } ?>

                            </ul>
                        </li>
                        <?php } ?> -->


                        <?php if (in_array('departmentsview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'department' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("masters/department"); ?>"><i class="fa fa-archive"></i> Department
                                    Master</a></li>
                        <?php } ?>

                        <?php if (in_array('designationsview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'designation' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("masters/designation"); ?>"><i class="fa fa-archive"></i>
                                    Designation Master</a></li>
                        <?php } ?>

                        <?php if (in_array('sessionsview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'location' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("masters/location"); ?>"><i class="fa fa-home"></i> Add Property
                                    Locations</a></li>
                        <?php } ?>

                        <?php if (in_array('sessionsview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'uplocation' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("masters/uplocation"); ?>"><i class="fa fa-home"></i> Add Upcoming
                                    Locations</a></li>
                        <?php } ?>

                        <?php if (in_array('leavetypeview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'leavetype' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("masters/leavetype"); ?>"><i class="fa fa-archive"></i> Leave
                                    Type</a></li>
                        <?php } ?>


                        <!-- 
                    
                     <?php if (in_array('itemgroupview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'itemgroup' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/itemgroup"); ?>"><i class="fa fa-archive"></i> Item Group</a></li>
                    <?php } ?>

                    <?php if (in_array('itemsubgroupview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'itemsubgroup' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/itemsubgroup"); ?>"><i class="fa fa-archive"></i> Item Sub Group</a></li>
                    <?php } ?>
                    
                    <?php if (in_array('unitview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'unit' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/unit"); ?>"><i class="fa fa-archive"></i> Unit</a></li>
                    <?php } ?>

                    <?php if (in_array('unitconversionview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'unitconversion' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/unitconversion"); ?>"><i class="fa fa-archive"></i> Unit Conversion</a></li>
                    <?php } ?>

                    <?php if (in_array('itemview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'item' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/item"); ?>"><i class="fa fa-archive"></i> Item</a></li>
                    <?php } ?>
                    
                    <?php if (in_array('billofmaterialview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'billofmaterial' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/billofmaterial"); ?>"><i class="fa fa-archive"></i> Bill of Materials</a></li>
                    <?php } ?>
                    
                    <?php if (in_array('expensetypeview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'expense_types' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/expense_types"); ?>"><i class="fa fa-table"></i> Expense Types</a></li>
                    <?php } ?>

                    <?php if (in_array('expensesubtypeview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'expense_subtypes' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/expense_subtypes"); ?>"><i class="fa fa-table"></i> Expense Sub Types</a></li>
                    <?php } ?>

                    <?php if (in_array('holidayview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'holidays' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/holidays"); ?>"><i class="fa fa-calendar"></i> Holidays</a></li>
                    <?php } ?>
                    
		            <?php if (in_array('commercialtermview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'commercialterm' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/commercialterm"); ?>"><i class="fa fa-archive"></i> Commercial Term</a></li>
                    <?php } ?>
		            
		            <?php if (in_array('documentheadsview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'documentheads' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/documentheads"); ?>"><i class="fa fa-archive"></i> Document Heads</a></li>
                    <?php } ?>

                    <?php if (in_array('documentheadsview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'documentheads' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/documentheads"); ?>"><i class="fa fa-archive"></i> Document Heads</a></li>
                    <?php } ?>

                    <?php if (in_array('transporterview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'transporter' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/transporter"); ?>"><i class="fa fa-archive"></i> Transporter</a></li>
                    <?php } ?>

                    <?php if (in_array('exclusionview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                    <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'exclusion' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/exclusion"); ?>"><i class="fa fa-archive"></i> Exclusion</a></li>
                    <?php } ?>

                    <?php if (in_array('voucherciew', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                        <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'voucher' ? 'active' : '' ?>"><a href="<?php echo site_url("masters/voucher"); ?>"><i class="fa fa-archive"></i>Voucher</a></li>
                    <?php } ?> -->
                    </ul>
                </li>
            <?php } ?>

            <?php if (in_array('empview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                <li class="<?php echo isset($activemenu) && $activemenu == 'employee' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-user"></i> <span>Employee</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (in_array('empadd', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'addemployee' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("employee/addemployee"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Add
                                    Employee</a></li>
                        <?php } ?>

                        <?php if (in_array('empview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'listemployee' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("employee"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> List Employee</a>
                            </li>
                        <?php } ?>

                        <?php if (in_array('empdata', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'empdata' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("employee/empdata"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Employee
                                    Data</a></li>
                        <?php } ?>

                        <?php if (in_array('leave', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'pendingleaves' ? 'active' : '' ?>">
                                <a href="<?php echo site_url("employee/pendingleaves"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Leave
                                    Request</a>
                            </li>
                        <?php } ?>

                        <?php if (in_array('legalAction', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'legalAction' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("employee/legalAction"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Legal
                                    Actions</a></li>
                        <?php } ?>

                        <?php if (in_array('matrix', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'matrix' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("payout/matrix"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Agency Payout</a>
                            </li>
                        <?php } ?>

                        <?php if (in_array('calculate', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'calculate' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("payout"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Employee Payout</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <?php if (in_array('usersview', $accessar) || in_array('menuaccessview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                <li class="<?php echo isset($activemenu) && $activemenu == 'users' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-users"></i> <span>Users</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (in_array('menuaccessadd', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'add_menu_access' ? 'active' : '' ?>">
                                <a href="<?php echo site_url("users/add_menu_access"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Add
                                    Menu Access</a>
                            </li>
                        <?php } ?>
                        <?php if (in_array('menuaccessview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'list_menu_access' ? 'active' : '' ?>">
                                <a href="<?php echo site_url("users/list_menu_access"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> List
                                    Menu Access</a>
                            </li>
                        <?php } ?>
                        <?php if (in_array('usersadd', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'adduser' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("users/adduser"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Add User</a>
                            </li>
                        <?php } ?>
                        <?php if (in_array('usersview', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'listuser' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("users/listuser"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> List User</a>
                            </li>
                        <?php } ?>

                        <?php if (in_array('employeeassign', $accessar) || $this->session->userdata('usertype') == 'Admin') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'trackingaccess' ? 'active' : '' ?>">
                                <a href="<?php echo site_url("users/trackingaccess"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Employee
                                    Assign</a>
                            </li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('usertype') == 'Admin') { ?>

                <li class="<?php echo isset($mainmenu) && $mainmenu == 'lead' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa-regular fa-file-pdf"></i> <span>Lead</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">

                        <li class="<?php echo (isset($submenu) && $submenu == 'add_source') ? ' active' : ''; ?>">
                            <a href="<?php echo site_url("lead/add_source"); ?>" class="nav-link">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Add Source
                            </a>
                        </li>

                        <li class="<?php echo (isset($submenu) && $submenu == 'new_lead') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url("lead/new_lead"); ?>">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Add Single Lead</a>
                        </li>

                        <li class="<?php echo (isset($submenu) && $submenu == 'add_lead') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('lead/add_lead'); ?>">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Add Multiple Lead
                            </a>
                        </li>

                        <li class="<?php echo (isset($submenu) && $submenu == 'lead_assignee') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('lead/lead_assignee'); ?>">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Lead Assignees
                            </a>
                        </li>

                        <li class="<?php echo (isset($submenu) && $submenu == 'listlead') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('lead'); ?>">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>List Lead
                            </a>
                        </li>

                        <!--  <li class="<?php echo (isset($submenu) && $submenu == 'activity') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('lead/counselor_activity'); ?>">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Counselor Activity
                            </a>
                        </li> -->

                        <!-- <li class="<?php echo (isset($submenu) && $submenu == 'lead_conversion') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('lead/lead_conversion'); ?>">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Lead Conversion
                            </a>
                        </li>

                        <li class="<?php echo (isset($submenu) && $submenu == 'leadcancel') ? 'active' : ''; ?>">
                            <a href="<?php echo site_url('lead/leadcancel'); ?>">
                                <i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Lead Cancel
                            </a>
                        </li> -->


                    </ul>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('usertype') == 'Admin') { ?>
                <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'userloginhistory' ? 'active' : '' ?>"><a
                        href="<?php echo site_url("login/userloginhistory"); ?>"><i class="fa fa-history"></i> User Login
                        History</a></li>
            <?php } ?>


            <?php if ($this->session->userdata('usertype') == 'Employee') { ?>

                <li class="<?php echo isset($mainmenu) && $mainmenu == 'leads' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-file-pdf-o"></i> <span>Leads</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">

                        <li class="nav-item">
                            <a href="<?php echo site_url("lead/new_lead"); ?>"
                                class="nav-link <?= $submenu == 'new_lead' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Add Lead</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo site_url("lead/add_lead"); ?>"
                                class="nav-link <?= $submenu == 'multi_lead' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Add Multiple
                                Lead</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo site_url("emp_leads"); ?>"
                                class="nav-link <?= $submenu == 'listleads' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>List Lead</a>
                        </li>

                        <!--  <li class="nav-item">
                            <a href="<?php echo site_url("lead/leadreport"); ?>" class="nav-link <?= $submenu == 'leadreport' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Lead Report</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a href="<?php echo site_url("lead/leadgraph"); ?>" class="nav-link <?= $submenu == 'leadgraph' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Lead graph Report</a>
                        </li> -->

                    </ul>
                </li>
            <?php } ?>

            <?php if (in_array('leadview', $accessar) || $this->session->userdata('usertype') == 'Employee') { ?>
                <li class="<?php echo isset($activemenu) && $activemenu == 'leadreport' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-file-pdf-o"></i><span>Lead Report</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">



                        <?php if (in_array('leadint', $accessar) || $this->session->userdata('usertype') == 'Employee') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'leadinterest' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("leadreport/leadinterest"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Interested</a></li>
                        <?php } ?>

                        <?php if (in_array('leadnotint', $accessar) || $this->session->userdata('usertype') == 'Employee') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'leadnotinterest' ? 'active' : '' ?>">
                                <a href="<?php echo site_url("leadreport/leadnotinterest"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Not interested</a>
                            </li>
                        <?php } ?>

                        <?php if (in_array('callback', $accessar) || $this->session->userdata('usertype') == 'Employee') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'callback' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("leadreport/callback"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Call
                                    Backs</a></li>
                        <?php } ?>

                        <?php if (in_array('calllog', $accessar) || $this->session->userdata('usertype') == 'Employee') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'calllog' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("leadreport/calllog"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Call
                                    Logs</a></li>
                        <?php } ?>


                    </ul>



                </li>
            <?php } ?>


            <?php if (in_array('leadview', $accessar) || $this->session->userdata('usertype') == 'Employee') { ?>

                <li class="<?php echo isset($activemenu) && $activemenu == 'property' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-file-pdf-o"></i><span>Property Lists</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">



                        <?php if (in_array('leadint', $accessar) || $this->session->userdata('usertype') == 'Employee') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'listproperty' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("property/listproperty"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Property Details</a></li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>



            <?php if (in_array('cpadd', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                <li class="<?= isset($activemenu) && $activemenu == 'channelpartner' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-id-card-o"></i> <span>Channel Partner</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (in_array('cpreg', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?= isset($activesubmenu) && $activesubmenu == 'registration' ? 'active' : '' ?>">
                                <a href="<?= site_url("channelpartner/registration"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Registration</a>
                            </li>
                        <?php } ?>



                        <?php if (in_array('cpstatus', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?= isset($activesubmenu) && $activesubmenu == 'approvestatus' ? 'active' : '' ?>">
                                <a href="<?= site_url("channelpartner/approvestatus"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Approval Status</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($this->session->userdata('usertype') == 'Channel Partner') { ?>

                <li class="<?php echo isset($mainmenu) && $mainmenu == 'leads' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-file-pdf-o"></i> <span>Leads</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>

                    <ul class="treeview-menu">

                        <li class="nav-item">
                            <a href="<?php echo site_url("lead/new_lead"); ?>"
                                class="nav-link <?= $submenu == 'new_lead' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Add Lead</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo site_url("lead/add_lead"); ?>"
                                class="nav-link <?= $submenu == 'multi_lead' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Add Multiple
                                Lead</a>
                        </li>

                        <li class="nav-item">
                            <a href="<?php echo site_url("emp_leads"); ?>"
                                class="nav-link <?= $submenu == 'listleads' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>List Lead</a>
                        </li>

                        <!--  <li class="nav-item">
                            <a href="<?php echo site_url("lead/leadreport"); ?>" class="nav-link <?= $submenu == 'leadreport' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Lead Report</a>
                        </li> -->
                        <!-- <li class="nav-item">
                            <a href="<?php echo site_url("lead/leadgraph"); ?>" class="nav-link <?= $submenu == 'leadgraph' ? 'active' : '' ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>Lead graph Report</a>
                        </li> -->

                    </ul>
                </li>
            <?php } ?>





            <?php if (in_array('leadview', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                <li class="<?php echo isset($activemenu) && $activemenu == 'leadreport' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-file-pdf-o"></i><span>Lead Report</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">



                        <?php if (in_array('leadint', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'leadinterest' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("leadreport/leadinterest"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Interested</a></li>
                        <?php } ?>

                        <?php if (in_array('leadnotint', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'leadnotinterest' ? 'active' : '' ?>">
                                <a href="<?php echo site_url("leadreport/leadnotinterest"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Not interested</a>
                            </li>
                        <?php } ?>

                        <?php if (in_array('callback', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'callback' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("leadreport/callback"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Call
                                    Backs</a></li>
                        <?php } ?>

                        <?php if (in_array('calllog', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'calllog' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("leadreport/calllog"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Call
                                    Logs</a></li>
                        <?php } ?>


                    </ul>



                </li>
            <?php } ?>

            <?php if (in_array('leadview', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>

                <li class="<?php echo isset($activemenu) && $activemenu == 'property' ? 'active' : '' ?> treeview">
                    <a href="javascript:;">
                        <i class="fa fa-file-pdf-o"></i><span>Property Lists</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <?php if (in_array('propadd', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'addproperty' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("property/addproperty"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i> Add
                                    Property</a></li>
                        <?php } ?>


                        <?php if (in_array('leadint', $accessar) || $this->session->userdata('usertype') == 'Channel Partner') { ?>
                            <li class="<?php echo isset($activesubmenu) && $activesubmenu == 'listproperty' ? 'active' : '' ?>"><a
                                    href="<?php echo site_url("property/listproperty"); ?>"><i class="fa-regular fa-circle fa-xs" style="margin-right:4px;"></i>
                                    Property Details</a></li>
                        <?php } ?>

                    </ul>
                </li>
            <?php } ?>

        </ul>
    </section>
</aside>