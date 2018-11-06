<div class="modal fade stick-up" id="app-global-modal_" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left">
                <span class="modal-title"></span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-14"></i></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div> <!-- .modal fade stick-up -->
<div class="modal fade slide-up disable-scroll" id="app-global-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-20"></i>
                    </button>
                    <h3>Make <?php echo ((isset($_GET['type']) && $_GET['type']== "urgent") ? 'An Urgent' : 'A New');?> Request</h3>
                </div>
                <div class="modal-body">
                    
                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade slide-right" id="modalSlideLeft" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="pg-close fs-20"></i>
                </button>
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="modal-body col-xs-height col-middle">
                            <div class="modal_content-heading">
                                <h2>Integrate SendGrid SDK into IHP 2.0</h2>
                                <div class="total-time">
                                    <img src="<?=url('/')?>/public/assets/img/dashboard/icon-clock.png" alt=""> <span>TOTAL TIME:</span> <span>1h 1m</span>
                                </div>
                           </div>
                           <textarea readonly="" style="height:100px;" class="form-control" name="comment" id="comment" cols="30" rows="10" >Setup IHP 2.0 so that we can send emails easily. 

http://github.com/sendgrid/sendgrid-php</textarea>
                            <div class="comment-container">
                                <div class="comments">
                                    <div class="user">
                                        <div class="avatar">J</div>
                                            <div class="message">
                                                <div class="name">Joe <span class="time">10 hours</span> </div>
                                                <p>I need sendgrid credentials. And also which part of the system where we send emails? Can't remember we have mail send function or compose email.</p>
                                           
                                        </div>
                                    </div>
                                    <div class="user">
                                        <div class="avatar">P</div>
                                        <div class="message">
                                            <div class="name">Paul <span class="time">10 hours</span></div>
                                            <p>Send Grid API Key: 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</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="write-comment">
                                    <input type="text" name="comment" class="form-control" placeholder="Write a comment"> 
                                    <button class="btn-send">send</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- End global Modal -->


<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/select2/js/select2.full.min.js"></script>
<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/classie/classie.js"></script>
<script src="<?=url('/')?>/public/assets/plugins/switchery/js/switchery.min.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/bootstrap3-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/jquery-autonumeric/autoNumeric.js"></script>
<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/dropzone/dropzone.min.js"></script>
<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/jquery-inputmask/jquery.inputmask.min.js"></script>
<script src="<?=url('/')?>/public/assets/plugins/bootstrap-form-wizard/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/summernote/js/summernote.min.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/moment/moment.min.js"></script>
<script src="<?=url('/')?>/public/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?=url('/')?>/public/assets/plugins/bootstrap-typehead/typeahead.bundle.min.js"></script>
<script src="<?=url('/')?>/public/assets/plugins/bootstrap-typehead/typeahead.jquery.min.js"></script>
<script src="<?=url('/')?>/public/assets/plugins/handlebars/handlebars-v4.0.5.js"></script>


<script src="<?=url('/')?>/public/assets/plugins/jquery-datatable/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/jquery-datatable/extensions/TableTools/js/dataTables.tableTools.min.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/jquery-datatable/media/js/dataTables.bootstrap.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/plugins/jquery-datatable/extensions/Bootstrap/jquery-datatable-bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
<script type="text/javascript" src="<?=url('/')?>/public/assets/plugins/datatables-responsive/js/lodash.min.js"></script>

<!-- END VENDOR JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<!-- BEGIN CORE TEMPLATE JS -->
<script src="<?=url('/')?>/public/pages/js/pages.js"></script>
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="<?=url('/')?>/public/assets/js/scripts.js" type="text/javascript"></script>
<!-- END PAGE LEVEL JS -->
<!-- END CORE TEMPLATE JS -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="<?=url('/')?>/public/assets/js/form_elements.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/js/scripts.js" type="text/javascript"></script>
<script src="<?=url('/')?>/public/assets/js/custom.js?v=1.1" type="text/javascript"></script>

<script type="text/javascript">
    var clientsAutomationbaseUrl = "{{url('/')}}/";
</script>
<script src="{{url("/public/assets/js/clientsAutomation.js")}}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
<script>$('body').addClass('menu-pin');</script>



