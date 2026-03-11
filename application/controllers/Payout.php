<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payout extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payout_model');
    }

    public function index()
{
    $data['portfolios'] = $this->Payout_model->get_portfolios();
    $data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'calculate';

    $this->load->view('payout/calculate',$data);
}

    public function get_categories()
    {
        echo json_encode(
            $this->Payout_model->get_categories(
                $this->input->post('portfolio_id')
            )
        );
    }

    public function calculate()
    {
        $portfolio_id   = $this->input->post('portfolio_id');
        $category_id    = $this->input->post('category_id');
        $value          = $this->input->post('value');
        $resolution     = $this->input->post('resolution');
        $normalization  = $this->input->post('normalization');
        $product        = $this->input->post('product');
        $recovery       = $this->input->post('recovery_amount');
        $slab_flag      = $this->input->post('slab_flag');

        $portfolio = $this->Payout_model->get_portfolio($portfolio_id);

        if (!$portfolio) {
            echo json_encode(['error'=>'Invalid Portfolio']); return;
        }

        if ($portfolio->payout_mode == 'CLASSIC') {

            $slab = $this->Payout_model->find_classic_slab(
                $category_id,
                $value,
                $slab_flag
            );

            if (!$slab) {
                echo json_encode(['error'=>'No slab matched']); return;
            }

            $payout = $this->Payout_model->get_payout_by_slab($slab->id);
            $fuel   = $this->Payout_model->get_fuel($category_id);

            if (!$payout) {
                echo json_encode(['error'=>'No payout rule']); return;
            }

            if ($payout->payout_type == 'FLAT') {
                $payout_amount = $payout->payout_value;
            } else {
                $payout_amount = ($recovery * $payout->payout_value)/100; 
            }

            $fuel_amount = $fuel ? $fuel->fuel_value : 0;

            echo json_encode([
                'payout' => round($payout_amount,2),
                'fuel' => round($fuel_amount,2),
                'total' => round($payout_amount+$fuel_amount,2)
            ]);
        }
        else {

            $rule = $this->Payout_model->find_matrix_rule(
                $category_id,
                $resolution,
                $normalization,
                $product,
                $slab_flag
            );

            if (!$rule) {
                echo json_encode(['error'=>'No matrix rule matched']); return;
            }

            if ($rule->rule_type == 'FLAT') {
                $payout_amount = $rule->payout_value;
            } else {
                $payout_amount = ($recovery * $rule->payout_value)/100;
            }

            echo json_encode([
                'payout' => round($payout_amount,2),
                'fuel' => round($rule->fuel_value,2),
                'total' => round($payout_amount+$rule->fuel_value,2)
            ]);
        }
    }
    
    public function matrix()
        {
            $data['portfolios'] = $this->Payout_model->get_aportfolios();
            $this->load->view('payout/matrix_calculate', $data);
            $data['activemenu'] = 'employee';
            $data['activesubmenu'] = 'matrix';
        }
        
    public function get_matrix_categories()
        {
            $portfolio_id = $this->input->post('portfolio_id');
        
            echo json_encode(
                $this->Payout_model->get_acategories($portfolio_id)
            );
        }
        
    public function matrix_calculate()
{
    $cat_id     = $this->input->post('category_id');
    $resolution = $this->input->post('resolution');
    $normalization = $this->input->post('normalization');
    $recovery   = $this->input->post('recovery_amount');

    if ($cat_id == 9) {

        $bom_bkt = $this->input->post('bom_bkt');
        $type    = $this->input->post('type') ?: 'NORMAL';

        $rule = $this->Payout_model
                     ->get_settlement_payout($cat_id, $resolution, $bom_bkt, $type);
    }

    elseif (in_array($cat_id, [10,11,15])) {

        $product = $this->input->post('product');
        $type    = $this->input->post('type') ?: 'NORMAL';

        $rule = $this->Payout_model
                     ->get_dpd_payout($cat_id, $resolution, $product, $type);
    }

    else {

        $rule = $this->Payout_model
                     ->get_normal_matrix_payout($cat_id, $resolution, $normalization);
    }

    if (!$rule) {
        echo json_encode(['error'=>'No matrix rule matched']);
        return;
    }

    $payout_amount = ($recovery * $rule->payout_val)/100;

    echo json_encode([
        'payout_percent' => $rule->payout_val,
        'payout_amount'  => round($payout_amount,2)
    ]);
}

public function monthlypayout()
{
    $data['activemenu'] = 'employee';
    $data['activesubmenu'] = 'monthlypayout';

    $this->load->view('payout/monthlypayout', $data);
}

}