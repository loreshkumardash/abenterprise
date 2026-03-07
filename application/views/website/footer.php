
<style type="text/css">
      
    </style>






<style>
        footer {
            background-color:var(--secondary-color) !important;
            color: white;
            padding: 40px 0 0 0;
        }
        
        .footer-title {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 1.2rem;

            color: white;
        }
        
        .contact-info {
            margin-bottom: 8px;
        }
        
   .contact-info p {
     color:white !important;
        }

       
   .contact-info b{
     color:#fff !important;
     font-size:18px !important;
        }
        .contact-info i {
            margin-right: 10px;
            color: #ffffff;
        }
        
        .quick-links a {

            display: block;
            color: white;

font-weight: bold;
            text-decoration: none;
            margin-bottom: 5px;
            transition: color 0.3s;
        }
        
        .quick-links a:hover {
            color:var(--primary-color);
        }
        
    .social-icons-f a {
            color: white;
            margin-right: 15px;
            font-size: 18px;
            transition: color 0.3s;
        }
        
        .social-icons-f a:hover {
            color: #00e0c6;
        }
        
        .gallery-img {
            margin-bottom: 15px;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .gallery-img img {
            width: 100%;
            height: 70px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        
        .gallery-img img:hover {
            transform: scale(1.05);
        }
        
        .newsletter-input {
            border-radius: 0;
            margin-bottom: 15px;
        }
        
        .signup-btn {
            background-color: #00e0c6;
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 12%;
            transition: background-color 0.3s;

        }
        
        .signup-btn:hover {
            background-color: #00c4ad;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 0;
            margin-top: 30px;
        }
        
        .copyright {
            font-size: 14px;
        }
        
        .designed-by a {
            color: #000;
            text-decoration: none;
        }
        
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background-color:black;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .back-to-top:hover {
            background-color: #00c4ad;
        }
        
        @media (max-width: 767px) {
            .footer-section {
                margin-bottom: 30px;
            }
        }
    </style>



 



 

 
 



<footer>
        <div class="container">
            <div class="row">
                <!-- Get In Touch Section -->
                <div class="col-md-3 col-sm-6 footer-section">
                    <h3 class="footer-title">Get In Touch</h3>
                    <div class="contact-info">
                        <p  class="m-0 p-0 " ><i class="fas fa-map-marker-alt"></i> Ladderbricks Pvt. Ltd.
Plot No. 123, ABC Road,
Bhubaneswar, Odisha, 751001, India.</p>
                        <p class="m-0 p-0 "><b> <i class="fas fa-phone"></i>Sales & Rentals: </b> +91 8260672752</p>
                         <p class="m-0 p-0 "><b> <i class="fas fa-phone"></i>Construction Services: </b>  <br> +91 8260672752</p>
                    </div>
                    <!-- <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div> -->
                </div>

                <div class="col-md-3 col-sm-6 footer-section">
                    <h3 class="footer-title">E Mail</h3>
                    <div class="contact-info">
                        
                        <p class="m-0 p-0 "><b> <i class="fas fa-envelope"></i>General Inquiries:  </b> info@ladderbricks.com</p>
                         <p class="m-0 p-0 "><b> <i class="fas fa-envelope"></i>Sales & Rentals: </b>  <br> sales@ladderbricks.com</p>
                          <p class="m-0 p-0 "><b> <i class="fas fa-envelope"></i>Construction: </b>  <br> construction@ladderbricks.com</p>
                    </div>
                    <!-- <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div> -->
                </div>
                
                <!-- Quick Links Section -->
                <div class="col-md-3 col-sm-6 footer-section">
                    <h3 class="footer-title">Quick Links</h3>
                    <div class="quick-links">
                        <a href="  <?= base_url('pages/listing')?> " class="m-0 p-0 "><i class="fa-solid fa-chevron-right fa-sm" style="color:var(--primary-color);"></i>  &nbsp Properties</a>
                        <a href="<?= base_url('pages/contact_us')?>" class="m-0 p-0 "> <i class="fa-solid fa-chevron-right fa-sm" style="color: var(--primary-color);"></i>  &nbsp Contact Us</a>
                        <a href="<?= base_url('pages/about')?>" class="m-0 p-0 "><i class="fa-solid fa-chevron-right fa-sm" style="color:var(--primary-color);"></i>  &nbsp About</a>
                        <a href="<?= base_url('pages/privacyPolicy')?>" class="m-0 p-0 "><i class="fa-solid fa-chevron-right fa-sm" style="color:var(--primary-color);"></i>  &nbsp Privacy Policy</a>
                        <a href="<?= base_url('pages/termCondition')?>" class="m-0 p-0 "><i class="fa-solid fa-chevron-right fa-sm" style="color: var(--primary-color);"></i>  &nbsp Terms & Conditions</a>
                    </div>
                </div>
                
                <!-- Photo Gallery Section -->
             <!--    <div class="col-md-2 col-sm-6 footer-section">
                    <h3 class="footer-title">Photo Gallery</h3>
                    <div class="row">
                        <div class="col-4 gallery-img">
                            <img src="/api/placeholder/150/100" alt="Property 1">
                        </div>
                        <div class="col-4 gallery-img">
                            <img src="/api/placeholder/150/100" alt="Property 2">
                        </div>
                        <div class="col-4 gallery-img">
                            <img src="/api/placeholder/150/100" alt="Property 3">
                        </div>
                        <div class="col-4 gallery-img">
                            <img src="/api/placeholder/150/100" alt="Property 4">
                        </div>
                        <div class="col-4 gallery-img">
                            <img src="/api/placeholder/150/100" alt="Property 5">
                        </div>
                        <div class="col-4 gallery-img">
                            <img src="/api/placeholder/150/100" alt="Property 6">
                        </div>
                    </div>
                </div>
                 -->
                <!-- Newsletter Section -->
                <div class="col-md-3 col-sm-6 footer-section">
                   
                   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3743.206357224716!2d85.83991807523557!3d20.250274781211314!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a19a7006b8fa06f%3A0xc4cdfbb36b3930b1!2sKR%20Developer!5e0!3m2!1sen!2sin!4v1743230488495!5m2!1sen!2sin" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>


                    <div class="social-icons-f mt-3 d-none">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p class="copyright text-light">© KR Developer, All Rights Reserved. Designed By <a href="https://cakiweb.com/" target="_blank" style="color: white;">Cakiweb Solutions Pvt. Ltd.</a></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Back to Top Button -->
        <div class="back-to-top  " id="back-to-top">
            <i class="fas fa-arrow-up"></i>
        </div>
    </footer>

<!-- Vendor -->
<script data-cfasync="false" 
src="<?= base_url('../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js')?>"></script>
<script src="<?= base_url('vendor/jquery/jquery.min.js')?>"></script>
<script src="<?= base_url('vendor/jquery.appear/jquery.appear.min.js')?>"></script>
<script src="<?= base_url('vendor/jquery.easing/jquery.easing.min.js')?>"></script>
<script src="<?= base_url('vendor/jquery.cookie/jquery.cookie.min.js')?>"></script>
<script src="<?= base_url('vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<script src="<?= base_url('vendor/jquery.validation/jquery.validate.min.js')?>"></script>
<script src="<?= base_url('vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js')?>"></script>
<script src="<?= base_url('vendor/jquery.gmap/jquery.gmap.min.js')?>"></script>
<script src="<?= base_url('vendor/lazysizes/lazysizes.min.js')?>"></script>
<script src="<?= base_url('vendor/isotope/jquery.isotope.min.js')?>"></script>
<script src="<?= base_url('vendor/owl.carousel/owl.carousel.min.js')?>"></script>
<script src="<?= base_url('vendor/magnific-popup/jquery.magnific-popup.min.js')?>"></script>
<script src="<?= base_url('vendor/vide/jquery.vide.min.js')?>"></script>
<script src="<?= base_url('vendor/vivus/vivus.min.js')?>"></script>
   <script src="<?= base_url('js/demos/demo-real-estate.js')?>"></script>
<!-- Theme Base, Components and Settings -->
 
<!-- Current Page Vendor and Views -->
 
<!-- Demo -->
 
 <!-- bootstrap -->
 



<!-- Theme Base, Components and Settings -->
      <script src="<?= base_url('js/theme.js')?>"></script>

      <!-- Current Page Vendor and Views -->
      <script src="<?= base_url('js/views/view.contact.js')?>"></script>

      <!-- Demo -->
      <script src="<?= base_url('js/demos/demo-real-estate.js')?>"></script>

      <!-- Theme Initialization Files -->
      <script src="<?= base_url('js/theme.init.js')?>"></script>
<!-- Theme Initialization Files -->
<script src="<?= base_url('js/theme.init.js')?>"></script>
<script defer src="<?= base_url('../../../../static.cloudflareinsights.com/beacon.min.js')?>" data-cf-beacon='{"rayId":"699d277a9ee30da4","version":"2021.9.0","r":1,"token":"03fa3b9eb60b49789931c4694c153f9b","si":100}'></script>
<script>
   // Get elements
   const enquiryBtn = document.getElementById('enquiryBtn');
   const modalBg = document.getElementById('modalBg');
   const closeModal = document.getElementById('closeModal');
   
   // Show the modal when the enquiry button is clicked
   enquiryBtn.addEventListener('click', () => {
       modalBg.style.display = 'block';
   });
   
   // Close the modal when the close button is clicked
   closeModal.addEventListener('click', () => {
       modalBg.style.display = 'none';
   });
   
   // Close the modal when clicking outside the modal content
   window.addEventListener('click', (e) => {
       if (e.target == modalBg) {
           modalBg.style.display = 'none';
       }
   });
</script>

<script>
         $(document).ready(function () {
            // Show or hide the button when scrolling
            $(window).scroll(function () {
                if ($(this).scrollTop() > 300) {
                    $('#back-to-top').fadeIn();
                } else {
                    $('#back-to-top').fadeOut();
                }
            });

            // Smooth scroll to top
            $("#back-to-top").click(function () {
                $("html, body").animate({ scrollTop: 0 }, 600);
            });
        });
    </script>


      <script type="text/javascript">
      $(document).ready(function () {
                  function checkScroll() {
                      let windowHeight = $(window).height();
                      let scrollTop = $(window).scrollTop();
      
                      $(".loading-animation").each(function () {
                          let elementTop = $(this).offset().top;
                          let animationType = $(this).data("animation");
      
                          if (scrollTop + windowHeight > elementTop + 50) {
                              $(this).addClass("visible");
                          } else {
                              $(this).removeClass("visible");
                          }
                      });
                  }
      
                  // Run on page load and scroll
                  $(window).on("scroll", checkScroll);
                  checkScroll();
              });

$(document).ready(function () {
    function checkScroll() {
        let windowHeight = $(window).height();
        let scrollTop = $(window).scrollTop();

        $(".serial-load").each(function () {
            let elementTop = $(this).offset().top;

            if (scrollTop + windowHeight > elementTop + 50) {
                let delay = $(this).data("delay") || 0;
                $(this)
                    .delay(delay)
                    .queue(function (next) {
                        $(this).addClass("visible").fadeIn(300); // Fade-in with 300ms duration
                        next();
                    });
            }
        });
    }

    });


   

   </script>
</body>
</html>