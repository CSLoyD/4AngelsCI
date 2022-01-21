<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">
            Documents > <?php echo $details['fullname']; ?>
            </h3>
        </div>
        <div class="col-md-7 align-self-center text-right d-none d-md-block">
            <button data-toggle="modal" data-target="#modal_addDocument" class="btn btn-info btn-submits addDocument"><i class="fa fa-plus-circle"></i> Add Document</button>  
        </div>
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
                    <table id="tbl_documents" class="table table-hover table-striped tbl_documents">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Document Type</th>
                                <th>Status</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="employee_id" value="<?php echo $details['employee_id']; ?>">
    <!-- ============================================================== -->
    <!-- End PAge Content -->
</div>
  <!-- =============================Add Document Modal================================= -->
  <div id="modal_addDocument" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-Doctor"></i> Add Document</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_addDocument" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Document Type</label>
                                    <input type="text" class="form-control" name="doctype" placeholder="Enter Document Type Here">

                                    <!-- <select name="doctype" class="form-control">
                                    <option value="">- Select Document Type -</option>
                                    <option value="Competency Test">Competency Test</option>
                                    <option value="Resume">Resume</option>
                                    <option value="License">License</option>
                                    <option value="Photo ID">Photo ID</option>
                                    <option value="General">General</option>
                                    <option value="Correspondence">Correspondence</option>
                                    <option value="Photograph">Photograph</option>
                                    <option value="Skills Checklist">Skills Checklist</option>
                                    </select> -->
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="docfile" class="control-label">Import Document File</label>
                                    <input type="file" class="form-control docfile" id="docfile" name="docfile" accept=".doc,.docx,.pdf,.xls,.png,.jpg,.zip,.jpeg">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="addemployee_id" value="<?php echo $details['employee_id']; ?>">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-file-pdf"></i> Add Document <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div>

 <!-- =============================Update Document Modal================================= -->
 <!-- <div id="modal_updateDocument" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><i class="icon-Doctor"></i> Update Document</h4>
                
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                    <form class="form_updateDocument" action="" method="post">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Current File</label>
                                    <input type="text" class="form-control text-center" name="currentFileName" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Document Type</label>
                                    <select name="updoctype" class="form-control">
                                        <option value="">- Select Document Type -</option>
                                        <option value="Competency Test">Competency Test</option>
                                        <option value="Resume">Resume</option>
                                        <option value="License">License</option>
                                        <option value="Photo ID">Photo ID</option>
                                        <option value="General">General</option>
                                        <option value="Correspondence">Correspondence</option>
                                        <option value="Photograph">Photograph</option>
                                        <option value="Skills Checklist">Skills Checklist</option>
                                    </select>
                                    <small class="err"></small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="docfile" class="control-label">Import Document File</label>
                                    <input type="file" class="form-control docfile" id="updocfile" name="updocfile" accept=".doc,.docx,.pdf,.xls">
                                    <small class="err"></small>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="updoc_id">
                            <input type="hidden" name="updoc_path">
                            <button type="submit" class="btn btn-primary btn-m btn-submits"><i class="fa fa-file-pdf"></i> Update Document <i class="buttonLoader"><img src="<?php echo base_url();?>assets/build/images/customLoading.gif"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
</div> -->