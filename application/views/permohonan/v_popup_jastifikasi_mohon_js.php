<script type="text/javascript">
// JavaScript Document
$(document).ready(function() {
	$('#btn-mohon-justifikasi').click(function(){
		var rpt_id = $('#hdd_rpt_id').val();
		var str = $('#frm-param-justifikasi').serialize();
		$.ajax({
			type: 'POST',
			url: base_url+'mohon/justifikasi_mohon/'+rpt_id,
			data: str,
			success: function(d){
				if(d=='0')
				{
					alert('Catatan Perlu di isi');
				}
				else
				{
					alert('Permohonan telah diterima');
					location.reload();
				}
			}
		});
	});

	$('#kursus').click(function(){
		var cond = $('#kursus').is(':checked');
		if(cond == true){
			$('#txtCatatanPunchOut').val($('#txtCatatanPunchIn').val());
			$('#panelTkhKursus').toggle();
			$( "#from" ).datepicker( "option", "minDate", $("#hdd_rpt_id").val());
			$( "#from" ).datepicker( "option", "maxDate", new Date());
			$( "#to" ).datepicker( "option", "minDate", $("#hdd_rpt_id").val());
			$( "#to" ).datepicker( "option", "maxDate", new Date());
			dateRange();
		}
		else {
			$('#txtCatatanPunchOut').val(null);
			$('#panelTkhKursus').toggle();
			$('#dateRange').show();
			$('#dateRangeOver').hide();
		}
	});

	$('#sama').click(function(){
		var cond = $('#sama').is(':checked');
		if(cond == true){
			$('#txtCatatanPunchOut').val($('#txtCatatanPunchIn').val());
			$('#txtCatatanPunchOut').prop('disabled', true);
		}
		else {
			$('#txtCatatanPunchOut').val(null);
			$('#txtCatatanPunchOut').prop('disabled', false);
		}
	});

	function dateRange(){
		var dateFrom = new Date($('#from').val());
		var dateTo = new Date($('#to').val());

		console.log(dateFrom.getTime()/1000);
		if((dateFrom.getTime()/1000) < (dateTo.getTime()/1000)){
			$('#dateRange').hide();
			$('#dateRangeOver').show();
		}
		else {
			$('#dateRange').show();
			$('#dateRangeOver').hide();
		}
	}



	$( "#from" ).datepicker({
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  dateFormat: 'yy-mm-dd',
	  onClose: function( selectedDate ) {
		//$( "#to" ).datepicker( "option", "minDate", selectedDate );
	  }
	});

	$( "#to" ).datepicker({
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  dateFormat: 'yy-mm-dd',
	  onClose: function( selectedDate ) {
			//$( "#from" ).datepicker( "option", "maxDate", selectedDate );
			dateRange();
	  }
	});

});
</script>
