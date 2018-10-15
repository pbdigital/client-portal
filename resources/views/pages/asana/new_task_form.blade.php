<form id="frm-add-new-task">
    <div class="form-group form-group-default  ">
        <label>Request Title</label>
        <input type="text" class="form-control" required="" name="request_title">
    </div>

    <div class="form-group form-group-default ">
        <label>Description</label>
        <textarea style="height:200px;" class="form-control" name="description"></textarea>
    </div>
    <div class="hdn-task-files"></div>
</form>

<form action="/file-upload" class="dropzone no-margin">
    <div class="fallback">
        <input name="file" type="file" multiple/>
    </div>
</form>


<button type="button" class="btn btn-primary btn-with-act" data-act="save_new_task">Save</button>