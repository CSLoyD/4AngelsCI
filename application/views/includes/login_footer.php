</section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <input type="hidden" name="base_url" value="<?php echo base_url(); ?>">
    <script src="<?php echo base_url() ?>assets/build/js/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo base_url() ?>assets/build/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>assets/build/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/build/js/sweetalert2.min.js"></script>
    
    <script src="<?php echo base_url() ?>assets/build/js/plugin.js"></script>
    <?php if ($this->router->fetch_class() == 'registration'){ ?>
        <script src="<?php echo base_url() ?>assets/users/js/user_plugin.js"></script>
    <?php } ?>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
    <?php
        __load_assets__($__assets__,'js');
    ?>
</body>

</html>
