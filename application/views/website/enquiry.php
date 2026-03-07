<!DOCTYPE html>
<html lang="en"> 
<head>
   <meta charset="utf-8"/>
    <title>Property Enquiry</title>
   <meta name="description" content="KR Developers is a trusted real estate company specializing in residential, commercial, and luxury properties.">
   <meta name="keywords" content="Real estate, Luxury homes, Commercial properties">
   <meta name="author" content="ladderbricks.com">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
   <?php include('header.php'); ?>
</head>
<body>

<div class="container mt-5">
    <h3>Property Enquiry</h3>

   <?php if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $this->session->flashdata('success'); ?>
    </div>
    <?php } ?>

    <form method="post" action="<?= site_url('pages/enquiry/' . $pid) ?>">
        
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email ID" required>
        </div>

        <div class="form-group">
            <label for="phone" class="form-label">Phone</label>
          <input type="tel" id="phone" name="phone" class="form-control" placeholder="Enter Phone Number" required
       maxlength="10" pattern="[0-9]{10}" title="Enter exactly 10 digit mobile number"
       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10);">

        </div>

        <div class="form-group">
            <label for="remark" class="form-label">Remark</label>
            <textarea name="remark" id="remark" class="form-control" rows="4" placeholder="Enter Remarks"></textarea>
        </div>

        <button type="submit" name="submitBtn" class="btn btn-success btn-rounded">
            Submit Enquiry
        </button>
        <br><br>
    </form>
</div>

<?php include('footer.php'); ?>

<script>
setTimeout(function(){
    $('.alert').alert('close');
}, 4000);
</script>


</body>
</html>
