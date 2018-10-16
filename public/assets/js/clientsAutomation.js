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

        settings : {

            loadClients : function(e){
                $.ajax({
                    url : clientsAutomationbaseUrl + "/settings_ajax",
                    data : {
                        task : "clients_list",
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
            }, //loadClients

            addUserForm : function(e){

                clientsAutomation.modalOpen({ title: "Add New User", content : "<div class='div-new-user' style='max-height:80vh; overflow:auto'>"+loader+"</div>","size" : "modal-lg" });


                $.ajax({
                    url : clientsAutomationbaseUrl + "/settings_ajax",
                    data : {
                        task : "add_user_form"
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                    },
                    success : function(d){
                        $(".div-new-user").html(d);
                    }
                });
            }, //addUserForm

            saveNewUser : function(e){
                $.ajax({
                    url : clientsAutomationbaseUrl + "/settings_ajax?task=save_new_user",
                    data : $("#frm-add-user").serialize(),
                    type : "post",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $(e).fadeTo("fast", .5);
                    },
                    success : function(d){
                        $(e).fadeTo("fast", 1).removeClass("btn-primary").addClass("btn-success").html("Saved");
                        clientsAutomation.settings.loadClients($("#div-settings-clients"));
                        $("#frm-add-user .form-control").val("");
                    }
                });
            }, //saveNewUser
        }, //settings
        
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

    if( $("#div-settings-clients").length > 0 ){
        setTimeout(function(){
            clientsAutomation.settings.loadClients($("#div-settings-clients"));
        }, 100);
    } // twilio-subaccount-container

});


$(document).on("change", ".listen-on-change", function(){
    e = this;
    act = $(this).data("act");
    console.log(act);
    switch(act){
        case "update_user_field":
            field = $(e).data("field");
            userid = $(e).data("userid");
            val = $(e).val();
            $.ajax({
                url : clientsAutomationbaseUrl + "/settings_ajax?task=update_user_field",
                data : {
                    field : field,
                    userid : userid,
                    val : val
                },
                type : "post",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                beforeSend : function(){
                    $(e).parent().find(".span-icon-notif").remove();
                    setTimeout(function(){
                        $(e).parent().append("<span class='span-icon-notif loader' style='position:absolute; right:27px; top:27px;'><i class='fa fa-spin fa-spinner'></i></span>");
                    },300);
                },
                success : function(){
                    $(e).parent().find(".span-icon-notif").remove();
                    setTimeout(function(){
                        $(e).parent().find(".loader").remove();
                        $(e).parent().append("<span class='span-icon-notif text-success' style='position:absolute; right:27px; top:27px;'><i class='fa fa-check'></i></span>");
                    },300);
                }
            });
        break; //
    } // switch

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

        case "add_user":
            clientsAutomation.settings.addUserForm(btn);
        break; // add_user

        case "save_new_user":
            clientsAutomation.settings.saveNewUser(btn);
        break; // save_new_user

        case "delete_user":
            r = confirm("Are you sure you want to delete this user?");
            userid = $(btn).data("userid");
            if(r == true){
                $.ajax({
                    url : clientsAutomationbaseUrl + "/settings_ajax",
                    data : {
                        task : "delete_user",
                        userid : userid
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $(btn).fadeTo("fast", .5);
                    },
                    success : function(d){
                        $(btn).parent().parent().fadeOut().remove();
                    }
                });
            }
        break; //delete_user
    }   
}); //$(document).on(".btn-with-act","click",function(){
