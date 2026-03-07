<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Certificate extends TCPDF{
	function __construct() { 
		parent::__construct();
	}

	public function Header() {
        $headerData = $this->getHeaderData();
	    $this->SetFont('helvetica', 'B', 9);
	    //$this->writeHTML($headerData['string']);
    }

    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $this->writeHTML('<table border="0" style="margin-top: 25px; text-align:justify">        <tr>            <td align="center" width="33%">Signature of Class Teacher</td>            <td align="center" width="33%">Checked By(State Full name and Designation)</td>            <td align="center" width="33%">Signature of Principal</td>        </tr>    </table>');
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}