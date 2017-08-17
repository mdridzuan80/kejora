<script type="text/javascript">
// JavaScript Document
$().ready(function() {
	
	$('#cmdRptBahagian').combotree({
    	onChange:function(newValue,oldValue){
        	//alert(newValue);
			var bahagianID=$('#cmdRptBahagian').combotree('getValue');
			
			if ( $("#comRptKakitangan").length ) {
				$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user",{"id":bahagianID});
			}
			
			if ( $("#comRptKakitanganLayak").length ) {
				var bulan="";
				var tahun="";
				bulan = $("#txtBulan").val();
				tahun = $("#txtTahun").val();
				$("#comRptKakitanganLayak").load(base_url+"kakitangan/layak_ts",{"id":bahagianID, "bulan":bulan, "tahun":tahun});
			}
    	}
	});
	
	$("#cmdRptBahagian").change(function(){
		var bahagianID="";
		$("#cmdRptBahagian option:selected").each(function(){
			bahagianID = $(this).val();
		});
		$("#comRptKakitangan").load(base_url+"kakitangan/bahagian",{"id":bahagianID});
	});
	
	$( "#from" ).datepicker({
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  dateFormat: 'yy-mm-dd',
	  onClose: function( selectedDate ) {
		$( "#to" ).datepicker( "option", "minDate", selectedDate );
	  }
	});
	
	$( "#to" ).datepicker({
	  defaultDate: "+1w",
	  changeMonth: true,
	  numberOfMonths: 1,
	  dateFormat: 'yy-mm-dd',
	  onClose: function( selectedDate ) {
		$( "#from" ).datepicker( "option", "maxDate", selectedDate );
	  }
	});
	
	$('#cmdJanaLaporanHarian').click(function(){
    	var deptid = $('#cmdRptBahagian').val();
		var staffid = $('#comRptKakitangan').val();
		var mula = $('#from').val();
		var akhir = $('#to').val();
		$("#rst-lpt-kehadiran").empty().html('<div class="att-loader"><img src="'+base_url+'assets/images/loading.gif" /></div>');
		$('#rst-lpt-kehadiran').load(base_url+'laporan/jana_harian', {'deptid': deptid, 'staffid':staffid, 'mula':mula, 'akhir':akhir});
	})
});

function rptSubmit()
{
	document.getElementById("frmRptBulanan").submit();	
}

function hapus_ketua_bahagian(pl_id)
{
	ans = confirm('Anda ingin menghapuskan pelulus ini?');
	if(ans){
		$.ajax({
			type: 'POST',
			url: base_url+'setting/ketua_bahagian_hapus',
			data: {'pl_id':pl_id},
			success: function(d){
					location.reload(); 
			}			
		});
	}else{
		return false;	
	}	
}

</script>
