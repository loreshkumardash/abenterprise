<?php error_reporting(0); ?>
<head>
   <meta charset="utf-8"/>
   <title> 
      KR Developers - Details 
   </title>
   <meta name="description" content="KR Developers is a trusted real estate company specializing in residential, commercial, and luxury properties. We offer a wide range of innovative and high-quality real estate solutions, including affordable homes, luxury apartments, and prime commercial spaces. ">
   <meta name="keywords" content="Real estate developers, Luxury real estate properties, Residential and commercial properties">
   <meta name="author" content="https://csplerp.com/">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- <link rel="canonical" href="https://csplerp.com/hostel-management"/> -->
   <link rel="icon" type="image/x-icon" href="<?= site_url('uploads/img/logo.jpg');?>">
   <?php  include ('header.php');?>
   <style>
      #thumbGallepxryThumbs div{
      height: 80px;
      }
      .map{
      height: 500px;
      }
      .map iframe{
      width: 100% !important;
      }
      .card{
      border: 2px solid red;
      background:#e3f2fd;
      height:200px;
      }
      .col-lg-3{
      padding-bottom: 10px;
      }
      .image-container {
      position: relative;
      display: inline-block;
      }
      .image-container img {
      height:400px;
      width: 100%;
      }
      .view-image {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      color: white;
      font-size: 20px;
      text-align: center;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      }
      .thumb-gallery a img{
      width: 100%;
      height: 350px;
      }
      @media(max-width:768px){
      .thumb-gallery a img{
      width: 100%;
      height: 250px !important;
      }
      #thumbGalleryThumbs img{
      height: 50px !important;
      }
      .image-container img {
      height:300px;
      width: 100%;
      }
      }
      @media(max-width:576px){
      #thumbGalleryThumbs img{
      height: 30px !important;
      }
      }
      .bg-color-green{
      background: #00c08b !important;
      }
      #thumbGalleryThumbs img{
      height: 120px !important;
      }
      #scrollBox {
      width: 100%;
      max-height: 500px;
      overflow: auto; /* Enable scrolling */
      overflow-y: scroll; /* Enable scrolling */
      scrollbar-width: none; /* Firefox */
      -ms-overflow-style: none; /* Internet Explorer 10+ */
      background: #fff;
      font-size: 16px;
      color: black;
      }
      #scrollBox::-webkit-scrollbar {
      display: none; /* Chrome, Safari */
      }
      .onw-text{
      font-family: cursive !important;
      }
   </style>
   <div class="main"  >
      <?php if($this->session->flashdata('success')){ ?>
      <div id="successMsg" style="font-weight:bold;" class="alert alert-success text-center">
          <?= $this->session->flashdata('success'); ?>
      </div>
      <?php } ?>

      <section class="breadcrumb-section"  
         style="background: url('<?= base_url('img/banner-6.jpg') ?>') center/cover no-repeat;">
         <div class="breadcrumb-overlay"></div>
         <div class="breadcrumb-content">
            <h1><?= $property[0]['prop_name'];?></h1>
         </div>
      </section>
      <div class="container   my-3">
         <div class="row">
            <div class="col-lg-12   ">
               <div class="row">
                  <div class="col-lg-8 text-center" >
                     <div class="thumb-gallery">
                        <div class=" " data-plugin-options="{'delegate': 'a', 'type': 'image', 'gallery': {'enabled': true}}">
                           <div class="owl-carousel owl-theme manual  show-nav-hover" id="thumbGalleryDetail">
                              <?php if($propertyimg){
                                 for($i=0;$i<count($propertyimg);$i++){
                                 ?>
                              <div class="border-radius overflow-hidden">
                                 <a >
                                 <span class="     text-4">
                                 <span class="  text-4">
                                 <img alt="Property Detail" src="<?= base_url('uploads/photos/') . $propertyimg[$i]['images']?>" class=" ">
                                 </span>
                                 </span>
                                 </a>
                              </div>
                              <?php }} ?>
                           </div>
                        </div>
                        <div class="owl-carousel owl-theme manual thumb-gallery-thumbs mt" id="thumbGalleryThumbs">
                           <?php if($propertyimg){
                              for($i=0;$i<count($propertyimg);$i++){
                              ?>
                           <div class="border-radius overflow-hidden">
                              <a href="<?= base_url('uploads/photos/') . $propertyimg[$i]['images']?>" target="_blank">
                              <img alt="Property Detail" src="<?= base_url('uploads/photos/') . $propertyimg[$i]['images']?>" class="img-fluid cur-pointer"></a>
                              <span style="color:teal; font: 20px bold;"><i><?= $propertyimg
                                 [$i]['image_name']; ?></i></span>
                           </div>
                           <?php }} ?>
                        </div>
                     </div>
                     <td>
                        <h4 style="color: indigo;"> <i class="fas fa-share-alt"></i> Share It</h4>
                        <!-- Hidden Share Options -->
                        <div>
                           <!-- WhatsApp -->
                           <!-- <a href="https://api.whatsapp.com/send?text=Check out this property: <?= urlencode(site_url('Pages/details/'.$property[0]['pid'])); ?>" 
                              class="btn btn-success btn-sm" target="_blank">
                           <i class="fab fa-whatsapp"></i> WhatsApp
                           </a> -->

                           <?php
                           $property_title = $property[0]['prop_name'] ?? 'Property';
                           $share_text = "Check out this property: " . $property_title . " – " . site_url('Pages/details/' . $property[0]['pid']);
                           $whatsapp_url = "https://api.whatsapp.com/send?text=" . urlencode($share_text);
                           ?>
                           <a href="<?= $whatsapp_url; ?>" class="btn btn-success btn-sm" target="_blank">
                              <i class="fab fa-whatsapp"></i> WhatsApp
                           </a>

                           <!-- Facebook -->
                           <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(site_url('Pages/details/'.$property[0]['pid'])); ?>" 
                              class="btn btn-primary btn-sm" target="_blank">
                           <i class="fab fa-facebook"></i> Facebook
                           </a>
                           <!-- Twitter (X) -->
                           <a href="https://twitter.com/intent/tweet?url=<?= urlencode(site_url('Pages/details/'.$property[0]['pid'])); ?>" 
                              class="btn btn-info btn-sm" target="_blank">
                           <i class="fab fa-twitter"></i> Twitter
                           </a>
                           <!-- Instagram (Instagram doesn’t support direct link sharing like WhatsApp & Facebook) -->
                           <!-- Instagram (Copies Link) -->
                           <button class="btn btn-danger btn-sm" onclick="copyToClipboard('<?= site_url('Pages/details/'.$property[0]['pid']); ?>')">
                           <i class="fab fa-instagram"></i> Instagram
                           </button>
                           <!-- LinkedIn -->
                           <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(site_url('Pages/details/'.$property[0]['pid'])); ?>" 
                              class="btn btn-secondary btn-sm" target="_blank">
                           <i class="fab fa-linkedin"></i> LinkedIn
                           </a>
                        </div>
                     </td>                  
                    
                    <!-- <br><hr>
                    <h4 style="color: indigo;">Property Enquiry</h4>                     
                        <div class="d-inline-flex gap-1" >
                           <a href="https://api.whatsapp.com/send?phone=91<?= $property[0]['userphone'] ?>&text=Hello%20there!" class="btn btn-sm btn-success" target="_blank" style="" ><i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i> WhatsApp</a>
                       
                            <a href="javascript:void(0)"                                               class="btn btn-sm btn-success openEnquiry"
                            data-pid="<?= $property[0]['pid']; ?>">
                            Enquiry
                            </a>
                       
                           <a href="tel:+<?= $property[0]['userphone'] ?>" class="btn btn-sm btn-success"  target="_blank" style=""><i class="fa-solid fa-phone-volume btn-success" style="color: #ffffff;"></i> Call</a>
                        </div>  -->
                     
                                                         
               </div>

                  <div class="col-lg-4">
                     <h2 class="font-weight-semibold text-5  text-center line-height-6 mt-3 mb-2">
                        <a href=" #"><?= $property[0]['prop_name'];?> </a>
                     </h2>
                     <div id="scrollBox">
                        <div class="post-meta text-center pt-0 ">
                           <span class="text-3 fw-bold text-danger">
                           <b>  Description 
                           </b>     
                           </span> 
                        </div>
                        <p class="fw-bold"><?= $property[0]['description'];?></p>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class=" col-lg-6">
                     <div class="border-radius  mt-5 ">
                        <table class="table table-striped">
                           <colgroup>
                              <col width="35%">
                              <col width="65%">
                           </colgroup>
                           <tbody>
                              <tr>
                                 <td class="  text-light align-middle font-weight-semibold " style="background: var(--primary-color);">
                                    Price
                                 </td>
                                 <td class="text-4 font-weight-bold align-middle  text-light " style="background: var(--primary-color);">
                                    ₹ <?= $property[0]['price'];?>  <span class="onw-text"> * Onwards </span>  
                                 </td>
                              </tr>
                              <tr>
                                 <td class="font-weight-semibold">
                                   <i class="fa-solid fa-house" style="color:var(--primary-color)"></i> &nbsp Property Size 
                                 </td>
                                 <td>
                                    <?= $property[0]['size'];?> Sqft.
                                 </td>
                              </tr>
                              <tr>
                                 <td class="font-weight-semibold">
                                   <i class="fa-solid fa-building" style="color:var(--primary-color)"></i> &nbsp Property Type
                                 </td>
                                 <td>
                                    <?= $property[0]['prop_type'];?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="font-weight-semibold">
                                    <i class="fa-solid fa-map-location-dot " style="color:var(--primary-color)"> &nbsp</i>Address
                                 </td>
                                 <td>
                                    <?= $property[0]['address'];?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="font-weight-semibold">
                                  <i class="fa-solid fa-house-medical" style="color:var(--primary-color)"></i> &nbsp Facilities
                                 </td>
                                 <td>
                                    <?= $property[0]['facilities'];?>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="font-weight-semibold">
                                  <i class="fa-solid fa-envelope" style="color:var(--primary-color)"></i> &nbsp Other Enquiry
                                 </td>
                                 <td class="d-grid">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary openEnquiry" data-pid="<?= $property[0]['pid']; ?>"><i class="fa-solid fa-envelope" style="color: #ffffff;"></i> Enquiry</a>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="font-weight-semibold">
                                  <i class="fa-solid fa-brands fa-whatsapp" style="color:var(--primary-color)"></i> &nbsp Chat Us
                                 </td>
                                  <?php
                                    $whatsappno = $property[0]['whatsappno'] ?? $property[0]['userphone'] ?? '';
                                    $contactno = $property[0]['contactno'] ?? $property[0]['userphone'] ?? '';
                                    $property_title = $property[0]['prop_name'] ?? 'Property';
                                    $phone = preg_replace('/\D/', '', $whatsappno);
                                    if (substr($phone, 0, 2) !== '91') {
                                        $phone = '91' . $phone;
                                    }
                                    $text = urlencode("Hello! I'm interested in this property: " . $property_title . ". Please share more details.");
                                    $whatsapp_url = "https://api.whatsapp.com/send?phone=" . $phone . "&text=" . $text;
                                    ?>
                                 <td class="d-grid">
                                    <a href="<?= $whatsapp_url; ?>" class="btn btn-sm btn-success" target="_blank">
                                       <i class="fab fa-whatsapp" style="color: #ffffff;"></i> WhatsApp
                                    </a>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="font-weight-semibold">
                                  <i class="fa-solid fa-headset" style="color:var(--primary-color)"></i> &nbsp Call Us
                                 </td>
                                 <td class="d-grid">
                                   <?php
                                      $phone = preg_replace('/^(\+91|0)/', '', $contactno);
                                   ?>
                                   <a href="tel:+91<?= $phone ?>" class="call-btn" target="_blank">  <i class="enquire-btn fa-solid fa-phone-volume btn-success" style="color:#fff;"></i> </a>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>


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
        <style>
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
    <!-- model end -->

                  <!--  -->
                  <div class="col-lg-6 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
                     <div class="container">
                        <h2 class="font-weight-semibold text-5  text-center line-height-6 mt-3 mb-2">
                           Floor Plan 
                        </h2>
                        <div id="floorplanCarousel" class="carousel slide" data-bs-ride="carousel">
                           <div class="carousel-inner">
                              <?php if($floorplan){
                                 for($i=0;$i<count($floorplan);$i++){
                                 ?>  
                              <div class="carousel-item <?= $i == 0 ? 'active' : ''; ?> text-center">
                                 <div class="blueprint-card p-3 shadow rounded">
                                    <a href="<?= base_url('uploads/photos/') . $floorplan[$i]['images']; ?>" target="_blank" class="d-block">
                                    <img src="<?= base_url('uploads/photos/') . $floorplan[$i]['images']; ?>" alt="Sample Plan" class="img-fluid rounded" style="height: 350px;">
                                    </a>
                                    <span class="d-block mt-2 text-teal font-weight-bold">
                                    <i><?= $floorplan[$i]['image_name']; ?></i>
                                    </span>
                                 </div>
                              </div>
                              <?php }} ?>
                           </div>
                           <button class="carousel-control-prev" type="button" data-bs-target="#floorplanCarousel" data-bs-slide="prev">
                           <span class="carousel-control-prev-icon bg-dark" aria-hidden="true"></span>
                           <span class="visually-hidden">Previous</span>
                           </button>
                           <button class="carousel-control-next" type="button" data-bs-target="#floorplanCarousel" data-bs-slide="next">
                           <span class="carousel-control-next-icon bg-dark" aria-hidden="true"></span>
                           <span class="visually-hidden">Next</span>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <br>
         </div>
       
      <div class="row">
         <div class="container">
            <div class="row d-flex justify-content-center">
               <div class="col-md-6">
                  <?php if($property[0]['link']) { ?>
                  <iframe width="100%" height="515" class="myIframelink" src="<?= convertToEmbedUrl($property[0]['link']);?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> 
                  <?php } ?> 
               </div>
               <div class="col-md-6">
                  <?php if($property[0]['map_location']) { ?>
                  <div class="row pt-5 p-0 m-0">
                     <div class="  p-0 m-0  map col-md-12">
                        <?= $property[0]['map_location'];?>
                        <!-- <iframe src="<?= $property[0]['map_location'];?>" width="100%" height="450" class="myIframeloc" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>  -->
                     </div>
                  </div>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
   </div>
   <script>
      // Function to display overlay
      function showOverlay(container) {
          container.querySelector('.view-image').style.display = 'flex';
      }
      
      // Function to hide overlay
      function hideOverlay(container) {
          container.querySelector('.view-image').style.display = 'none';
      }
      
      // Function to handle "View Image" action
      function viewImage(overlay) {
          const imgSrc = overlay.previousElementSibling.src;
          window.open(imgSrc, '_blank'); // Opens the image in a new tab
      }
   </script>
   <script>
      let scrollInterval;
      let isScrolling = false;
      
      function startScrolling() {
      scrollInterval = setInterval(function() {
       let box = $("#scrollBox");
       box.scrollTop(box.scrollTop() + 1); // Scrolls down slowly
      }, 50);
      }
      
      function stopScrolling() {
      clearInterval(scrollInterval);
      }
      
   </script>
   <script>
      // function toggleShareOptions() {
      //     var shareDiv = document.getElementById("share-options");
      //     shareDiv.style.display = (shareDiv.style.display === "none" || shareDiv.style.display === "") ? "block" : "none";
      // }
      function copyToClipboard(text) {
          var tempInput = document.createElement("input");
          tempInput.value = text;
          document.body.appendChild(tempInput);
          tempInput.select();
          document.execCommand("copy");
          document.body.removeChild(tempInput);
          alert("Property link copied! Paste it in Instagram.");
      }
   </script>
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
       }, 3000); // 3000ms = 3 sec
   });
   </script>
   <?php include 'footer.php' ;?>
