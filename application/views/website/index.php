<!DOCTYPE html>
<html lang="en"><head>
   <meta charset="utf-8"/>
   <title> 
      KR Developers 
   </title>
   <meta name="description" content="KR Developers is a trusted real estate company specializing in residential, commercial, and luxury properties. We offer a wide range of innovative and high-quality real estate solutions, including affordable homes, luxury apartments, and prime commercial spaces. ">
   <meta name="keywords" content="Real estate developers, Luxury real estate properties, Residential and commercial properties">
   <meta name="author" content="ladderbricks.com">
   <meta name="viewport" content="width=device-width,initial-scale=1">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- <link rel="canonical" href="https://csplerp.com/hostel-management"/> -->
   <link rel="icon" type="image/x-icon" href="<?= site_url('uploads/img/logo.jpg');?>">
 
  
   <style type="">


p{
text-align: left;

font-size: 18px !important;
color: black !important;
}

</style>
<?php  include ('header.php');?>
   <div  class=" main ">
       
<?php if($this->session->flashdata('success')){ ?>
<div id="successMsg" style="font-weight:bold;" class="alert alert-success text-center">
    <?= $this->session->flashdata('success'); ?>
</div>
<?php } ?>

       <div class="container">  
       
        <section>
            
         <div class="row ">
            <div class="col-lg-12 loading-animation slide-top">
               <div id=" " class="  "  >
                  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1500">
                     <!-- Indicators -->
                     <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true"></button>
                        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1"></button>
                        <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2"></button>
                     </div>
                     <!-- Slides -->
                    <div class="carousel-inner">
    <div class="carousel-item active banner-img" style="background-image: url('<?= base_url('img/new-banner-3.jpg') ?>');">

<!-- 
         <div class="carousel-caption">
                <h2>Welcome to Our Website</h2>
                <p>Discover amazing experiences with us.</p>
                <a href="#" class="btn  ">Learn More</a>
            </div> -->
    </div>
    <div class="carousel-item banner-img" style="background-image: url('<?= base_url('img/new-banner-1.jpg') ?>');">


        <!--  <div class="carousel-caption">
                <h2>Welcome to Our Website</h2>
                <p>Discover amazing experiences with us.</p>
                <a href="#" class="btn  ">Learn More</a>
            </div> -->
    </div>
    <div class="carousel-item banner-img" style="background-image: url('<?= base_url('img/new-banner-2.jpg') ?>');">

        <!--  <div class="carousel-caption">
                <h2>Welcome to Our Website</h2>
                <p>Discover amazing experiences with us.</p>
                <a href="#" class="btn  ">Learn More</a>
            </div> -->
    </div>
</div>
                     <!-- Navigation Buttons -->
                     <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                     </button>
                     <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                     <span class="carousel-control-next-icon" aria-hidden="true"></span>
                     </button>
                  </div>
               </div>
            </div>
            <div class="col-lg-12 loading-animation slide-right">

                <div class="container">    <div class="hero-text text-center">
                  <h1>Find A <span>Perfect Home</span> To Live With Your Family</h1>
                  <p >Welcome to Ladderbricks, Odisha’s premier real estate company dedicated to providing top-notch services in property sales, rentals, and construction. Whether you’re looking for your dream home, a profitable commercial property, or need expert construction services, we are here to help you at every step of the way. With years of experience, a dedicated team of professionals, and an unwavering commitment to customer satisfaction, Ladderbricks is your trusted partner in making your real estate journey smooth and successful. 
</p>
                  <!-- <a href="#" class="btn">Get Started</a> -->
               </div> </div>
             
            </div>
         </div>
      </section>
      <!--<section class="about-section">-->
      <!--   <div class="container">-->
      <!--      <div class="row align-items-center">-->
               <!-- Image Section -->
      <!--         <div class="col-lg-6 position-relative loading-animation slide-left">-->
      <!--            <div class="image-wrapper">-->
      <!--               <img src="<?= base_url('img/about-us.jpg')?>" alt="Property">-->
      <!--               <div class="decorative-border"></div>-->
      <!--               <div class="decorative-border-bottom"></div>-->
      <!--            </div>-->
      <!--         </div>-->
               <!-- Text Section -->
      <!--         <div class="col-lg-6 loading-animation slide-bottom">-->
      <!--            <div class="text-content">-->
      <!--               <h2 class="animated-link">#1 Place To Find The Perfect Property</h2>-->
      <!--               <p>KR Developers is a trusted real estate company specializing in residential, commercial, and luxury properties. We offer a wide range of innovative and high-quality real estate solutions,</p>-->
      <!--               <ul class="check-list">-->
      <!--                  <li><i class="fas fa-check-circle"></i> Expertise & Experience</li>-->
      <!--                  <li><i class="fas fa-check-circle"></i> Quality & Transparency</li>-->
      <!--                  <li><i class="fas fa-check-circle"></i>Customer-Centric Approach</li>-->
      <!--               </ul>-->
      <!--               <a href="<?= base_url('pages/about')?>" class="btn-read-more">Read More</a>-->
      <!--            </div>-->
      <!--         </div>-->
      <!--      </div>-->
      <!--   </div>-->
      <!--</section>-->


