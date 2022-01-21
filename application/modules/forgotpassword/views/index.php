<div class="login-register login" style="">
    <div class="login-box card">
        <div class="card-body">
            <img src="<?php echo base_url()?>assets/build/images/login-logo.png" alt="Logo" id="loginLogo">
            <br><br>
            <!-- <?php if($used) { ?> -->
            <div>
                <h3><strong>CHANGE PASSWORD</strong></h3>
            </div>  
            <form class="login-form" action="<?php echo base_url('forgotpassword/changePassword'); ?>" method="POST">
                <?php if (isset($_SESSION['error'])): ?>
                    <label class="text-danger text-center"><i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['error']; ?></label>
                <?php endif; ?>
                <div class="form-group password">
                    <input class="form-control" type="password" name="pass" autocomplete="off" placeholder="Enter New Password" autofocus>
                    <span class="text-danger" style="color:#d01a2c"></span>
                </div>
                <div class="form-group password">
                    <input class="form-control" type="password" name="cpass" placeholder="Confirm New Password">
                    <span class="text-danger" style="color:#d01a2c"><?php echo form_error('cpass');?></span>
                </div>
                <div class="form-group btn-container">
                    <input type="hidden" name="fk_userid" value="<?php echo $user_id; ?>">
                    <input type="hidden" name="forgot_id" value="<?php echo $token; ?>">
                    <button class="btn btn-themecolor btn-block" name="button"><i class="fas fa-sign-in-alt"></i> SUBMIT</button>
                </div>
            </form>
            <!-- <?php } else { ?> -->
                <div>
                    <h3><strong>TOKEN EXPIRED</strong></h3>
                    <br><br>
                    <h2>SORRY THIS TOKEN HAS ALREADY BEEN USED / EXPIRED</h2>
                    <br><br>
                    <a href="<?php echo base_url('login'); ?>" class="btn btn-themecolor">BACK TO LOGIN</a>
                </div>
            <!-- <?php } ?> -->
        </div>
    </div>
</div>

