var base_url = $('input[name="base_url"]').val();
var method = $('input[name="basemethod"]').val();

$(document).ready(function() {
    var tbl_shifts = $('#tbl_shifts').DataTable({
        "destroy":true,
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "pageLength": 50,
        "order": [[1, 'desc']],
        "columns": [
            { "data": "schedule_id","width":"10%" },
            { "data": "employeename","width":"20%" },
            { "data": "facility_name","width":"20%" },
            { "data": "schedule_date","width":"20%" },
            {
                "data": "schedule_status", "width":"20%", "render": function (data, type, row, meta) {
                    var str = '';
                    if(row.schedule_status == 2) {
                        str += `<p class="btn btn-sm btn-outline-primary">Taken</p>`;
                    } else if(row.schedule_status == 3) {
                        str += `<p class="btn btn-sm btn-outline-danger">Declined</p>`;
                    } else if(row.schedule_status == 4) {
                        str += `<p class="btn btn-sm btn-outline-warning">Close</p>`;
                    } else if (row.schedule_status == 4){
                        str += `<p class="btn btn-sm btn-outline-success">Completed</p>`;
                    }else{
                        str += `<p class="btn btn-sm btn-outline-success">Open</p>`;
                    }
                    return str;
                }
            },
            {
                "data": "schedule_id", "width":"20%", "render": function (data, type, row, meta) {
                    var str = '';
                    if(row.schedule_status == 2) {
                        str += '<button data-id="'+row.schedule_id+'" data-status="'+row.schedule_status+'" class="btn btn-sm btn-outline-success updateShiftStatus" title="Approve Shift"><i class="fa fa-check"></i></button>&nbsp;';
                        str += '<button data-id="'+row.schedule_id+'" data-status="'+row.schedule_status+'" class="btn btn-sm btn-outline-danger updateShiftStatus" title="Disapprove Shift"><i class="fa fa-times"></i></button>&nbsp;';
                    } else if(row.schedule_status == 4) {
                        str += '<button data-id="'+row.schedule_id+'" data-status="'+row.schedule_status+'" class="btn btn-sm btn-outline-success updateShiftStatus" title="Open Shift"><i class="fa fa-unlock"></i></button>&nbsp;';
                    } else {
                        
                    }
                    str += '<button data-toggle="modal" data-target="#modal_shiftDetails" data-id="'+row.schedule_id+'" class="btn btn-sm btn-outline-warning shiftDetails" title="Click to view"><i class="fa fa-eye"></i></button>&nbsp;';
                    return str;
                }
            },
        ],
        "language": { "search": '', "searchPlaceholder": "Search Shifts...","infoFiltered": "" },
        "ajax": {
            "url": base_url + "facilities/getShifts",
            "type": "POST",
            "beforeSend": function () {
                $('.tableLoad').show();
                $(".all_contents").css({ opacity: 0 });
            },
            "complete": function(){
                $('.tableLoad').hide();
                $(".all_contents").css({ opacity: 1 });
            },
        },
        "columnDefs": [
            {
                "targets": [0,5],
                "orderable": false,
            },
        ],
    });

    // Update Schedule
    $(document).on('submit','.form_updateSchedule',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_updateSchedule')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'facilities/updateSchedule', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_updateSchedule')[0].reset();
                renderCalendar();
                $('#modal_updateSchedule').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // Remove Schedule
    $(document).on('click','#removeSchedule',function(e){
        e.preventDefault();
        var schedule_id = $(this).data('id');
        confirm_swal('Are you sure you want to remove this Schedule?', 'Remove').then(function (val) {
            if (val === true) {
                const sendAjaxVar = sendAjax({
                    url: base_url + 'facilities/removeSchedule',
                    data: { schedule_id: schedule_id }
                });
                if (sendAjaxVar) {
                    $('#modal_updateSchedule').modal('toggle');
                    swal(sendAjaxVar.msg, sendAjaxVar.type);
                    renderCalendar();
                }
            }
        });
    });

    //Shift Update Status
    $(document).on('click','.updateShiftStatus',function(){
        var schedule_id = $(this).data('id');
        var schedule_status = $(this).data('status');
        if (schedule_status == 2) {
            confirm_swal('Approve employee shift request?', 'Enable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'facilities/updateShiftStatus/'+schedule_status,
                        data: { schedule_id: schedule_id, schedule_status: schedule_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_shifts.ajax.reload();
                    }
                }
            });

        }else if (schedule_status == 4) {
            confirm_swal('Open employee shift request?', 'Enable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'facilities/updateShiftStatus/'+schedule_status,
                        data: { schedule_id: schedule_id, schedule_status: schedule_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_shifts.ajax.reload();
                    }
                }
            });

        }else{
            confirm_swal('Decline employee shift request?', 'Disable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'facilities/updateShiftStatus/'+schedule_status,
                        data: { schedule_id: schedule_id, schedule_status: schedule_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_shifts.ajax.reload();
                    }
                }
            });
        }
    });
    /////////////////////////////////////===SHIFTS END====////////////////////////////////////////

    var tbl_facilities = $('#tbl_facilities').DataTable({
        "destroy":true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "responsive": true,
        "order": [[1, 'asc']], //Initial no order.
        "columns": [
            { "data": "facility_id","width":"15%" },
            // { "data": "facility_name","width":"30%" },
            {
                "data": "facility_name", "width":"30%", "render": function (data, type, row, meta) {
                    var str = '';
                    str = '<b><a class="facNameHover" href="'+base_url+'facilities/viewScheduleCalendar/'+row.facility_code+'/'+row.facility_id+'">'+row.facility_name+'</a></b>';
                    return str;
                }
            },
            { "data": "date_added","width":"15%" },
            {
                "data": "facility_id", "width":"10%", "render": function (data, type, row, meta) {
                    var str = '';
                    str += '<button data-toggle="modal" data-target="#modal_updateFacility" data-id="'+row.facility_id+'" class="btn btn-sm btn-outline-warning updateFacility" title="Click to update"><i class="fa fa-edit"></i> Edit</button>&nbsp;';
                    str += '<button data-id="'+row.facility_id+'" class="btn btn-sm btn-outline-danger removeFacility" title="Click to remove"><i class="fa fa-times-circle"></i> Remove</button>';
                    return str;
                }
            },
        ],
        "language": { "search": '', "searchPlaceholder": "Search Facility...","infoFiltered": "" },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "facilities/getFacilities",
            "type": "POST",
            "beforeSend": function () {
                $('.tableLoad').show();
                $(".all_contents").css({ opacity: 0 });
            },
            "complete": function(){
                $('.tableLoad').hide();
                $(".all_contents").css({ opacity: 1 });
            },
        },
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "targets": [3], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
    });

    $(document).on('click','.addFacility',function(e){
        e.preventDefault();
        clearError();
    });

    // =================================================Add Facility======================================
    $(document).on('submit','.form_addFacility',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_addFacility')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'facilities/addFacility', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_addFacility')[0].reset();
                tbl_facilities.ajax.reload();
                $('#modal_addFacility').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // =================================================Add Schedule======================================
    $(document).on('submit','.form_addSchedule',function(e){
        
        e.preventDefault();
        var form_data = new FormData($('.form_addSchedule')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'facilities/addSchedule', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('#modal_addSchedule').modal('toggle');
                
            } else {
                
                $.each(sendAjaxVar, function (key, value) {
                    
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // =================================================Add Multi Schedule======================================

    $(document).on('submit','.form_addMultiSchedule',function(e){
        
        e.preventDefault();
        var form_data = new FormData($('.form_addMultiSchedule')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'facilities/addMultiSchedule', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('#modal_addMultiSchedule').modal('toggle');
                
            } else {
                
                $.each(sendAjaxVar, function (key, value) {
                    
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // =================================================Update Facility======================================
    $(document).on('click','.updateFacility',function(){
        facility_id = $(this).data('id');
        var data = sendAjax({ url: base_url + 'facilities/getFacilityInfo', data: { facility_id: facility_id}});
        $('.form_updatefacility')[0].reset();
        clearError();
        input('input[name="up_facility_id"]', facility_id);
        input('input[name="facilityname"]', data.facility_name);
        $('.form_addFacility')[0].reset();
    });

    $(document).on('submit','.form_updatefacility',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_updatefacility')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'facilities/updateFacility', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_updatefacility')[0].reset();
                tbl_facilities.ajax.reload();
                $('#modal_updateFacility').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // =================================================Remove Facility======================================
    $(document).on('click','.removeFacility',function(e){
        e.preventDefault();
        var facility_id = $(this).data('id');
        confirm_swal('Are you sure you want to remove this Facility?', 'Remove').then(function (val) {
            if (val === true) {
                const sendAjaxVar = sendAjax({
                    url: base_url + 'facilities/removeFacility',
                    data: { facility_id: facility_id }
                });
                if (sendAjaxVar) {
                    swal(sendAjaxVar.msg, sendAjaxVar.type);
                    tbl_facilities.ajax.reload();
                }
            }
        });
    });

}); // End of Document Ready

function sendAjax(param = {},isReturn = true){
    if(isReturn === false){
        var return_response = null;
        $.ajax({
            url:param.url,
            type: 'post',
            data:param.data,
            async:false,
            processData: false,
            contentType: false,
            dataType:'json',
            beforeSend: function() {
              $('.buttonLoader').show();
            },
            success:function(response){
                $('.buttonLoader').hide();
                console.log(response);
                return_response = response;
            },error:function(e){
                console.log(e);
            }
        });
        return return_response;
    } else {
        var return_data = null;
        $.ajax({
            url:param.url,
            type: 'post',
            data:param.data,
            async:false,
            dataType:'json',
            success:function(response){
                return_data = response;
            },error:function(e){
                console.log(e);
            }
        });

        if(isReturn){
            return return_data;
        }
    }
}

function confirm_swal(text,confirmBtnText){
    var isSuccess = false;
    return new Promise(function(resolve, reject) {
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmBtnText
        }).then((result) => {
            if (result.value) {
                resolve(true);
            } else {
                resolve(false);
            }
        });
   });
}

function swal(content,response = 'success'){
    if(response == 'success'){
        if(content === 'Error adding Schedule: Please select days without overlapping a month')
        {
            Swal.fire("Error",content,"error");
        }else{
            Swal.fire("Success",content,response);
            console.log(content);
            if(content === 'Schedule Added Successfully'){
                setTimeout(function(){
                    window.location.reload(1);
                }, 2000);
            }
        }
    }else{
        Swal.fire("Error",content,response);
    }
}

function clearError() {
    $('.err').html('');
}

function input(element,value){
    $(element).val(value);
}

function customswal(msg) {
    let timerInterval;
    Swal.fire({
        title: 'Success!',
        html: 'Will close in <b></b>',
        text: msg,
        type: 'success',
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok',
        allowOutsideClick: false,
        allowEscapeKey: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            timerInterval = setInterval(() => {
              const content = Swal.getHtmlContainer();
              if (content) {
                const b = content.querySelector('b');
                if (b) {
                  b.textContent = (Swal.getTimerLeft() / 1000).toFixed(0);
                }
              }
            }, 100)
          },
          willClose: () => {
            clearInterval(timerInterval)
        },
    }).then((result) => {
        if (result) {
            location.reload();
        }
    });
}

// to check if the current url is in the page that uses the calendar
// var curURL = window.location.href;
// function findWord(word, curURL) {
//     return RegExp('\\b'+ word +'\\b').test(curURL)
// }
// if(findWord("viewScheduleCalendar",curURL)){
if (method == 'viewScheduleCalendar') {
    renderCalendar();
}
function renderCalendar() {
// document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var facilityID = document.getElementById('facility_id_holder').textContent;
 
    var getSched = base_url + 'facilities/getSchedules/'+ facilityID;
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
    
    selectable: true,
    unselectAuto: true,
    
    dateClick: function(info) {
        clearError();
        $('input[name=Shift_Date]').val(info.dateStr);
        $("#modal_addSchedule").modal();
        
    },
    select: function(info) {
       
        var start = info.startStr;
        var end = info.endStr;
        const dates = [start,end];
        var dateData = dates.map(Date.parse);
        var DateDifference = BigInt(dateData[1]) - BigInt(dateData[0]);
        // used to determine if the selected date is one or two days or more
        if(DateDifference == 86400000){//86400000 is the difference if it is one day
            
        }else{
            clearError();

            var str = dateData[1];
            var strToDate = new Date(str);
            var lastDayOfMonth = new Date(strToDate.getFullYear(), strToDate.getMonth()+1, 0);
            lastDayOfMonth = lastDayOfMonth.getDate();
            var day = strToDate.getDate() - 1;
            // if(day == lastDayOfMonth){
            //     alert(lastDayOfMonth);
            //     alert('dasdasd');
            // }else{
                
            // }
            var year = strToDate.getFullYear();
            var month = strToDate.getMonth() + 1;

            if(month < 10){
                month = '0'+month;
            }
            if(day < 10 && day > 0){
                var endDate = year+'-'+month+'-0'+day;
            }else if(day == 0){
                var endDate = year+'-'+month+'-01';
            }else if(day + 1 == lastDayOfMonth){
                var endDate = year+'-'+month+'-'+lastDayOfMonth;
            }else{
                var endDate = year+'-'+month+'-'+day;
            }
            
            $('input[name=Start_Date]').val(info.startStr);
            $('input[name=End_Date]').val(endDate);
            $('input[name=lastDayofMonth]').val(lastDayOfMonth);
            $("#modal_addMultiSchedule").modal();
        }
    },
    eventClick: function(info) {
        var schedule_id = info.event._def.publicId;
        var data = sendAjax({ url: base_url + 'facilities/getScheduleInfo', data: { schedule_id: schedule_id}});
        $('.form_updateSchedule')[0].reset();
        clearError();
        input('input[name="upsched_id"]',schedule_id);
        input('input[name="upShift_Date"]',data.schedule_date);
        input('input[name="upShift_Time_Start"]',data.time_start);
        input('input[name="upShift_Time_End"]',data.time_end);
        $('#removeSchedule').data('id',schedule_id);
        $('#modal_updateSchedule').modal('toggle');
    },
    
    // height: 650,
    initialView: 'dayGridMonth',
    // initialDate: '2021-11-07',
    headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: ''
    // right: 'dayGridMonth,timeGridWeek,timeGridDay'
    },
    events: getSched,
    eventColor: '#6cc1bd',
    eventTimeFormat: {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    },
    displayEventEnd: true,

    // [
    // {
    //   title: 'All Day Event',
    //   start: '2021-11-01'
    // },
    // {
    //   title: 'Long Event',
    //   start: '2021-11-07',
    //   end: '2021-11-10'
    // },
    // {
    //   groupId: '999',
    //   title: 'Repeating Event',
    //   start: '2021-11-09T16:00:00'
    // },
    // {
    //   groupId: '999',
    //   title: 'Repeating Event',
    //   start: '2021-11-16T16:00:00',
    //   end: '2021-11-16T18:00:00'
    // },
    // {
    //   title: 'Conference',
    //   start: '2021-11-11T10:30:00',
    //   end: '2021-11-12T12:30:00'
    // },
    // {
    //   title: 'Meeting',
    //   start: '2021-11-12T10:30:00',
    //   end: '2021-11-12T12:30:00'
    // },
    // {
    //     title: 'Meeting2',
    //     start: '2021-11-12T10:30:00',
    //     end: '2021-11-12T12:30:00'
    //   },
    // {
    //   title: 'Lunch',
    //   start: '2021-11-12T12:00:00'
    // },
    // {
    //   title: 'Meeting',
    //   start: '2021-11-12T14:30:00'
    // },
    // {
    //   title: 'Birthday Party',
    //   start: '2021-11-13T07:00:00'
    // },
    // {
    //   title: 'Click for Google',
    //   url: 'http://google.com/',
    //   start: '2021-11-28'
    // }
    // ]
    });
    calendar.destroy();
    calendar.render();
    calendar.on('dateClick', function(info) {
        console.log('clicked on ' + info.dateStr);
      });
    // });

// }
}