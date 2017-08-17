<script type="application/javascript">
$().ready(function() {
	
	panelJustifikasi();
		
	$('#frmJustifikasi .btn').click(function(){
		panelJustifikasi();
	});
	
	function panelJustifikasi()
	{
		var str = $('#frmJustifikasi').serialize();
		$('#panelJustifikasi').empty().html('<div class="eskt-loader" align="center"><img src="'+base_url+'assets/images/loaderb64.gif" /><p>Please wait</p></div>');
		$.post(base_url+'welcome/justifikasi_kehadiran', str, function(data){
			$('#panelJustifikasi').html(data);
		});	
	}
});
</script>