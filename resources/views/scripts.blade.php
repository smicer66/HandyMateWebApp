<script>
$(window).on('load', function(){
	@if(Session::has('message'))
		$.notify({
			icon: 'fa fa-check',
			message: '<?php echo Session::get('message'); ?>'
		},{
			type: 'success'
		});
	@endif
	@if(Session::has('success'))
		//alert(33);
		$.notify({
			icon: 'fa fa-check',
			message: '<?php echo Session::get('success'); ?>'
		},{
			type: 'success'
		});
	@endif
	@if(Session::has('error'))
		$.notify({
			icon: 'fa fa-close',
			message: '<?php echo Session::get('error'); ?>'
		},{
			type: 'danger'
		});
	@endif
	@if(Session::has('warning'))
		$.notify({
			icon: 'fa fa-exclamation-triangle',
			message: '<?php echo Session::get('warning'); ?>'
		},{
			type: 'warning'
		});
	@endif
	@if($errors->any())
		<?php
		$err = '';
		?>
		$.notify({
			message: '<?php echo $err; ?>'
		},{
			type: 'danger'
		});
	@endif
});
</script>