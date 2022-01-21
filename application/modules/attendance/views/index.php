<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            <i class="fa fa-calendar"></i> Attendance History Logs
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
                        <span class="input-group-text">Filter Employee</span>
                    </div>
                    <select name="filterEmployee" class="form-control filterEmployee"> 
                        <option value="all" selected>- All Employees -</option>
                        <?php foreach($employees as $key => $value) { ?>
                        <option value="<?php echo $value['employee_id'] ;?>"><?php echo $value['employeename']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Filter Date</span>
                    </div>
                    <input type="date" name="filterDate" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Filter Time</span>
                    </div>
                    <select name="filterTime" class="form-control filterTime"> 
                        <option value="all" selected>- All Time -</option>
                        <option value="morning">Morning</option>
                        <option value="afternoon">Afternoon</option>
                        <option value="evening">Evening</option>
                        <option value="midnight">Midnight</option>
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
                    <table id="tbl_attendance" class="table table-hover table-striped tbl_attendance">
                        <thead>
                            <tr>
                                <th>Employee Name</th>
                                <th>Date</th>
                                <th>Clock In</th>
                                <th>Total Hours</th>
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
  <!-- =============================View Attendance Modal================================= -->
  <div id="modal_viewAttendance" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-calendar"></i> View Attendance</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="form_viewAttendance" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Employee Name</label>
                                    <input type="text" class="form-control" name="viewemployeename" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Clock In</label>
                                    <input type="text" class="form-control" name="viewclockin" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Clock Out</label>
                                    <input type="text" class="form-control" name="viewclockout" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Date</label>
                                    <input type="text" class="form-control" name="viewdate" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Total Hours</label>
                                    <input type="text" class="form-control" name="viewtotalhours" disabled>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>
 <!-- =============================Update Attendance Modal================================= -->
 <div id="modal_updateAttendance" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-calendar"></i> Update Attendance</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateAttendance" action="" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Clock In</label>
                                    <input type="time" class="form-control" name="upclockin">
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Clock Out</label>
                                    <input type="time" class="form-control" name="upclockout">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="upattendance_id">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-calendar"></i> Update Attendance <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>