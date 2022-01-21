    <footer class="footer">
        © <?php echo date('Y') ?> 4Angels Healthcare Staffing
    </footer>
    <!-- ============================================================== -->
    <!-- End footer -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <input type="hidden" name="base_url" value="<?php echo base_url(); ?>">
    <input type="hidden" name="basemethod" value="<?php echo $this->router->fetch_method(); ?>">
    <input type="hidden" name="sessionutype" value="<?php echo $_SESSION['user_type']; ?>">
    <!-- <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script> -->
    <script src="<?php echo base_url() ?>assets/build/js/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url() ?>assets/build/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/build/js/bootstrap.min.js"></script>
    <!-- Datatables JavaScript -->
    <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>assets/build/js/dataTables.responsive.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo base_url() ?>assets/build/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo base_url() ?>assets/build/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo base_url() ?>assets/build/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo base_url() ?>assets/build/js/sticky-kit.min.js"></script>
    <script src="<?php echo base_url() ?>assets/build/js/jquery.sparkline.min.js"></script>
    <!--Text Area Editor -->
    <!-- <script src="https://cdn.tiny.cloud/1/mktt0fn2ft20073ys6bah0ijlryi2jvwkp0izh52jb23hh3h/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> -->
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    
    <!--Custom JavaScript -->
    <script src="<?php echo base_url() ?>assets/build/js/custom.min.js"></script>
    <?php
        $route = $this->router->fetch_class();
        $method = $this->router->fetch_method();
    ?>

    <script src="<?php echo base_url() ?>assets/build/js/sweetalert2.min.js"></script>
    <script src="<?php echo base_url() ?>assets/build/js/select2.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo base_url() ?>assets/build/js/jQuery.style.switcher.js"></script>
    
    <script>
        var base_url = $('input[name="base_url"]').val();

        //Requested Shedule Notifications
        $(document).on('click', '.nav-link', function(e) {
            e.preventDefault();
            var base_url = "<?php echo base_url(); ?>notifications/get_schedules/";
            $.ajax({  
                type: "GET",
                url: base_url,
                dataType: 'json',
                success: function (data) {
                    var obj = data;  
                    var dl_str = '';
                    $.each(obj, function(key, value) {
                        console.log(value.notif_id);   
                        dl_str += '<a href="#"><div class="btn btn-success btn-circle"><i class="fa fa-calendar"></i></div><div class="mail-contnet"><h5>'+value.title+'</h5><span class="mail-desc">'+value.description+'</span><span class="time">'+value.date_added+'</span></div></a>';
                        $('#notification-dis').html(dl_str);
                    });
                }
            });
        });
        
        //Updating My Profile
        $(document).ready(function(){
            $(document).on('click','.btn-profile',function(){
                user_id = $(this).data('id');
                var data = sendAjax({ url: base_url + 'users/getUserInfo', data: { user_id: user_id}});
                input('input[name="upfirstname"]', data.firstname);
                input('input[name="uplastname"]', data.lastname);
                input('input[name="upusername"]', data.username);
                input('input[name="upemail"]', data.email);
                input('input[name="tbl_user_id"]', user_id);
            });

            $(document).on('submit','.form_updateProfile',function(e){
                e.preventDefault();
                var form_data = new FormData($('.form_updateProfile')[0]);
                var sendAjaxVar = sendAjax({ url: base_url + 'users/updateUser', data: form_data }, false);
                if (sendAjaxVar) {
                    clearError();
                    if (sendAjaxVar.status == "success") {
                        location.reload();
                    } else {
                        $.each(sendAjaxVar, function (key, value) {
                            $('input[name="' + key + '"]').next('.err').html(value);
                            $('textarea[name="' + key + '"]').next('.err').html(value);
                            $('select[name="' + key + '"]').next('.err').html(value);
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
        function input(element,value){
            $(element).val(value);
        }
        function clearError() {
            $('.err').html('');
        }
    </script>
    <!-- End of Updating My Profile -->

    <?php
        __load_assets__($__assets__,'js');
    ?>
</body>
</html>
