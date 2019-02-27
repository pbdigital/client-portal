<div class="modal fade" id="project-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <hr>
                </div>
                <div class="modal-body">
                    <form id="project-modal-form">
                        <input type="hidden" name="id" id="id">

                        <div class="row form-group">
                            <div  class="col-md-12" id="error_name">
                                <label>Project Name</label>
                                <input class="form-control text-black" name="name" id="name">
                                <span class="help-block"></span>
                            </div>
                        </div>
    
                        <div class="row form-group">
                            <div  class="col-md-6" id="error_first_name">
                                <label>Client First Name:</label>
                                <input class="form-control" name="first_name" id="first_name"> 
                                <span class="help-block"></span>
                            </div>

                            <div  class="col-md-6" id="error_last_name">
                                <label>Client Last Name:</label>
                                <input class="form-control" name="last_name" id="last_name"> 
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div  class="col-md-6" id="error_email">
                                <label>Email:</label>
                                <input class="form-control" name="email" id="email"> 
                                <span class="help-block"></span>
                            </div>

                            <div  class="col-md-6" id="error_password">
                                <label>Password:</label>
                                <input type="password" class="form-control" name="password" id="password"> 
                                <span class="help-block"></span>
                            </div>
                        </div>
                        
                        <div class="row form-group">
                            <div  class="col-md-6" id="error_project_id">
                                <label>Project ID</label>
                                <input type="number" class="form-control text-black" name="project_id" id="project_id">
                                <span class="help-block"></span>
                            </div>
                           
                            <div  class="col-md-6" id="error_quickbooks_client_id">
                                <label>QuickBooks Client ID</label>
                                <input type="number" class="form-control text-black" name="quickbooks_client_id" id="quickbooks_client_id">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </form> 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="saveProjectModal()" id="project-modal-save-btn">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>