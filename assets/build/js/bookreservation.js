var base_url = $('input[name="base_url"]').val();

    var txt='';
    $(document).on('click','.add_child',function(){
        txt = `<div class="child_seat">
                    <div class="input-group" style="margin-top:10px">
                        <select class="form-control" name="child[]">
                            <option value="Infant">Infant (ages 0-1)</option>
                            <option value="Toddler Seat">Toddler Seat (ages 1-3)</option>
                            <option value="Booster Seat">Booster Seat (ages 3-6)</option>
                        </select>
                        <input type="number" min="1" name="child_number[]" class="form-control text-center" placeholder="0" value="1" style="text-align:center">&nbsp;&nbsp;
                        <i class="fas fa-trash remove_child"></i>
                    </div>
                </div>`;
        if($('.child_seat').length >= 2){
            $(this).hide();
        }
        $('.con_child').append(txt);
    });
    $(document).on('click','.remove_child',function(){
        $(this).parents('.child_seat').remove();
        $('.add_child').show();
    });
    $(document).on('click','.usecoupon',function(){
        txt = `<div class="code text-center">
                    <div class="input-group" style="margin-top:10px">
                        <i class="text-danger fas fa-times-circle remove_coupon"></i>&nbsp;&nbsp
                        <input type="text" name="coupon_code" class="form-control text-center" placeholder="Coupon Code" value="" autocomplete='off' style="text-align:center" required>
                        <button type="button" class="btn btn-primary btn-sm btn_coupon" name="button">Use</button>;
                    </div>
                    <span class="err"></span>
                </div>`;
        $('.con_coupon').html(txt);
    });
    $(document).on('click','.remove_coupon',function(){
        txt = `<button type="button" class="btn btn-primary btn-sm usecoupon" name="button">Use Coupon</button>`;
        $('.con_coupon').html(txt);
    });

    $(document).on('click','.add_stop',function(){
        txt = `<div class="location_stop">
                    <div class="col-md-12 mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control stoplocation" name="stop_location[]" value="" placeholder="Stop Location" required>&nbsp;&nbsp;
                            <i class="fas fa-trash remove_stops"></i>
                        </div>
                    </div>
               </div>`;
        if($('.location_stop').length >= 2){
           $(this).hide();
        }
        $('.con_stop').append(txt);
    });
    $(document).on('click','.remove_stops',function(){
        $(this).parents('.location_stop').remove();
        $('.add_stop').show();
    });
    $(document).on('change','input[name="payment_method"]',function(){
        var option = $(this).data('option');
        if (option == 2) {
            $('.online_payment').css('display','unset');
            $('.cash_on_hand').css('display','none');
            $(this).parents('form').removeAttr('class');
            $(this).parents('form').attr('id','paymentform');
        }else{
            $(this).parents('form').attr('class','paymentform');
            $(this).parents('form').removeAttr('id');
            $('.cash_on_hand').css('display','unset');
            $('.online_payment').css('display','none');
        }
    });
    // use coupon Code
    $(document).on('click','.btn_coupon',function(){
        var total = 0;
        var discount = 0;
        var fare = 0;
        var code = '';
        var coupon  = $('input[name="coupon_code"]').val();
        var service = $('select[name="service_type"]').val();

        var sendAjaxVar = sendAjax({ url: base_url + 'bookreservation/applydiscount', data: {coupon_code:coupon,service_type:service} }, true);
        if (sendAjaxVar) {
            clearError();
            if (sendAjaxVar.status == "success") {
                discount = sendAjaxVar.result.amount;
                code     = sendAjaxVar.result.code;
                fare     = $('input[name="Fare"]').val();
                total    = fare - discount;
                if (total <= 0) {
                    total = 0;
                }
                $('input[name="Amount"]').val(total.toFixed(2));
                var txt = `<label for="Amount">Coupon Code</label>
                            <input type="text" name="coupon_code" class="form-control" value="${code}" readonly required>`;
                $('.con_coupon').html(txt);
            }else if (sendAjaxVar.status == "error") {
                swal(sendAjaxVar.msg, sendAjaxVar.status);
            }else {
                $.each(sendAjaxVar, function (key, value) {
                    $('input[name="' + key + '"]').parent().next('.err').html(value);
                    $('select[name="' + key + '"]').parent().next('.err').html(value);
                });
            }
        }
    });
    $(document).on('submit','.paymentform',function(e){
        e.preventDefault();
        confirm_swal('Once booked, this data cannot be changed.', 'Book').then(function (val) {
            if (val === true) {
                var form_data = new FormData($('.paymentform')[0]);
                var sendAjaxVar = sendAjax({ url: base_url + 'bookreservation/book', data: form_data }, false);
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
                               location.reload();
                           }
                        });
                    }else if (sendAjaxVar.status == "error") {
                        swal(sendAjaxVar.msg, sendAjaxVar.status);
                    }
                     else {
                        $.each(sendAjaxVar, function (key, value) {
                            $('input[name="' + key + '"]').parent().next('.err').html(value);
                            $('select[name="' + key + '"]').parent().next('.err').html(value);
                        });
                    }
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

function input(element,value){
    $(element).val(value);
}

function clearError() {
    $('.err').html('');
}
