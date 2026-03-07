<?php $this->load->view("common/meta");?>
<div class="wrapper">
    <?php $this->load->view("common/sidebar");?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Payout Calculator</h3>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-4">
                                <label>Portfolio</label>
                                <select id="portfolio" class="form-control">
                                    <option value="">Select Portfolio</option>
                                    <?php foreach($portfolios as $p): ?>
                                    <option value="<?= $p->id ?>" data-mode="<?= $p->payout_mode ?>">
                                        <?= $p->name ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Category</label>
                                <select id="category" class="form-control">
                                    <option value="">Select Category</option>
                                </select>
                            </div>

                            <div class="col-md-4 matrix-only">
                                <label>Product</label>
                                <select id="product" class="form-control">
                                    <option value="">Select Product</option>
                                    <option value="AUTO">AUTO</option>
                                    <option value="TW">TW</option>
                                    <option value="EMI">EMI</option>
                                </select>
                            </div>

                        </div>

                        <br>

                        <div class="row">

                            <div class="col-md-4">
                                <label>POS (Principal Outstanding)</label>
                                <input type="number" id="pos" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Recovery Amount</label>
                                <input type="number" id="recovery_amount" class="form-control">
                            </div>

                            <div class="col-md-4 classic-only">
                                <label>Value (Resolution / Recovery %)</label>
                                <input type="number" id="value" class="form-control" readonly>
                            </div>

                            <div class="col-md-4 matrix-only">
                                <label>Resolution %</label>
                                <input type="number" id="resolution" class="form-control" readonly>
                            </div>

                            <div class="col-md-4 matrix-only">
                                <label>Normalization %</label>
                                <input type="number" id="normalization" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Special Flag</label>
                                <select id="slab_flag" class="form-control">
                                    <option value="">None</option>
                                    <option value="FORECLOSURE">FORECLOSURE</option>
                                    <option value="EMI_PART_PAYMENT">EMI PART PAYMENT</option>
                                    <option value="ONLY_CASH">ONLY CASH</option>
                                </select>
                            </div>

                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-md-4 col-sm-4 col-12">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon">
                                        <i class="fas fa-money-bill"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Payout</span>
                                        <span class="info-box-number" id="payout_display">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-12">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon">
                                        <i class="fas fa-gas-pump"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Fuel</span>
                                        <span class="info-box-number" id="fuel_display">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-4 col-12">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon">
                                        <i class="fas fa-calculator"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Grand Total</span>
                                        <span class="info-box-number" id="total_display">0</span>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="card-footer text-right">
                        <button id="calculate" class="btn btn-primary">Calculate</button>
                    </div>

                </div>
            </div>
        </section>
    </div>

    <?php $this->load->view("common/footer");?>
</div>
<?php $this->load->view("common/script");?>

<script>
function toggleMode() {
    let mode = $('#portfolio option:selected').data('mode');

    if (mode == 'CLASSIC') {
        $('.classic-only').show();
        $('.matrix-only').hide();
    } else {
        $('.classic-only').hide();
        $('.matrix-only').show();
    }
}

function calculateRecoveryPercent() {

    let pos = parseFloat($('#pos').val());
    let recovery = parseFloat($('#recovery_amount').val());

    if (pos > 0 && recovery >= 0) {

        let percent = (recovery / pos) * 100;
        percent = percent.toFixed(2);

        if ($('.classic-only').is(':visible')) {
            $('#value').val(percent);
        }

        if ($('.matrix-only').is(':visible')) {
            $('#resolution').val(percent);
        }
    }
}

$('#pos, #recovery_amount').on('input', function() {
    calculateRecoveryPercent();
});

$('#portfolio').change(function() {
    toggleMode();

    $.post("<?= base_url('payout/get_categories') ?>", {
            portfolio_id: $(this).val()
        },
        function(data) {
            let res = JSON.parse(data);
            $('#category').html('<option value="">Select Category</option>');
            res.forEach(function(row) {
                $('#category').append('<option value="' + row.id + '">' + row.name + '</option>');
            });
        });
});

$('#calculate').click(function() {

    $.post("<?= base_url('payout/calculate') ?>", {
            portfolio_id: $('#portfolio').val(),
            category_id: $('#category').val(),
            value: $('#value').val(),
            resolution: $('#resolution').val(),
            normalization: $('#normalization').val(),
            product: $('#product').val(),
            recovery_amount: $('#recovery_amount').val(),
            slab_flag: $('#slab_flag').val()
        },
        function(data) {

            let res = JSON.parse(data);

            if (res.error) {
                alert(res.error);
                return;
            }

            $('#payout_display').text(res.payout);
            $('#fuel_display').text(res.fuel);
            $('#total_display').text(res.total);
        });
});

toggleMode();
</script>
</body>

</html>