<?php $this->load->view("common/meta");?>

<style type="text/css">
      
        #map {
          height: 50vh;
          width: 80%;
        }

      
        
.wrapper12 {
  display: inline-block;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%)
}

.video-main {
  position: relative;
  display: inline-block;
  margin-top: 45vh;
}

.video {
  height: 50px;
  width: 50px;
  line-height: 50px;
  text-align: center;
  border-radius: 100%;
  background: transparent;
  color: #fff;
  display: inline-block;
  background: #000000;
  z-index: 999;
}

@keyframes waves {
  0% {
    -webkit-transform: scale(0.2, 0.2);
    transform: scale(0.2, 0.2);
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  }
  50% {
    opacity: 0.9;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=90)";
  }
  100% {
    -webkit-transform: scale(0.9, 0.9);
    transform: scale(0.9, 0.9);
    opacity: 0;
    -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  }
}

.fa-play:before {
  content: "\f04b";
}

.waves {
  position: absolute;
  width: 100px;
  height: 100px;
  background: rgba(0, 0, 0, 0.3);
  opacity: 0;
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  border-radius: 100%;
  right: -25px;
  bottom: -25px;
  z-index: -1;
   -webkit-animation: waves 3s ease-in-out infinite;
  animation: waves 3s ease-in-out infinite;
}
        
.wave-1 {
  -webkit-animation-delay: 0s;
  animation-delay: 0s;
}

.wave-2 {
  -webkit-animation-delay: 1s;
  animation-delay: 1s;
}

.wave-3 {
  -webkit-animation-delay: 2s;
  animation-delay: 2s;
}
    </style>
<div class="wrapper">

  <?php $this->load->view("common/sidebar");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Tracking view
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">View Records on Map </h3>
              
            </div>
            <!-- /.box-header -->
            
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <?php
                  if($this->session->flashdata('success')){
                  ?>
                  <div class="alert alert-dismissable alert-success">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success !</strong> <?php echo $this->session->flashdata('success');?>
                  </div>
                  <?php
                  }
                  
                  if($this->session->flashdata('error')){
                  ?>
                  <div class="alert alert-dismissable alert-danger">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <strong>Success !</strong> <?php echo $this->session->flashdata('error');?>
                  </div>
                  <?php
                  }
                  ?>
                </div>
                <div class="col-md-12 row">
                <div class="col-md-3 col-3 col-xs-3 col-xl-3 col-sm-3">
                  <center>
                  <h4 style="font-family:monospace;"><b><?=$user[0]['firstname'].' '.$user[0]['lastname'];?></b></h4>
                  <span>Date: <?=$userdate;?></span>
                </center>
                  <div class="wrapper12">
                  <div class="video-main">
                    <div class="promo-video">
                      <div class="waves-block">
                        <div class="waves wave-1"></div>
                        <div class="waves wave-2"></div>
                        <div class="waves wave-3"></div>
                      </div>
                    </div>
                    <a href="javascript:void();" class="video video-popup mfp-iframe" data-lity id="videoplaybtn"><i class="fa fa-play"></i></a>
                  </div>
                  </div>

                </div>
                <div class="col-md-9 col-9 col-xs-9 col-xl-9 col-sm-9">
                   <center>
                    <div id="map" style="box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;">map</div>
                  </center>
                </div> 
              </div> 
  
    
          </div>
        </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->

<?php $this->load->view("common/script");?>
<script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCU0kuFMQ1jMuonnkXU3R-s2TeRhmkJf8I&callback=initMap&v=weekly"
      defer
    ></script>

<script type="text/javascript">
      
function initMap() {
  var flightPlanCoordinates = new Array();
     <?php   
     $rl_min = array_column($location, 'lat'); 
     $rlng_min = array_column($location, 'lng'); ?>
     <?php  $min = min($rl_min);
      $max = max($rlng_min);

            if ($location) { for ($i=0; $i < count($location); $i++) { ?>

        var point =new google.maps.LatLng(<?=$location[$i]['lat'];?>,<?=$location[$i]['lng'];?>);
        flightPlanCoordinates.push(point);  
     <?php }}
    
     ?>

  var min = <?php echo $min?>; 
  var max = <?php echo $max?>; 


  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 11,
    center: { lat: min, lng: max },
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  });

  var lineSymbol = {
    path: google.maps.SymbolPath.CIRCLE,
    scale: 8,
    strokeColor: "#393",
  };
var animationInterval;
      var isPlaying = false;
  const flightPath = new google.maps.Polyline({
    icons: [
      {
        icon: lineSymbol,
        offset: "100%",
      },
    ],
    path: flightPlanCoordinates,
    geodesic: true,
    strokeColor: "#FF0000",
    strokeOpacity: 1.0,
    strokeWeight: 2,
  });
var line = flightPath;
const locationButton = document.getElementById("videoplaybtn")

  /*locationButton.textContent = "Pan to Current Location";
  locationButton.classList.add("custom-map-control-button");
  map.controls[google.maps.ControlPosition.BOTTOM_LEFT].push(locationButton);*/

locationButton.addEventListener("click", () => {
  animateCircle(line);
});
  flightPath.setMap(map);
}

function animateCircle(line) {
  let count = 0;

  let intervalHandler = window.setInterval(() => {
    count = (count + 1) % 200;

    const icons = line.get("icons");

    icons[0].offset = count / 2 + "%";
    line.set("icons", icons);
    if (count >= 199)
        window.clearTimeout(intervalHandler);
  }, 20);

}

window.initMap = initMap;
    </script>
    </body>
</html>
