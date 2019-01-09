<form id="frm-add-new-task">
    <div class="form-group mb-0">
        <input type="text" id="request_title" class="form-control" required="" name="request_title" placeholder="Request Title">
    </div>

    <div class="form-group">
        <textarea style="height:200px;" id="description" class="form-control" name="description" placeholder="Description"></textarea>
    </div>

    <div class="form-group">
        <label>Is this urgent?</label>
        <div class="radio radio-success">
            <input type="radio" value="yes" name="optionyes" id="yes">
            <label for="yes">Yes</label>
            <input type="radio" checked="checked" value="no" name="optionyes" id="no">
            <label for="no">No</label>
        </div>
    </div>


    <!-- <div class="hdn-task-files"></div> -->
</form>

 <form action="/file-upload" class="dropzone no-margin">
    <div class="fallback">
        <input name="file" type="file" multiple/>
    </div>
</form> 


<button type="button" class="btn btn-primary btn-with-act" data-act="save_new_task">SAVE</button>