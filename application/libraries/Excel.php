<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 *  ======================================= 
 *  Author     : Bibhudutta Dash 
 *  Email      : bibhu@cupazo.co.in 
 *  ======================================= 
 */  
require_once APPPATH."third_party/PHPExcel.php";

class Excel extends PHPExcel {
	public function __construct() {
		parent::__construct();
	}
}
?>