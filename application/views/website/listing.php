<!DOCTYPE html>
<html lang="en"> 
<head>
   <meta charset="utf-8"/>
   <title>KR Developers - Property Listings</title>
   <meta name="description" content="KR Developers is a trusted real estate company specializing in residential, commercial, and luxury properties.">
   <meta name="keywords" content="Real estate, Luxury homes, Commercial properties">
   <meta name="author" content="ladderbricks.com">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   
   <?php include('header.php'); ?>
</head>
<body>
 
<div role="main" class="main">

<?php if($this->session->flashdata('success')){ ?>
<div id="successMsg" style="font-weight:bold;" class="alert alert-success text-center">
    <?= $this->session->flashdata('success'); ?>
</div>
<?php } ?>

    <!-- Banner Section -->
    <section class="breadcrumb-section" style="background: url('<?= base_url('img/banner-6.jpg') ?>') center/cover no-repeat;"> 
        <div class="breadcrumb-overlay"></div>
        <div class="breadcrumb-content">
            <h1>Property Listings</h1>
        </div>
    </section>

    <!-- Property Listing Section -->
    <section>    
    <div class="container mt-5">
        <div class="row">
            <?php 
            $totalProperties = count($properties);
            if (!empty($properties)) :
                foreach ($properties as $index => $property) : 
                    // Show only first 6 properties initially
                    $hiddenClass = ($index >= 6) ? 'd-none' : '';
            ?>
                    <div class="col-md-4 property-item <?= $hiddenClass ?>">
                        <div class="card property-card border-radius">
                            <a href="<?= base_url('pages/details/' . $property['pid']) ?>" class="text-decoration-none text-dark">
                                <?php 
                                    $imgSrc = !empty($property['images']) ? base_url('uploads/photos/' . $property['images'][0]['images']) : base_url('uploads/img/default.jpg');
                                ?>
                                <img src="<?= $imgSrc ?>" alt="Property Image">
                                <div class="card-body">
                                    <h5 class="card-title "><?= $property['prop_name'] ?></h5>
                                    <p class="card-text "><?= $property['address'] ?></p>
                                    <p><strong class="">₹ <?= $property['price'] ?> * Onwards</strong></p> 
                                    <div class="d-flex justify-content-between">
                                        <span class=" fw-bold">&#128719; <?= ucfirst($property['prop_type']) ?></span>
                                        <span class=" fw-bold">&#x1F3E0; <?= $property['size'] ?> Sqft.</span>
                                    </div>
                                    <hr>
                                    <a href="<?= base_url('pages/details/' . $property['pid']) ?>" class="enquire-btn">View Details</a>

                                    <div class="row">
                                        <?php
                                            $whatsappno = $property[0]['whatsappno'] ?? $property[0]['userphone'] ?? '';
                                            $contactno = $property[0]['contactno'] ?? $property[0]['userphone'] ?? '';
                                            $property_title = $property['prop_name'] ?? 'Property';
                                            $phone = preg_replace('/\D/', '', $whatsappno);
                                            if (substr($phone, 0, 2) !== '91') {
                                                $phone = '91' . $phone;
                                            }
                                            $text = urlencode("Hello! I'm interested in this property: " . $property_title . ". Please share more details.");
                                            $whatsapp_url = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . $text;
                                        ?>
                                        <div class="col-3 col-md-3" style="text-align: center;">
                                            <a href="<?= $whatsapp_url; ?>" class="call-btn" target="_blank" style="" ><i class="enquire-btn btn-success fa-brands fa-whatsapp" style="color: #ffffff;"></i></a>
                                        </div>
                                        <!-- <div class="col-6 col-md-6">
                                           <a href="<?= site_url('pages/enquiry/' . $property['pid']) ?>" class="enquire-btn btn-success">Enquiry</a>
                                        </div> -->
                                        <div class="col-6 col-md-6">
                                            <a href="javascript:void(0)"
                                               class="btn-success enquire-btn openEnquiry"
                                               data-pid="<?= $property['pid']; ?>">
                                               Enquiry
                                            </a>
                                        </div>
                                        <div class="col-3 col-md-3">
                                           <?php
                                              $phone = preg_replace('/^(\+91|0)/', '', $contactno);
                                            ?>
                                            <a href="tel:+91<?= $phone ?>" class="call-btn" target="_blank">  <i class="enquire-btn fa-solid fa-phone-volume btn-success" style="color:#fff;"></i> </a>
                                        </div>                                        
                                    </div>
                                    
                                </div>
                            </a>
                        </div>
                    </div>
            <?php 
                endforeach;
            else: ?>
                <p class="text-center ">No properties available.</p>
            <?php endif; ?>
        </div>

        <!-- View More Button -->
        <?php if ($totalProperties > 6) : ?>
            <div class="text-center mt-4 py-">
               <button id="viewMoreBtn" class="btn-read-more my-5 ">Load More</button>

              
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- enquiry model -->
        <div class="modal fade" id="enquiryModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered modal-sm modal-md">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title">Property Enquiry</h5>
                <button type="button" class="close" onclick="$('#enquiryModal').modal('hide')">
                    <span>&times;</span>
                </button>

              </div>

              <div class="modal-body">
                <form method="post" action="<?= site_url('pages/enquiry'); ?>">
                    <input type="hidden" name="property_id" id="property_id">

                    <div class="form-group">
                        <label style="font-weight:bold;">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <label style="font-weight:bold;">Phone</label>
                        <input type="tel" name="phone" class="form-control" maxlength="10"
                         oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,10)"
                         placeholder="Phone" required>
                    </div>                   

                    <div class="form-group">
                        <label style="font-weight:bold;">Remark</label>
                        <textarea name="remark" class="form-control" placeholder="Remark" required></textarea>
                    </div>

                    <fieldset class="fieldset-box">
                    <legend >Other Enquiry</legend>
                        <div class="form-group">
                            <label style="font-weight:bold;">Enquiry For Other</label>
                            <select class="form-control" name="other">
                                <option value="">--Select--</option>
                                <option value="PLOTS">PLOTS</option>
                                <option value="FLATS">FLATS</option>
                                <option value="VILLAS ">VILLAS </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="font-weight:bold;">Area</label>
                            <input type="area" name="area" class="form-control" placeholder="Enter Expected Area">
                        </div>

                        <div class="form-group">
                            <label style="font-weight:bold;">Expected Price</label>
                            <input type="price" name="price" class="form-control" placeholder="Rs. 0.00">
                        </div>
                    </fieldset>

                    <div class="modal-footer">
                        <button type="submit" name="submitBtn" class="btn btn-success">Submit</button>
                        <button type="button" class="close btn btn-default" onclick="$('#enquiryModal').modal('hide')"> Close </button>
                     </div>            

                </form>
              </div>
            </div>
          </div>
        </div>
    <!-- model end -->

