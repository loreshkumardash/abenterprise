 


<?php session_start(); ?>
  
 
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
 
    
      <meta name="author" content=" ">
      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= base_url('img/cspl-favicon.png')?>" type="image/cspl-favicon.png" />
      <link rel="apple-touch-icon" href="<?= base_url('img/cspl-favicon.png')?>">
      <link rel="icon" type="image/x-icon" href="<?= site_url('uploads/img/logo.jpg');?>">
  
 
      <!-- Web Fonts  -->
      <link id="googleFonts" 
      href="<?= base_url('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800%7CShadows+Into+Light&amp;display=swap')?>" 
      rel="stylesheet" type="text/css">
      <!-- Vendor CSS -->
      <link rel="stylesheet" href="<?= base_url('vendor/bootstrap/css/bootstrap.min.css')?>">
      <link rel="stylesheet" href="<?= base_url('vendor/fontawesome-free/css/all.min.css')?>">
      <link rel="stylesheet" href="<?= base_url('vendor/animate/animate.compat.css')?>">
      <link rel="stylesheet" href="<?= base_url('vendor/simple-line-icons/css/simple-line-icons.min.css')?>">
      <link rel="stylesheet" href="<?= base_url('vendor/owl.carousel/assets/owl.carousel.min.css')?>">
      <link rel="stylesheet" href="<?= base_url('vendor/owl.carousel/assets/owl.theme.default.min.css')?>">
      <link rel="stylesheet" href="<?= base_url('vendor/magnific-popup/magnific-popup.min.css')?>">
      <!-- Theme CSS -->
      <link rel="stylesheet" href="<?= base_url('css/theme.css')?>">
      <link rel="stylesheet" href="<?= base_url('css/theme-elements.css')?>">
      <link rel="stylesheet" href="<?= base_url('css/theme-blog.css')?>">
      <link rel="stylesheet" href="<?= base_url('css/theme-shop.css')?>">
      <!-- Demo CSS -->
      <!-- <link rel="stylesheet" href="css/demos/demo-real-estate.css"> -->
      <!-- <link id="skinCSS" rel="stylesheet" href="css/skins/skin-corporate-3.css"> -->
      <link id="skinCSS" rel="stylesheet" href="<?= base_url('css/skins/skin-medical.css')?>">
      <!-- icon CSS -->
      <link rel="stylesheet" href="<?= base_url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css')?>" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!-- Theme Custom CSS -->
      <link rel="stylesheet" href="<?= base_url('css/custom.css')?>">
        <link rel="stylesheet" href="<?= base_url('css/blogs.css')?>">

<!-- Demo CSS -->
      <link rel="stylesheet" href="<?= base_url('css/demos/demo-real-estate.css')?>">

      <!-- Skin CSS -->
      <link id="skinCSS" rel="stylesheet" href="<?= base_url('css/skins/skin-real-estate.css')?>">


      <!-- font-awesome -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <!-- Head Libs -->
      <script src="<?= base_url('vendor/modernizr/modernizr.min.js')?>"></script>
      <!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="<?= base_url('https://www.googletagmanager.com/gtag/js?id=G-SEP1T05Z5V')?>"></script>
      <!--  <script>
         window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
         gtag('js', new Date());
         
         gtag('config', 'G-SEP1T05Z5V');
         </script> -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
         new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
         j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
         'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
         })(window,document,'script','dataLayer','GTM-PPXLPR2X');
      </script>
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   </head>










 

 

 



   <style type="text/css">
      

   
        .social-icons {
            position: fixed;
            top: 50%;
  left: 0;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
            
            z-index:1000;
        }
        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: #333;
            color: white;
            text-decoration: none;
            font-size: 24px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .social-icons a:hover {
            background: #555;
        }



 .sticky-button {
    position: fixed;
    font-weight:bold;
right:-2% ;
    top: 50%;
    transform: translateY(-50%);
 background:#63b22d ;
    color: #fff; /* Text color */
   border-radius:12px !important;
    font-size: 16px;
    font-weight: bold;
 
    text-decoration: none;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 3000;
    transform: translateY(-50%) rotate(-90deg); /* Rotate text */

}

