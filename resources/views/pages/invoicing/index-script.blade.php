<script>
    $(document).ready( function () {
        $('#users-project-table').DataTable();
    } );

    /* Update Credit Log */
    function showProjectModal(project = '') {
        let modal = $('#project-modal')
        let form = $('#project-modal-form')
        let modal_title = ''
        modal.modal('show')

        form.find('.has-error').removeClass('has-error')
        form.find('.help-block').addClass('hidden').html('')

        if(project == '') {
            modal_title = 'Create New Project'

            form.find('#id').val('')
            form.find('#name').val('')
            form.find('#first_name').val('')
            form.find('#last_name').val('')
            form.find('#email').val('')
            form.find('#password').val('')
            form.find('#project_id').val('')
            form.find('#quickbooks_client_id').val('')
        }else{
            modal_title = `Update Project <strong class="text-info">${project.name}</strong>`

            form.find('#id').val(project.id)
            form.find('#name').val(project.name)
            form.find('#first_name').val(project.first_name)
            form.find('#last_name').val(project.last_name)
            form.find('#email').val(project.email)
            form.find('#password').val('')
            form.find('#project_id').val(project.project_id)
            form.find('#quickbooks_client_id').val(project.quickbooks_client_id)
        }
        modal.find('.modal-title').html(modal_title)
    }

    function saveProjectModal() {
        let form = $('#project-modal-form')
        
        if(form.find('#id').val()) {
            updateProject()
        }else{
            storeProject()
        }
    }

    function storeProject() {
        let modal = $('#project-modal')
        let form = $('#project-modal-form')

        $('#project-modal-save-btn').attr('disabled',true);

        let url = "{{ route('project.store') }}"
        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize() +  "&_token={{ csrf_token() }}",
            success: function(data) {
                $('#project-modal-save-btn').attr('disabled',false); 

                $('body').pgNotification({ 
                    message: data.message, 
                    style: 'flip', 
                    type: 'success' 
                }).show();

                setTimeout(function() {
                    window.location.reload()
                }, 1000)

                modal.modal('hide');
            },
            error: function(resp){
                $('#project-modal-save-btn').attr('disabled',false)
                form.find('.has-error').removeClass('has-error')
                form.find('.help-block').addClass('hidden').html('')
                $('#project-modal-form [id^="error_"] .help-block').addClass('hidden')

                var response_json = resp.responseJSON;
                
                $.each(response_json.errors, function(i, v) {
                    var resp = '* ' + v
                    $('#error_' + i).addClass('has-error')
                    $('#error_'+i+' .help-block').removeClass('hidden').html(resp)
                });
                var keys = Object.keys(resp)
                $('input[name="'+keys[0]+'"]').focus()       
            }
        }); // end ajax
    }

    function updateProject() {
        let modal = $('#project-modal')
        let form = $('#project-modal-form')

        $('#project-modal-save-btn').attr('disabled',true);

        let url = "{{ route('project.update', ['id' => ':id']) }}"
        url = url.replace(':id', form.find('#id').val())
        
        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize() +  "&_token={{ csrf_token() }}",
            success: function(data) {
                $('#project-modal-save-btn').attr('disabled',false); 

                $('body').pgNotification({ 
                    message: data.message, 
                    style: 'flip', 
                    type: 'success' 
                }).show();

                $('#column-name-' + data.project.id).html(data.project.name)
                $('#column-project_id-' + data.project.id).html(data.project.project_id)
                $('#column-quickbooks_client_id-' + data.project.id).html(data.project.quickbooks_client_id) 

                modal.modal('hide');
            },
            error: function(resp){
                $('#project-modal-save-btn').attr('disabled',false);
                form.find('.has-error').removeClass('has-error')
                form.find('.help-block').addClass('hidden').html('')
                $('#project-modal-form [id^="error_"] .help-block').addClass('hidden');

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
</script>