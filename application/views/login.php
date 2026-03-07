<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AB ENTERPRISE</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url();?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url();?>/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url();?>/plugins/iCheck/square/blue.css">

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap">
    <title>AB ENTERPRISE</title>
  <style>
   .login-content .login-box {
    position: relative;
    min-width: 350px;
    min-height: unset;
    background-color: #3d5293;
    -webkit-box-shadow: 0px 29px 147.5px 102.5px rgb(0 0 0 / 5%), 0px 29px 95px 0px rgb(0 0 0 / 16%);
    box-shadow: 0px 29px 147.5px 102.5px rgb(0 0 0 / 5%), 0px 29px 95px 0px rgb(0 0 0 / 16%);
    -webkit-perspective: 800px;
    perspective: 800px;
    -webkit-transition: all 0.5s ease-in-out;
    -o-transition: all 0.5s ease-in-out;
    transition: all 0.5s ease-in-out;
}
.material-half-bg .cover{
  height: 89vh;
}
@media(max-width: 720px){
  .col-md-5 .g{
    padding: 10px !important;
  }
h2 img{
  height: 100px !important;
}
.col-md-5{
  background-color: #fff !important;
}
 .col-5{
  padding: 0px;
 }
 .dnm{
  display: none;
 }
}
@media screen and (max-width: 2000px) and (min-width: 730px) {
  .dnw{
    display: none;
  }
} 

@import url("https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600&display=swap");


.title {
  font-family: "Dancing Script", cursive;
  font-size: 3rem;
  color: whitesmoke;
  position: relative;
}

</style>
  <script src="https://code.iconify.design/2/2.1.1/iconify.min.js"></script>
  </head>
  <body>
   <!--  <section class="material-half-bg">
      <div class="cover"></div>
    </section> -->
  <section  style="background-color:;">
  <div class="container-fluid" >
    <div class="row">
    <div class="col-md-7 dnm" style="background-color: #fff">
      <img src="<?=base_url();?>assets/user.gif" style=" width: 100%">
    </div>
    <div class="col-md-5" style="background-color: #fffffff5">
      <div class="g" style="padding: 10px">
        <div class="login-box"  style="border-radius:5px; ">
         <form class="login-form" action="<?php echo site_url("login");?>" method="post">
          <span class="dnw"><br><br></span>
          <!-- <h2><img src="<?=base_url();?>assets/logokr.png" style="height: 70px"> </h2><br>  -->
          <div class="row">
            <div class="col-md-12 col-7">
               <h3 class="login-head" style="color:black;text-align: -webkit-left;">
               <span style="font-size: 20px"> <img src="<?=base_url();?>assets/hi.jpg" style="height: 20px;"> Hi, <br>
                Welcome to AB ENTERPRISE ERP
               </span></h3>
            </div>
            
          </div>
          
          <br>
          <!-- /.login-logo -->
          <?php if($this->session->flashdata('error')){?>
          <div class="alert alert-dismissable alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error !</strong> <?php echo $this->session->flashdata('error');?>
          </div>
          <?php }?>
          <?php if($this->session->flashdata('success')){?>
          <div class="alert alert-dismissable alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $this->session->flashdata('success');?>
          </div>
          <?php }?>
          <?php if($blocked){?>
            <div class="alert alert-dismissable alert-warning">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Blocked !</strong> Your IP is blocked for 2 hours due invalid attempt
            </div>
          <?php }?>
          <?php  if ($this->session->userdata('otp')) {

           ?>
           <div class="loginsection">
            <p style="text-align:left!important;">OTP Sent</p>
              <span>Enter 6 digit OTP we sent to your e-mail.</span><br>
              
              <div class = "form-group ">
                <input type = "text" name = "otp" class = "form-control" placeholder="000000" style="" maxlength="6" autocomplete="off">
            </div>
            <div class="form-group btn-container" >
              <?php echo '<input type="hidden" name="sesusername" value="'.$this->session->userdata('username').'">
              <input type="hidden" name="sespassword" value="'.$this->session->userdata('password').'">';?>
              <button type="submit" name="submitBtn" value="submit" class="btn btn-primary btn-block btn-flat" <?=$blocked ? 'disabled="disabled"' : '';?> style="background-color: #2058F5; border:none;  "><i class="fa fa-check fa-lg fa-fw" ></i> Validate</button>
              <div class="col-md-12" style="padding:0;">
                <div class="row" style="margin-top:10px;">
                  <div class="col-md-6" >
                      <button type="submit" name="resendBtn" value="submit" class="btn btn-primary btn-block btn-flat" <?=$blocked ? 'disabled="disabled"' : '';?> style="background-color: #7f922d; border:none;  " formaction="<?=site_url("login/sendotp");?>"><i class="fa fa-key fa-lg fa-fw" ></i> Re-Send OTP</button>
                  </div>
                  <div class="col-md-6" > 
                      <button type="submit" name="resendBtn" value="submit" class="btn btn-primary btn-block btn-flat" <?=$blocked ? 'disabled="disabled"' : '';?> style="background-color: #107c9c; border:none;" formaction="<?=site_url("login/logout");?>"><i class="fa fa-refresh fa-lg fa-fw" ></i> Reset</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        
        <?php }else{ ?>
            <div class="otpsection">
              <div class="form-group">
                <label class="control-label" style="color:#0B7A6D">USERNAME</label>
                <input class="form-control" placeholder="User Name" name="username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" <?=$blocked ? 'disabled="disabled"' : '';?> type="text" autofocus required style="color:#007aa9">
              </div>
              <div class="form-group">
                <label class="control-label" style="color:#0B7A6D">PASSWORD</label>
                <input class="form-control" placeholder="Password" id="myInput" name="password"   type="password" required style="color:#007aa9" <?=$blocked ? 'disabled="disabled"' : '';?>><br>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <input type="checkbox" onclick="myFunction()"> Show Password
                </div>
                <div class="col-md-6">
                 
                </div>
              </div>
             <div class="form-group btn-container" >
                <button type="submit" name="submitBtn" value="submit" class="btn btn-primary btn-block btn-flat" <?=$blocked ? 'disabled="disabled"' : '';?> style="background-color: #2058F5; border:none;  " formaction="<?=site_url("login/sendotp");?>"><i class="fa fa-lock fa-lg fa-fw" ></i> Login</button>
                    
              </div>
            </div>
        <?php } ?>

            <br>
            
          </div>
            </form>
            <center>
              <h5 style="color:black;font-family: ;">Developed by <b><a href="https://cakiweb.com/" style="color:#bd1313;font-size: 16px;font-family: Dancing Script, cursive;font-size: 3rem; position: relative;" onmouseover="this.style='color:#66b021;';" onmouseout="this.style='color:#bd1313';" target="_blank" class="title" >Cakiweb</a></b></h5>
            </center>
          </div>
        
      </div>
      

    </div>
  </div>
    </div>
  </div>
</section>





<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
 <script src="<?php echo base_url();?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url();?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
 
</script>
</body>
</html>