.sticky-button:hover {
    background-color: #000;
    text-decoration: none;
    color: #fff;
}



@media (max-width: 768px) {
    .sticky-button {
    position: fixed;
   right:-15px;
    top: 50%;
 
 
    color: #fff; /* Text color */
   
    font-size: 12px;
    font-weight: bold;
    border-radius: 0 5px 5px 0; /* Rounded edges on right */
    text-decoration: none;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    transition: 0.3s;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 3000;
    transform: translateY(-50%) rotate(-90deg); /* Rotate text */


}
}

  .modal-dialog {
            max-width: 95vw; /* 95% of the viewport width */
            margin: 1.5rem auto; /* Center modal vertically */
        }




  .nav-link{
    color: #fff !important;
  }


 
  @media (max-width: 576px) {
    h2 {
        font-size: 1.5rem;
            line-height: 1 !important ;
    }
     h3 {
        font-size: 1rem;
    }
      h4 {
        font-size: 0.7rem;
    }

}

@media (min-width: 768px) {
    h2 {
        font-size: 2rem;
    }
     h3 {
        font-size: 1.5rem;
    }
      h4 {
        font-size: 1rem;
    }

}

@media (min-width: 992px) {
    h2 {
        font-size: 2rem;
    }
     h3 {
        font-size: 1.7rem;
    }
      h4 {
        font-size: 1.3rem;
    }


}
 
  .carousel-item {
         width: 100% !important;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        object-fit: cover;
    }

   /* Centering the text */
    .carousel-caption {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 2;
    }

    .carousel-caption h2 {
        font-size: 2.5rem;
        font-weight: bold;
    }

    .carousel-caption p {
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .carousel-caption .btn {
        padding: 10px 20px;
        font-size: 1rem;
        color: white;
        background: var(--primary-color);
        border-radius: 12px !important;
    }

    .form-label{


font-weight: bold;
color: black;
    }
@media(max-width:991px){

  #header .header-nav-main nav > ul{
background:var(--secondary-color); !important;

 }


    }

   </style>
   <body>
       
       
       <button class="btn   sticky-button" type="button"data-bs-toggle="modal" data-bs-target="#fullWidthModal1">
									Enquiry   
									</button>
									
									
							<div class="modal fade" id="fullWidthModal1" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h3 class="modal-title " id="modalTitle">Customer Enquiry Form</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form action="<?=site_url('pages/submitEnquiry')?>" method="POST">
    <div class="row">
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Contact Number <span style="color: red;">*</span></label>
            <input type="tel" class="form-control" name="mobile" placeholder="Enter your Mobile number" required>
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Email (Optional)</label>
            <input type="email" class="form-control" name="email" placeholder="Enter your email">
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">WhatsApp Number</label>
            <input type="tel" class="form-control" name="wp_no" placeholder="Enter Your WhatsApp number">
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Type of Enquiry</label>
            <select class="form-select" name="specification">
                <option value="">--Select Type--</option>
                <option value="Plot">Plot</option>
                <option value="Flat">Flat</option>
                <option value="Villa">Villa</option>
                <option value="Duplex">Duplex</option>
                <option value="Triplex">Triplex</option>
                
            </select>
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Preferred Location <span style="color: red;">*</span></label>

            <input type="text" class="form-control" name="preferred_location" placeholder="Enter Your Preferred Location">
            
           
        </div>
 
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Budget Range</label>
            <select class="form-select" name="budget">
                <option value="">--Select Budget Range--</option>
                <option value="Below 10 Lakh/-">Below 10 Lakh/-</option>
                <option value="10 Lakh/- to 20 Lakh/-">10 Lakh/- to 20 Lakh/-</option>
                <option value="20 Lakh/- to 40 Lakh/-">20 Lakh/- to 40 Lakh/-</option>
                <option value="40 Lakh/- to 60 Lakh/-">40 Lakh/- to 60 Lakh/-</option>
                <option value="60 Lakh/- to 80 Lakh/-">60 Lakh/- to 80 Lakh/-</option>
                <option value="Above 80 Lakh/-">Above 80 Lakh/-</option>
            </select>
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Mode of Deal</label>
            <select class="form-select" name="deal_mode">
                <option value="">--Select Mode of Deal--</option>
                <option value="Loan">Loan</option>
                <option value="Cash">Cash</option>
            </select>
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Occupation</label>
            <input type="text" class="form-control" name="occupation" placeholder="Enter your occupation">
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Salary (Optional)</label>
            <input type="text" class="form-control" name="salary" placeholder="Enter your salary">
        </div>

        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Plan Out Date</label>
            <input type="date" class="form-control" name="plan_o_date">
        </div>

        <div class="col-12 mb-3">
            <label class="form-label">Message/Query</label>
            <textarea class="form-control" name="message" rows="3" placeholder="Enter your message"></textarea>
        </div>

        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary px-4">Submit</button>
        </div>
    </div>
