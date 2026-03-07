<?php $this->load->view("common/meta");?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar");?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
            Users
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="row">
        <form role="form" action="<?php echo site_url("users/edit_menu_access/".$access[0]['access_id']);?>" method="post">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Menu Access</h3>
                </div>

                <div class="box-body">
                    <?php
                    if($this->session->flashdata('success')){
                    ?>
                    <div class="alert alert-dismissable alert-success">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
                    </div>
                    <?php
                    }

                    if($this->session->flashdata('error')){
                    ?>
                    <div class="alert alert-dismissable alert-danger">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="access_name">Access Name</label>
                                <input type="text" class="form-control input-sm" id="access_name" value="<?=$access[0]['access_name'];?>" name="access_name" placeholder="Enter Access Name" required="required">
                            </div>
                        </div>
                            <?php $accessar = json_decode($access[0]['access_menus']);?>
                            <div class="col-md-4">
                            <table class="table table-condensed">
                                <tr style="background-color: #e78131;color:black;">
                                    <th style="background-color: #375506;" width="7%"><input type="checkbox" class="checkall"></th>
                                    <th>Access Name </th>
                                    <th><i class="fa fa-eye" title="View"></i></th>
                                    <th><i class="fa fa-plus-square" title="Add"></i></th>
                                    <th><i class="fa fa-edit" title="Edit"></i></th>
                                    <th><i class="fa fa-trash" title="Delete"></i></th>
                                </tr>
                                <tr  style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Master</td>
                                    <td><input value="masterview" id="masterview" name="menu_access[]" type="checkbox" title="View" <?=in_array('masterview', $accessar) ? 'checked="checked"' : '';?>></td>
                                    <td><input value="masteradd" id="masteradd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('masteradd', $accessar) ? 'checked="checked"' : '';?>></td>
                                    <td><input value="masteredit" id="masteredit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('masteredit', $accessar) ? 'checked="checked"' : '';?>></td>
                                    <td><input value="masterdelete" id="masterdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('masterdelete', $accessar) ? 'checked="checked"' : '';?>></td>
                                </tr>
                                <tr  style="background-color: #ddf3ba;">
                                    <th ><input type="checkbox" class="checkall1"></th>
                                    <td>Sessions</td>
                                    <td><input value="sessionsview" id="sessionsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('sessionsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="sessionsadd" id="sessionsadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('sessionsadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="sessionsedit" id="sessionsedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('sessionsedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="sessionsdelete" id="sessionsdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('sessionsdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                               <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Category</td>
                                    <td><input value="categoryview" id="categoryview" name="menu_access[]" type="checkbox" title="View" <?=in_array('categoryview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="categoryadd" id="categoryadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('categoryadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="categoryedit" id="categoryedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('categoryedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="categorydelete" id="categorydelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('categorydelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Account Group</td>
                                    <td><input value="accountgroupview" id="accountgroupview" name="menu_access[]" type="checkbox" title="View" <?=in_array('accountgroupview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="accountgroupadd" id="accountgroupadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('accountgroupadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="accountgroupedit" id="accountgroupedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('accountgroupedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="accountgroupdelete" id="accountgroupdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('accountgroupdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Ledger</td>
                                    <td><input value="ledgerview" id="ledgerview" name="menu_access[]" type="checkbox" title="View" <?=in_array('ledgerview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="ledgeradd" id="ledgeradd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('ledgeradd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="ledgeredit" id="ledgeredit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('ledgeredit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="ledgerdelete" id="ledgerdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('ledgerdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Departments</td>
                                    <td><input value="departmentsview" id="departmentsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('departmentsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="departmentsadd" id="departmentsadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('departmentsadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="departmentsedit" id="departmentsedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('departmentsedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="departmentsdelete" id="departmentsdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('departmentsdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Designation</td>
                                    <td><input value="designationsview" id="designationsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('designationsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="designationsadd" id="designationsadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('designationsadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="designationsedit" id="designationsedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('designationsedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="designationsdelete" id="designationsdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('designationsdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Leave Type</td>
                                    <td><input value="leavetypeview" id="leavetypeview" name="menu_access[]" type="checkbox" title="View" <?=in_array('leavetypeview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="leavetypeadd" id="leavetypeadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('leavetypeadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="leavetypeedit" id="leavetypeedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('leavetypeedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="leavetypedelete" id="leavetypedelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('leavetypedelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Item Group</td>
                                    <td><input value="itemgroupview" id="itemgroupview" name="menu_access[]" type="checkbox" title="View" <?=in_array('itemgroupview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemgroupadd" id="itemgroupadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('itemgroupadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemgroupedit" id="itemgroupedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('itemgroupedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemgroupdelete" id="itemgroupdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('itemgroupdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Item Sub Group</td>
                                    <td><input value="itemsubgroupview" id="itemsubgroupview" name="menu_access[]" type="checkbox" title="View" <?=in_array('itemsubgroupview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemsubgroupadd" id="itemsubgroupadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('itemsubgroupadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemsubgroupedit" id="itemsubgroupedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('itemsubgroupedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemsubgroupdelete" id="itemsubgroupdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('itemsubgroupdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Unit</td>
                                    <td><input value="unitview" id="unitview" name="menu_access[]" type="checkbox" title="View" <?=in_array('unitview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unitadd" id="unitadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('unitadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unitedit" id="unitedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('unitedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unitdelete" id="unitdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('unitdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Unit Conversion</td>
                                    <td><input value="unitconversionview" id="unitconversionview" name="menu_access[]" type="checkbox" title="View" <?=in_array('unitconversionview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unitconversionadd" id="unitconversionadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('unitconversionadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unitconversionedit" id="unitconversionedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('unitconversionedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unitconversiondelete" id="unitconversiondelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('unitconversiondelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Item</td>
                                    <td><input value="itemview" id="itemview" name="menu_access[]" type="checkbox" title="View" <?=in_array('itemview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemadd" id="itemadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('itemadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemedit" id="itemedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('itemedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="itemdelete" id="itemdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('itemdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Bill of Material</td>
                                    <td><input value="billofmaterialview" id="billofmaterialview" name="menu_access[]" type="checkbox" title="View" <?=in_array('billofmaterialview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="billofmaterialadd" id="billofmaterialadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('billofmaterialadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="billofmaterialedit" id="billofmaterialedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('billofmaterialedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="billofmaterialdelete" id="billofmaterialdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('billofmaterialdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Expense Type</td>
                                    <td><input value="expensetypeview" id="expensetypeview" name="menu_access[]" type="checkbox" title="View" <?=in_array('expensetypeview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensetypeadd" id="expensetypeadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('expensetypeadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensetypeedit" id="expensetypeedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('expensetypeedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensetypedelete" id="expensetypedelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('expensetypedelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Expense Sub Type</td>
                                    <td><input value="expensesubtypeview" id="expensesubtypeview" name="menu_access[]" type="checkbox" title="View" <?=in_array('expensesubtypeview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensesubtypeadd" id="expensesubtypeadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('expensesubtypeadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensesubtypeedit" id="expensesubtypeedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('expensesubtypeedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensesubtypedelete" id="expensesubtypedelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('expensesubtypedelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Holidays</td>
                                    <td><input value="holidayview" id="holidayview" name="menu_access[]" type="checkbox" title="View" <?=in_array('holidayview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="holidayadd" id="holidayadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('holidayadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="holidayedit" id="holidayedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('holidayedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="holidaydelete" id="holidaydelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('holidaydelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>

                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-condensed">
                                <tr style="background-color: #e78131;color:black;">
                                    <th style="background-color: #375506;" width="7%"><input type="checkbox" class="checkall"></th>
                                    <th>Access Name </th>
                                    <th><i class="fa fa-eye" title="View"></i></th>
                                    <th><i class="fa fa-plus-square" title="Add"></i></th>
                                    <th><i class="fa fa-edit" title="Edit"></i></th>
                                    <th><i class="fa fa-trash" title="Delete"></i></th>
                                </tr>
                                
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Sale</td>
                                    <td><input value="saleview" id="saleview" name="menu_access[]" type="checkbox" title="View" <?=in_array('saleview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="saleadd" id="saleadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('saleadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="saleedit" id="saleedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('saleedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="saledelete" id="saledelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('saledelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Purchase</td>
                                    <td><input value="purchaseview" id="purchaseview" name="menu_access[]" type="checkbox" title="View" <?=in_array('purchaseview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="purchaseadd" id="purchaseadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('purchaseadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="purchaseedit" id="purchaseedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('purchaseedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="purchasedelete" id="purchasedelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('purchasedelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Unregistered Purchase</td>
                                    <td><input value="unrpurchaseview" id="unrpurchaseview" name="menu_access[]" type="checkbox" title="View" <?=in_array('unrpurchaseview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unrpurchaseadd" id="unrpurchaseadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('unrpurchaseadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unrpurchaseedit" id="unrpurchaseedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('unrpurchaseedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="unrpurchasedelete" id="unrpurchasedelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('unrpurchasedelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Complaints</td>
                                    <td><input value="complaintsview" id="complaintsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('complaintsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="complaintsadd" id="complaintsadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('complaintsadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="complaintsedit" id="complaintsedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('complaintsedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="complaintsdelete" id="complaintsdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('complaintsdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Customer</td>
                                    <td><input value="customerview" id="customerview" name="menu_access[]" type="checkbox" title="View" <?=in_array('customerview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="customeradd" id="customeradd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('customeradd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="customeredit" id="customeredit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('customeredit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="customerdelete" id="customerdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('customerdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Customer Verify</td>
                                    <td><input value="customerverifyview" id="customerview" name="menu_access[]" type="checkbox" title="View" <?=in_array('customerview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Employee</td>
                                    <td><input value="empview" id="empview" name="menu_access[]" type="checkbox" title="View" <?=in_array('empview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="empadd" id="empadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('empadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="empedit" id="empedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('empedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="empdelete" id="empdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('empdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Employee Attendance Report</td>
                                    <td><input value="employeeattenview" id="employeeattenview" name="menu_access[]" type="checkbox" title="View" <?=in_array('employeeattenview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Employee Services</td>
                                    <td><input value="employeerecview" id="employeerecview" name="menu_access[]" type="checkbox" title="View" <?=in_array('employeerecview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Enquiry</td>
                                    <td><input value="enquiryview" id="enquiryview" name="menu_access[]" type="checkbox" title="View" <?=in_array('enquiryview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="enquiryadd" id="enquiryadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('enquiryadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="enquiryedit" id="enquiryedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('enquiryedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="enquirydelete" id="enquirydelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('enquirydelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Purchase Order</td>
                                    <td><input value="purchaseorderview" id="purchaseorderview" name="menu_access[]" type="checkbox" title="View" <?=in_array('purchaseorderview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="purchaseorderadd" id="purchaseorderadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('purchaseorderadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="purchaseorderedit" id="purchaseorderedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('purchaseorderedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="purchaseorderdelete" id="purchaseorderdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('purchaseorderdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Entries</td>
                                    <td><input value="entriesview" id="entriesview" name="menu_access[]" type="checkbox" title="View" <?=in_array('entriesview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="entriesadd" id="entriesadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('entriesadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="entriesedit" id="entriesedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('entriesedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="entriesdelete" id="entriesdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('entriesdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Expenses</td>
                                    <td><input value="expensesview" id="expensesview" name="menu_access[]" type="checkbox" title="View" <?=in_array('expensesview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensesadd" id="expensesadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('expensesadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensesedit" id="expensesedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('expensesedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="expensesdelete" id="expensesdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('expensesdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Expense Requests</td>
                                    <td><input value="expenserequestsview" id="expenserequestsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('expenserequestsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Ledger A/c</td>
                                    <td><input value="ledgeracview" id="ledgeracview" name="menu_access[]" type="checkbox" title="View" <?=in_array('ledgeracview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Messages</td>
                                    <td><input value="messagesview" id="messagesview" name="menu_access[]" type="checkbox" title="View" <?=in_array('messagesview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Payments</td>
                                    <td><input value="paymentsview" id="paymentsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('paymentsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="paymentsadd" id="paymentsadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('paymentsadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="paymentsedit" id="paymentsedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('paymentsedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="paymentsdelete" id="paymentsdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('paymentsdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Salary Advance</td>
                                    <td><input value="saladvview" id="saladvview" name="menu_access[]" type="checkbox" title="View" <?=in_array('saladvview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="saladvadd" id="saladvadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('saladvadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="saladvedit" id="saladvedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('saladvedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="saladvdelete" id="saladvdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('saladvdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Vouchers</td>
                                    <td><input value="voucherview" id="voucherview" name="menu_access[]" type="checkbox" title="View" <?=in_array('voucherview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="voucheradd" id="voucheradd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('voucheradd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="voucheredit" id="voucheredit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('voucheredit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="voucherdelete" id="voucherdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('voucherdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                
                                
                                
                            </table>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-condensed">
                                <tr style="background-color: #e78131;color:black;">
                                    <th style="background-color: #375506;" width="7%"><input type="checkbox" class="checkall"></th>
                                    <th>Access Name </th>
                                    <th><i class="fa fa-eye" title="View"></i></th>
                                    <th><i class="fa fa-plus-square" title="Add"></i></th>
                                    <th><i class="fa fa-edit" title="Edit"></i></th>
                                    <th><i class="fa fa-trash" title="Delete"></i></th>
                                </tr>
                                
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Release Salary</td>
                                    <td><input value="relsalview" id="relsalview" name="menu_access[]" type="checkbox" title="View" <?=in_array('relsalview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="relsaladd" id="relsaladd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('relsaladd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="relsaledit" id="relsaledit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('relsaledit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="relsaldelete" id="relsaldelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('relsaldelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Projects</td>
                                    <td><input value="projectsview" id="projectsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('projectsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="projectsadd" id="projectsadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('projectsadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="projectsedit" id="projectsedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('projectsedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="projectsdelete" id="projectsdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('projectsdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Tasks</td>
                                    <td><input value="tasksview" id="tasksview" name="menu_access[]" type="checkbox" title="View" <?=in_array('tasksview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="tasksadd" id="tasksadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('tasksadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="tasksedit" id="tasksedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('tasksedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="tasksdelete" id="tasksdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('tasksdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Notices</td>
                                    <td><input value="noticeview" id="noticeview" name="menu_access[]" type="checkbox" title="View" <?=in_array('noticeview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="noticeadd" id="noticeadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('noticeadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="noticeedit" id="noticeedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('noticeedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="noticedelete" id="noticedelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('noticedelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>

                                
                                                                
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Leaves</td>
                                    <td><input value="leaveview" id="leaveview" name="menu_access[]" type="checkbox" title="View" <?=in_array('leaveview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="leaveadd" id="leaveadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('leaveadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="leaveedit" id="leaveedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('leaveedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="leavedelete" id="leavedelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('leavedelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                 <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Quotation</td>
                                    <td><input value="quotationview" id="quotationview" name="menu_access[]" type="checkbox" title="View" <?=in_array('quotationview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="quotationadd" id="quotationadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('quotationadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="quotationedit" id="quotationedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('quotationedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="quotationdelete" id="quotationdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('quotationdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Supplier</td>
                                    <td><input value="supplierview" id="supplierview" name="menu_access[]" type="checkbox" title="View" <?=in_array('supplierview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="supplieradd" id="supplieradd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('supplieradd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="supplieredit" id="supplieredit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('supplieredit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="supplierdelete" id="supplierdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('supplierdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Supplier Verify</td>
                                    <td><input value="supplierverifyview" id="supplierverifyview" name="menu_access[]" type="checkbox" title="View" <?=in_array('supplierverifyview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Reports</td>
                                    <td><input value="reportsview" id="reportsview" name="menu_access[]" type="checkbox" title="View" <?=in_array('reportsview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>

                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Leave Statement</td>
                                    <td><input value="leavestatementview" id="leavestatementview" name="menu_access[]" type="checkbox" title="View" <?=in_array('leavestatementview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Expenses Report</td>
                                    <td><input value="expenseseportview" id="expenseseportview" name="menu_access[]" type="checkbox" title="View" <?=in_array('expenseseportview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Profit & Loss</td>
                                    <td><input value="profitandlossview" id="profitandlossview" name="menu_access[]" type="checkbox" title="View" <?=in_array('profitandlossview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Balance Sheet</td>
                                    <td><input value="balancesheetview" id="balancesheetview" name="menu_access[]" type="checkbox" title="View" <?=in_array('balancesheetview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Trial Balance</td>
                                    <td><input value="trialbalanceview" id="trialbalanceview" name="menu_access[]" type="checkbox" title="View" <?=in_array('trialbalanceview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Salary Slip</td>
                                    <td><input value="salaryslipclientview" id="salaryslipclientview" name="menu_access[]" type="checkbox" title="View" <?=in_array('salaryslipclientview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                               <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Expense Report</td>
                                    <td><input value="expensesreportview" id="expensesreportview" name="menu_access[]" type="checkbox" title="View" <?=in_array('usersdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Menu Access</td>
                                    <td><input value="menuaccessview" id="menuaccessview" name="menu_access[]" type="checkbox" title="View" <?=in_array('menuaccessview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="menuaccessadd" id="menuaccessadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('menuaccessadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="menuaccessedit" id="menuaccessedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('menuaccessedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="menuaccessdelete" id="menuaccessdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('menuaccessdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Users</td>
                                    <td><input value="usersview" id="usersview" name="menu_access[]" type="checkbox" title="View" <?=in_array('usersview', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="usersadd" id="usersadd" name="menu_access[]" type="checkbox" title="Add" <?=in_array('usersadd', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="usersedit" id="usersedit" name="menu_access[]" type="checkbox" title="Edit" <?=in_array('usersedit', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td><input value="usersdelete" id="usersdelete" name="menu_access[]" type="checkbox" title="Delete" <?=in_array('usersdelete', $accessar) ? 'checked="checked"' : '';?> ></td>
                                </tr>
                               
                               <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Attendance</td>
                                    <td><input value="attendance" id="attendance" name="menu_access[]" type="checkbox" title="View" <?=in_array('attendance', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                
                                <tr style="background-color: #ddf3ba;">
                                    <th><input type="checkbox" class="checkall1"></th>
                                    <td>Employee Assign</td>
                                    <td><input value="employeeassign" id="employeeassign" name="menu_access[]" type="checkbox" title="View" <?=in_array('employeeassign', $accessar) ? 'checked="checked"' : '';?> ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                             
				
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" name="submitBtn" value="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
<script type="text/javascript">
    $(".checkall").change(function(e){
        e.preventDefault();
        if($(this).prop("checked") == true){
            $(this).closest("table").find('input[type=checkbox]').each(function() { this.checked = true; });
        }else{
            $(this).closest("table").find('input[type=checkbox]').each(function() { this.checked = false; });
        }
    });
    $(".checkall1").change(function(e){
        e.preventDefault();
        if($(this).prop("checked") == true){
            $(this).closest("tr").find('input[type=checkbox]').each(function() { this.checked = true; });
        }else{
            $(this).closest("tr").find('input[type=checkbox]').each(function() { this.checked = false; });
        }
    });
</script>
</body>
</html>

