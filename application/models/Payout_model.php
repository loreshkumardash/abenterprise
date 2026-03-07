<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payout_model extends CI_Model {


    public function get_portfolios()
    {
        return $this->db->get('portfolio')->result();
    }

    public function get_portfolio($id)
    {
        return $this->db->where('id',$id)->get('portfolio')->row();
    }

    public function get_categories($portfolio_id)
    {
        return $this->db->where('portfolio_id',$portfolio_id)
                        ->get('payout_category')
                        ->result();
    }

    public function find_classic_slab($category_id, $input_value, $slab_flag = NULL)
    {
        $this->db->where('category_id',$category_id);

        if ($slab_flag) {
            $this->db->where('slab_flag',$slab_flag);
        } else {
            $this->db->where('slab_flag IS NULL', NULL, FALSE);
        }

        $this->db->group_start();
        $this->db->where('(min_value IS NULL OR '.$input_value.' >= min_value)', NULL, FALSE);
        $this->db->where('(max_value IS NULL OR '.$input_value.' <= max_value)', NULL, FALSE);
        $this->db->group_end();

        return $this->db->get('slab')->row();
    }

    public function get_payout_by_slab($slab_id)
    {
        return $this->db->where('slab_id',$slab_id)
                        ->get('payout')
                        ->row();
    }

    public function get_fuel($category_id)
    {
        return $this->db->where('category_id',$category_id)
                        ->get('fuel') 
                        ->row();
    }

    public function find_matrix_rule($category_id, $resolution, $normalization, $product, $slab_flag = NULL)
    {
        $this->db->where('category_id',$category_id);

        $this->db->where('(resolution_from IS NULL OR '.$resolution.' >= resolution_from)', NULL, FALSE);
        $this->db->where('(resolution_to IS NULL OR '.$resolution.' <= resolution_to)', NULL, FALSE);

        if ($normalization !== '') {
            $this->db->where('(normalization_from IS NULL OR '.$normalization.' >= normalization_from)', NULL, FALSE);
            $this->db->where('(normalization_to IS NULL OR '.$normalization.' <= normalization_to)', NULL, FALSE);
        }

        if ($product) {
            $this->db->where('product',$product);
        }

        if ($slab_flag) {
            $this->db->where('slab_flag',$slab_flag);
        }

        return $this->db->get('payout_matrix')->row();
    }

public function get_aportfolios()
    {
        return $this->db->get('aportfolio')->result();
    }

public function get_acategories($portfolio_id)
    {
        return $this->db->where('portfolio_id', $portfolio_id)
                        ->get('acategory')
                        ->result();
    }

public function get_normal_matrix_payout($cat_id, $resolution, $normalization)
    {
        return $this->db
            ->where('cat_id', $cat_id)
            ->where('resolution_from <=', $resolution)
            ->where('resolution_to >=', $resolution)
            ->where('normalization_from <=', $normalization)
            ->where('normalization_to >=', $normalization)
            ->limit(1)
        ->get('apayout')
        ->row();
}

public function get_dpd_payout($cat_id, $resolution, $product, $type='NORMAL')
{
    $this->db->where('cat_id', $cat_id);
    $this->db->where('product', $product);

    if ($type == 'FORECLOSURE') {

        $this->db->where('is_foreclosure', 1);

    } elseif ($type == 'NO_SETTLEMENT') {

        $this->db->where('is_no_settlement', 1);

    } elseif ($type == 'PENAL') {

        $this->db->where('is_penal', 1);

    } else {

        $this->db->where('is_foreclosure', 0);
        $this->db->where('is_no_settlement', 0);
        $this->db->where('is_penal', 0);

        $this->db->where('resolution_from <=', $resolution);
        $this->db->where('resolution_to >=', $resolution);
    }

    return $this->db->limit(1)->get('apayout')->row();
}

public function get_settlement_payout($cat_id, $resolution, $bom_bkt, $type='NORMAL')
{
    $this->db->where('cat_id', $cat_id);
    $this->db->where('bom_bkt', $bom_bkt);

    if ($type == 'FORECLOSURE') {

        $this->db->where('is_foreclosure', 1);

    } elseif ($type == 'POS_INT') {

        $this->db->where('is_pos_interest', 1);

    } else {

        $this->db->where('is_foreclosure', 0);
        $this->db->where('is_pos_interest', 0);
        $this->db->where('resolution_from <=', $resolution);
        $this->db->where('resolution_to >=', $resolution);
    }

    return $this->db->limit(1)->get('apayout')->row();
}
}