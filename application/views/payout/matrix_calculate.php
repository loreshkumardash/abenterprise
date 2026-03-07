<?php $this->load->view("common/meta"); ?>
<div class="wrapper">

    <?php $this->load->view("common/sidebar"); ?>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Agency Payout Calculator</h3>
                    </div>

                    <div class="card-body">

                        <form id="matrixForm">

                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Portfolio</label>
                                        <select name="portfolio_id" id="portfolio_id" class="form-control" required>
                                            <option value="">Select Portfolio</option>
                                            <?php foreach($portfolios as $p): ?>
                                            <option value="<?= $p->id ?>"><?= $p->name ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category_id" id="category_id" class="form-control" required>
                                            <option value="">Select Category</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Resolution/Recovery %</label>
                                        <input type="number" step="0.01" name="resolution" class="form-control"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-2" id="normalization_box">
                                    <div class="form-group">
                                        <label>Normalization %</label>
                                        <input type="number" step="0.01" name="normalization" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2" id="bom_box" style="display:none;">
                                    <div class="form-group">
                                        <label>BOM Bucket</label>
                                        <select name="bom_bkt" class="form-control">
                                            <option value="">Select</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2" id="type_box" style="display:none;">
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control">
                                            <option value="NORMAL">Normal</option>
                                            <option value="FORECLOSURE">Foreclosure</option>
                                            <option value="NO_SETTLEMENT">No Settlement</option>
                                            <option value="PENAL">Penal Collection</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2" id="product_box" style="display:none;">
                                    <div class="form-group">
                                        <label>Product</label>
                                        <select name="product" class="form-control">
                                            <option value="">Select</option>
                                            <option value="BL">BL</option>
                                            <option value="PL">PL</option>
                                            <option value="AL">AL</option>
                                            <option value="TW">TW</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Recovery Amount</label>
                                        <input type="number" step="0.01" name="recovery_amount" class="form-control"
                                            required>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Calculate</button>
                                </div>
                            </div>

                        </form>

                        <hr>

                        <div id="result_box" style="display:none;">
                            <div class="alert alert-success">
                                <strong>Payout % :</strong> <span id="payout_percent"></span>% <br>
                                <strong>Payout Amount :</strong> ₹ <span id="payout_amount"></span>
                            </div>
                        </div>

                        <div id="error_box" style="display:none;">
                            <div class="alert alert-danger">
                                <span id="error_message"></span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </div>
    <?php $this->load->view("common/footer");?>
</div>

<?php $this->load->view("common/script");?>

<script>
$('#portfolio_id').change(function() {
    let portfolio_id = $(this).val();

    $('#category_id').html('<option value="">Loading...</option>');

    $.post("<?= base_url('payout/get_matrix_categories'); ?>", {
            portfolio_id: portfolio_id
        },
        function(data) {
            let categories = JSON.parse(data);
            let html = '<option value="">Select Category</option>';

            categories.forEach(function(row) {
                html += '<option value="' + row.id + '">' + row.name + '</option>';
            });

            $('#category_id').html(html);
        }
    );
});


$('#matrixForm').submit(function(e) {
    e.preventDefault();

    $('#result_box').hide();
    $('#error_box').hide();

    $.post("<?= base_url('payout/matrix_calculate'); ?>",
        $(this).serialize(),
        function(data) {

            let response = JSON.parse(data);

            if (response.error) {
                $('#error_message').text(response.error);
                $('#error_box').show();
            } else {
                $('#payout_percent').text(response.payout_percent);
                $('#payout_amount').text(response.payout_amount);
                $('#result_box').show();
            }

        }
    );
});

$('#category_id').change(function() {

    let cat_id = $(this).val();

    $('#bom_box, #type_box, #product_box').hide();
    $('#normalization_box').show();

    $('input[name="normalization"]').prop('required', false);
    $('select[name="bom_bkt"]').prop('required', false);
    $('select[name="product"]').prop('required', false);

    if (cat_id == 9) {

        $('#bom_box, #type_box').show();
        $('#normalization_box').hide();

        $('select[name="bom_bkt"]').prop('required', true);

    } else if (cat_id == 10 || cat_id == 11 || cat_id == 15) {

        $('#product_box, #type_box').show();
        $('#normalization_box').hide();

        $('select[name="product"]').prop('required', true);
    } else {

        $('#normalization_box').show();
        $('input[name="normalization"]').prop('required', true);
    }

});
</script>

</body>

</html>