var base_url = $('input[name="base_url"]').val();
$(document).ready(function(){
// ======= Users Table ============
    usersTable();

    $(document).on('submit','.form_addUser',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_addUser')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'users/addUser', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_addUser')[0].reset();
                tbl_users.ajax.reload();
                $('#modal_addUser').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    $(document).on('click','.updateUserStatus',function(){
        var user_id = $(this).data('id');
        var user_status = $(this).data('status');
        if (user_status == 1) {
            confirm_swal('Disable this User?', 'Disable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'users/userStatus',
                        data: { user_id: user_id, user_status: user_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_users.ajax.reload();
                    }
                }
            });
        } else{
            confirm_swal('Enable this User?', 'Enable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'users/userStatus',
                        data: { user_id: user_id, user_status: user_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_users.ajax.reload();
                    }
                }
            });
        }
    });

    $(document).on('click','.removeUser',function(e){
        e.preventDefault();
        var user_id = $(this).data('id');
        confirm_swal('Are you sure you want to remove this User?', 'Remove').then(function (val) {
            if (val === true) {
                const sendAjaxVar = sendAjax({
                    url: base_url + 'users/removeUser',
                    data: { user_id: user_id }
                });
                if (sendAjaxVar) {
                    swal(sendAjaxVar.msg, sendAjaxVar.type);
                    tbl_users.ajax.reload();
                }
            }
        });
    });

    $(document).on('click','.updateUser',function(){
        user_id = $(this).data('id');
        var data = sendAjax({ url: base_url + 'users/getUserInfo', data: { user_id: user_id}});
        $('.form_updateUser')[0].reset();
        input('select[name="upusertype"]', data.user_type);
        input('input[name="upfirstname"]', data.firstname);
        input('input[name="uplastname"]', data.lastname);
        input('input[name="upusername"]', data.username);
        input('input[name="upemail"]', data.email);
        input('input[name="tbl_user_id"]', user_id);
        $('.form_addUser')[0].reset();
    });

    $(document).on('submit','.form_updateUser',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_updateUser')[0]);
        var sendAjaxVar = sendAjax({ url: base_url + 'users/updateUser', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_updateUser')[0].reset();
                tbl_users.ajax.reload();
                $('#modal_updateUser').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    $(document).on('change', '.filterType', function() {
        usersTable($(this).val());
    });

}); // End of Document Ready

function usersTable(filter = 'all') {
    $('#tbl_users').DataTable({
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "responsive": true,
        "destroy":  true,
        "order": [[0, 'desc']], //Initial no order.
        "columns": [
            { "data": "user_id", "width":"10%" },
            { "data": "fullname", "width":"18%" },
            { "data": "email", "width":"15%" },
            {
                "data": "user_status", "width":"10%", "render": function (data, type, row, meta) {
                    str = ``;
                    if(row.user_type == 1) {
                        str += `<span class="label label-danger">Admin</span>`;
                    } else if(row.user_type == 2) {
                        str += `<span class="label label-success">Supervisor</span>`;
                    } else {
                        str += `<span class="label label-info">Manager</span>`;
                    }
                    return str;
                }
            },
            {
                "data": "user_status", "width":"8%", "render": function (data, type, row, meta) {
                    str = ``;
                    if (row.user_status == 1) {
                        str += `<p class="btn btn-sm btn-outline-success">Enabled</p>`;
                    }else{
                        str += `<p class="btn btn-sm btn-outline-danger">Disabled</p>`;
                    }
                    return str;
                }
            },
            {
                "data": "user_id", "width":"12%", "render": function (data, type, row, meta) {
                    var str = '';
                        if (row.user_status == 1) {
                            str += '<button data-id="'+row.user_id+'" data-status="'+row.user_status+'" class="btn btn-sm btn-outline-success updateUserStatus" title="Click to enable"><i class="fa fa-unlock"></i> Disable</button>&nbsp;';
                        }else{
                            str += '<button data-id="'+row.user_id+'" data-status="'+row.user_status+'" class="btn btn-sm btn-outline-dark updateUserStatus" title="Click to disable"><i class="fa fa-lock"></i> Enable</button>&nbsp;';
                        }
                        str += '<button data-toggle="modal" data-target="#modal_updateUser" data-id="'+row.user_id+'" class="btn btn-sm btn-outline-warning updateUser" title="Click to update"><i class="fa fa-edit"></i> Edit</button>&nbsp;';
                        str += '<button data-id="'+row.user_id+'" class="btn btn-sm btn-outline-danger removeUser" title="Click to remove"><i class="fa fa-times-circle"></i> Remove</button>';
                    return str;
                }
            },
        ],
        "language": { "search": '', "searchPlaceholder": "Search keyword...","infoFiltered": "" },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "users/getUsersList",
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
                "targets": [5], //first column / numbering column
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
              $('.overlay').show();
            },
            success:function(response){
                $('.overlay').hide();
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

