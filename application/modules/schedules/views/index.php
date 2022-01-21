<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            Schedules
            </h3>
        </div>
    </div>
    <div id='calendar' style="width: 80%;margin: 0 auto;"></div>

</div>

<!-- =============================Add User Modal================================= -->
<div id="modal_addUser" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><i class="icon-user"></i> Add a Schedule</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
                <form class="form_addUser" action="" method="post">
                <div class="form-body">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Date</label>
                                <input type="date" class="form-control" name="DateShift" value="2013-01-08">
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Start Shift</label>
                                <select name="usertype" class="form-control text-center">
                                    <option value="1">Admin</option>
                                    <option value="2">Supervisor</option>
                                    <option value="3">Manager</option>
                                </select>
                                <small class="err"></small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">End Shift</label>
                                <select name="usertype" class="form-control text-center">
                                    <option value="1">Admin</option>
                                    <option value="2">Supervisor</option>
                                    <option value="3">Manager</option>
                                </select>
                                <small class="err"></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Add Schedule</button>
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
