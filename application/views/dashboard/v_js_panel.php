<script type="application/javascript">
$(function() {
	
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

	$('#panelJustifikasi').delegate('.cmdHapusjustifikasi','click',function(){
		console.log($(this).attr('data-justifikasi_id'));
		var justifikasi_id = $(this).attr('data-justifikasi_id');
		$.ajax({
			method: 'post',
			url: base_url + 'welcome/hapus_justifikasi',
			data: {justifikasi_id: justifikasi_id},
			success: function(){
				panelJustifikasi();
				alert('Proses hapus justifikasi telah berjaya');
			},
			error: function( jqXHR, textStatus, errorThrown){
				alert('Proses hapus justifikasi tidak berjaya');
			}
		});
	});
});	
</script>