<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            Pick-up Shift Request
            </h3>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Filter Status</span>
                    </div>
                    <select name="filterType" class="form-control filterType"> 
                        <option value="all" selected>- All Status -</option>
                        <option value="2">Taken</option>
                        <option value="3">Declined</option>
                        <option value="4">Close</option>
                        <option value="5">Completed</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row tableLoad">
        <img src="<?php echo base_url()?>assets/build/images/tableLoader.gif" alt="Loading Icon"><br />
        <span>Loading...</span>
    </div>

    <div class="row all_contents">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table id="tbl_shifts" class="table table-hover table-striped tbl_shifts">
                        <thead>
                            <tr>
                                <th>Schedule Id</th>
                                <th>Employee Name</th>
                                <th>Facility Name</th>
                                <th>Schedule Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals Below -->
<div id="modal_shiftDetails" class="modal fade" role="dialog">
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
                                    <label class="control-label">Email</label>
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