</form>

            </div>
           
        </div>
    </div>
</div>
		
									
								<div class="modal fade" id="fullWidthModal2" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title text-light" id="modalTitle">Request For Site Visit</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
   <form class="container mt-4" action="<?=site_url('pages/siteVisit')?>" method="POST">
    <div class="row">
        <!-- Name -->
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Name <span style="color: red;">*</span></label>
            <input type="text" class="form-control" name="c_name" placeholder="Enter your name" required>
        </div>

        <!-- Contact Number -->
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Contact Number <span style="color: red;">*</span></label>
            <input type="number" class="form-control" name="con_no" placeholder="Enter your Mobile number" maxlength="10" required>
        </div>

        <!-- Email (Optional) -->
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Email (Optional)</label>
            <input type="email" class="form-control" name="email" placeholder="Enter your email">
        </div>

        <!-- Preferred Visit Date -->
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Preferred Visit Date <span style="color: red;">*</span></label>
            <input type="date" class="form-control" name="visit_date" required>
        </div>

        <!-- Preferred Time Slot -->
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Preferred Time Slot</label>
            <select class="form-select" name="time_slot">
                <option value="">--Select Time Slot--</option>
                <option value="Morning">Morning</option>
                <option value="Afternoon">Afternoon</option>
                <option value="Evening">Evening</option>
            </select>
        </div>

        <!-- Specific Time Drop Box -->
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Specific Time (Optional)</label>
            <input type="time" class="form-control" name="specific_time">
        </div>

        <!-- Property Interested In -->
        <div class="col-md-6 col-12 mb-3">
            <label class="form-label">Property Interested In</label>
            <select class="form-select" name="prop_interest">
                <option>--Select Property Type--</option>
                <option value="Flat">Flat</option>
                <option value="Plot">Plot</option>
                <option value="Villa">Villa</option>
                <option value="Duplex">Duplex</option>
                <option value="Triplex">Triplex</option>
                
            </select>
        </div>

        <!-- Specific Requirements -->
        <div class="col-12 mb-3">
            <label class="form-label">Any Specific Requirements?</label>
            <textarea class="form-control" name="notes" rows="3" placeholder="Enter any special requests or preferences..."></textarea>
        </div>

        <!-- Submit Button -->
        <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary px-4">Submit</button>
        </div>
    </div>
</form>


            </div>
           
        </div>
    </div>
