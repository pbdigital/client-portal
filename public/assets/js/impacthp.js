var ImpactHP = {};
var loader = '<div class="" style="padding:40px; text-align:center; padding-top:0px;"><div class="progress-circle-indeterminate  progress-circle-primary m-t-45" style="" data-color="primary"></div></div>';
var webformInterval;
$ = jQuery;

$(document).ready(function(){
    ImpactHP = {

        callList : {
            
            submitCallStatus : function(btn){
                $.ajax({
                    url : ImpactHPbaseUrl+"call-list/submit_call_status",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    type : "post",
                    data : {
                        call_status : $(".sel-call-status").val(),
                        comments : $(".comments").val(),
                        contactid : $(btn).data("contactid"),
                        call_outcome : $(".hdn-call-outcome").val(),
                        followup_datetime : $(".frm-followup-date").val(),
                    },
                    dataType : "json",
                    beforeSend : function(){
                        $(btn).fadeTo("fast",.2);
                    },
                    success : function(d){

                        $(btn).fadeTo("fast",1);

                        if(d.success==0){
                            $('.page-content-wrapper').pgNotification({
                                style: 'flip',
                                message: d.message,
                                timeout: 0,
                                type: "danger"
                            }).show();
                        }else{
                            currPos = $(btn).data("currentpos");
                            $(".item-"+currPos).animate({'left':'-500px'});
                            setTimeout(function(){
                                $(".item-"+currPos).remove();
                                currPos++;
                                $(".item-"+currPos).addClass('active');
                            },400);
                            /*$('.page-content-wrapper').pgNotification({
                                style: 'flip',
                                message: "Status saved",
                                timeout: 0,
                                type: "success"
                            }).show();*/

                            setTimeout(function(){
                                //window.location = ImpactHPbaseUrl+"call-list/call/"+$(btn).data("callstatus")+"?pos="+$(btn).data("pos")+"&points="+$(btn).data("points");
                                $.ajax({
                                    headers: {
                                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                                    },
                                    url : ImpactHPbaseUrl+"call-list/call/"+$(btn).data("callstatus")+"?pos="+$(btn).data("pos")+"&points="+$(btn).data("points"),
                                    data : {
                                        inner : 1
                                    },
                                    beforeSend : function(){
                                        $(".inner-content").fadeTo("fast", .5);
                                    },
                                    success : function(d){
                                        $(".inner-content").html(d);
                                        $(".inner-content").fadeTo("fast", 1);

                                        setTimeout(function(){
                                            loadConversationHistory();
                                            startTimer();

                                            $(".sel-call-status").select2();
                                            $("#datepicker-component").datepicker();
                                            $(".span-conv-remaining").html($(".sidebar-call-list li").length);

                                        },300);
                                    }
                                });
                           
                            },500);
                        }
                    }
                });
            }, //submitCallStatus
            sendSms : function(e){
                cid = $(e).data("cid");
                msg = $(".call-list-sms-message").val();
                token = $(e).data("token");
                country = $(e).data("country");
                phone = $(e).data("phone");
                $.ajax({
                    url : ImpactHPbaseUrl+"/send_sms",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    data : {
                        cid : cid,
                        msg : msg,
                        country : country,
                        phone : phone,
                    },
                    type : "post",
                    beforeSend : function(){
                        $(e).fadeTo("fast",.5).html("<i class='fa fa-spin fa-spinner'></i> Sending... ");
                    },
                    success : function(){
                        $(e).fadeTo("fast", 1).html("<i class='fa fa-check-circle'></i> ");
                        loadConversationHistory();
                    },
                    error : function(){
                        loadConversationHistory();
                        $(e).fadeTo("fast", 1).html("<i class='fa fa-times'></i> ");
                    }
                });
            }, // sendSms
        }, //callList


        manage : {

            purchasePhoneAddress : function(e){
                $.ajax({
                    url : ImpactHPbaseUrl+"/manage_account?ajax=purchase_phone_number",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    data :  $(e).serialize(),
                    type : "post",
                    dataType : "json",
                    beforeSend : function(){
                        $(".div-search-phone-number").fadeTo("fast", .5);
                    },
                    success : function(d){
                        $(".div-search-phone-number").fadeTo("fast",1);

                        if(d.success==false){
                            $(".div-msg").html("<div class='alert alert-danger'>"+d.message+"</div>");
                        }else{
                            $(".div-msg").html("<div class='alert alert-success'>Successfully purchased phone number.</div>");
                            

                            setTimeout(function(){
                                ImpactHP.modalClose();
                                ImpactHP.manage.loadSubaccount( $(".twilio-subaccount-container") );
                            }, 3000);

                        }

                    }
                });
            }, // purchasePhoneAddress

            loadSubaccount : function( target ){
                $.ajax({
                    url : ImpactHPbaseUrl+"/manage_account",
                    data : {
                        ajax : "twilio_subaccount"
                    },
                    success : function(d){
                        $(target).html(d);
                     },
                    beforeSend : function(){
                        $(target).html(loader);
                    }
                });
            }, //loadSubaccount

            verifyBankAccount : function(btn){
                $.ajax({
                    url : ImpactHPbaseUrl+"/manage_account",
                    data : {
                        ajax : "verify_bank_account",
                    },
                    success : function(d){
                        $(".div-add-back-account").html(d);
                    }
                });
            }, // verifyBankAccount

            contactBilling : function(cid){
                $.ajax({
                    url : ImpactHPbaseUrl+"/manage/contact_billing?id="+cid,
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $(".contact-billing-container").html(loader);
                    },
                    success : function(d){
                        $(".contact-billing-container").html(d);
                    }
                });
            }, // contactBilling

            addClientSave : function(e){
                me = $(e);
                var form = $('#add_client_form');
                //console.log(me);
               
                if(form.valid()){
                    me.html("Adding...");
                    me.prop('disabled', true);
                    
                    jQuery.ajax({
                        type : "post",
                        dataType : "json",
                        url : ImpactHPbaseUrl+'ajax_add_client',
                        data : form.serialize(),
                        success: function(response) {
                            if(response.success) {
                                $(".add-client-modal-msg").html("<div class='alert alert-success'>"+response.msg+"</div>");                                
                                me.html("Save");
                                me.prop('disabled', false);
                                form.find("input[type='text']").val("");
                                
                                $('#find_client_form').find('input[name="id"]').val(response.id);
                                $('.search_btn').trigger('click');
                                setTimeout(function(){ 
                                    $('.find_client_btn').trigger('click');
                                }, 1000);
                            }
                            else {
                                $(".add-client-modal-msg").html("<div class='alert alert-error'>"+response.msg+"</div>");                                
                                me.html("Save");
                                me.prop('disabled', false);
                            }
                        }
                    });
                }
			
				
            }, // addClientSave

            addClientForm : function(e){
                $.ajax({
                    url : ImpactHPbaseUrl+"add_client_form",
                    beforeSend : function(){
                        ImpactHP.modalOpen({ title: "Add Client", content : "<div class='div-add-client'>"+loader+"</div>","size" : "modal-lg" });
                    },
                    success : function(d){
                        $(".div-add-client").html(d);

                        setTimeout(function(){
                            //$(".phone").mask("(999) 999-9999");
                        },300);
                    }
                });
            }, // addClient

            searchClient : function(e){
                var me = $(e);
                var error = 0;
                var good = 0;
                
                if($('#find_client_form').find('#contact_id').val() == '')
                {
                    $('#find_client_form').find('.form-control').each(function() {
                        if($.trim($(this).val()) == '')
                            error++;
                    });
                    
                    if(error < 4)
                        good = 1;
                }
                else
                    good = 1;
                
                if(good == 1)
                {
                    me.html("Searching...");
                    me.prop('disabled', true);
                    $('#search_result_table').parent().hide();
                    
                    jQuery.ajax({
                        type : "post",
                        dataType : "json",
                        url : ImpactHPbaseUrl+'/ajax_find_client',
                        data : $('#find_client_form').serialize(),
                        success: function(response) {
                            $('#search_result_table tbody').html(response.data).hide().fadeIn('slow');
                            me.html("Search");
                            me.prop('disabled', false);
                            $('#search_result_table').parent().show();
                        }
                    });
                }
                else
                    alert("At least one field must be filled.");
            }, // searchClient

            searchClientAgreement : function(e){
                var me = $(e);
                var error = 0;
                var good = 0;
                
                if($('#find_client_form_agreement').find('#contact_id').val() == '')
                {
                    $('#find_client_form_agreement').find('.form-control').each(function() {
                        if($.trim($(this).val()) == '')
                            error++;
                    });
                    
                    if(error < 4)
                        good = 1;
                }
                else
                    good = 1;
                
                if(good == 1)
                {
                    me.html("Searching...");
                    me.prop('disabled', true);
                    $('.search_result_table').parent().hide();
                    
                    jQuery.ajax({
                        type : "post",
                        dataType : "json",
                        url : ImpactHPbaseUrl+'/ajax_find_client',
                        data : $('#find_client_form_agreement').serialize(),
                        success: function(response) {
                            $('.search_result_table tbody').html(response.data).hide().fadeIn('slow');
                            me.html("Search");
                            me.prop('disabled', false);
                            $('.search_result_table').parent().show();
                        }
                    });
                }
                else
                    alert("At least one field must be filled.");
            }, // searchClient

            searchClientForm : function(e){
                $.ajax({
                    url : ImpactHPbaseUrl+"search_client_form",
                    beforeSend : function(){
                        ImpactHP.modalOpen({ title: "Search Client", content : "<div class='div-search-client'>"+loader+"</div>","size" : "modal-lg", "size" : "modal-lg" });
                    },
                    success : function(d){
                        $(".div-search-client").html(d);

                        setTimeout(function(){
                            //$(".phone").mask("(999) 999-9999");
                        },300);
                    }
                });
            }, // searchClientForm


            addBankAccount : function(e){
                $.ajax({
                    url : ImpactHPbaseUrl + "/manage_account?ajax=save_bank_account",
                    type : "post",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    dataType : "json",
                    data : $("#frm-add-bank-account").serialize(),
                    beforeSend : function(){
                        $(e).html("<i class='fa fa-spin fa-spinner'></i>");
                        $(".div-add-bank-account-msg").html("");
                    },
                    success : function(d){
                        $(e).html("Save");

                        if(d.error.length >0 ){
                            $(".div-add-bank-account-msg").html("<div class='alert alert-danger'>"+d.error+"</div>");
                        }else{
                            $(".btn-verify-account").show();
                            $(".div-add-bank-account-msg").html("<div class='alert alert-success'>Bank Succesfully Added</div>");
                        }
                    }
                });
            }, // addBankAccount


            updateFBToken : function(d){
                $.ajax({
                    url : ImpactHPbaseUrl + "/manage_account?ajax=update_fb_token",
                    type : "post",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    dataType : "json",
                    data : {
                        token : d.token,
                        user_id : d.userID
                    },
                    beforeSend : function(){
                         
                    },
                    success : function(d){
                         
                    }
                });
            }, // updateFBToken

            loadFBAd : function(){
                $.ajax({
                    url : ImpactHPbaseUrl + "/manage_account?ajax=load_fb_ad",
                    type : "post",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                         $(".fb-integration-content").html(loader);
                    },
                    success : function(d){
                         $(".fb-integration-content").html(d);

                         $(".with-select2").select2();
                    }
                });
            }, // loadFBAd

            costPerLead : function(target){
                $.ajax({
                    url : ImpactHPbaseUrl + "/manage_account?ajax=home_cost_per_lead",
                    data : {
                        data : $(target).data("total_leads")
                    },
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                         
                    },
                    success : function(d){
                         $(target).html(d);
                    }
                });
            }, //costPerLead

        }, // manage

        settings : {

            updateStripeKeys : function(e){
                $.ajax({
                    url : ImpactHPbaseUrl+"ajax_update_stripe_keys",
                    data : $(e).serialize(),
                    type : "post",
                    beforeSend : function(){
                        $(e).find(".btn").fadeTo("fast",.5);
                    },
                    success : function(){
                        $(e).find(".btn").fadeTo("fast", 1).html("Updates saved!");
                        setTimeout(function(){
                            $(e).find(".btn").html("Save");
                        },3000);
                    }
                });
            }, // updateStripeKeys

            updateTwilioDetails : function(e){
                $.ajax({
                    url : ImpactHPbaseUrl+"ajax_update_twilio_keys",
                    data : $(e).serialize(),
                    type : "post",
                    beforeSend : function(){
                        $(e).find(".btn").fadeTo("fast",.5);
                    },
                    success : function(){
                        $(e).find(".btn").fadeTo("fast", 1).html("Updates saved!");
                        setTimeout(function(){
                            $(e).find(".btn").html("Save");
                        },3000);
                    }
                });
            }, // updateTwilioDetails

        }, // settings

        billing : {
            retryCCNoConfirmation : function(btn){
                //console.log(btn);
                /*
                $cc_data['contact_id']  = trim($post_data['contact_id']);
                $cc_data['product_id']  = trim($post_data['product_id']);
                $cc_data['amount']      = trim($post_data['amount']);
                $cc_data['cc_num']      = trim($post_data['cc_number']);
                $cc_data['expiry_month']= trim($post_data['expiry_month']);
                $cc_data['expiry_year'] = trim($post_data['expiry_year']);
                $cc_data['ccv']         = trim($post_data['ccv']);
                $cc_data['card_type']   = trim($post_data['card_type']);
                $cc_data['address']     = trim($post_data['address']);
                $cc_data['city']        = trim($post_data['city']);
                $cc_data['state']       = trim($post_data['state']);
                $cc_data['zip']         = trim($post_data['zip']);
                $cc_data['country']     = trim($post_data['country']);
                $cc_data['card_name']   = trim($post_data['card_name']);
                $cc_data['payment_id']  = trim($post_data['payment_id']);
                $cc_data['existing_cc'] = trim($post_data['existing_cc']);

                <span id="span_payment_4693" 
                payment_id="4693" 
                stripe_customer_id="cus_DN64KPXBo4VYGI" 
                contact_id="82211" 
                first_name="John" last_name="Smith" address="" city="" state="(___) ___-____" zip="" 
                country="" amount="49900" product_id="18" cc_id="card_1CwLsBKovuP9dmqa0rJVwkJU" 
                class="btn-with-act retry-btn-no-confirm" data-act="retry_cc_no_confirmation"><i class="fa fa-refresh fa-spin"></i></span>
                */
                $.ajax({
                    url : ImpactHPbaseUrl+"/billing/retry_cc",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    type : "post",
                    data : {
                        contact_id : $(btn).attr("contact_id"),
                        product_id : $(btn).attr("product_id"),
                        amount : $(btn).attr("amount"),
                        address : $(btn).attr("address"),
                        city : $(btn).attr("city"),
                        state : $(btn).attr("state"),
                        zip : $(btn).attr("zip"),
                        country : $(btn).attr("country"),
                        payment_id : $(btn).attr("payment_id"),
                        existing_cc : $(btn).attr("cc_id"),
                        customer_id : $(btn).attr("stripe_customer_id"),
                        cc_number : "",
                        expiry_month : "",
                        expiry_year : "",
                        ccv : "",
                        card_type : "",
                        card_name : "",
                    },
                    paymentid : $(btn).attr("payment_id"),
                    beforeSend : function(){
                        console.log("#span_payment_"+this.paymentid);
                        $("#span_payment_"+this.paymentid).html("<i class='fa fa-spin fa-refresh'></i>");
                        $("#span_payment_"+this.paymentid).parent().find(".retry_btn").hide();
                    },
                    dataType : "json",
                    success : function(d){
                        if(d.success==true){
                            $("#span_payment_"+d.payment_id).html("<span class='badge badge-success'><i class='fa fa-check'></i></span>");
                            $("#span_payment_"+d.payment_id).parent().parent().attr("class","").fadeTo("fast",.5);
                        }else{
                            $("#span_payment_"+d.payment_id).html("");
                            $("#span_payment_"+d.payment_id).parent().parent().attr("class","").fadeTo("fast",1);
                            $("#span_payment_"+d.payment_id).prepend("<span class='badge badge-error'><i class='fa fa-times'></i></span>");
                        }
                        
                    }
                });
            }, // retryCCNoconfirmation
            retryAll : function(firstRow, firstButton){
                if( firstButton.html() == "" ){
                        
                    firstButton.html("<i class='fa fa-refresh fa-spin'></i>");
                    firstRow.find(".retry_btn").hide();
                    firstButton.trigger("click");
                    

                    if ( firstRow.find(".retry_btn").length <=0 ){                            
                        clearInterval(retryInterval);
                    }

                }else{
                    //console.log("Retrying..."+ firstButton.attr("payment_id") );
                }
            }, // retryAll

            UpdatePaymentDateSave : function(frm){
                
                $.ajax({
                    url : ImpactHPbaseUrl+"/billing/update_payment_date",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    dataType : "json",
                    type : "post",
                    data : $(frm).serialize(),
                    beforeSend : function(){
                        $(frm).find(".btn-primary").fadeTo("fast", .5);
                    },
                    success : function(d){
                        $(frm).find(".btn-primary").fadeTo("fast", 1 ).removeClass("btn-primary").addClass("btn-success").html("Payment date updated");
                        $(".td_payment_date_"+d.payment_id).html(d.payment_date);
                        $(".btn-change-date-"+d.payment_id).attr("data-date",d.payment_date);
                    }
                });
            }, // UpdatePaymentDateSave

            UpdatePaymentDate : function(btn){
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                dateVal = $(btn).attr("data-date");
                changeDate = "<form onsubmit='ImpactHP.billing.UpdatePaymentDateSave(this); return false;' data-paymentid='"+$(btn).data("paymentid")+"'>";
                changeDate += "<input type='hidden' class='form-control ' value='"+$(btn).data("paymentid")+"' name='payment_id'/>";
                changeDate += "<input type='text' required class='form-control datepicker' value='"+dateVal+"' name='payment_date'/>";
                changeDate += "<div style='margin-top:10px'><button type='submit' class='btn btn-primary btn-sm'>Save</button>";
                changeDate += "<button onclick='ImpactHP.modalClose()' type='button' class='btn btn-default btn-sm'>Cancel</button></div></form>";
                ImpactHP.modalOpen({ title: "Change Date", content : "<div class='div-change-date' style='margin-top:10px'>"+changeDate+"</div>" });
                setTimeout(function(){
                    $(".datepicker").datepicker({
                        startDate: today,
                        autoclose: true
                    });
                },100);
                
            }, // billing_update_payment_date
        }, // billing

        leads : {
            list : function(table){
                
                setTimeout(function(){
                    var settings = {
                        "ordering": false,
                        "processing": true,
                        "serverSide": true,
                        "ajax": ImpactHPbaseUrl+"/leads/leads_table_json",
                        
                    };

                    /*
                    "sDom": "<t><'row'<p i>>",
                    "destroy": true,
                    "scrollCollapse": true,
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ ",
                        "sInfo": "Showing <b>_START_ to _END_</b> of _TOTAL_ entries"
                    },
                    "processing": true,
                    "serverSide": true,
                    "ajax": ImpactHPbaseUrl+"/leads/leads_table_json",
                    "iDisplayLength": 10,
                    "initComplete": function(settings, json) {


                    }
                    */  

                    table.dataTable(settings);
                    // search box for table
                     
                }, 200);
            } // list
        }, // leads

        webforms : {
            leadCaptureForm : function(i){
                ImpactHP.modalOpen({ title: "Lead Capture Form", content : "<div class='div-lead-capture-form'>"+loader+"</div>","size" : "modal-lg" });
                ImpactHP.webforms.leadCaptureDetails(i);
            },
            leadCaptureDetails : function(id){
                console.log( ImpactHPbaseUrl+"webforms/details");
                $.ajax({
                    url : ImpactHPbaseUrl+"webforms/details",
                    data : {
                        id : id
                    },
                    beforeSend : function(){
                        $(".div-lead-capture-form").fadeTo("fast", .5);
                    },
                    success : function(d){
                        $(".div-lead-capture-form").fadeTo("fast", 1);
                        $(".div-lead-capture-form").html(d);
                    }
                });
            },
            leadCaptureDetailsSave : function(e){
                $.ajax({
                    url : ImpactHPbaseUrl+"webforms/save",
                    data : $(e).serialize(),
                    type : "post",
                    dataType : "json",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $(e).find(".btn").fadeTo("fast", .5);
                    },
                    success : function(d){
                        $(e).find(".btn").addClass("btn-success").removeClass("btn-primary").fadeTo("fast", 1);
                        var i = 3;
                        webformInterval = setInterval(function(){
                            $(e).find(".btn").html("Page refresh in ("+i+") ");
                            if(i <= 0){
                                clearInterval(webformInterval);
                                window.location.href = window.location;
                            }
                            i--;
                        },1000);
                    }
                });
            },//leadCaptureDetailsSave
        }, // webforms


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

    } // ImpactHP


    if( $(".div-leads-list").length > 0 ){
        var target = this;
        setTimeout(function(){
            ImpactHP.leads.list( $(".table-contact-list") );
        },100);

    } // declare table users datatable


    if( $(".twilio-subaccount-container").length > 0 ){
        setTimeout(function(){
            ImpactHP.manage.loadSubaccount( $(".twilio-subaccount-container") );
        }, 100);
    } // twilio-subaccount-container


    // check new message
    var heartbeatReady = true;
    setInterval(function(){
        Pace.ignore(function(){
            if(heartbeatReady){
           
                $.ajax({
                    url : ImpactHPbaseUrl + "/heartbeat_sms",
                    beforeSend : function(){
                        heartbeatReady = false;
                    },
                    dataType : "json",
                    success : function(d){
                        heartbeatReady = true;
                        for(var i in d){
                            if($(".sms-notif-"+d[i].id).length <= 0 ){
                                
                                txt = 

                                $('.page-content-wrapper').pgNotification({
                                    style: 'position-simple',
                                    title: d[i].form,
                                    message: "<div data-id='"+d[i].id+"' class='sms-notif-"+d[i].id+" sms-notif-alert'><div class='bold'>"+d[i].contact_name+"</div><div>"+d[i].from+"</d><p>"+d[i].body+"</p></div>",
                                    position: "top-right",
                                    timeout: 0,
                                    type: "success",
                                    thumbnail: d[i].profile,
                                    onClose : function(){
                                        
                                    }
                                }).show();

                            }else{
                                
                            }
                        }
                    }
                });
            }
        });
        
    },10000);

    
}); // $(document).ready()


