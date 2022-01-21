var base_url = $('input[name="base_url"]').val();

$(document).ready(function(){

    $(document).on('submit','.form_reset',function(e){

        e.preventDefault();

        var form_data = new FormData($('.form_reset')[0]);

        var sendAjaxVar = sendAjax({ url: base_url + 'login/resetpass', data: form_data }, false);

        if (sendAjaxVar) {

            clearError();

            if (sendAjaxVar.status == "success") {

                Swal.fire({

                   text: sendAjaxVar.msg,

                   type: sendAjaxVar.status,

                   showCancelButton: false,

                   confirmButtonColor: '#254392',

                   confirmButtonText: 'Ok',

                   allowOutsideClick: false

                }).then((result) => {

                   if (result.value) {

                       window.location.href = base_url+'login/recovery';

                   }

                });

            }else if (sendAjaxVar.status == "error") {

                Swal.fire({

                   text: sendAjaxVar.msg,

                   type: sendAjaxVar.status,

                   showCancelButton: false,

                   confirmButtonColor: '#254392',

                   confirmButtonText: 'Ok',

                   allowOutsideClick: false

                }).then((result) => {});

            }else {

                $.each(sendAjaxVar, function (key, value) {

                    $('input[name="' + key + '"]').next('.err').html(value);

                });

            }

        }

    });

    $(document).on('submit','.form_recovery',function(e){

        e.preventDefault();

        var form_data = new FormData($('.form_recovery')[0]);

        var sendAjaxVar = sendAjax({ url: base_url + 'login/recoverpass', data: form_data }, false);

        if (sendAjaxVar) {

            clearError();

            if (sendAjaxVar.status == "success") {

                Swal.fire({

                   text: sendAjaxVar.msg,

                   type: sendAjaxVar.status,

                   showCancelButton: false,

                   confirmButtonColor: '#254392',

                   confirmButtonText: 'Ok',

                   allowOutsideClick: false

                }).then((result) => {

                   if (result.value) {

                       window.location.href = base_url+'login';

                   }

                });

            }else if (sendAjaxVar.status == "error") {

                Swal.fire({

                   text: sendAjaxVar.msg,

                   type: sendAjaxVar.status,

                   showCancelButton: false,

                   confirmButtonColor: '#254392',

                   confirmButtonText: 'Ok',

                   allowOutsideClick: false

                }).then((result) => {});

            }else {

                $.each(sendAjaxVar, function (key, value) {

                    $('input[name="' + key + '"]').next('.err').html(value);

                });

            }

        }

    });

});

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

            success:function(response){

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



function input(element,value){

    $(element).val(value);

}



function clearError() {

    $('.err').html('');

}