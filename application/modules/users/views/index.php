<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            Users
            </h3>
        </div>
        <div class="col-md-7 align-self-center text-right d-none d-md-block">
            <button data-toggle="modal" data-target="#modal_addUser" class="btn btn-info btn-submits addUser"><i class="fa fa-plus-circle"></i> Add User</button>  
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Filter Type</span>
                    </div>
                    <select name="filterType" class="form-control filterType"> 
                        <option value="all" selected>- All Users -</option>
                        <option value="1">Admin</option>
                        <option value="2">Supervisor</option>
                        <option value="3">Manager</option>
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
                    <table id="tbl_users" class="table table-hover table-striped tbl_users">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
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
    <!-- =============================Add User Modal================================= -->
<div id="modal_addUser" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Add User</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_addUser" action="" method="post">
                    <div class="form-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">User Type</label>
                                    <select name="usertype" class="form-control text-center">
                                        <option value="1">Admin</option>
                                        <option value="2">Supervisor</option>
                                        <option value="3">Manager</option>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname" placeholder="Enter First Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="form-control" name="username" placeholder="Enter Username Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email Address Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Password Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Add User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>

<!-- =============================Update User Modal================================= -->
<div id="modal_updateUser" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-user"></i> Update User</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateUser" action="" method="post">
                    <div class="form-body">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">User Type</label>
                                    <select name="upusertype" class="form-control text-center">
                                        <option value="1">Admin</option>
                                        <option value="2">Supervisor</option>
                                        <option value="3">Manager</option>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">First Name</label>
                                    <input type="text" class="form-control" name="upfirstname" placeholder="Enter First Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="uplastname" placeholder="Enter Last Name Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Username</label>
                                    <input type="text" class="form-control" name="upusername" placeholder="Enter Username Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email Address</label>
                                    <input type="email" class="form-control" name="upemail" placeholder="Enter Email Address Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="uppassword" placeholder="Password Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="upcpassword" placeholder="Confirm Password Here" value="">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="tbl_user_id">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-user"></i> Update User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>