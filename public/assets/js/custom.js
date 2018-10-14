function show_alert(msg, type)
{
	if(type == 'error')
	{
		$('.alert').removeClass('alert-success');
		$('.alert').addClass('alert-danger');
	}
	else if(type == 'success')
	{
		$('.alert').removeClass('alert-danger');
		$('.alert').addClass('alert-success');
	}
	
	$('.popover_msg').html("<strong>"+type.toUpperCase()+": </strong>"+msg);
	$('.alert').show();
	$('html,body').animate({ scrollTop: 0 }, 'slow');
}

