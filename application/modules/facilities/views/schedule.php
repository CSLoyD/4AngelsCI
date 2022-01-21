<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            
            </h3>
        </div>
    </div>
    <span id='facility_id_holder' hidden><?php echo $facDetails['facility_id'];?></span>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="delivery-tab" data-toggle="pill" href="#delivery" role="tab" aria-controls="pills-delivery" aria-selected="true"><?php echo $facDetails['facility_name'];?> Facility</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pickup-tab" data-toggle="pill" href="#pickup" role="tab" aria-controls="pills-pickup" aria-selected="false">Shifts Request</a>
        </li>
    </ul>
    
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="delivery" role="tabpanel" aria-labelledby="pills-delivery-tab">
        <!-- Tab 1 -->
            <div class="row all_contents">
                <div class="col-md-12">
                    <div class="card">
                    <div class="row page-titles">
                        <div class="col-md-5 align-self-center">
                            <h3 class="text-themecolor schedTitle">
                            Schedules
                            </h3>
                        </div>
                    </div>
                        <div class="card-body">
                        <div id='calendar' style="width: 90%;margin: 0 auto;"></div> 
                        </div>
                    </div>
                </div>
            </div>
         <!-- Tab 1 End -->
        </div>

        <div class="tab-pane fade" id="pickup" role="tabpanel" aria-labelledby="pickup-tab">
        <!-- Tab 2 -->
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">
                    Pick-up Shift Request
                    </h3>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            <div class="row tableLoad">
                <img src="<?php echo base_url()?>assets/build/images/tableLoader.gif" alt="Loading Icon"><br />
                <span>Loading...</span>
            </div>

            <div class="row all_contents">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="tbl_shifts" class="table table-hover table-striped tbl_shifts">
                                <thead>
                                    <tr>
                                        <th>Schedule Id</th>
                                        <th>Employee Name</th>
                                        <th>Facility Name</th>
                                        <th>Schedule Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tab 2 End-->
        </div>
    </div>

</div>

<!-- =============================Add Schedule Modal================================= -->
<div id="modal_addSchedule" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="icon-user"></i> Add a Schedule</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
                <form class="form_addSchedule" action="" method="post">
                <div class="form-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date</label>
                                <input type="date" class="form-control" name="Shift_Date" value="" >
                                <input type="hidden" class="form-control" name="facilityID" value="<?php echo $facDetails['facility_id'];?>">
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Start Shift</label>
                                <input type="time" class="form-control" name="Shift_Time_Start" require>
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">End Shift</label>
                                <input type="time" class="form-control" name="Shift_Time_End" require>
                                <small class="err"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Add Schedule <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- =============================Update Schedule Modal================================= -->
<div id="modal_updateSchedule" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="icon-user"></i> Update Schedule</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
                <form class="form_updateSchedule" action="" method="post">
                <div class="form-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date</label>
                                <input type="date" class="form-control" name="upShift_Date">
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Start Shift</label>
                                <input type="time" class="form-control" name="upShift_Time_Start" required>
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">End Shift</label>
                                <input type="time" class="form-control" name="upShift_Time_End" required>
                                <small class="err"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <input type="hidden" name="upsched_id">
                        <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-calendar"></i> Update Schedule <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        <br /><br /> - OR - <br /><br />
                        <button type="button" id="removeSchedule" class="btn btn-danger btn-m"><i class="fa fa-calendar"></i> Remove Schedule <i class="buttonLoader"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>

<!-- =============================Add Multiple Schedule  Modal================================= -->

<div id="modal_addMultiSchedule" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="icon-user"></i> Add a Schedule</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
                <form class="form_addMultiSchedule" action="" method="post">
                <div class="form-body">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Start Date</label>
                                <input type="date" class="form-control" name="Start_Date" value="" >
                                <input type="hidden" class="form-control" name="facilityID" value="<?php echo $facDetails['facility_id'];?>">
                                <input type="hidden" class="form-control" name="lastDayofMonth" value="">
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">End Date</label>
                                <input type="date" class="form-control" name="End_Date" value="" >
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">Start Shift</label>
                                <input type="time" class="form-control" name="Shift_Time_Start" require>
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="control-label">End Shift</label>
                                <input type="time" class="form-control" name="Shift_Time_End" require>
                                <small class="err"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Add Schedule <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  </div>
</div>



<script>

      // document.addEventListener('DOMContentLoaded', function() {
      //   var calendarEl = document.getElementById('calendar');
      //   var calendar = new FullCalendar.Calendar(calendarEl, {
      //     initialView: 'dayGridMonth'
      //   });
      //   calendar.render();
      // });


//       document.addEventListener('DOMContentLoaded', function() {
//   var calendarEl = document.getElementById('calendar');
//
//   var calendar = new FullCalendar.Calendar(calendarEl, {
//
//     dateClick: function() {
//     alert('a day has been clicked!');
//     },
//
//     initialView: 'dayGridMonth',
//     initialDate: '2021-11-07',
//     headerToolbar: {
//       left: 'prev,next today',
//       center: 'title',
//       right: 'dayGridMonth,timeGridWeek,timeGridDay'
//     },
//     events: [
//       {
//         title: 'All Day Event',
//         start: '2021-11-01'
//       },
//       {
//         title: 'Long Event',
//         start: '2021-11-07',
//         end: '2021-11-10'
//       },
//       {
//         groupId: '999',
//         title: 'Repeating Event',
//         start: '2021-11-09T16:00:00'
//       },
//       {
//         groupId: '999',
//         title: 'Repeating Event',
//         start: '2021-11-16T16:00:00'
//       },
//       {
//         title: 'Conference',
//         start: '2021-11-11',
//         end: '2021-11-13'
//       },
//       {
//         title: 'Meeting',
//         start: '2021-11-12T10:30:00',
//         end: '2021-11-12T12:30:00'
//       },
//       {
//         title: 'Lunch',
//         start: '2021-11-12T12:00:00'
//       },
//       {
//         title: 'Meeting',
//         start: '2021-11-12T14:30:00'
//       },
//       {
//         title: 'Birthday Party',
//         start: '2021-11-13T07:00:00'
//       },
//       {
//         title: 'Click for Google',
//         url: 'http://google.com/',
//         start: '2021-11-28'
//       }
//     ]
//   });
//
//
//   calendar.render();
// });

</script>
