<script>
    $(document).ready( function () {
        $('#invoicing-table').DataTable();
    } );

    /* Update Credit Log */
    function showCreditLogModal(creditLog = '') {
        let modal = $('#credit-log-modal')
        let form = $('#credit-log-form')
        let modal_title = ''
        modal.modal('show')

        form.find('.has-error').removeClass('has-error')
        form.find('.help-block').addClass('hidden').html('')
        
        if(creditLog == '') {
            modal_title = 'Create New Credit Log'

            form.find('#assignable').val('')
            form.find('#date').val('').attr('disabled', false)
            form.find('#discount_percent').val('')
            form.find('#id').val('')
            form.find('#project_id').val('').attr('disabled', false)
            form.find('#spent').val('')
            form.find('#time_id').val('').attr('disabled', false)
        } else {
            modal_title = 'Update Credit Log'
            let credit_date = getInputDate(creditLog.date)

            form.find('#assignable').val(creditLog.assignable)
            form.find('#date').val(credit_date).attr('disabled', true)
            form.find('#discount_percent').val(creditLog.discount_percent)
            form.find('#id').val(creditLog.id)
            form.find('#project_id').val(creditLog.project_id).attr('disabled', true)
            form.find('#spent').val(creditLog.spent)
            form.find('#time_id').val(creditLog.time_id).attr('disabled', true)
        }
        modal.find('.modal-title').html(modal_title)
    }

    function saveCreditLogModal() {
        let form = $('#credit-log-form')
        
        if(form.find('#id').val()) {
            updateCreditLog()
        }else{
            storeCreditLog()
        }
    }

    function storeCreditLog() {
        let form = $('#credit-log-form')
        $('#credit-log-modal-save-btn').attr('disabled',true);

        let url = "{{ route('invoicing.store') }}"
        
        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize() +  "&_token={{ csrf_token() }}",
            success: function(data) {
                $('#credit-log-modal-save-btn').attr('disabled',false); 

                $('body').pgNotification({ 
                    message: data.message, 
                    style: 'flip', 
                    type: 'success' 
                }).show();

                setTimeout(function() {
                    window.location.reload()
                }, 1000)

                $('#credit-log-modal').modal('hide');
            },
            error: function(resp){
                $('#credit-log-modal-save-btn').attr('disabled',false);
                form.find('.has-error').removeClass('has-error');
                $('#credit-log-form [id^="error_"] .help-block').addClass('hidden');

                var response_json = resp.responseJSON;
                
                $.each(response_json.errors, function(i, v) {
                    var resp = '* ' + v;
                    $('#error_' + i).addClass('has-error');
                    $('#error_'+i+' .help-block').removeClass('hidden').html(resp);
                });
                var keys = Object.keys(resp);
                $('input[name="'+keys[0]+'"]').focus();          
            }
        }); // end ajax
    }

    function updateCreditLog() {
        let form = $('#credit-log-form')
        $('#credit-log-modal-save-btn').attr('disabled',true);

        let url = "{{ route('invoicing.update', ['id' => ':id']) }}"
        url = url.replace(':id', form.find('#id').val())
        
        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize() +  "&_token={{ csrf_token() }}",
            success: function(data) {
                $('#credit-log-modal-save-btn').attr('disabled',false); 

                $('body').pgNotification({ 
                    message: data.message, 
                    style: 'flip', 
                    type: 'success' 
                }).show();

                $('#column-assignable-' + data.credit_log.id).html(data.credit_log.assignable)
                $('#column-spent-' + data.credit_log.id).html(data.credit_log.spent)
                $('#column-discount_percent-' + data.credit_log.id).html(data.credit_log.discount_percent) 

                $('#credit-log-modal').modal('hide');
            },
            error: function(resp){
                $('#credit-log-modal-save-btn').attr('disabled',false);
                form.find('.has-error').removeClass('has-error');
                $('#credit-log-form [id^="error_"] .help-block').addClass('hidden');

                var response_json = resp.responseJSON;
                
                $.each(response_json.errors, function(i, v) {
                    var resp = '* ' + v;
                    $('#error_' + i).addClass('has-error');
                    $('#error_'+i+' .help-block').removeClass('hidden').html(resp);
                });
                var keys = Object.keys(resp);
                $('input[name="'+keys[0]+'"]').focus();          
            }
        }); // end ajax
    }

    function getInputDate(creditLogDate) {
        let credit_date = new Date(creditLogDate)
        let year = credit_date.getFullYear(),
            month = credit_date.getMonth() + 1,
            date = credit_date.getDate()
        month = (month < 9) ? `0${month}` : month
        date = (date < 9) ? `0${date}` : date

        return `${year}-${month}-${date}`;
    }
    /* End Update Credit Log */

    function comfirmDeleteCreditLog(id, assignable) {
        var comfirm_delete = confirm(`Are you sure you want to delete the "${assignable}"?`);
        
        if (comfirm_delete == true) {
            deleteCreditLog(id)
        }
    }

    function deleteCreditLog(id) {
        let url = "{{ route('invoicing.delete', ['id' => ':id']) }}"
        url = url.replace(':id', id)

        $.ajax({
            type: 'delete',
            url: url,
            data: "_token={{ csrf_token() }}",
            success: function(data) {
                $('body').pgNotification({ 
                    message: data.message, 
                    style: 'flip', 
                    type: 'danger' 
                }).show();

                setTimeout(function() {
                    window.location.reload()
                }, 1000)
            },
            error: function(resp){
                $('#credit-log-modal-save-btn').attr('disabled',false);
                form.find('.has-error').removeClass('has-error');
                $('#credit-log-form [id^="error_"] .help-block').addClass('hidden');

                var response_json = resp.responseJSON;
                
                $.each(response_json.errors, function(i, v) {
                    var resp = '* ' + v;
                    $('#error_' + i).addClass('has-error');
                    $('#error_'+i+' .help-block').removeClass('hidden').html(resp);
                });
                var keys = Object.keys(resp);
                $('input[name="'+keys[0]+'"]').focus();          
            }
        }); // end ajax
    }
</script>