$(document).on("click",".pgn .close",function(){
    e = this;
    smsid = $(e).parent().find(".sms-notif-alert").attr("data-id");
    
    $.ajax({
        url : ImpactHPbaseUrl + "/mark_as_read",
        data : {
            id : smsid
        }
    });
});


$(document).on("change",".listen-on-change", function(){
    e = this;
    act = $(this).data("act");
    console.log(act);
    switch(act){
       

        case "call-list-select-count-report":
            var totalCount = 0;
            $(".ck-contact-count").each(function(){
                if($(this).is(":checked")){
                    totalCount = totalCount + parseInt( $(this).data("count") );
                }else{
                }
             });
            setTimeout(function(){
                //$(".total-leads-to-processed").html(totalCount);
                $(".total-leads-estimate").html( (totalCount * 3) );
            },200);
        break; // call-list-select-count-report

        case "update_fb_ad_account_id":
            id = $(this).val();
            $.ajax({
                url : ImpactHPbaseUrl + "/manage_account?ajax=update_fb_ad_account_id",
                type : "post",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                data : {
                    fb_ad_account_id : id,
                },
                beforeSend : function(){
                     
                },
                success : function(d){
                    setTimeout(function(){
                        ImpactHP.manage.loadFBAd();
                    },100);
                }
            });
        break; //update_fb_ad_account_id

        case "update_fb_ad_campaign_id":
            id = $(this).val();
            $.ajax({
                url : ImpactHPbaseUrl + "/manage_account?ajax=update_fb_ad_campaign_id",
                type : "post",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                data : {
                    fb_ad_campaign_id : id,
                },
                beforeSend : function(){
                    
                },
                success : function(d){
                    setTimeout(function(){
                        ImpactHP.manage.loadFBAd();
                    },100);
                }
            });
        break; //update_fb_ad_campaign_id

        case "call-action-outcome":
            val = $(e).val();
            if(val == "Check back tomorrow"){
                $(".frm-followup-date").val($(e).attr("data-tomorrow"));
            }else{
                $(".frm-followup-date").val("");
            }
        break; //
    }
});

