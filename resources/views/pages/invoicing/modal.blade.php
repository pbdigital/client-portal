<div class="modal fade" id="credit-log-modal" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Credit Log - Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="credit-log-form">
                    <div class="row form-group">
                        <div  class="col-md-6">
                            &nbsp;
                            <input type="hidden" name="id" id="id">
                        </div>

                        <div  class="col-md-6">
                            <label>Date</label>
                            <input type="date" class="form-control text-black" name="date" id="date" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div  class="col-md-12" id="error_assignable">
                            <label>Assignable</label>
                            <input type="email" class="form-control" name="assignable" id="assignable"> 
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div  class="col-md-6">
                            <label>Project ID</label>
                            <input type="number" class="form-control text-black" name="project_id" id="project_id" disabled>
                        </div>
                       
                        <div  class="col-md-6">
                            <label>Time ID</label>
                            <input type="number" class="form-control text-black" name="time_id" id="time_id" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div  class="col-md-6" id="error_spent">
                            <label>Time Spent</label>
                            <input type="number" class="form-control" name="spent" id="spent">
                            <span class="help-block"></span>
                        </div>
                       
                        <div  class="col-md-6" id="error_discount_percent">
                            <label>Discount Percent</label>
                            <input type="number" class="form-control" name="discount_percent" id="discount_percent">
                            <span class="help-block"></span>
                        </div>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <button type="button" class="btn btn-primary" onclick="updateCreditLog()" id="credit-log-modal-save-btn">
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>