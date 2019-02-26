<script>
    $(document).ready( function () {
        $('#invoicing-table').DataTable();
    } );

    /* Update Credit Log */
    function showCreditLogModal(creditLog) {
        $('#credit-log-modal').modal('show')
        let form = $('#credit-log-form')
        let credit_date = getInputDate(creditLog.date)
        
        form.find('#assignable').val(creditLog.assignable)
        form.find('#date').val(credit_date)
        form.find('#discount_percent').val(creditLog.discount_percent)
        form.find('#id').val(creditLog.id)
        form.find('#project_id').val(creditLog.project_id)
        form.find('#spent').val(creditLog.spent)
        form.find('#time_id').val(creditLog.time_id)
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
    
    $(document).ready(function() {
        
    })
    /* End Update Credit Log */
</script>