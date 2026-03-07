<?php $this->load->view("common/meta");?>
<div class="wrapper">
  <?php $this->load->view("common/sidebar");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Holidays
      </h1>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">        
        <div class="col-md-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Holidays</h3>
              <!-- <a href="<?=site_url("masters/holidays");?>" class="btn btn-primary btn-sm" style="float:right;">Add New</a> -->
            </div>
            <div class="box-body">
              <div id='calendar'></div>
	      <input type="hidden" id="selected_sdate">
              <input type="hidden" id="selected_edate">
            </div>
          </div>
        </div>
      </div>   
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php $this->load->view("common/footer");?>
</div>
<!-- ./wrapper -->
  <div id="createEventModal" class="modal fade">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <strong>Add Holiday/Event</strong>
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span> <span class="sr-only">close</span></button>
              </div>
              <form id="event-form">
                <div id="modalBody" class="modal-body addRowDiv">
                  <div class="row addRow">
                    <div class="col-sm-12 form-group">
                        <label>  Name of the Holiday/Event </label>
                        <input type="text" id="event_name" class="form-control event_name" autocomplete="off">
                        <span class="text-error">The field is required.</span>
                    </div>
                    <div class="col-sm-12 form-group">
                         <label> Type </label>
                         <select class="form-control type" id="type">
                          <option value="">---Select---</option>
                          <option value="1">Holiday</option>
                          <option value="2">Event</option>
                        </select>
                        <span class="text-error">The field is required.</span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                </div>
              </form>
          </div>
      </div>
  </div>
<?php $this->load->view("common/script");?>

<link href='<?php echo base_url()?>assets/lib/main.css' rel='stylesheet' />
<script src='<?php echo base_url()?>assets/lib/main.js'></script>
    <script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var date = new Date();
    var valid_upto = date.getFullYear()+'-12-31';
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        //right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      initialDate: new Date(),
      navLinks: true, // can click day/week names to navigate views
      selectable: true,
      selectMirror: true,
      validRange: {
        end: valid_upto
      },
      select: function(arg) {
        var start_date = arg.startStr;
        var end_date = arg.endStr;
        $("#selected_sdate").val(start_date);
        $("#selected_edate").val(end_date);

        diffDays = Math.round(Math.abs((arg.end - arg.start) / (24 * 60 * 60 * 1000)));
        if(diffDays>1){
           $("#type option[value='1']").prop("disabled", true);
        }else{
          $("#type option[value='1']").prop("disabled", false);
        }

        $('#createEventModal').modal('show');

        $('#btnSave').on('click',function(){
          if(!validateEvent())
            return false;
          var event_name = $('#event_name').val();
          var type = $('#type').val();
          // alert(start_date +'---'+ end_date);
          if(start_date == $("#selected_sdate").val() && end_date == $("#selected_edate").val()){
            $.ajax({
                method:'post',
                url: appUrl+'/Ajax_requests/addHoliday',
                dataType:'json',
                data:{event_name:event_name,type:type,start_date:start_date,end_date:end_date},
                success:function(res){
                  if(res.status === 200){
                    var txtType = (type == 1)?'(Holiday)':'(Event)';
                    calendar.addEvent({
                        id:res.uid,
                        title: event_name+' '+txtType,
                        allDay: arg.allDay,              
                        start: arg.start,
                        end: arg.end,
                        extendedProps: {
                          start_date: start_date,
                          end_date: end_date,
                          name: event_name,
                          type: type,
                          uid: res.uid
                        }
                    });
                    $('#event_name').val('');
                    $('#type').val('');
                  }
                }
            }); 
          }

          $('#createEventModal').modal('hide');
        });

        calendar.unselect()
      },
      eventClick: function(arg) {
        console.log(arg.event);
        if (confirm('Are you sure you want to delete this event?')) {
          var id = arg.event['_def']['extendedProps'].uid;
          $.ajax({
              method:'post',
              url: appUrl+'/Ajax_requests/removeHoliday',
              dataType:'json',
              data:{id:id},
              success:function(res){
                if(res.status === 200){
                  arg.event.remove();
                }
              }
          }); 
        }
      },
      editable: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: <?php echo json_encode($event); ?>
    });
    calendar.render();
  });


function validateEvent(){
  $('#event-form').find(".text-error").hide();
  if($('#event_name').val() == ''){
      $('#event_name').next(".text-error").show();
      return false;
  }
  if($('#type').val() == ''){
      $('#type').next(".text-error").show();
      return false;
  }
  return true;
}
</script>
<style>
.text-error{
  color: red;
  display: none;
}
</script>
</body>
</html>