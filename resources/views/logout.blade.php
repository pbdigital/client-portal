<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	{{ csrf_field() }}
</form>
<script src="<?=url('/')?>/public/assets/plugins/jquery/jquery-3.2.1.min.js"></script>

<script type="text/javascript">
	$( document ).ready(function(e) {
		$('#logout-form').submit();
	});
</script>