<?php $this->load->view("common/meta"); ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <div class="content-wrapper">

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h3>Employee Payout</h3>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">

          <div class="row justify-content-center mt-4">
            <div class="col-lg-5">

              <div class="card shadow-lg border-0">

                <form id="excelForm" method="post" action="<?php echo base_url('payout/process'); ?>"
                  enctype="multipart/form-data" target="_blank">

                  <div class="card-body">

                    <div class="form-group">
                      <label class="font-weight-bold">
                        <i class="fas fa-user mr-1"></i> Select Portfolio
                      </label>

                      <select name="portfolio" class="form-control form-control-lg" required>
                        <option value="" disabled selected>Choose Portfolio</option>
                        <option value="tata_blpl" <?= set_select('portfolio','tata_blpl'); ?>>TATA BL/PL</option>
                        <option value="renault" <?= set_select('portfolio','renault'); ?>>RENAULT</option>
                        <option value="kmbl" <?= set_select('portfolio','kmbl'); ?>>KMBL</option>
                        <option value="iifl" <?= set_select('portfolio','iifl'); ?>>IIFL</option>
                        <option value="tata_auto_tw" <?= set_select('portfolio','tata_auto_tw'); ?>>TATA AUTO/TW
                        </option>
                      </select>
                    </div>

                    <div class="form-group mt-4">
                      <label class="font-weight-bold">
                        <i class="fas fa-file-excel mr-1"></i> Upload Excel File
                      </label>

                      <div class="custom-file">
                        <input type="file" name="excel" class="custom-file-input" id="excelFile" accept=".xls,.xlsx"
                          required>
                        <label class="custom-file-label" for="excelFile">Choose Excel file (.xlsx / .xls)</label>
                      </div>

                      <small class="text-muted">
                        Upload the portfolio-wise payout Excel sheet to calculate employee payouts automatically.
                      </small>
                    </div>

                  </div>

                  <div class="card-footer text-center">

                    <button type="submit" id="submitBtn" class="btn btn-success btn-sm px-4">
                      <i class="fas fa-upload mr-1"></i> Upload & Calculate
                    </button>

                    <button type="reset" class="btn btn-outline-secondary btn-sm px-4 ml-2">
                      <i class="fas fa-redo mr-1"></i> Reset
                    </button>

                  </div>

                </form>

              </div>

            </div>
          </div>

        </div>
      </section>

    </div>

    <?php $this->load->view("common/footer"); ?>

  </div>

  <?php $this->load->view("common/script"); ?>

  <script>
  $('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\\').pop();
    $(this).next('.custom-file-label').addClass("selected").html(fileName);
  });

  $('#excelForm').on('reset', function() {
    $('.custom-file-label')
      .removeClass("selected")
      .html('Choose Excel file (.xlsx / .xls)');
  });

  $('#excelForm').submit(function() {

    $('#submitBtn')
      .prop('disabled', true)
      .html('<i class="fas fa-spinner fa-spin mr-1"></i> Processing...');

    setTimeout(function() {
      $('#submitBtn')
        .prop('disabled', false)
        .html('<i class="fas fa-upload mr-1"></i> Upload & Calculate');
    }, 4000);

  });
  </script>

</body>

</html>