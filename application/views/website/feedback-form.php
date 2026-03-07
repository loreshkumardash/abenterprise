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
<?php  include 'header.php'  ?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .hidden { display: none; }
        .rating input { display: none; }
        .rating label { font-size: 1.5rem; cursor: pointer; color: #ccc; }
        .rating input:checked ~ label { color: gold; }
    </style>
     <style>
        .stars {
            display: flex;
            cursor: pointer;
        }
        .star {
            font-size: 30px;
            color: gray;
            transition: color 0.3s;
            margin-right: 5px;
        }
        .star.active {
            color: goldenrod;
        }
        input, select, textarea{
            border: 1px solid black !important;
        }
    </style>
 

    <div class="container mt-2" style="min-height:80%;">
        <h2 class="text-center mb-4" style="color:indigo;">Site Visit Feedback Form</h2>

        <!-- Feedback Form -->
        <form id="feedbackForm" class="bg-white p-4 shadow rounded" 
        action="<?=site_url('pages/feedback')?>" method="POST">
            <div class="row">
                <!-- Name -->
                <div class="col-md-6  mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" required>
                </div>

                <!-- Contact Number -->
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">Contact Number <span style="color: red;">*</span></label>
                    <input type="mobile" class="form-control" name="mob_no" placeholder="Enter your Mobile number" required>
                </div>

                <!-- Date of Visit -->
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">Date of Visit <span style="color: red;">*</span></label>
                    <input type="date" class="form-control" name="date_visit" required>
                </div>

                <!-- Property Visited -->
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">Property Visited</label>
                    <select class="form-select" name="prop_visited">
                        <option value="">--Select Property Type--</option>
                        <option value="Flat">Flat</option>
                        <option value="Plot">Plot</option>
                        <option value="Villa">Villa</option>
                        <option value="Duplex">Duplex</option>
                        <option value="Triplex">Triplex</option>
                        
                    </select>
                </div>

                <!-- Star Rating -->
                <div class="col-12 mb-3 stars" id="starContainer">
                    <label class="form-label">How would you rate the visit?</label>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <i class="fa-solid fa-star star" data-value="1"></i>
                    <i class="fa-solid fa-star star" data-value="2"></i>
                    <i class="fa-solid fa-star star" data-value="3"></i>
                    <i class="fa-solid fa-star star" data-value="4"></i>
                    <i class="fa-solid fa-star star" data-value="5"></i>
                </div>
                <input type="hidden" name="rating" id="rating">
                

                <!-- What did you like about the property? -->
                <div class="col-12 mb-3">
                    <label class="form-label">What did you like about the property?</label>
                    <textarea class="form-control" name="likes" rows="3" placeholder="Share your thoughts..."></textarea>
                </div>

                <!-- Any concerns or suggestions? -->
                <div class="col-12 mb-3">
                    <label class="form-label">Any concerns or suggestions?</label>
                    <textarea class="form-control" name="concerns" rows="3" placeholder="Share your feedback..."></textarea>
                </div>

                <!-- Interested in proceeding further? -->
                <div class="col-md-6 col-12 mb-3">
                    <label class="form-label">Interested in proceeding further?</label>
                    <select class="form-select" name="proceed">
                        <option value="">--Select an option--</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                        <option value="Need More Info">Need More Info</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-info px-4">Submit</button>
                </div>
            </div>
        </form>

        <!-- Thank You Message (Hidden Initially) -->
       <!--  <div id="thankYouMessage" class="hidden text-center p-4 mt-4 bg-white shadow rounded">
            <h3 class="text-success">Thank You for Your Feedback! 🎉</h3>
            <p>We appreciate your time and effort in helping us improve. Your response has been successfully submitted.</p>
            <button onclick="resetForm()" class="btn btn-secondary">Back</button>
        </div> -->
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('.star').on('click', function() {
                let rating = $(this).data('value');
                $('#rating').val(rating);
                $('.star').each(function() {
                    $(this).toggleClass('active', $(this).data('value') <= rating);
                });
            });
        });
    </script>
<?php  include 'footer.php'  ?>
