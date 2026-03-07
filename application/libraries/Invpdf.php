<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Invpdf extends TCPDF{
	function __construct() { 
		parent::__construct();
	}

	public function Header() {
        $headerData = $this->getHeaderData();
	    $this->SetFont('helvetica', '', 9);
        $this->writeHTML('<table width="100%" style="font-family: serif; ">
    <tr>
        <td width="50%" style="border-top: 1px solid black;border-left: 1px solid black; border-right: 1px solid black;"><br><br>
            <img src="'.base_url("assets/logopng.png").'" height="70px"  style="margin-top: 15px;"><br>
            <span style="color:red;  font-size: 12px;">GSTN : <span style="color:blue;">21 AAKCG0507B 1ZG </span></span>
        </td>
        <td width="50%" style="border-top: 1px solid black;border-left: 1px solid black; border-right: 1px solid black; font-size: 12px;" >
        <table>
                <tr>
                    <td width="100%" colspan="2" style="color:#5DADE2;font-size:18px;">GLOSENT PRIVATE LIMITED</td>
                </tr>
                <tr>
                    <td width="15%"><b style="color:red ;">CIN</b> : </td>
                    <td width="85%">U29309OR2022PTC040813</td>
                </tr>
                <tr>
                    <td width="15%"><b style="color:red;">Add.</b> : </td>
                    <td width="85%">Plot No-1094/2869, Madanpur, Bhubaneswar, Odisha, INDIA, 752054</td>
                </tr>
                <tr>
                    <td width="15%"><b style="color:red;">Mob.</b> : </td>
                    <td width="85%">+91 97654 97655  &nbsp;<span><b style="color:red;">Web </b>:www.glosent.in</span></td>
                </tr>
                <tr>
                    <td width="15%"><b style="color:red;">Email</b> : </td>
                    <td width="85%">operations@glosent.in<br></td>
                </tr>
        </table>
           

        </td>
    </tr>
</table>');
	    //$this->writeHTML($headerData['string']);
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $this->writeHTML('Plot No-1094/2869, Madanpur, Bhubaneswar, Odisha,
INDIA,752054'."\n".'PH: +91- 97654 9765, E-mail: operations@glosent.in'."\n", 0, 1, 0,true, "C", true);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}