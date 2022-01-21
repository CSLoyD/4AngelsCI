var base_url = $('input[name="base_url"]').val();

$(document).ready(function() {

    attendanceTable();

    // =================================================View Attendance======================================
    $(document).on('click','.viewAttendance',function(){
        attendance_id   = $(this).data('id');
        employeename    = $(this).data('employeename');
        var data = sendAjax({ url: base_url + 'attendance/getAttendanceInfo', data: { attendance_id: attendance_id, type:'view'}});
        $('.form_viewAttendance')[0].reset();
        clearError();
        input('input[name="viewemployeename"]', employeename);
        input('input[name="viewclockin"]', data.clockin_time);
        input('input[name="viewclockout"]', data.clockout_time);
        input('input[name="viewdate"]', data.date_added);
        input('input[name="viewtotalhours"]', data.total_hrs_rendered);
    });

    // =================================================Update Attendance======================================
    $(document).on('click','.updateAttendance',function(){
        attendance_id = $(this).data('id');
        var data = sendAjax({ url: base_url + 'attendance/getAttendanceInfo', data: { attendance_id: attendance_id, type:'update'}});
        $('.form_updateAttendance')[0].reset();
        input('input[name="upattendance_id"]', attendance_id);
        input('input[name="upclockin"]', data.clockin_time);
        input('input[name="upclockout"]', data.clockout_time);
        clearError();

    });

    $(document).on('submit','.form_updateAttendance',function(e){
        e.preventDefault();
        var employee    = $('select[name="filterEmployee"]').val();
        var date        = $('input[name="filterDate"]').val();
        var time        = $('select[name="filterTime"]').val();
        var form_data = new FormData($('.form_updateAttendance')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'attendance/updateAttendance', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_updateAttendance')[0].reset();
                attendanceTable(employee,date,time);
                $('#modal_updateAttendance').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // =================================================Filters======================================
    $(document).on('change', 'select[name="filterEmployee"]', function() {
        var employee    = $(this).val();
        var date        = $('input[name="filterDate"]').val();
        var time        = $('select[name="filterTime"]').val();
        attendanceTable(employee,date,time);
    });
    $(document).on('change', 'input[name="filterDate"]', function() {
        var employee    = $('select[name="filterEmployee"]').val();
        var date        = $(this).val();
        var time        = $('select[name="filterTime"]').val();
        attendanceTable(employee,date,time);
    });
    $(document).on('change', 'select[name="filterTime"]', function() {
        var employee    = $('select[name="filterEmployee"]').val();
        var date        = $('input[name="filterDate"]').val();
        var time        = $(this).val();
        attendanceTable(employee,date,time);
    });

}); // End of Document Ready

function attendanceTable(employee = 'all',date = '',time = 'all') {

    $('#tbl_attendance').DataTable({
        "destroy":true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "responsive": true,
        "order": [[1, 'desc']], //Initial no order.
        "columns": [
            { "data": "employeename","width":"20%" },
            { "data": "date_added","width":"15%" },
            { "data": "clockin_time","width":"15%" },
            {
                "data": "total_hrs_rendered", "width":"10%", "render": function (data, type, row, meta) {
                    var str = '';
                    (row.total_hrs_rendered == 0) ? str += `<span>Pending</span>` : str += row.total_hrs_rendered + ` Hour(s)`;
                    return str;
                }
            },
            {
                "data": "attendance_id", "width":"10%", "render": function (data, type, row, meta) {
                    var str = '';
                    str += '<button data-toggle="modal" data-target="#modal_viewAttendance" data-id="'+row.attendance_id+'" data-employeename="'+row.employeename+'" class="btn btn-sm btn-outline-info viewAttendance" title="Click to view"><i class="fa fa-eye"></i> View</button>&nbsp;';
                    str += '<button data-toggle="modal" data-target="#modal_updateAttendance" data-id="'+row.attendance_id+'" class="btn btn-sm btn-outline-warning updateAttendance" title="Click to update"><i class="fa fa-edit"></i> Edit</button>&nbsp;';
                    return str;
                }
            },
        ],
        "language": { "search": '', "searchPlaceholder": "Search Attendance...","infoFiltered": "" },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "attendance/getAttendance",
            "type": "POST",
            "data": { employee:employee,date:date,time:time },
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
                "targets": [4], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
    });
}

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
        Swal.fire("Success",content,response);
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