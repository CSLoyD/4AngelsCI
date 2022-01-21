<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            Facilities
            </h3>
        </div>
        <?php if($_SESSION['user_type'] == 1) { ?>
        <div class="col-md-7 align-self-center text-right d-none d-md-block">
            <button data-toggle="modal" data-target="#modal_addFacility" class="btn btn-info btn-submits addFacility"><i class="fa fa-plus-circle"></i> Add Facility</button>  
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
                    <table id="tbl_facilities" class="table table-hover table-striped tbl_facilities">
                        <thead>
                            <tr>
                                <th>Facility ID</th>
                                <th>Facility Name</th>
                                <th>Date Added</th>
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
  <!-- =============================Add Facility Modal================================= -->
  <div id="modal_addFacility" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-university"></i> Add Facility</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_addFacility" action="" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Facility Name</label>
                                    <input type="text" class="form-control" name="facilityname" placeholder="Enter Facility Name Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-university"></i> Add Facility <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>
 <!-- =============================Update Facility Modal================================= -->
 <div id="modal_updateFacility" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="fa fa-university"></i> Update Facility</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updatefacility" action="" method="post">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Facility Name</label>
                                    <input type="text" class="form-control" name="facilityname" placeholder="Enter Facility Name Here">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="up_facility_id">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-university"></i> Update Facility <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>