<section>    

      <div class="container mt-5">
         <!-- Row for layout -->
         <div class="row align-items-center">
            <!-- Left side: Title & Description -->
            <div class="col-md-8 loading-animation slide-left">
               <div class="text-content animated-link">
                  <h2>Browse Premium Residential & Commercial Properties (PLOTS, FLATS, VILLAS etc.)</h2>
               </div>
            </div>
            <!-- Right side: Tab Buttons -->
            <!-- <div class="col-md-6 text-md-end text-start loading-animation slide-right">
               <div class="nav nav-pills d-inline-flex" id="tab-buttons" role="tablist">
                  <button class="tab-btn active me-2" id="tab-featured" data-bs-toggle="pill" data-bs-target="#featured" type="button" role="tab">Featured</button>
                  <button class="tab-btn me-2 " id="tab-for-sell" data-bs-toggle="pill" data-bs-target="#for-sell" type="button" role="tab">For Sell</button>
                  <button class="tab-btn me-2" id="tab-for-rent" data-bs-toggle="pill" data-bs-target="#for-rent" type="button" role="tab">For Rent</button>
               </div>
            </div> -->
         </div>
         <!-- Tab Content -->
     
                    
           
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
                                    <p class="card-text  "><?= $property['address'] ?></p>
                                    <p><strong class=" ">₹ <?= $property['price'] ?> * Onwards</strong></p> 
                                    <div class="d-flex justify-content-between">
                                        <span class="  fw-bold">&#128719; <?= ucfirst($property['prop_type']) ?></span>
                                        <span class="  fw-bold">&#x1F3E0; <?= $property['size'] ?> Sqft.</span>
                                    </div>
                                    <hr>
                                    <a href="<?= site_url('pages/details/' . $property['pid']) ?>" class="enquire-btn">View Details</a>
                                    <div class="row">
                                        <?php
                                            $whatsappno = $property['whatsappno'] ?? $property['userphone'] ?? '';
                                            $contactno = $property['contactno'] ?? $property['userphone'] ?? '';
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
                                        <!-- <div class="col-6 col-md-6" style="text-align: center;">
                                           <a href="<?= site_url('pages/enquiry/' . $property['pid']) ?>" class="enquire-btn btn-success" >Enquiry</a>
                                        </div>  -->
                                        <div class="col-6 col-md-6">
                                            <a href="javascript:void(0)"
                                               class="btn-success enquire-btn openEnquiry"
                                               data-pid="<?= $property['pid']; ?>">
                                               Enquiry
                                            </a>
                                        </div>

                                        <div class="col-3 col-md-3" style="text-align: center;">
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
                <p class="text-center  ">No properties available.</p>
            <?php endif; ?>
        </div>

        <!-- View More Button -->
        <?php if ($totalProperties > 6) : ?>
            <div class="text-center mt-4">
               <a href="<?= base_url('pages/listing')?>" id="viewMoreBtn" class="btn-read-more">View More</a>
               
            </div>
        <?php endif; ?>
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
                        <label style="font-weight:bold;">Expected Price Range</label>
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
        /*background:#1877F2;*/
        border-radius:50%;
        animation: glowPulse 1.5s infinite;
        /*box-shadow: 0 0 5px #1877F2;*/
    }

    .call-btn i{
        color:#fff;
        font-size:20px;
    }

    /* Animation */
    @keyframes glowPulse {
        0%{
            /*box-shadow: 0 0 5px #1877F2, 0 0 10px #1877F2;*/
            transform: scale(1);
        }
        50%{
            /*box-shadow: 0 0 15px #1877F2, 0 0 30px #1877F2;*/
            transform: scale(1.1);
        }
        100%{
            /*box-shadow: 0 0 5px #1877F2, 0 0 10px #1877F2;*/
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
</section>
            

         
           

 
            
            
     
    

           
           

         <!-- <center> <a href="<?= base_url('pages/listing')?>" class="text-decoration-none btn btn-outline-success  mt-3 btn-rounded"> View More </a>  </center> -->
      </div>
</section>
      <section id="our-mission" class="about-section">
      <div class="text-center  mb-4">
                             
                            <h2 class="main-heading  pb-3">Our Mission & Vision</h2>
                        </div>
<div class="container">      
                      
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="feature-box-2 hover-effect-1" style="border-right: 3px solid var(--primary-color);">

                                    <center>    <img src="<?= base_url('img/icons/mission.png')?>" class=" " height="100px">   <h4>Mission</h4> </center>

                                 
                                    <p>Our mission is simple: to provide an all-inclusive, hassle-free, and rewarding real estate experience for all our clients. We aim to offer the finest properties that align with the specific needs and preferences of our customers, whether for residential or commercial use. By blending modern technology, innovative strategies, and expert knowledge of the real estate market, we deliver services that go beyond expectations. Ladderbricks is committed to creating long-lasting relationships with every client, ensuring satisfaction from the first interaction to the final transaction.

</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="feature-box-2 hover-effect-1" style="border-right: 3px solid var(--primary-color);">
                                <center>    <img src="<?= base_url('img/icons/vision.png')?>" class=" "height="100px">   <h4>Vision</h4> </center>

                                    <p>To become Odisha's leading real estate company, renowned for our commitment to excellence, our personalized service, and our ability to adapt to the evolving demands of the real estate market. We envision expanding our footprint across India, offering innovative solutions that are environmentally sustainable, cost-effective, and customer-oriented.

</p>
                                </div>
                            </div>
                        </div>

                        </div>
                    </section>











  <!-- Our Expertise Section -->
                    <section id="why-choose-us" class="about-section">


                        <div class="container">
                             <center>   

                            <h2 class="section-title mb-0 text-center main-heading">Why Choose Us</h2> </center>
                       
                        
                       
                        
                        <div class="row mt-4">
                            <div class="col-md-6 mb-4">
                                <div class="feature-box-2">
<center>    <img src="<?= base_url('img/icons/wh-1.png')?>" class="about-icon">   <h4>Local Expertise</h4> </center>
                                   
                                  
                                    <p>With our deep knowledge of the Odisha real estate market, we are uniquely positioned to provide clients with insightful advice, valuable property recommendations, and expert guidance. Whether you’re looking for a residential property in Bhubaneswar, a commercial space in Cuttack, or a plot of land in the outskirts of the city, we have extensive market intelligence to help you make the right choice.
</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="feature-box-2">
                                    <center>    <img src="<?= base_url('img/icons/wh-2.png')?>" class="about-icon">   <h4>Comprehensive Service</h4> </center>
                                  
                                    <p>Ladderbricks offers a full range of services, making us a one-stop shop for all your real estate needs. From property sales and rentals to construction and property management, we provide everything you need under one roof, ensuring a streamlined and efficient process.
</p>
                                </div>
                            </div>
                           

 







                        </div>



<center>   <a href="<?= base_url('pages/about#why-choose-us')?>" class="btn-read-more">Read More</a></center>


                        </div>
                    </section>
                    


 <!-- Our Values Section -->
                    <section id="our-values" class="about-section">
                        <div class="text-center my-4">
                           
                            <h2 class="main-heading  ">Our Core Values</h2>
                        </div>

                        <div class="container">   <div class="row mt-4">
                            
                            <div class="col-md-4 mb-4">
                                <div class="card core-value-card hover-effect-1  ">

                                    <center>  <img src="<?= base_url ('img/icons/cv-1.png ')  ?>" alt="Icon"> </center>
                   
                    <h4>Integrity:</h4>
                    <p> We believe in being transparent and honest in all our dealings, ensuring that you can trust us every step of the way.</p>
                    
                </div>
                            </div>
                            <div class="col-md-4 mb-4">
                                <div class="card core-value-card hover-effect-1">

                                    <center>  <img src="<?= base_url ('img/icons/cv-2.png ')  ?>" alt="Icon"> </center>
                   
                    <h4>Customer-Centricity:</h4>
                    <p> Our clients’ needs are at the forefront of everything we do. We offer personalized services tailored to meet your individual preferences and requirements.</p>
                    
                </div>
                            </div>


                            <div class="col-md-4 mb-4">
                                <div class="card core-value-card hover-effect-1">

                                    <center>  <img src="<?= base_url ('img/icons/cv-3.png ')  ?>"> </center>
                   
                    <h4>Quality:</h4>
                    <p>Whether it’s a sale, a rental, or a construction project, we maintain the highest standards of quality in every aspect of our work.</p>
                    
                </div>
                            </div>
                          
                             
                        </div>


                        <center>   <a href="<?= base_url('pages/about#our-values')?>" class="btn-read-more">Read More</a></center>

                         </div>
                        
                       
                    </section>


  <section id="our-achievements" class="about-section">
                        <div class=" ">
                             
                            <center>   <h2 class="  mb-0 main-heading">Our Achievements</h2> </center>
                         
                        </div>
                        

                        <div class="container"> <div class="row mt-4">
                            <div class="col-md-3 mb-4">
                                <div class="stats-counter hover-effect-1">
                                    <div class="number">50+</div>
                                    <div class="label">Completed Projects</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stats-counter hover-effect-1">
                                    <div class="number">2000+</div>
                                    <div class="label">Happy Clients</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stats-counter hover-effect-1">
                                    <div class="number">15+</div>
                                    <div class="label">Years of Excellence</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-4">
                                <div class="stats-counter hover-effect-1">
                                    <div class="number">25+</div>
                                    <div class="label">Industry Awards</div>
                                </div>
                            </div>
                        </div>   </div>
                       
                    </section>





      <section class="mt-5">


        <div class="container">  
       
         <center> 
            <div class="row my-3  ">
               <div class="col appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="100">
                  <div class="owl-carousel-wrapper" style="height: 373px;">
                     <div class="owl-carousel carousel-shadow-1 carousel-shadow-1-bold owl-theme dots-horizontal-center custom-dots-style-1 dots-dark mb-0" data-plugin-options="{'responsive': {'576': {'items': 1}, '768': {'items': 2}, '992': {'items': 2}, '1200': {'items': 3}, '1440': {'items': 3}}, 'margin': 10, 'loop': true, 'nav':false, 'dots': false, 'dotsVerticalOffset': '30px', 'autoplay': true, 'autoplayTimeout': 1100}">
                        <a   class="popup-with-zoom-anim text-decoration-none align-items-center">
                           <div class="testimonial-card">
                              <p class="testimonial-text">
                               “I was looking for a commercial space for my startup, and Ladderbricks helped me find the perfect location at a competitive price. Their team guided me through every step, from negotiating the lease to finalizing the agreement. A truly professional experience.”

                              </p>
                              <div class="testimonial-user">
                                 <img src="<?= base_url('img/demo-user.jpg')?>" alt="Client">
                                 <div class="user-info">
                                    <span class="name">Ravi Sharma, Business Owner 
</span>
                                    <span class="profession">Bhubaneswar</span>
                                 </div>
                              </div>
                           </div>
                        </a>

                         <a   class="popup-with-zoom-anim text-decoration-none align-items-center">
                           <div class="testimonial-card">
                              <p class="testimonial-text">
                              “Buying my first home with Ladderbricks was a fantastic experience. Their team made the entire process smooth and stress-free. From selecting the property to completing the paperwork, everything was handled with professionalism and care.”

                              </p>
                              <div class="testimonial-user">
                                 <img src="<?= base_url('img/demo-user.jpg')?>" alt="Client">
                                 <div class="user-info">
                                    <span class="name">– Priya Agarwal, Homebuyer 
</span>
                                    <span class="profession">Cuttack</span>
                                 </div>
                              </div>
                           </div>
                        </a>

                        <a   class="popup-with-zoom-anim text-decoration-none align-items-center">
                           <div class="testimonial-card">
                              <p class="testimonial-text">
                             “As a real estate investor, I trust Ladderbricks to find me high-value properties with great potential. Their market insights are invaluable, and I know I’m always getting the best deals. They’re more than just a service provider—they’re a partner in my investment journey.”

 
                              </p>
                              <div class="testimonial-user">
                                 <img src="<?= base_url('img/demo-user.jpg')?>" alt="Client">
                                 <div class="user-info">
                                    <span class="name">Sandeep Jain, Real Estate Investor,
</span>
                                    <span class="profession">Cuttack</span>
                                 </div>
                              </div>
                           </div>
                        </a>


                        <a   class="popup-with-zoom-anim text-decoration-none align-items-center">
                           <div class="testimonial-card">
                              <p class="testimonial-text">
                              "I was looking for an affordable house in Rourkela, and they provided the best options within my budget. Very reliable service!"
 
 
                              </p>
                              <div class="testimonial-user">
                                 <img src="<?= base_url('img/demo-user.jpg')?>" alt="Client">
                                 <div class="user-info">
                                    <span class="name">Sneha Mishra</span>
                                    <span class="profession">Rourkela</span>
                                 </div>
                              </div>
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </center>
         </div>
      </section>
      
      </div>
   </div>
   <?php include "footer.php"; ?>

<!-- <script>
   $('#enquiryModal').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget);
       var pid = button.data('pid');
       $('#property_id').val(pid);
   });
</script>
 -->
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

