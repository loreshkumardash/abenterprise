<?php $this->load->view("common/meta");?>

<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <div class="content-wrapper">

    <section class="content">
      <div class="container-fluid">

        <div class="card card-primary">

          <div class="card-header">
            <h3 class="card-title">Payout Entry</h3>
          </div>

          <form method="post" action="<?php echo site_url('payout/monthlypayout'); ?>">

            <div class="card-body">

              <div class="row">

                <div class="col-md-3">
                  <label>Allocation Month</label>
                  <input type="text" name="allocation_month" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Portfolio</label>
                  <input type="text" name="portfolio" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Product</label>
                  <input type="text" name="product" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Loan Number</label>
                  <input type="text" name="loan_number" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Customer Name</label>
                  <input type="text" name="customer_name" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Customer Mobile</label>
                  <input type="text" name="customer_mobile" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>OD/POS</label>
                  <input type="text" name="od_pos" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Cycle DT</label>
                  <input type="date" name="cycle_dt" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>EMI</label>
                  <input type="text" name="emi" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>BKT Category</label>
                  <input type="text" name="bkt_category" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>BKT</label>
                  <input type="text" name="bkt" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>TOS</label>
                  <input type="text" name="tos" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>DPD</label>
                  <input type="text" name="dpd" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Tenure</label>
                  <input type="text" name="tenure" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Tenure Paid</label>
                  <input type="text" name="tenure_paid" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Pool Type</label>
                  <select name="pool_type" class="form-control">
                    <option value="">Select</option>
                    <option>Fresh Pool</option>
                    <option>Stab Pool</option>
                    <option>Old Pool</option>
                  </select>
                </div>

                <div class="col-md-3">
                  <label>TL Name</label>
                  <input type="text" name="tl_name" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>TC Name</label>
                  <input type="text" name="tc_name" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>FOS Name</label>
                  <input type="text" name="fos_name" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>FOS Number</label>
                  <input type="text" name="fos_number" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Location</label>
                  <input type="text" name="location" class="form-control">
                </div>

                <div class="col-md-6">
                  <label>Residence Address</label>
                  <input type="text" name="residence_address" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Residence ZIP Code</label>
                  <input type="text" name="residence_zip" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Residence Landline</label>
                  <input type="text" name="residence_landline" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Customer Office Name</label>
                  <input type="text" name="office_name" class="form-control">
                </div>

                <div class="col-md-6">
                  <label>Office Address</label>
                  <input type="text" name="office_address" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Office ZIP Code</label>
                  <input type="text" name="office_zip" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Reference Name</label>
                  <input type="text" name="reference_name" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Reference Number</label>
                  <input type="text" name="reference_number" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Asset Model</label>
                  <input type="text" name="asset_model" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Registration #</label>
                  <input type="text" name="registration_no" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Engine No</label>
                  <input type="text" name="engine_no" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Disbursal Date</label>
                  <input type="date" name="disbursal_date" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>EMI Start Date</label>
                  <input type="date" name="emi_start_date" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>EMI End Date</label>
                  <input type="date" name="emi_end_date" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Legal Status</label>
                  <input type="text" name="legal_status" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Short Code</label>
                  <input type="text" name="short_code" class="form-control">
                </div>

                <div class="col-md-6">
                  <label>Detail Calling Feedback</label>
                  <textarea name="calling_feedback" class="form-control"></textarea>
                </div>

                <div class="col-md-6">
                  <label>Detail FOS Feedback</label>
                  <textarea name="fos_feedback" class="form-control"></textarea>
                </div>

                <div class="col-md-3">
                  <label>PTP Amount</label>
                  <input type="text" name="ptp_amount" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>PTP Date</label>
                  <input type="date" name="ptp_date" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Paid Amount</label>
                  <input type="text" name="paid_amount" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Paid Date</label>
                  <input type="date" name="paid_date" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>FOS Payout Grid</label>
                  <input type="text" name="fos_payout_grid" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>FOS Payout %</label>
                  <input type="text" name="fos_payout_percent" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>FOS Payout Amount</label>
                  <input type="text" name="fos_payout_amount" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Actual Payout Grid</label>
                  <input type="text" name="actual_payout_grid" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Actual Payout %</label>
                  <input type="text" name="actual_payout_percent" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Booster Payout</label>
                  <input type="text" name="booster_payout" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Actual Payout Amount</label>
                  <input type="text" name="actual_payout_amount" class="form-control">
                </div>

              </div>

            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>

          </form>

        </div>
      </div>
    </section>

  </div>

  <?php $this->load->view("common/footer");?>

</div>

<?php $this->load->view("common/script");?>

</body>

</html>