</div>		
									
									
                                    <div class="row align-items-center">
							 
						 
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PPXLPR2X"
         height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
         
      
  <div class="social-icons  ">
        <a href="#" target="_blank"  style="background:#1877F2;"  class="d-none"><i class="fab fa-facebook-f" class="d-none"></i></a>
        
        
        
        
        <a href="https://api.whatsapp.com/send?phone=918260672752&text=Hello%20there!" target="_blank" style="background: #25D366;" ><i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i></a>
        
        
        
        
        <a href="#" target="_blank"style="background: #833ab4;
  background: linear-gradient(
    to right,
    #833ab4,#fd1d1d,#fcb045
  );"  class="d-none"  ><i class="fab fa-instagram"></i></a>
        
        
        
        
        
        <a href="tel:+918260672752" target="_blank" style="background:#1877F2;"><i class="fa-solid fa-phone-volume fa-sm" style="color: #ffffff;"></i></a>
    </div>
     
      </div>
      <header id="header" class="header-effect-shrink" data-plugin-options="{'stickyEnabled': true, 'stickyEffect': 'shrink', 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile':true
         , 'stickyChangeLogo': false, 'stickyStartAt': 70, 'stickyHeaderContainerHeight': 70}">
         <div class="header-body border-top-0" style="background: #001000;">
          <!--   -->
            <div class="  container  "  style="height: 65px;">
               <div class="header-row main-nav ">
                  <div class="header-column">
                     <div class="header-row">
                        <div class="header-logo">
                           <a href="#" class="mt-2">
                           <img alt="Porto" width="200" class="pt-1" height="70" data-sticky-width="50" data-sticky-height="50" src="<?= base_url('img/logo/kr-logo-200.jpg
                           ')?>">

                        
                           </a>

                        <!-- <a href="#" class="d-none d-md-block mt-2">
                          

                            <img alt="Porto" width="168" class="pt-1" height="38" data-sticky-width="150" data-sticky-height="50" src=" <?= base_url('img/logo/kr-developers.png')?>">
                           </a> -->
                        </div>
                     </div>
                  </div>
                  <div class="header-column justify-content-end ">
                     <div class="header-row pb-5">
                        <div class="header-nav header-nav-links  ">
                           <div class="header-nav-main header-nav-main-square header-nav-main-dropdown-no-borders header-nav-main-dropdown-modern header-nav-main-effect-2 header-nav-main-sub-effect-1">
                              <nav class="collapse">
                                 <ul class="nav nav-pills" id="mainNav">
                                    <li class="">
                                       <a class="nav-link    " href="<?= base_url('pages/index')?>">


                                       Home
                                       </a>
                                    </li>

                                    <li>
                                       <a class="nav-link  " href="<?= base_url('pages/about')?>">
                         About
                                       </a>
                                    </li>
                                    <li class="dropdown">
                                      <a class="nav-link    " href="<?= base_url('pages/listing')?>">


                                  Properties
                                       </a>
                                    </li>

                                    <li>
                                       <a class="nav-link  " href="<?= base_url('pages/services')?>">
                    Services
                                       </a>
                                    </li>
                                   
                                    <li>
                                       <a class="nav-link" href="<?= base_url('pages/contact_us')?>">
                                       Contact
                                       </a>
                                    </li>
                                  
                                
                                    
                                    
                                    
                                   
                                    <li class=" ">     <a href="#" class=" pb-2 text-center   text-decoration-none  ">
                                       <button class="split-button-2   text-light  text-3 fw-bold p-2"   type="button"data-bs-toggle="modal" data-bs-target="#fullWidthModal2" style="  height: 40px; border-radius: 7px; padding-right: 5px; padding-left: 5px;"> REQUEST FOR SITE VISIT
                                       </button>
                                       </a>
                                    </li>
                                 </ul>
                              </nav>
                           </div>
                           <button class="btn header-btn-collapse-nav bg-transparent " data-bs-toggle="collapse" data-bs-target=".header-nav-main nav" style="  background:#00a5e8;">
                           <i class="fas fa-bars mt-5 fa-2x " style="  color:var(--primary-color);"></i>
                           </button>
                        </div>
                        <div class="header-nav-features header-nav-features-no-border header-nav-features-lg-show-border order-1 order-lg-2">
                           <div class="header-nav-feature header-nav-features-search d-inline-flex">
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         </div>
      </header>
   <!--    <div class="row  p-2 " style="background: #00a5e8;
         ">
         <div class="col-md-12 text-center text-light font-weight-Light text-capitalize  " > <a href="index.php#demo-contact" class="text-light text-decoration-none text-3 fw-bold"> Start Your 15 Days <span>FREE</span> Trial  Now !</a> </div>
      </div> -->