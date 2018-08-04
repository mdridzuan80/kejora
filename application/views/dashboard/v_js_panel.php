<script type="application/javascript">
$(function() {
	var jenisPopUp = '';
	var dataId = '';

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

	$('.events li').on('click', function(e) {
		e.preventDefault();
		jenisPopUp = $(this).data('jenis');
		dataId = $(this).data('jid');

		$('#myEvent').modal('show');
	});

	$('#myEvent').on('show.bs.modal', function (e) {
		var _this = $(this);
		
		$.ajax({
			method: 'post',
			url: base_url + 'api/event_info',
			data: {jenis: jenisPopUp, id: dataId},
			success: function(data, textStatus, jqXHR) {
				if(jenisPopUp == "LEWAT")
				{
					var masuk = moment(data.checkin);

					_this.find('#kategori2').html(data.kategori);
					_this.find('#masuk').html(masuk.format("dddd, DD MMM YYYY, h:mm:ss a"));
					_this.find('#lewat').show();
					_this.find('#biasa').hide();
				}
				else
				{
					var mula = moment(data.mula);
					var tamat = moment(data.tamat);

					_this.find('#kategori').html(data.kategori);
					_this.find('#mula').html(mula.format("dddd, DD MMM YYYY, h:mm:ss a"));
					_this.find('#tamat').html(tamat.format("dddd, DD MMMM YYYY, h:mm:ss a"));
					_this.find('#keterangan').html(data.keterangan);

					_this.find('#lewat').hide();
					_this.find('#biasa').show();
				}
			}
		});
  		//$(this).find('.modal-body').html(jenisPopUp);
	})
});	
</script>