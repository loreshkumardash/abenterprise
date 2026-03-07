<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF {

    public function Header() {

        $this->SetFillColor(139, 30, 30);
        $this->Rect(0, 0, 210, 38, 'F');

        $this->SetTextColor(255,255,255);
        $this->SetFont('helvetica','I',26);
        $this->SetXY(15,12);
        $this->Cell(0,10,'AB ENTERPRISE',0,1);

        $this->SetTextColor(230,196,107);
        $this->SetFont('helvetica','',11);
        $this->SetXY(15,24);
        $this->Cell(0,10,'Trusted Recovery. Ethical Resolution.',0,1);
    }

    public function Footer() {

        $pageHeight = $this->getPageHeight();

        $footerTextY = $pageHeight - 20;

        $this->SetFillColor(201,162,77);
        $this->Rect(0, $footerTextY - 6, 210, 6, 'F');

        $this->SetY($footerTextY);
        $this->SetTextColor(0,0,0);
        $this->SetFont('helvetica','',8);

        $this->Cell(0, 4, 'Authorized Professional Collection Agency', 0, 1, 'C');

        $this->Cell(0, 4,
            'AB ENTERPRISE | Plot No-80, House No-5, Ground Floor, Vasundhara Apartment, Bhubaneswar - 751010, Odisha',
            0, 1, 'C');

        $this->Cell(0, 4,
            'Email: aparna.chakrabarty@abenterprise.org.in | www.abenterprise.org.in',
            0, 1, 'C');

        $this->Cell(0, 4,
            'GST No : 21AOPPC6694D1ZZ | Cell : +91 73810 31090, +91 78480 24849',
            0, 0, 'C');
}
}