$(document).on("change", "#existing_cc", function(e){
    var me = $(this);
    var stripe_card_id = $('#existing_cc').val();
    
    if(me.val() != '')
    {
        var cc_info = $(me).find("option:selected");
        $('#cc_number').val('**********'+cc_info.data('last4')).data('disabled', 'disabled');
        $('#expiry_month').val(cc_info.data('expiry_month')).data('disabled', 'disabled');
        $('#expiry_year').val(cc_info.data('expiry_year')).data('disabled', 'disabled');
        $('#ccv').val('***').data('disabled', 'disabled');
        $('#card_type').val(cc_info.data('card_type'));
        
        $('#cc_number').removeAttr('remove', 'required');
        $('#cc_number').removeAttr('remove', 'creditcard');
    }
    else
    {
        $('#cc_number').val('').removeAttr('disabled');
        $('#expiry_month').val('').removeAttr('disabled');
        $('#expiry_year').val('').removeAttr('disabled');
        $('#ccv').val('').removeAttr('disabled');
        $('#card_type').val('');
        
        $('#cc_number').attr('required');
        $('#cc_number').attr('creditcard');
    }
    e.preventDefault(); 
});

var retryInterval;
$(document).on("click",".btn-with-act",function(){
    btn = this;
    act = $(this).data("act");
    
    switch(act){

        case "update_contact_details":
            $.ajax({
                url : "/ajax_update_client",
                data : $("#manage_client_form").serialize(),
                type : "post",
                beforeSend : function(){
                    $(btn).fadeTo("fast", .5).html("<i class='fa fa-spin fa-spinner'></i>");
                },
                success : function(){
                    $(btn).fadeTo("fast", 1).html("Updates saved!");

                }
            });
        break; //update_contact_details
        
        case "purchase_phone_enter_address":
            $.ajax({
                url : ImpactHPbaseUrl + "/manage_account",
                data : {
                    ajax : "purchase_phone_enter_address",
                    phone : $(btn).data("phone"),
                    country : $(btn).data("country")
                },
                beforeSend : function(){
                    $(".div-search-phone-number").fadeTo("fast",.5);
                },
                success : function(d){
                    $(".div-search-phone-number").fadeTo("fast", 1).html(d);
                }
            });
        break; // enter address

        case "purchase_phone_number":
            $.ajax({
                url : ImpactHPbaseUrl + "/manage_account",
                data : {
                    ajax : "purchase_phone_number",
                    phone : $(btn).data("phone"),
                    country : $(btn).data("country")
                },
                beforeSend : function(){
                    $(btn).fadeTo("fast", .5).html("<i class='fa fa-spin fa-spinner'></i> Processing");
                },
                success : function(d){
                    $(btn).removeClass("btn-primary").addClass("btn-success").fadeTo("fast", 1).html("Purchase complete");
                    
                    setTimeout(function(){
                        ImpactHP.modalClose();
                        ImpactHP.manage.loadSubaccount( $(".twilio-subaccount-container") );
                    }, 400);
                    
                }
            });
        break; //purchase_phone_number

        case "search_twilio_number":
            ImpactHP.modalOpen({ title: "Buy Phone Number", content : "<div class='div-search-phone-number' style='max-height:80vh; overflow:auto'>"+loader+"</div>","size" : "modal-lg" });
            $.ajax({
                url : ImpactHPbaseUrl+ "/manage_account?ajax=twilio_search_phone_numbers",
                type : "post",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                data : $("#frm-add-twilio-number").serialize(),
                beforeSend : function(){

                },
                success : function(d){
                    $(".div-search-phone-number").html(d);

                    setTimeout(function(){
                        $(".table-twilio-phone").DataTable({
                            "bLengthChange" : false, //thought this line could hide the LengthMenu
                            "bInfo" : false,
                            "searching" : false  
                        });
                    },200);
                }
            });
        break; //search_twilio_number
        
        case "navigate_call_list":

            $.ajax({
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                url : window.location+"?pos="+$(btn).data("pos"),
                data : {
                    inner : 1
                },
                beforeSend : function(){
                    $(".inner-content").fadeTo("fast", .5);
                },
                success : function(d){
                    $(".inner-content").html(d);
                    $(".inner-content").fadeTo("fast", 1);

                    setTimeout(function(){
                        loadConversationHistory();
                        startTimer();
                    },300);
                }
            });

        break; //navigate_call_list

        case "bank_account_save":
            ImpactHP.manage.addBankAccount(btn);
        break; //bank_account_save

        case "verify_bank_account_open":
            ImpactHP.modalClose();
            setTimeout(function(){
                ImpactHP.modalOpen({ title: "Verify Bank Account", content : "<div class='div-add-back-account'>"+loader+"</div>","size" : "modal-lg" });
                ImpactHP.manage.verifyBankAccount(btn);
            },500);
        break; //verify_bank_account_open
        case "verify_bank_account":
            ImpactHP.manage.verifyBankAccount(btn);
        break; //verify_bank_account

        case "verify_bank_account_confirm":
            $.ajax({
                url : ImpactHPbaseUrl+"/manage_account?ajax=verify_bank_account_confirm",
                data : $("#frm-verify-bank-account").serialize(),
                dataType : "json",
                beforeSend : function(){
                    $(btn).fadeTo("fast", .5 ).html("<i class='fa fa-spin fa-spinner'></i>");
                },
                success : function(d){
                    if(d.msg.length > 0 ){
                        $(".div-verify-bank-account-msg").html("<div class='alert alert-danger'>"+d.msg+"</div>");
                    }else{
                        $(".div-verify-bank-account-msg").html("<div class='alert alert-success'>Bank account successfully verified. Page will refresh in (<span class='span-counter'>5</span>)</div>");
                        var x = 5;
                        setInterval(function(){
                            
                            if(x >= 0 ) $(".span-counter").html(x);

                            if(x <= 0 ){
                                window.location.href = window.location;
                            }
                            x--;
                        },1000);
                    }
                    $(btn).fadeTo("fast", 1).html("Submit");
                }
            });
        break; // verify_bank_account

        case "add_bank_account":
            ImpactHP.modalOpen({ title: "Add Bank Account", content : "<div class='div-add-back-account'>"+loader+"</div>","size" : "modal-lg" });
            $.ajax({
                url : ImpactHPbaseUrl+"/manage_account",
                data : {
                    ajax : "add_bank_account"
                },
                success : function(d){
                    $(".div-add-back-account").html(d);
                }
            });
        break; //add_bank_account

        case "webform_copy_to_clipboard":
                var copyText = document.getElementById("webform-generate-form-code");

                /* Select the text field */
                copyText.select();
            
                /* Copy the text inside the text field */
                document.execCommand("copy");

                $(btn).html("Done");

        break; // copy to clipboard

        case "webform_generate_code":
            ImpactHP.modalOpen({ title: "", content : "<div class='div-lead-capture-form-code'>"+loader+"</div>","size" : "modal-lg" });
            $.ajax({
                url : ImpactHPbaseUrl+"webforms/form_code",
                data : {
                    id : $(btn).data("id"),
                },
                beforeSend : function(){

                },
                success : function(d){
                    $(".div-lead-capture-form-code").html(d);
                }
            });
        break;//webform_generate_code
        case "webform_delete":
            r = confirm("Are you sure you want to delete this webform? ");
            if(r === true){
                $.ajax({
                    url : ImpactHPbaseUrl+"webforms/delete",
                    data : {
                        id : $(btn).data("id")
                    },
                    success : function(){
                        $(btn).parent().parent().fadeOut().remove();
                    }
                });
            }
        break;//webform_delete
        case "webform_edit":
            id = $(btn).data("id");
            ImpactHP.modalOpen({ title: "Lead Capture Form", content : "<div class='div-lead-capture-form'>"+loader+"</div>","size" : "modal-lg" });
            ImpactHP.webforms.leadCaptureDetails(id);
        break; // webform_edit
        case "open_lead_capture_form":
            id = $(btn).data("id");
            ImpactHP.webforms.leadCaptureForm(id);
        break; // open_lead_capture_form
      
        case "call_list_skip":
            window.location = ImpactHPbaseUrl+"call-list/call/"+$(btn).data("callstatus")+"?pos="+$(btn).data("pos")+"&points="+$(btn).data("points");
        break; // call_list_skip

        case "call_list_next":
            ImpactHP.callList.submitCallStatus(btn);
            
        break; // call_list_next

        case "save_callback_date":
            ImpactHP.modalClose();
        break; // save_callback_date

        case "select_call_outcome":
                val = $(btn).html();

                switch(val){
                    case "Callback On Date":
                        var divCallbackOndate = "";
                        date = $(btn).data("date");
                        time = $(btn).data("time");

                        divCallbackOndate += "<div class='row' style='margin-top:20px'> ";

                            divCallbackOndate += "<div class='col-sm-5'>";
                                divCallbackOndate += '<div class="input-group date ">';
                                divCallbackOndate += '<input type="text" class="form-control with-datepicker" value='+date+'>';
                                divCallbackOndate += '<div class="input-group-append ">';
                                divCallbackOndate += '<span class="input-group-text"><i class="fa fa-calendar"></i></span>';
                                divCallbackOndate += '</div>';
                                divCallbackOndate += '</div>';
                            divCallbackOndate += "</div>";

                            divCallbackOndate += "<div class='col-sm-5'>";
                                divCallbackOndate += '<div class="input-group date ">';
                                divCallbackOndate += '<input type="text" class="form-control with-timepicker" value='+time+'>';
                                divCallbackOndate += '<div class="input-group-append ">';
                                divCallbackOndate += '<span class="input-group-text"><i class="fa fa-clock-o"></i></span>';
                                divCallbackOndate += '</div>';
                                divCallbackOndate += '</div>';
                            divCallbackOndate += "</div>";

                            divCallbackOndate += "<div class='col-sm-2'>";
                            divCallbackOndate += "<button type='button' class='btn btn-primary btn-sm btn-with-act' data-act='save_callback_date'>Save</button>";
                            divCallbackOndate += "</div>";

                        divCallbackOndate += "</div>";

                        ImpactHP.modalOpen({ title: "Callback On Date", content : "<div class='div-callback-ondate'>"+divCallbackOndate+"</div>","size" : "modal-lg" });

                        setTimeout(function(){
                            $(".with-timepicker").timepicker();
                            $(".with-datepicker").datepicker();
                        },500);

                    break;
                    
                }

                $(".hdn-call-outcome").val(val);
                $(".span-call-outcome").html(val);

        break; // open_calllist_callback_date

        case "send_sms_call_list":
            ImpactHP.callList.sendSms(btn);
        break; //send_sms_call_list
        case "search-client-agreement":
            ImpactHP.manage.searchClientAgreement(btn);
        break;
        case "search_client":
            ImpactHP.manage.searchClient(btn);
        break;
        case "search_client_form":
            ImpactHP.manage.searchClientForm(btn);
        break;
        case "add-client-save":
            ImpactHP.manage.addClientSave(btn);
        break;
        case "add_client":
            ImpactHP.manage.addClientForm(btn);
        break; // add_client

        case "submit_call_status":
            $("#frm-call-status").submit();
        break;  //submit_call_status

        case "retry_all":

            if($(btn).hasClass("btn-warning")){
                $(btn).removeClass("btn-warning").addClass("btn-primary").html("Retry All");
                clearInterval(retryInterval);
            }else{
                $(btn).removeClass("btn-primary").addClass("btn-warning").html("<i class='fa fa-spin fa-spinner'></i> Click here to stop the process");
                $(".retry-btn-no-confirm").trigger("click");

                setTimeout(function(){
                    $(".btn-retry-all-button").removeClass("btn-warning").addClass("btn-primary").html("Retry All");
                },500);
                

                /*
                firstRow = $(".table-failed-payments tr.trfailedpayment").first();
                firstButton = firstRow.find(".retry-btn-no-confirm");
                $(btn).removeClass("btn-primary").addClass("btn-warning").html("<i class='fa fa-spin fa-spinner'></i> Click here to stop the process");
               
                ImpactHP.billing.retryAll(firstRow, firstButton);
                retryInterval = setInterval(function(){

                    firstRow = $(".table-failed-payments tr.trfailedpayment").first();
                    firstButton = firstRow.find(".retry-btn-no-confirm");

                    if ( $(".table-failed-payments tr.trfailedpayment").first().length <= 0){
                        console.log($(".table-failed-payments tr.trfailedpayment").first().length);
                        $(".btn-retry-all-button").trigger("click");
                    }
                     
                    
                    setTimeout(function(){ 
                        ImpactHP.billing.retryAll(firstRow, firstButton);
                    },200);
                },500);
                */

            }
        break; // retry_all

        case "retry_cc_no_confirmation":
            ImpactHP.billing.retryCCNoConfirmation(btn);
        break; // retry_cc_no_confirmation

        case "retry_cc":

            var me = $(this);
            var contact_id = me.attr('contact_id');
            var payment_id = me.attr('payment_id');
            var stripe_customer_id = me.attr('stripe_customer_id');
            var cc_id = me.attr("cc_id");
            
            $('#existing_cc').val('');
            /*$('#existing_cc').html($('<option>', { 
                value: '',
                text : 'Existing Credit Card' 
            }));*/
            
            $('#cc_number').val('');
            $('#expiry_month').val('');
            $('#expiry_year').val('');
            $('#ccv').val('');
            
            $('#cc_number').removeAttr('disabled');
            $('#expiry_month').removeAttr('disabled');
            $('#expiry_year').removeAttr('disabled');
            $('#ccv').removeAttr('disabled');
            
            me.hide();
            me.parent().find('.loader').show();
            
            
            if($('.select_'+stripe_customer_id).length)
            {
                //Reset the select options
                document.getElementById("existing_cc").options.length = 0;
                
                $('.select_'+stripe_customer_id+' option').each(function(){
                    $('#existing_cc').append($('<option>', {
                        value: this.value,
                        text : this.text 
                    }));
                });
                
                me.show();
                me.parent().find('.loader').hide();
                me.parent().find('.retry_btn_dummy').trigger('click');
            }
            else
            {
                $.ajax({
                    type : "post",
                    dataType : "json",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    url : ImpactHPbaseUrl+'ajax_show_cards',
                    data : {'mode' : 'show_cards', 'stripe_card_id' : cc_id , 'stripe_customer_id' : stripe_customer_id, "paymentid" : payment_id },
                    beforeSend : function(){
                        $('#existing_cc select').fadeTo("fast", .5);
                        $('.existing-card-select .fa-spin').show();
                    },
                    success: function(response) {
                        $('#existing_cc select').fadeTo("fast", 1);
                        $('.existing-card-select .fa-spin').hide();
                        if(response.success) {
                            $('#existing_cc').html(response.options);
                            $('.select_options_cc').append("<select class='select_"+stripe_customer_id+"'>"+response.options+"</select>")
                            
                            
                            //$('.cc_info').html("");
                            $('.cc_info').append(response.cc_info);
                            
                            //me.parent().find('.retry_btn_dummy').trigger('click');
                        }
                        else {
                            
                        }
                        
                        me.show();
                        me.parent().find('.loader').hide();
                    }
                });
            }
            
            
            var cc_id = me.attr('cc_id');
            //var card_type = $(obj).attr('card_type');
            //var last4 = $(obj).attr('last4');
            var address = me.attr('address');
            var country = me.attr('country');
            var city = me.attr('city');
            var state = me.attr('state');
            var zip = me.attr('zip');
            var first_name = me.attr('first_name');
            var last_name = me.attr('last_name');
            var amount = me.attr('amount');
            var customer_id = me.attr('stripe_customer_id');
            var product_id = me.attr('product_id');
            
            
            $('#address').val(address);
            $('#country').val(country);
            $('#city').val(city);
            $('#state').val(state);
            $('#zip').val(zip);
            $('#amount').val(amount);
            $('#customer_id').val(customer_id);
            $('#product_id').val(product_id);
            $('#card_name').val(first_name+" "+last_name);
            
            
            $('#contact_id').val(contact_id);
            $('#payment_id').val(payment_id);
            
            $("#retry_modal").modal("show");

        break; // retry_cc

        case "retry_cc_process":
            var me = $(this);
            var form = $('#retry_cc_form');
            
            if(form.valid()) 
            {
                if($('#existing_cc').val() == '')
                {
                    // disable the submit button to prevent repeated clicks
                    me.html('Processing..');
                    me.attr("disabled", "disabled");
                    //--->OLD SETUP var chargeAmount = ($('#amount').val() * 100); //amount you want to charge, in cents. 1000 = $10.00, 2000 = $20.00 ...
                    var chargeAmount = 100;
                    // createToken returns immediately - the supplied callback submits the form if there are no errors
                    Stripe.createToken({
                        number: form.find('#cc_number').val(),
                        name: form.find('#card_name').val(),
                        address_line1: form.find('#address').val(),
                        address_city: form.find('#city').val(),
                        address_state: form.find('#state').val(),
                        address_zip: form.find('#zip').val(),
                        address_country: 'US',
                        cvc: form.find('#ccv').val(),
                        exp_month: form.find('#expiry_month').val(),
                        exp_year: form.find('#expiry_year').val()
                    }, chargeAmount, stripeResponseHandler);
                    return false; // submit from callback
                }
                else
                {
                    $( ".retry_cc_dummy" ).trigger('click');
                }
            }
        break; // retry_cc_process

        case "proceed_to_call_list":
            var selectedCallStatus = [];
            $(".ck-contact-count").each(function(){
                if($(this).is(":checked")){
                    selectedCallStatus.push($(this).val());
                }else{
                }
            });

            setTimeout(function(){
                window.location = ImpactHPbaseUrl+"call-list/call/"+selectedCallStatus.join(",");
            }, 500);
        break;

        case "billing_update_payment_date":
            ImpactHP.billing.UpdatePaymentDate(btn);
        break; // billing_update_payment_date

        case "billing_delete_payment":
            row = $(btn).parent().parent();
            $(row).fadeTo("fast",.5);
            r = confirm("Are you sure you want to delete this payment?");
             
            if(r===true){
                $.ajax({
                    url : ImpactHPbaseUrl+"billing/payment_delete",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    data : {
                        paymentid : $(btn).data("paymentid")
                    },
                    success : function(){
                        $(row).fadeOut().remove();
                    }
                });
            }else{
                $(row).fadeTo("fast",1);
            }        
        break; // billing_delete_payment

        case "billing_change_add_credit_card":
            $.ajax({
                url : ImpactHPbaseUrl+"billing/update_create_credit_card",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                data : {
                    contactid : $(btn).data("contactid"),
                    customerid : $(btn).data("customerid"),
                    paymentid : $(btn).data("paymentid")
                },
                beforeSend : function(){
                    ImpactHP.modalOpen({ title: "Enter New Credit Card or Select Existing One", content : "<div class='div-select-create-card'>"+loader+"</div>","size" : "modal-lg" });
                },
                success : function(d){
                    $(".div-select-create-card").html(d);
                }
            });
        break; //billing_change_add_credit_card

        case "billing_add_new_credit_card":
            $.ajax({
                url : ImpactHPbaseUrl+"billing/add_new_cc",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                data : {
                    customerid : $(btn).data("customerid"),
                    contactid : $(btn).data("contactid")
                },
                beforeSend : function(){
                    ImpactHP.modalOpen({ title: "Add New Credit Card", content : "<div class='div-create-card'>"+loader+"</div>","size" : "modal-lg" });
                },
                success : function(d){
                    $(".div-create-card").html(d);
                }
            });
        break; /// 
    }
});