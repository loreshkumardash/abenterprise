<table id="" class="table table-bordered table-condensed table-striped">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Joining Dt.</th>
                                    <th>Date of Birth</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                  <th>Last edited by</th>
                                </tr>
                                <?php if($records){ for($i=0;$i<count($records);$i++){?>
                                <tr>
                                    <td>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn bg-maroon btn-flat btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="width:100%"><?php echo $records[$i]['techno_emp_id'];?>&nbsp;<span class="fa fa-caret-down float-right"></span></button>
                                            <ul class="dropdown-menu">
                                                <?php if(in_array('empprofileview', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                                <li><a href="<?php echo site_url("employee/viewemployee/".$records[$i]['employee_id']);?>">View</a></li>
                                                <?php }?>
                                                <?php if(in_array('empedit', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                                <li><a href="<?php echo site_url("employee/editemployee/".$records[$i]['employee_id']);?>">Edit</a></li>
                                                <li><a href="<?php echo site_url("employee/bankandkyc/".$records[$i]['employee_id']);?>" >Bank & KYC Details</a></li>
                                                <li><a href="<?php echo site_url("employee/pfandesi/".$records[$i]['employee_id']);?>" >PF & ESI Settings</a></li>
                                                <?php } ?>
                                              <li class="divider"></li>
                                              
                                                <?php if(in_array('empdelete', $accessar) || $this->session->userdata('usertype') == 'Admin'){ ?>
                                                
                                                <li><a href="<?php echo site_url("employee/deleteemployee/".$records[$i]['employee_id']);?>" onclick="return confirm('Are you sure to delete this?');">Delete</a></li>
                                                <?php }?>
            
            
                                            </ul>
                                            
                                            <?php if ($records[$i]['emp_status']=='Active') {
                                                $ocolor = '#52be80';
                                            }else if ($records[$i]['emp_status']=='Deactive') {
                                                $ocolor = '#ec7063';
                                            }else if ($records[$i]['emp_status']=='Leave') {
                                                $ocolor = '#48c9b0';
                                            }else if ($records[$i]['emp_status']=='Block') {
                                                $ocolor = '#34495e';
                                            }   
                                            ?>
                                            <input type="hidden" class="employee_id" value="<?=$records[$i]['employee_id'];?>">
                                            <select class="empstatus form-control input-sm" style="background-color:<?=$ocolor;?>;color:white;">
                                                <option value="Active" style="background-color:#52be80;color: white;" <?=$records[$i]['emp_status']=='Active'?'selected':'';?>>Active</option>
                                                <option value="Deactive" style="background-color: #ec7063;color: white;" <?=$records[$i]['emp_status']=='Deactive'?'selected':'';?>>Deactive</option>
                                                <option value="Leave" style="background-color: #48c9b0;color: white;" <?=$records[$i]['emp_status']=='Leave'?'selected':'';?>>Leave</option>
                                                <option value="Block" style="background-color: #34495e;color: white;" <?=$records[$i]['emp_status']=='Block'?'selected':'';?>>Block</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <ul class="products-list product-list-in-box">
                                        <li class="item" style="padding:0px;">
                                            <div class="product-img">
                                                <a href="<?php echo site_url("employee/viewemployee/".$records[$i]['employee_id']);?>">
                                                <?php 
                                                if($records[$i]['emp_photo'] != ''){
                                                ?>
                                                <img src="<?=base_url();?>uploads/employeeicon/<?=$records[$i]['emp_photo']?>" style="width:50px; height:50px;">
                                                <?php
                                                }else{
                                                ?>
                                                <img src="<?=base_url()?>assets/usericon.png" style="width:50px; height:50px;">
                                                <?php
                                                }
                                                ?>
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <a href="<?php echo site_url("employee/viewemployee/".$records[$i]['employee_id']);?>" class="product-title"><?php echo $records[$i]['employee_name'];?></a>
                                                <!--<span class="label label-warning pull-right">$1800</span></a>-->
                                                <span class="product-description">
                                                Department - <?php echo $records[$i]['department_name'];?>
                                                </span>
                                                <span class="product-description">Aadhaar : <?php echo $records[$i]['kyc_adharno'];?></span>
                                            </div>
                                        </li>
                                    </td>
                                    
                                    <td>
                                        <?php echo $records[$i]['emp_mobile'];?><br/>
                                        <?php echo $records[$i]['employee_mobile2'];?>
                                    </td>
                                    <td><?php echo $records[$i]['emp_doj'] != '' && $records[$i]['emp_doj'] != '0000-00-00' ? date("d/m/Y", strtotime($records[$i]['emp_doj'])) : '';?></td>
                                    <td><?php echo $records[$i]['emp_dob'] != '' && $records[$i]['emp_dob'] != '0000-00-00' ? date("d/m/Y", strtotime($records[$i]['emp_dob'])) : '';?></td>
                                    <td><?php echo 'AT: '.$records[$i]['emp_at'];?> <?php echo '<br>PO: '.$records[$i]['emp_po'];?></td>
                                    <td><?php echo $records[$i]['emp_status'];?></td>
                                  <td><?php echo isset($records[$i]['last_edit_by'])?$records[$i]['last_edit_by']:'';?><br><?php echo isset($records[$i]['last_edit_on'])?date("d-M-Y h:i:s",strtotime($records[$i]['last_edit_on'])):'';?> </td>
                                </tr>
                                <?php }} ?>
                            </table>
                  <?php echo $this->ajax_pagination->create_links(); ?>

