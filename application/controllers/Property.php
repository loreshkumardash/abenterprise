<?php 
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Property extends CI_Controller {

	public function __construct(){
		parent::__construct();
		is_logged_in();
		date_default_timezone_set("Asia/Kolkata"); 
		$this->present_date 		= date('Y-m-d');
		$this->present_time 		= date('H:i:a');
		$this->timestamp 		= date('Y-m-d H:i:s'); 
	}


  public function addProperty() {
        $data = array();

        if($this->input->post('submitBtn')) {

            // Form validation rules
            $this->form_validation->set_rules('prop_name', 'Property Name', 'required');
            
            $this->form_validation->set_rules('price', 'Price', 'required');
            
            $this->form_validation->set_rules('size', 'Size', 'required|numeric');
             
            $this->form_validation->set_rules('prop_type', 'Type', 'required');

            $this->form_validation->set_rules('p_status', 'Project Status', 'required');
           

            $this->form_validation->set_error_delimiters('<span><label>', '</label></span>');

            if($this->form_validation->run()) {
                // Property data to insert into property table
                $data_list = array(
                    'prop_name'   => $this->input->post('prop_name'),
                    'description' => $this->input->post('description'),
                    'price'       => $this->input->post('price'),
                    'config'      => $this->input->post('config'),
                    'size'        => $this->input->post('size'),
                    'address'     => $this->input->post('address'),
                    'location'     => $this->input->post('location'),
                    'prop_type'   => $this->input->post('prop_type'),
                    'prop_sub_type'   => $this->input->post('prop_sub_type'),
                    'facilities'  => $this->input->post('facilities'),
                    'map_location'=> $this->input->post('maploc'),
                    'prop_doc'=> $this->input->post('prop_doc'),
                    'link'=> $this->input->post('link'),
                    'proj_head'=> $this->input->post('proj_head'),
                    'avail_status'=> 'available',  // Default status
                    'listedby' => $this->session->userdata("usertype"),
                    'p_status' => $this->input->post('p_status')
                );

            // Handle document upload
            if (!empty($_FILES['prop_doc']['name'])) {
                $config['upload_path']   = 'uploads/docfiles/';
                $config['allowed_types'] = 'pdf|doc|docx|txt';
                $config['file_name']     = 'DOCUMENT_' . date("Ymd") . '_' . time();
                $config['max_size']      = '10240';    //max : 10 mb
                $this->upload->initialize($config);
                if ($this->upload->do_upload('prop_doc')) {
                    $uploadData = $this->upload->data();
                    $data_list['prop_doc'] = $uploadData['file_name'];
                } else {
                    log_message('error', 'project document upload error: ' . $this->upload->display_errors());
                }
            }

                // Insert property details into property table
                $pid = $this->Common_Model->dbinsertid("property", $data_list);

                // Handle Property Images Upload
                if(!empty($_FILES['prop_img']['name'][0])) {
                    $prop_img_names = $this->input->post('prop_img_names');
                    $this->handleFileUpload('prop_img', 'property_image', $pid, 
                        $prop_img_names);
                }

                // Handle Floor Plan Images Upload
                if(!empty($_FILES['plan_imgs']['name'][0])) {
                    $plan_img_names = $this->input->post('plan_img_names');
                    $this->handleFileUpload('plan_imgs', 'floor_plan', $pid, $plan_img_names);
                }

                // Redirect with success message
                $this->session->set_flashdata('success', 'Property added successfully');
                redirect($this->input->server('HTTP_REFERER'));
            } else {
                $this->session->set_flashdata('error', validation_errors());
            }
        }

         $data['employee'] = $employee = $this->Common_Model->FetchData("users", "*", "usertype = 'Employee'", "", "user_id ASC");
         $data['locate'] = $locate = $this->Common_Model->FetchData("location", "*");
        // Load view with active menu data
        $data['activemenu'] = 'property';
        $data['activesubmenu'] = 'addproperty';
        $this->load->view('property/addproperty', $data);
    }

    private function handleFileUpload($input_name, $image_type, $pid, $image_names = []) {
        $config['upload_path'] = 'uploads/photos/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['file_name'] = $image_type . '_' . date("Ymd") . '_' . time();
        $config['max_size'] = 10240;  // 10MB max size

        // Initialize upload library
        $this->upload->initialize($config);

        $files = $_FILES[$input_name];
        $file_count = count($files['name']);

        for ($i = 0; $i < $file_count; $i++) {
            $_FILES['file']['name'] = $files['name'][$i];
            $_FILES['file']['type'] = $files['type'][$i];
            $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
            $_FILES['file']['error'] = $files['error'][$i];
            $_FILES['file']['size'] = $files['size'][$i];

            // Upload file
            if($this->upload->do_upload('file')) {
                $uploadData = $this->upload->data();
                $imageData = array(
                    'pid'        => $pid,
                    'image_type' => $image_type,  // 'property_image' or 'floor_plan'
                    // Store the image name
                    'image_name' => !empty($image_names[$i]) ? $image_names[$i] : NULL, 
                    'images'     => $uploadData['file_name'],
                    'dateadded'  => date("Y-m-d")
                );

                // Insert image data into the appropriate table
                $this->Common_Model->dbinsertid("property_images", $imageData);
            } else {
                // Handle error
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect($this->input->server('HTTP_REFERER'));
            }
        }
    }

    public function editproperty($pid) {
        if($this->input->post()) {
                // Property data to update into property table
                $data_list = array(
                    'prop_name'   => $this->input->post('prop_name'),
                    'description' => $this->input->post('description'),
                    'price'       => $this->input->post('price'),
                    'config'      => $this->input->post('config'),
                    'size'        => $this->input->post('size'),
                    'address'     => $this->input->post('address'),
                     'location'     => $this->input->post('location'),
                     'prop_type'   => $this->input->post('prop_type'),
                     'prop_sub_type'   => $this->input->post('prop_sub_type'),
                    'facilities'  => $this->input->post('facilities'),
                    'map_location'=> $this->input->post('maploc'),
                     
                    'link'=> $this->input->post('link'),
                    'proj_head'=> $this->input->post('proj_head'),
                     'p_status'=> $this->input->post('p_status'),
                     'assigne_to' => implode(",", $this->input->post('assigne_to'))
                    // 'listedby' => $this->session->userdata("usertype")
                );

                // Handle Property Images Upload
                if(!empty($_FILES['prop_img']['name'][0])) {
                    $prop_img_names = $this->input->post('prop_img_names');
                    $this->handleFileUpload('prop_img', 'property_image', $pid, 
                        $prop_img_names);
                }

                // Handle Floor Plan Images Upload
                if(!empty($_FILES['plan_imgs']['name'][0])) {
                    $plan_img_names = $this->input->post('plan_img_names');
                    $this->handleFileUpload('plan_imgs', 'floor_plan', $pid, $plan_img_names);
                }

              // Handle document upload
            if (!empty($_FILES['prop_doc']['name'])) {
                $config['upload_path']   = 'uploads/docfiles/';
                $config['allowed_types'] = 'pdf|doc|docx|txt';
                $config['file_name']     = 'DOCUMENT_' . date("Ymd") . '_' . time();
                $config['max_size']      = '10240';    //max : 10 mb
                $this->upload->initialize($config);
                if ($this->upload->do_upload('prop_doc')) {
                    $uploadData = $this->upload->data();
                    $data_list['prop_doc'] = $uploadData['file_name'];
                } else {
                    log_message('error', 'project document upload error: ' . $this->upload->display_errors());
                }
            }  

            $this->Common_Model->update_records("property","pid", $pid, $data_list); 
            $this->session->set_flashdata('success', 'Property Updated successfully');
               redirect($this->input->server('HTTP_REFERER'));  

            }
            $data['props'] = $this->Common_Model->FetchData("property","*","pid= '$pid'");
            $data['employee'] = $this->Common_Model->FetchData("users", "*", "1 ORDER BY user_id ASC");
             $data['locate'] = $locate = $this->Common_Model->FetchData("location", "*");
        $data['activemenu'] = 'property';
        $data['activesubmenu'] = 'listproperty';
        $this->load->view('property/editproperty', $data);
    }

   public function viewproperty($pid = 0) { 
            $data = array();
            $data['accessar'] = json_decode($this->session->userdata('access_menus'));

            // Fetch property details with activity
           $sSql = "SELECT 
                    p.*,
                    u.user_id,
                    u.firstname, 
                    u.lastname,
                    u.userphone,
                    l.location
                FROM property p
                LEFT JOIN users u ON p.proj_head = u.user_id 
                
                LEFT JOIN location l ON p.location = l.lid
                WHERE p.pid = $pid";
            
            $property = $this->Common_Model->db_query($sSql);
            $data['record'] = $property[0] ?? []; // Fetch single property

            if (!empty($data['record'])) {
                $pid = $data['record']['pid'];

                // Get floor plans
                $floor_plan_sql = "SELECT * FROM property_images WHERE pid = $pid AND image_type = 'floor_plan'";
                $data['floor_plans'] = $this->Common_Model->db_query($floor_plan_sql);

                // Get property images
                $property_images_sql = "SELECT * FROM property_images WHERE pid = $pid AND image_type = 'property_image'";
                $data['images'] = $this->Common_Model->db_query($property_images_sql);
            }

            $data['mainmenu'] = 'property';
            $data['submenu'] = 'listproperty';
            $this->load->view('property/viewproperty', $data);
        }



    public function listproperty() { 
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 20;
        $data['page'] = $page = $this->input->get('page') ?? 1;

        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = "";
        $cond = "p_status = 'Live'"; // Base condition

        // Fetch Locations
        $data['locate'] = $this->Common_Model->FetchData("location", "*");

        // Retrieve filter inputs
        $loc_id = $this->input->get('location');
        $prop_type = $this->input->get('prop_type');
        $prop_name = $this->input->get('prop_name');

        // Apply filters
        if (!empty($loc_id)) {
            $cond .= " AND p.location = " . $this->db->escape($loc_id);
            $queryvars .= "&location=" . urlencode($loc_id);
        }
        if (!empty($prop_type)) {
            $cond .= " AND p.prop_type = " . $this->db->escape($prop_type);
            $queryvars .= "&prop_type=" . urlencode($prop_type);
        }
        if (!empty($prop_name)) {
            $cond .= " AND p.prop_name LIKE " . $this->db->escape("%$prop_name%");
            $queryvars .= "&prop_name=" . urlencode($prop_name);
        }

        // Count total records
        $countSql = "SELECT COUNT(*) as num FROM property p WHERE $cond";
        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords > 0) {
            $this->load->library("Paginator");
            $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $per_page; // Fix for LIMIT

            // Fetch paginated property records
            $sSql = "SELECT 
                        p.*,
                        u.user_id,
                        u.firstname, u.lastname, 
                        u2.firstname as assign_fname, u2.lastname as assign_lname,
                        u.userphone,
                        l.location
                     FROM property p
                     LEFT JOIN users u ON p.proj_head = u.user_id 
                     LEFT JOIN users u2 ON p.assigne_to = u2.user_id
                     LEFT JOIN location l ON p.location = l.lid
                     WHERE $cond 
                     ORDER BY p.prop_name ASC
                     LIMIT $range1, $range2";

            $records = $this->Common_Model->db_query($sSql);

            // Setup pagination
            $queryvars = "per_page=$per_page" . $queryvars;
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $data['sPages'] = $paging_info[1];
            $data['record'] = $records;
            $data['norecords'] = false;
        } else {
            $data['record'] = [];
            $data['norecords'] = true;
        }

        // View parameters
        $data['activemenu'] = 'property';
        $data['activesubmenu'] = 'listproperty';
        $this->load->view('property/listproperty', $data);
    }
 
   

   
 

     public function update_status($pid) {
        // Check if the property exists
        $current_status = $this->db->select('avail_status')
                                    ->from('property')
                                    ->where('pid', $pid)
                                    ->get()
                                    ->row_array(); // Get result as an associative array
        
        if ($current_status) {
            // Get the current avail_status
            $new_status = ($current_status['avail_status'] == 'available') ? 'sold' : 'available';
            
            // Update the status in the database
            $this->db->where('pid', $pid);
            $this->db->update('property', ['avail_status' => $new_status]);

            // Set a success message based on the new status
            $status_message = ($new_status == 'sold') ? 'Property marked as Sold.' : 'Property marked as Available.';
            $this->session->set_flashdata('success', $status_message);
        } else {
            $this->session->set_flashdata('error', 'Property not found.');
        }
        
        redirect($this->input->server('HTTP_REFERER'));
    }

    public function upcomingproperty() { 
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 10;
        $data['page'] = $page = $this->input->get('page') ?? 1;

        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = "";
        $cond = "p_status = 'Upcoming'"; // Base condition

        // Fetch Locations
        $data['locate'] = $this->Common_Model->FetchData("location", "*");

        // Retrieve filter inputs
        $loc_id = $this->input->get('location');
        $prop_type = $this->input->get('prop_type');
        $prop_name = $this->input->get('prop_name');

        // Apply filters
        if (!empty($loc_id)) {
            $cond .= " AND p.location = " . $this->db->escape($loc_id);
            $queryvars .= "&location=" . urlencode($loc_id);
        }
        if (!empty($prop_type)) {
            $cond .= " AND p.prop_type = " . $this->db->escape($prop_type);
            $queryvars .= "&prop_type=" . urlencode($prop_type);
        }
        if (!empty($prop_name)) {
            $cond .= " AND p.prop_name LIKE " . $this->db->escape("%$prop_name%");
            $queryvars .= "&prop_name=" . urlencode($prop_name);
        }

        // Count total records
        $countSql = "SELECT COUNT(*) as num FROM property p WHERE $cond";
        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords > 0) {
            $this->load->library("Paginator");
            $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $per_page; // Fix for LIMIT

            // Fetch paginated property records
            $sSql = "SELECT 
                        p.*,
                        u.user_id,
                        u.firstname, u.lastname, 
                        u2.firstname as assign_fname, u2.lastname as assign_lname,
                        u.userphone,
                        l.location
                     FROM property p
                     LEFT JOIN users u ON p.proj_head = u.user_id 
                     LEFT JOIN users u2 ON p.assigne_to = u2.user_id
                     LEFT JOIN location l ON p.location = l.lid
                     WHERE $cond 
                     ORDER BY p.prop_name ASC
                     LIMIT $range1, $range2";

            $records = $this->Common_Model->db_query($sSql);

            // Setup pagination
            $queryvars = "per_page=$per_page" . $queryvars;
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $data['sPages'] = $paging_info[1];
            $data['record'] = $records;
            $data['norecords'] = false;
        } else {
            $data['record'] = [];
            $data['norecords'] = true;
        }

        // View parameters
        $data['activemenu'] = 'property';
        $data['activesubmenu'] = 'upcomingproperty';
        $this->load->view('property/upcomingproperty', $data);
    }

    // public function propertyassigne() {

    //     $data = array();
    //     $data['accessar'] = json_decode($this->session->userdata('access_menus'));

    //     $data['user'] = $user = $this->Common_Model->FetchData("users","*","usertype = 'Employee'");
    //     $data['locate'] = $this->Common_Model->FetchData("location", "*");
    //     //print_r($employee);exit;
        

    //     $sql = "SELECT 
    //          p.*,
    //          u.user_id,
    //          u.firstname,
    //          u.lastname,
    //          u.userphone,
    //          l.location
    //      FROM property p
    //      LEFT JOIN users u 
    //          ON p.proj_head = u.user_id 
    //          LEFT JOIN location l ON p.location = l.lid
    //          ORDER BY pid DESC";

    //     $data['records'] = $this->Common_Model->db_query($sql);     

    //     //$data['records'] = $this->Common_Model->FetchData("property","*","1 ORDER BY pid DESC");

    //     if ($this->input->post('submitBtn')) {
    //     $user_id = $this->input->post('assignees');
    //     $selected_leads = $this->input->post('check');
        

    //     if (!empty($user_id) && !empty($selected_leads)) {
    //         $update_success = true;

    //         foreach ($selected_leads as $p_id) {
    //             $assigne = $this->Common_Model->FetchData("property", "assigne_to", 
    //                 "pid = $p_id");
    //             if($assigne)  {
    //               $user_id = $assigne . "," . $user_id;
    //               $userArray = explode(",", $user_id);
    //               $userArray = array_unique($userArray); // Remove duplicate user IDs
    //               $userArray = array_values($userArray); // Reindex array
    //               $user_id = implode(",", $userArray);
    //             }
    
    //             $result = $this->Common_Model->update_records('property',"pid",
    //                 $p_id,array('assigne_to'=>$user_id));
                
    //         }

    //             $this->session->set_flashdata('success', 'Leads successfully assigned to the Employee.');
            
    //     } else {

    //         $this->session->set_flashdata('error', 'Please select a employee and at least one lead.');
    //     }

    //     redirect('property/propertyassigne');
    //     }

    //     if ($this->input->post('deleteBtn')) {
    //         $selected_leads = $this->input->post('check');
    //         foreach ($selected_leads as $p_id) {
    
    //             $result = $this->Common_Model->DelData('property',"pid=".$p_id);
                
    //         }

    //             $this->session->set_flashdata('success', 'Property deleted successfully.');
    //           redirect($_SERVER['HTTP_REFERER']); 
    //     }

    //     $data['activemenu'] = 'property';
    //     $data['activesubmenu'] = 'propertyassigne';
    //     $this->load->view('property/propertyassigne', $data);
    // }
    
     public function propertyassigne() {
        $data = array();
        $data['accessar'] = json_decode($this->session->userdata('access_menus'));
        $data['per_page'] = $per_page = $this->input->get('per_page') ?? 50;
        $data['page'] = $page = $this->input->get('page') ?? 1;

        $this->load->helper('url');
        $currentURL = current_url();
        $queryvars = "";
        $cond = "1"; // Base condition

        // Fetch Users & Locations
       $data['user'] = $this->Common_Model->FetchData("users", "*", "1 ORDER BY user_id ASC");
        $data['locate'] = $this->Common_Model->FetchData("location", "*");
        
        // Retrieve filter inputs
        $loc_id = $this->input->get('location');
        $prop_type = $this->input->get('prop_type');
        $prop_name = $this->input->get('prop_name');
        //echo "<pre>";print_r([$loc_id, $prop_type, $prop_name]);exit;

        // Apply filters
        if (!empty($loc_id)) {
            $cond .= " AND p.location = " . $this->db->escape($loc_id);
            $queryvars .= "&location=" . urlencode($loc_id);
        }
        if (!empty($prop_type)) {
            $cond .= " AND p.prop_type = " . $this->db->escape($prop_type);
            $queryvars .= "&prop_type=" . urlencode($prop_type);
        }
        if (!empty($prop_name)) {
            $cond .= " AND p.prop_name LIKE " . $this->db->escape("%$prop_name%");
            $queryvars .= "&prop_name=" . urlencode($prop_name);
        }

        // Count total records for pagination
        $countSql = "SELECT COUNT(*) as num FROM property p WHERE $cond";
        $records = $this->Common_Model->db_query($countSql);
        $totalrecords = $records[0]['num'] ?? 0;

        if ($totalrecords > 0) {
            $this->load->library("Paginator");
            $this->paginator->setparam(["page_num" => $page, "num_rows" => $totalrecords]);
            $this->paginator->set_Limit($per_page);
            $range1 = $this->paginator->getRange1();
            $range2 = $per_page; // Fix for LIMIT
 
            // Fetch paginated property records
            $sql = "SELECT 
                        p.*,
                        u.user_id,
                        u.firstname,
                        u.lastname,
                        u.userphone,
                        l.location
                    FROM property p
                    LEFT JOIN users u ON p.proj_head = u.user_id 
                    LEFT JOIN location l ON p.location = l.lid
                    WHERE $cond
                    ORDER BY p.prop_name ASC
                    LIMIT $range1, $range2";

            $data['records'] = $this->Common_Model->db_query($sql);

            // Setup pagination
            $queryvars = "per_page=$per_page" . $queryvars;
            $paging_info = $this->paginator->DBPagingNav($queryvars, $currentURL, $totalrecords, $per_page);
            $data['sPages'] = $paging_info[1];
        } else {
            $data['records'] = [];
            $data['sPages'] = "";
        }

        // Assign Property to Employee

        if ($this->input->post('submitBtn')) {
            $user_id = $this->input->post('assignees');
            $selected_leads = $this->input->post('check');

            if (!empty($user_id) && !empty($selected_leads)) {
                foreach ($selected_leads as $p_id) {
                    $assigne = $this->Common_Model->FetchData("property", "assigne_to", "pid = " . $this->db->escape($p_id));
                    if (!empty($assigne)) {
                        $user_id = $assigne . "," . $user_id;
                        $userArray = array_unique(explode(",", $user_id)); 
                        $user_id = implode(",", $userArray);
                    }
                    $this->Common_Model->update_records('property', "pid", $p_id, ['assigne_to' => $user_id]);
                }
                $this->session->set_flashdata('success', 'Leads successfully assigned to the Employee.');
            } else {
                $this->session->set_flashdata('error', 'Please select an employee and at least one lead.');
            }
            redirect('property/propertyassigne');
        }

        // Delete Property
        if ($this->input->post('deleteBtn')) {
            $selected_leads = $this->input->post('check');
            if (!empty($selected_leads)) {
                foreach ($selected_leads as $p_id) {
                    $this->Common_Model->DelData('property', "pid = " . $this->db->escape($p_id));
                }
                $this->session->set_flashdata('success', 'Property deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Please select at least one property to delete.');
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
        
        // Revoke Property Assignment
            if ($this->input->post('revokeBtn')) {
                $user_id = $this->input->post('assignees');  // The user to revoke
                $selected_leads = $this->input->post('check');

                if (!empty($user_id) && !empty($selected_leads)) {
                    foreach ($selected_leads as $p_id) {
                        $assigne = $this->Common_Model->FetchData("property", "assigne_to", "pid = " . $this->db->escape($p_id));

                        if (!empty($assigne)) {
                            // Convert string of assigned users into an array
                            $userArray = array_unique(explode(",", $assigne));

                            // Remove the user from the list
                            $userArray = array_diff($userArray, [$user_id]);

                            // Update the `assigne_to` column
                            $updated_users = implode(",", $userArray);

                            $this->Common_Model->update_records('property', "pid", $p_id, ['assigne_to' => $updated_users]);
                        }
                    }

                    $this->session->set_flashdata('success', 'User successfully revoked from the selected properties.');
                } else {
                    $this->session->set_flashdata('error', 'Please select an employee and at least one property to revoke.');
                }

               redirect($_SERVER['HTTP_REFERER']);
            }

        // Set Active Menus
        $data['activemenu'] = 'property';
        $data['activesubmenu'] = 'propertyassigne';

        // Load View
        $this->load->view('property/propertyassigne', $data);
    }


    public function deleteproperty($pid) {
        $this->Common_Model->DelData("property","pid = $pid");
         $this->session->set_flashdata('success', 'Property deleted successfully.');
        redirect($this->input->server('HTTP_REFERER'));
    }

    public function deletephoto($id) {
        $this->Common_Model->DelData("property_images","id = $id");
        $this->session->set_flashdata('success', 'Photo deleted successfully.');
        redirect($this->input->server('HTTP_REFERER'));
    }


}



