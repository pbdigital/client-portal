var clientsAutomation = {}
var loader = '<div class="" style="padding:40px; text-align:center; padding-top:0px;"><div class="progress-circle-indeterminate  progress-circle-primary m-t-45" style="" data-color="primary"></div></div>';


$(document).ready(function(){

    clientsAutomation = {

        asana : {
    
            loadProject : function(e){
                $.ajax({
                    url : clientsAutomationbaseUrl + "/home_ajax",
                    data : {
                        task : "load_project",
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $(e).html(loader);
                    },
                    success : function(d){
                        $(e).html(d);
                    }
                });
            },

            frmAddNewTask : function(e){
                clientsAutomation.modalOpen({ title: "New Request", content : "<div class='div-new-request' style='max-height:80vh; overflow:auto'>"+loader+"</div>","size" : "modal-lg" });
                $.ajax({
                    url : clientsAutomationbaseUrl + "/home_ajax",
                    data : {
                        task : "new_task_form",
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $(".div-new-request").html(loader);
                    },
                    success : function(d){
                        $(".div-new-request").html(d);

                        setTimeout(function(){
                            $(".dropzone").dropzone({ 
                                url: "/file_upload",
                                headers: {
                                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                },
                                success : function(d){
                                    url = d.xhr.responseText;
                                    $(".hdn-task-files").append("<input type='hidden' name='files[]' value='"+url+"' />")
                                }
                            });
                        },300);
                    }
                });
            },  //frmAddNewTask

            saveNewTask : function(e){
                $.ajax({
                    url : clientsAutomationbaseUrl + "/home_ajax?task=save_new_task",
                    data : $("#frm-add-new-task").serialize(),
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    type : "post",
                    beforeSend : function(){
                        $(e).fadeTo("fast", .5).html("<i class='fa fa-spin fa-spinner'></i> Saving... ");
                    },
                    success : function(){
                        $(e).fadeTo("fast", 1).removeClass("btn-primary").addClass("btn-success").html("Task Saved");

                        clientsAutomation.modalClose();
                        setTimeout(function(){
                            clientsAutomation.asana.loadProject($("#div-home-projects"));
                        }, 500);
                    }
                });
            }, //saveNewTask

            loadTaskDetails : function(taskid){
                $.ajax({
                    url : clientsAutomationbaseUrl + "/home_ajax",
                    data : {
                        taskid : taskid,
                        task : "task_details",
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $("#sidebar-task-content").html("");
                    },
                    success : function(d){
                        $("#sidebar-task-content").html(d);
                    }
                });
            }, //loadTaskDetails
    
        }, // asana
        
        modalOpen : function(obj){
            title = obj.title;
            content = obj.content;

            $("#app-global-modal .modal-dialog").addClass(obj.size);
            $("#app-global-modal .modal-title").html(title);
            $("#app-global-modal .modal-body").html(content);
            $("#app-global-modal").modal("show");
        }, // modal
        modalClose : function(){
            $("#app-global-modal").modal("hide");
        }

    } //clientsAutomation


    if( $("#div-home-projects").length > 0 ){
        setTimeout(function(){
            clientsAutomation.asana.loadProject($("#div-home-projects"));
        }, 100);
    } // twilio-subaccount-container


});





$(document).on("click",".btn-with-act",function(){
    btn = this;
    act = $(this).data("act");
    
    switch(act){
        case "add_new_task":
            clientsAutomation.asana.frmAddNewTask(btn);
        break; //add_new_task

        case "save_new_task":
            clientsAutomation.asana.saveNewTask(btn);
        break; //save_new_task

        case "open_quickview":
            taskid = $(btn).data("taskid");
            clientsAutomation.asana.loadTaskDetails(taskid);
        break; // open_quickview

        case "save_comment":
            txt = $(".task-text-comment").val();
            taskid = $(btn).data("taskid");
            $.ajax({
                url : clientsAutomationbaseUrl + "/home_ajax",
                data : {
                    taskid : taskid,
                    text : txt,
                    task : "post_comment",
                },
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                beforeSend : function(){
                    $("#sidebar-task-content").html("");
                },
                success : function(d){
                    $("#sidebar-task-content").html(d);
                    clientsAutomation.asana.loadTaskDetails(taskid);
                }
            });
        break; // save_comment
    }
}); //$(document).on(".btn-with-act","click",function(){
