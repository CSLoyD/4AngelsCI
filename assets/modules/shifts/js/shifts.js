var base_url = $('input[name="base_url"]').val();
var method = $('input[name="basemethod"]').val();
$(document).ready(function() {
    shiftsTable();

    //======================Shift Update Satus
    $(document).on('click','.updateShiftStatus',function(){
        var schedule_id = $(this).data('id');
        var schedule_status = $(this).data('status');
        if (schedule_status == 2) {
            confirm_swal('Approve employee shift request?', 'Enable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'shifts/updateShiftStatus/'+schedule_status,
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
                        url: base_url + 'shifts/updateShiftStatus/'+schedule_status,
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
                        url: base_url + 'shifts/updateShiftStatus/'+schedule_status,
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

    $(document).on('change', '.filterType', function() {
        shiftsTable($(this).val());
    });
});


function shiftsTable(filter = 'all') {
    $('#tbl_shifts').DataTable({
        "destroy":true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "responsive": true,
        "pageLength": 50,
        "order": [[1, 'desc']], //Initial no order.
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
                    } else if (row.schedule_status == 5){
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
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "shifts/getShifts",
            "type": "POST",
            "data": { filter:filter },
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
                "targets": [0,5], //first column / numbering column
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

