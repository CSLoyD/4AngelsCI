<div class="login-register login" style="">
    <div class="login-box card">
        <div class="card-body">
            <img src="<?php echo base_url()?>assets/build/images/login-logo.png" alt="Logo" id="loginLogo">
            <br><br>
            <form class="login-form" action="<?php echo base_url('login/auth'); ?>" method="POST">
                <?php if (isset($_SESSION['error'])): ?>
                    <label class="text-danger text-center"><i class="fa fa-exclamation-circle"></i> <?php echo $_SESSION['error']; ?></label>
                <?php endif; ?>
                <div class="form-group username">
                    <input class="form-control" type="text" name="uname" autocomplete="off" placeholder="Email/Username" value="<?php echo set_value('uname');?>" autofocus>
                    <span class="text-danger" style="color:#d01a2c"><?php echo form_error('uname');?></span>
                </div>
                <div class="form-group password">
                    <input class="form-control" type="password" name="pass" placeholder="Password">
                    <span class="text-danger" style="color:#d01a2c"><?php echo form_error('pass');?></span>
                </div>
                <div class="form-group btn-container">
                    <button class="btn btn-themecolor btn-block" name="button"><i class="fas fa-sign-in-alt"></i> SIGN IN</button>
                </div>
            </form>
            <button data-toggle="modal" data-target="#modal_forgotPass" class="btn-forgot">Forgot Password</button>
        </div>
    </div>
</div>

    <!-- =============================Forgot Password Modal================================= -->
    <div id="modal_forgotPass" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="sl-icon-question"></i> Forgot Password</h4>
                    
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                        <form class="form_forgotPass" action="" method="post">
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email Here">
                                        <small class="err"></small>
                                    </div>
                                </div>
                            </div>
                        </div><br />
                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <input type="hidden" name="base_url" value="<?php echo base_url(); ?>">
                                <button type="submit" class="btn btn-primary btn-sm btn-submits"><i class="fa fa-check"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

