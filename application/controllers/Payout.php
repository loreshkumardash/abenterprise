<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Payout extends CI_Controller {

public function index()
{
    $data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'emp_payout';

    $this->load->view('payout/emp_payout', $data);
}

public function process()
{

    if(empty($_FILES['excel']['tmp_name'])){
        show_error('No file uploaded');
    }

    $portfolio = $this->input->post('portfolio');

    if(empty($portfolio)){
        show_error('Portfolio not selected');
    }

    $file = $_FILES['excel']['tmp_name'];

    $originalName = $_FILES['excel']['name'];
    $fileNameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);

    $reader = IOFactory::createReaderForFile($file);
    $reader->setReadDataOnly(false);
    $spreadsheet = $reader->load($file);

    $sheet = $spreadsheet->getActiveSheet();
    $highestRow = $sheet->getHighestRow();

    for ($row = 2; $row <= $highestRow; $row++)
    {

        $pos  = floatval($sheet->getCell('G'.$row)->getCalculatedValue());
        $paid = floatval($sheet->getCell('AP'.$row)->getCalculatedValue());
        $bkt  = strtoupper(trim($sheet->getCell('K'.$row)->getValue()));
        $dpd = intval($sheet->getCell('M'.$row)->getCalculatedValue());
        $vehicle = strtoupper(trim($sheet->getCell('C'.$row)->getValue()));
        $emi = floatval($sheet->getCell('I'.$row)->getCalculatedValue());

        $recovery = ($pos > 0) ? ($paid / $pos) * 100 : 0;

        if($paid <= 0)
        {
            $sheet->setCellValue('AR'.$row, 'NO COLLECTION');
            $sheet->setCellValue('AS'.$row, 0);
            $sheet->setCellValue('AT'.$row, 0);
            continue;
        }

        switch($portfolio)
        {
            case 'tata_blpl':
                $payoutData = $this->calculateTataBlpl($bkt,$recovery,$paid);
            break;

            case 'renault':
                $payoutData = $this->calculateRenault($bkt,$recovery,$paid);
            break;

            case 'kmbl': 
                $payoutData = $this->calculateKmbl($bkt,$recovery,$paid);
            break;

            case 'iifl':
            $payoutData = $this->calculateIifl($dpd,$pos,$recovery,$paid);
            break;

            case 'tata_auto_tw':
            $payoutData = $this->calculateTataAutoTw($dpd,$vehicle,$recovery,$paid,$emi);
            break;

            default:
                $payoutData = ['grid'=>'UNKNOWN','percent'=>0,'amount'=>0];
        }

        $sheet->setCellValue('AR'.$row, $payoutData['grid']);
        $sheet->setCellValue('AS'.$row, $payoutData['percent']);
        $sheet->setCellValue('AT'.$row, $payoutData['amount']);
    }

    $writer = new Xlsx($spreadsheet);

    $filename = $fileNameWithoutExt . '_emp_payout_' . time() . '.xlsx';
    $path = FCPATH . 'downloads/' . $filename;

    $writer->save($path);

    redirect(base_url('downloads/'.$filename));
}



