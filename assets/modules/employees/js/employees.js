var base_url = $('input[name="base_url"]').val();
var method = $('input[name="basemethod"]').val();
$(document).ready(function() {
    var tbl_employees = $('#tbl_employees').DataTable({
        "destroy":true,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "responsive": true,
        "pageLength": 50,
        "order": [[1, 'desc']], //Initial no order.
        "columns": [
            {
                "data": "employee_id", "width":"6%", "render": function (data, type, row, meta) {
                    var str = '';
                    if(row.profile_image != '') {
                        str += `<img src="`+base_url+row.profile_image+`" class="tableProfile" alt="Profile">`;
                    } else {
                        str += `<img src="`+base_url+`./assets/build/images/profile.png" class="tableProfile" alt="Profile">`;
                    }
                    
                    return str;
                }
            },
            { "data": "firstname","width":"20%" },
            { "data": "lastname","width":"15%" },
            { "data": "email","width":"15%" },
            { "data": "phone","width":"15%" },
            {
                "data": "employee_status", "width":"10%", "render": function (data, type, row, meta) {
                    var str = '';
                    if(row.employee_status == 1) {
                        str += `<p class="btn btn-sm btn-outline-success">Enabled</p>`;
                    } else {
                        str += `<p class="btn btn-sm btn-outline-danger">Disabled</p>`;
                    }
                    return str;
                }
            },
            {
                "data": "employee_id", "width":"10%", "render": function (data, type, row, meta) {
                    var str = '';
                    str += '<a href="'+base_url+'employees/viewDocuments/'+row.employee_code+'" class="btn btn-sm btn-outline-info text-info viewDocBtn" title="Click to view Documents"><i class="fa fa-file-medical"></i></a>&nbsp;';
                    if(row.employee_status == 1) {
                        str += '<button data-id="'+row.employee_id+'" data-status="'+row.employee_status+'" class="btn btn-sm btn-outline-success updateEmployeeStatus" title="Click to Update Status"><i class="fa fa-lock-open"></i></button>&nbsp;';
                    } else {
                        str += '<button data-id="'+row.employee_id+'" data-status="'+row.employee_status+'" class="btn btn-sm btn-outline-danger updateEmployeeStatus" title="Click to Update Status"><i class="fa fa-lock"></i></button>&nbsp;';
                    }
                    str += '<button data-toggle="modal" data-target="#modal_updateEmployee" data-id="'+row.employee_id+'" class="btn btn-sm btn-outline-warning updateEmployee" title="Click to update"><i class="fa fa-edit"></i></button>&nbsp;';
                    str += '<button data-id="'+row.employee_id+'" class="btn btn-sm btn-outline-danger removeEmployee" title="Click to remove"><i class="fa fa-times-circle"></i></button>';
                    return str;
                }
            },
        ],
        "language": { "search": '', "searchPlaceholder": "Search Employee...","infoFiltered": "" },
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": base_url + "employees/getEmployees",
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
                "targets": [0,6], //first column / numbering column
                "orderable": false, //set not orderable
            },
        ],
    });

    $(document).on('click','.addEmployee',function(e){
        e.preventDefault();
        clearError();
    });

    // Image File Validation
    $('.profilePic').change(function (e) {
        var error_file = '';
        var files = $('.profilePic')[0].files;
        for (var i = 0; i < files.length; i++) {
            var name = $(this)[0].files[i].name;
            var ext = name.split('.').pop().toLowerCase();
            if (jQuery.inArray(ext, ['jpeg','jpg','png','gif']) == -1) {
                error_file += '<p>Invalid file type</p>';
            }
            var oFReader = new FileReader();
            oFReader.readAsDataURL($(this)[0].files[i]);
            var f = $(this)[0].files[i];
            var fsize = f.size || f.fileSize;
            console.log(fsize);
            if (fsize > 20871520) {
                error_file += '<p> Image file size is too big to upload </p>';
            }
        }
        if (error_file != "") {
            ctr+=1;
            $('.profilePic').val('');
            $('.profilePic').next('.err').html(error_file);
            return false;
        }else{
            ctr = 0;
            $('.profilePic').next('.err').html("");
        }
    });

    // For Image Input Clicking
    $(document).on('click', '#addProfile', function(){
        $('#profilePic').trigger('click');
    });

    // =================================================Add Employee======================================
    $(document).on('submit','.form_addEmployee',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_addEmployee')[0]);
        form_data.append( 'profilePic', $( '#profilePic' )[0].files);
        var sendAjaxVar = sendAjax({ url: base_url + 'employees/addEmployee', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_addEmployee')[0].reset();
                $('#addProfile').attr(`src`,base_url+`./assets/build/images/profile.png`);
                tbl_employees.ajax.reload();
                $('#modal_addEmployee').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // =================================================Update Employee======================================
    $(document).on('click','.updateEmployee',function(){
        var imgsrc = '';
        employee_id = $(this).data('id');
        var data = sendAjax({ url: base_url + 'employees/getEmployeeInfo', data: { employee_id: employee_id}});
        $('.form_updateEmployee')[0].reset();
        clearError();
        input('input[name="upemployee_id"]',employee_id);
        input('input[name="upempfirstname"]',data.firstname);
        input('input[name="upemplastname"]',data.lastname);
        input('input[name="upempphone"]',data.phone);
        input('input[name="upempaddress"]',data.address);
        input('input[name="upempusername"]',data.username);
        input('input[name="upempemail"]',data.email);
        input('input[name="upprofile_image"]',data.profile_image);
        (data.profile_image != '') ? imgsrc = base_url+data.profile_image : imgsrc = base_url + `./assets/build/images/profile.png` ;
        $('#upProfile').attr(`src`,imgsrc);
        $('.form_addEmployee')[0].reset();
    });

    $(document).on('submit','.form_updateEmployee',function(e){
        e.preventDefault();
        var form_data = new FormData($('.form_updateEmployee')[0]);
        form_data.append( 'upProfilePic', $( '#upProfilePic' )[0].files);
        var sendAjaxVar = sendAjax({ url: base_url + 'employees/updateEmployee', data: form_data }, false);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
                $('.form_updateEmployee')[0].reset();
                tbl_employees.ajax.reload();
                $('#modal_updateEmployee').modal('toggle');
            } else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').next('.err').html(value);
                    $('textarea[name="' + key + '"]').next('.err').html(value);
                    $('select[name="' + key + '"]').next('.err').html(value);
                });
            }
        }
    });

    // For Image Input Clicking
    $(document).on('click', '#upProfile', function(){
        $('#upProfilePic').trigger('click');
    });

    // =================================================Remove Employee======================================
    $(document).on('click','.removeEmployee',function(e){
        e.preventDefault();
        var employee_id = $(this).data('id');
        confirm_swal('Are you sure you want to remove this Employee?', 'Remove').then(function (val) {
            if (val === true) {
                const sendAjaxVar = sendAjax({
                    url: base_url + 'employees/removeEmployee',
                    data: { employee_id: employee_id }
                });
                if (sendAjaxVar) {
                    swal(sendAjaxVar.msg, sendAjaxVar.type);
                    tbl_employees.ajax.reload();
                }
            }
        });
    });
    // =================================================Update Employee Status======================================
    $(document).on('click','.updateEmployeeStatus',function(){
        var employee_id = $(this).data('id');
        var employee_status = $(this).data('status');
        if (employee_status == 1) {
            confirm_swal('Disable this Employee?', 'Disable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'employees/updateEmployeeStatus',
                        data: { employee_id: employee_id, employee_status: employee_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_employees.ajax.reload();
                    }
                }
            });
        } else{
            confirm_swal('Enable this Employee?', 'Enable').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'employees/updateEmployeeStatus',
                        data: { employee_id: employee_id, employee_status: employee_status }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_employees.ajax.reload();
                    }
                }
            });
        }
    });

    // ==================================================================Documents Section======================================================================
    if(method == "viewDocuments") {
        // =================================================Documents Table======================================
        var docEmployeeID = $('input[name="employee_id"]').val();
        var tbl_documents = $('#tbl_documents').DataTable({
            "destroy":true,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "responsive": true,
            "order": [[0, 'desc']], //Initial no order.
            "columns": [
                { "data": "doc_name","width":"20%" },
                { "data": "doc_type","width":"15%" },
                {
                    "data": "doc_status", "width":"10%", "render": function (data, type, row, meta) {
                        var str = '';
                        if(row.doc_status == 1) {
                            str += `<span class="btn btn-outline-success">Verified</span>`;
                        } else {
                            str += `<span class="btn btn-outline-danger">Not Verified</span>`;
                        } 
                        return str;
                    }
                },
                { "data": "date_added","width":"10%" },
                {
                    "data": "doc_id", "width":"10%", "render": function (data, type, row, meta) {
                        var str = '';
                        str += `<a href="`+base_url+row.doc_path+`" target="_blank" class="btn btn-sm btn-outline-info"><i class="fa fa-eye"></i> View</a>&nbsp;`;
                        if(row.doc_status == 2) {
                            str += '<button data-id="'+row.doc_id+'" data-status="'+row.doc_status+'" class="btn btn-sm btn-outline-success updateDocVerification" title="Click to Verify"><i class="fa fa-check"></i> Verify</button>&nbsp;';
                        } else {
                            str += '<button data-id="'+row.doc_id+'" data-status="'+row.doc_status+'" class="btn btn-sm btn-outline-danger updateDocVerification" title="Click to Update Back as Not Verified"><i class="fa fa-times"></i> Unverify</button>&nbsp;';
                        }
                        // str += '<button data-toggle="modal" data-target="#modal_updateDocument" data-id="'+row.doc_id+'" class="btn btn-sm btn-outline-warning updateDocument" title="Click to update"><i class="fa fa-edit"></i></button>&nbsp;';
                        str += '<button data-id="'+row.doc_id+'" data-doc_path="'+row.doc_path+'" class="btn btn-sm btn-outline-danger removeDocument" title="Click to remove"><i class="fa fa-times-circle"></i></button>';
                        return str;
                    }
                },
            ],
            "language": { "search": '', "searchPlaceholder": "Search Document...","infoFiltered": "" },
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": base_url + "employees/getDocuments",
                "type": "POST",
                "data": {employee_id:docEmployeeID},
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

        // Document File Validation
        $('.docfile').change(function (e) {
            var error_file = '';
            var files = $('.docfile')[0].files;
            for (var i = 0; i < files.length; i++) {
                var name = $(this)[0].files[i].name;
                var ext = name.split('.').pop().toLowerCase();
                if (jQuery.inArray(ext, ['doc','docx','pdf','xls','xlsx','zip','jpeg','jpg','png']) == -1) {
                    error_file += '<p>Invalid file type</p>';
                }
                var oFReader = new FileReader();
                oFReader.readAsDataURL($(this)[0].files[i]);
                var f = $(this)[0].files[i];
                var fsize = f.size || f.fileSize;
                console.log(fsize);
                if (fsize > 20871520) {
                    error_file += '<p> Document file size is too big to upload </p>';
                }
            }
            if (error_file != "") {
                ctr+=1;
                $('.docfile').val('');
                $('.docfile').next('.err').html(error_file);
                return false;
            }else{
                ctr = 0;
                $('.docfile').next('.err').html("");
            }
        });

        // =================================================Add Document======================================
        $(document).on('submit','.form_addDocument',function(e){
            e.preventDefault();
            var form_data = new FormData($('.form_addDocument')[0]);
            form_data.append( 'docfile', $( '#docfile' )[0].files);
            var sendAjaxVar = sendAjax({ url: base_url + 'employees/addDocument', data: form_data }, false);
            if (sendAjaxVar) {
                clearError();
                if (sendAjaxVar.status == "success") {
                    swal(sendAjaxVar.msg, sendAjaxVar.status);
                    $('.form_addDocument')[0].reset();
                    tbl_documents.ajax.reload();
                    $('#modal_addDocument').modal('toggle');
                } else {
                    $.each(sendAjaxVar, function (key, value) {
                        $('input[name="' + key + '"]').next('.err').html(value);
                        $('textarea[name="' + key + '"]').next('.err').html(value);
                        $('select[name="' + key + '"]').next('.err').html(value);
                    });
                }
            }
        });

        // =================================================Update Document Status======================================
        $(document).on('click','.updateDocVerification',function(){
            var doc_id = $(this).data('id');
            var doc_status = $(this).data('status');
            if (doc_status == 1) {
                confirm_swal('Unverify this Document?', 'Unverify').then(function (val) {
                    if (val === true) {
                        const sendAjaxVar = sendAjax({
                            url: base_url + 'employees/updateDocumentStatus',
                            data: { doc_id: doc_id, doc_status: doc_status }
                        });
                        if (sendAjaxVar) {
                            swal(sendAjaxVar.msg, sendAjaxVar.type);
                            tbl_documents.ajax.reload();
                        }
                    }
                });
            } else{
                confirm_swal('Verify this Document?', 'Verify').then(function (val) {
                    if (val === true) {
                        const sendAjaxVar = sendAjax({
                            url: base_url + 'employees/updateDocumentStatus',
                            data: { doc_id: doc_id, doc_status: doc_status }
                        });
                        if (sendAjaxVar) {
                            swal(sendAjaxVar.msg, sendAjaxVar.type);
                            tbl_documents.ajax.reload();
                        }
                    }
                });
            }
        });

        // =================================================Update Document======================================
    // $(document).on('click','.updateDocument',function(){
    //     doc_id = $(this).data('id');
    //     var data = sendAjax({ url: base_url + 'employees/getDocInfo', data: { doc_id: doc_id}});
    //     $('.form_updateDocument')[0].reset();
    //     clearError();
    //     input('input[name="updoc_id"]',doc_id);
    //     input('input[name="currentFileName"]',data.doc_name);
    //     input('select[name="updoctype"]',data.doc_type);
    //     input('input[name="updoc_path"]',data.doc_path);
    //     $('.form_addDocument')[0].reset();
    // });

    // $(document).on('submit','.form_updateDocument',function(e){
    //     e.preventDefault();
    //     var form_data = new FormData($('.form_updateDocument')[0]);
    //     form_data.append( 'updocfile', $( '#updocfile' )[0].files);
    //     var sendAjaxVar = sendAjax({ url: base_url + 'employees/updateDocument', data: form_data }, false);
    //     if (sendAjaxVar) {
    //         clearError();
    //         if (sendAjaxVar.status == "success") {
    //             swal(sendAjaxVar.msg, sendAjaxVar.status);
    //             $('.form_updateDocument')[0].reset();
    //             tbl_documents.ajax.reload();
    //             $('#modal_updateDocument').modal('toggle');
    //         } else {
    //             $.each(sendAjaxVar, function (key, value) {
    //                 $('input[name="' + key + '"]').next('.err').html(value);
    //                 $('textarea[name="' + key + '"]').next('.err').html(value);
    //                 $('select[name="' + key + '"]').next('.err').html(value);
    //             });
    //         }
    //     }
    // });

        // =================================================Remove Document======================================
        $(document).on('click','.removeDocument',function(e){
            e.preventDefault();
            var doc_id = $(this).data('id');
            var doc_path = $(this).data('doc_path');
            confirm_swal('Are you sure you want to remove this Document?', 'Remove').then(function (val) {
                if (val === true) {
                    const sendAjaxVar = sendAjax({
                        url: base_url + 'employees/removeDocument',
                        data: { doc_id: doc_id, doc_path:doc_path }
                    });
                    if (sendAjaxVar) {
                        swal(sendAjaxVar.msg, sendAjaxVar.type);
                        tbl_documents.ajax.reload();
                    }
                }
            });
        });

    }

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

function imagePreview(e) {
    output = document.getElementById('addProfile');
    var reader = new FileReader();
    reader.onload = function(){
        output.src = reader.result;
    }
    reader.readAsDataURL(e.target.files[0]);
}
function upImagePreview(e) {
    output = document.getElementById('upProfile');
    var reader = new FileReader();
    reader.onload = function(){
        output.src = reader.result;
    }
    reader.readAsDataURL(e.target.files[0]);
}