<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            Employees
            </h3>
        </div>
        <?php if($_SESSION['user_type'] == 1) { ?>
        <div class="col-md-7 align-self-center text-right d-none d-md-block">
            <button data-toggle="modal" data-target="#modal_addEmployee" class="btn btn-info btn-submits addEmployee"><i class="fa fa-plus-circle"></i> Add Employee</button>  
        </div>
        <?php } ?>
    </div>
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->

    <div class="row tableLoad">
        <img src="<?php echo base_url()?>assets/build/images/tableLoader.gif" alt="Loading Icon"><br />
        <span>Loading...</span>
    </div>

    <div class="row all_contents">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_employees" class="table table-hover table-striped tbl_employees">
                        <thead>
                            <tr>
                                <th>Profile</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
</div>
  <!-- =============================Add Employee Modal================================= -->
  <div id="modal_addEmployee" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-Doctor"></i> Add Employee</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_addEmployee" action="" method="post">
                    <div class="form-body">

                        <div class="row text-center">
                            <div class="col-md-3 marginCenter imageDiv">
                                <img src="<?php echo base_url()?>assets/build/images/profile.png" id="addProfile" class="imageContainer">
                                <input type="file" class="form-control profilePic" id="profilePic" name="profilePic" accept=".jpg,.jpeg,.png,.gif" onchange="imagePreview(event)">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input type="text" class="form-control" name="empfirstname" placeholder="Enter First Name Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="emplastname" placeholder="Enter Last Name Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" name="empphone" placeholder="Enter Phone Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" name="empaddress" placeholder="Enter Address Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="form-control" name="empusername" placeholder="Enter  Username Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" name="empemail" placeholder="Enter Email Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="emppassword" placeholder="Enter Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="empconfpassword" placeholder="Confirm Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="icon-Doctor"></i> Add Employee <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>

 <!-- =============================Update Employee Modal================================= -->
 <div id="modal_updateEmployee" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-Doctor"></i> Update Employee</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateEmployee" action="" method="post">
                    <div class="form-body">

                        <div class="row text-center">
                            <div class="col-md-3 marginCenter imageDiv">
                                <img src="<?php echo base_url()?>assets/build/images/profile.png" id="upProfile">
                                <input type="file" class="form-control profilePic" id="upProfilePic" name="upProfilePic" accept=".jpg,.jpeg,.png,.gif" onchange="upImagePreview(event)">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input type="text" class="form-control" name="upempfirstname" placeholder="Enter First Name Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="upemplastname" placeholder="Enter Last Name Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" name="upempphone" placeholder="Enter Phone Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" name="upempaddress" placeholder="Enter Address Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="form-control" name="upempusername" placeholder="Enter  Username Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input type="email" class="form-control" name="upempemail" placeholder="Enter Email Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="upemppassword" placeholder="Enter Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="upempconfpassword" placeholder="Confirm Password Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="upemployee_id">
                            <input type="hidden" name="upprofile_image">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="icon-Doctor"></i> Update Employee <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>