private function calculateTataBlpl($bkt,$recovery,$paid)
{
        $payout=0;
        $percent='';

        switch($bkt)
        {

        case 'BKT 1':
        
        if($recovery < 75) $payout=400;
        elseif($recovery <=85) $payout=500;
        else $payout=600;
        
        return ['grid'=>'BKT 1','percent'=>'Fixed','amount'=>$payout];
        
        
        case 'BKT 2':
        
        if($recovery <54) $payout=400;
        elseif($recovery <=75) $payout=500;
        else $payout=600;
        
        return ['grid'=>'BKT 2','percent'=>'Fixed','amount'=>$payout];
        
        
        case 'BKT 3':
        
        if($recovery <38) $payout=400;
        elseif($recovery <=64) $payout=500;
        else $payout=600;
        
        return ['grid'=>'BKT 3','percent'=>'Fixed','amount'=>$payout];
        
        
        case 'BKT 4':
        
        if($recovery <25) $percent=5;
        elseif($recovery <=33) $percent=6;
        else $percent=7;
        
        $payout = ($paid*$percent)/100;
        
        return ['grid'=>'BKT 4','percent'=>$percent,'amount'=>$payout];
        
        
        case 'BKT 5+':
        
        if($recovery <25) $percent=6;
        elseif($recovery <=33) $percent=7;
        else $percent=8;
        
        $payout = ($paid*$percent)/100;
        
        return ['grid'=>'BKT 5+','percent'=>$percent,'amount'=>$payout];
        
        
        case 'BKT 6+':
        
        if($recovery <25) $percent=6;
        elseif($recovery <=33) $percent=7;
        else $percent=8;
        
        $payout = ($paid*$percent)/100;
        
        return ['grid'=>'BKT 6+','percent'=>$percent,'amount'=>$payout];

    }

    return ['grid'=>'UNKNOWN','percent'=>0,'amount'=>0];

}

private function calculateRenault($bkt,$recovery,$paid)
{

    $payout = 300;

    return [
    'grid' => 'ALL BKTS',
    'percent' => 'EMI COLLECTION',
    'amount' => $payout
    ];

}

private function calculateKmbl($bkt,$recovery,$paid)
{

    $percent = 0;

    if($paid < 100000){
        $percent = 10;
    }
    elseif($paid <= 200000){
        $percent = 11;
    }
    elseif($paid <= 300000){
        $percent = 12;
    }
    else{
        $percent = 13;
    }

    $payout = ($paid * $percent) / 100;

    return [
        'grid' => 'WRITE OFF (WHEELS)',
        'percent' => $percent,
    'amount' => $payout
    ];

}

private function calculateIifl($dpd,$pos,$recovery,$paid)
{

        $percent = 0;

        if($dpd >=181 && $dpd <=360 && $pos > 150000)
        {
            if($recovery <45) $percent = 6;
            elseif($recovery <=55) $percent = 7;
            elseif($recovery <=80) $percent = 10;
            else $percent = 14;
        }

        elseif($dpd >360 && $dpd <=720 && $pos >150000)
        {
            if($recovery <45) $percent = 7;
            elseif($recovery <=75) $percent = 10;
            else $percent = 13;
        }

        elseif($dpd >720 && $pos >150000)
        {
            if($recovery <35) $percent = 8;
            elseif($recovery <=55) $percent = 10;
            elseif($recovery <=75) $percent = 14;
            else $percent = 18;
        }

        elseif($dpd >180 && $pos <=150000)
        {
            if($recovery <50) $percent = 6;
            elseif($recovery <=75) $percent = 8;
            else $percent = 10;
        }

        if($paid < ($pos * 0.10))
        {
            $percent = 5;
        }

        $payout = ($paid * $percent) / 100;

        return [
            'grid' => 'IIFL FINANCE',
            'percent' => $percent,
            'amount' => $payout
        ];
}

private function calculateTataAutoTw($dpd,$vehicle,$recovery,$paid,$emi)
{

        $percent = 0;

        if($paid < $emi)
        {
            $percent = 10;
        }

        elseif($dpd >= 450)
        {

        if($recovery <45)
        {
            $percent = ($vehicle == 'TW') ? 12 : 10;
        }
        elseif($recovery <=60)
        {
            $percent = ($vehicle == 'TW') ? 14 : 12;
        }
        elseif($recovery <=70)
        {
            $percent = ($vehicle == 'TW') ? 16 : 14;
        }
        elseif($recovery <=90)
        {
            $percent = ($vehicle == 'TW') ? 18 : 16;
        }
        elseif($recovery <=100)
        {
            $percent = ($vehicle == 'TW') ? 20 : 18;
        }

        }

        if($recovery >100)
        {
        $percent = ($vehicle == 'TW') ? 22 : 20;
        }

        $payout = ($paid * $percent) / 100;

        return [
        'grid' => 'SETTLEMENT (450+ DPD)',
        'percent' => $percent,
        'amount' => $payout
        ];

}

}