<style>
    .btn-view-more {
        background: linear-gradient(45deg, #ff6b6b, #ffb142);
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 4px 10px rgba(255, 107, 107, 0.5);
    }

    .btn-view-more:hover {
        background: linear-gradient(45deg, #ff4757, #ffa502);
        box-shadow: 0px 6px 14px rgba(255, 71, 87, 0.7);
        transform: translateY(-2px);
    }

    .btn-view-more:active {
        transform: scale(0.95);
    }

    .call-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        width:50px;
        height:50px;
        border-radius:50%;
        animation: glowPulse 1.5s infinite;
    }

    .call-btn i{
        color:#fff;
        font-size:20px;
    }

    /* Animation */
    @keyframes glowPulse {
        0%{
            transform: scale(1);
        }
        50%{
            transform: scale(1.1);
        }
        100%{
            transform: scale(1);
        }
    }

    @media (max-width: 576px) {
      .modal-dialog {
        margin: 10px;
      }
    }
     .fieldset-box {
        border: 1px solid #28a745;
        border-radius: 8px;
        padding: 20px;
        margin-top: 15px;
        position: relative;
    }

    .fieldset-box legend {
        font-size: 16px;
        font-weight: bold;
        /*padding-top: -10px 12px;*/
        color: #28a745;
        position:absolute;
        width:150px;
        top:-12px;
        text-align: center;
    }
    .fieldset-box legend {
        background: #fff;
        background-origin: content-box;
    }

</style>


<script>
    document.getElementById("viewMoreBtn")?.addEventListener("click", function() {
        document.querySelectorAll(".property-item.d-none").forEach(item => item.classList.remove("d-none"));
        this.style.display = "none";
    });
</script>

</div>

<?php include('footer.php'); ?>

<script>
$(document).on('click', '.openEnquiry', function(){
    var pid = $(this).data('pid');
    $('#property_id').val(pid);
    $('#enquiryModal').modal('show');
});
</script>
<script>
$(document).ready(function(){
    setTimeout(function(){
        $("#successMsg").fadeOut("slow");
    }, 3000); // 2000ms = 2 sec
});
</script>

</body>
</html>
