<script type="text/javascript">
// JavaScript Document
$(document).ready(function() {
	var chkArkib = $("input[name=\"chkArkib\"]");

	chkArkib.click(function(){
		$("#comRptKakitangan").html("<option value=\"0\">[none]</option>");
		var bahagianID=$('#cmdRptBahagian').combotree('getValue');
		var segmen = $('#segmen').val();
		if(this.checked) {
			$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user_arkib",{"id":bahagianID, "segmen":segmen});
		} else {
			$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user",{"id":bahagianID, "segmen":segmen});
		}
	});

	$('#cmdRptBahagian').combotree({
    	onChange:function(newValue,oldValue){
				var bahagianID=$('#cmdRptBahagian').combotree('getValue');
				var segmen = $('#segmen').val();
				if ( bahagianID != undefined ) {
					if(chkArkib.is(':checked')) {
						$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user_arkib",{"id":newValue, "segmen":segmen});
					} else {
						$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user",{"id":bahagianID, "segmen":segmen});
					}
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

	$("#cmdRptArkibBahagian").change(function(){
		var bahagianID="";
		$("#cmdRptArkibBahagian option:selected").each(function(){
			bahagianID = $(this).val();
		});
		$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user_arkib",{"id":bahagianID});
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
			dateRange();
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

	$('#cmdJanaLaporanHarian').click(function(){
    	var deptid = $('#cmdRptBahagian').combotree('getValue');
		var staffid = $('#comRptKakitangan').val();
		var mula = $('#from').val();
		var akhir = $('#to').val();
		$("#rst-lpt-kehadiran").empty().html('<div class="att-loader"><img src="'+base_url+'assets/images/loading.gif" /></div>');
		$('#rst-lpt-kehadiran').load(base_url+'laporan/jana_harian', {'deptid': deptid, 'staffid':staffid, 'mula':mula, 'akhir':akhir});
	})

	$('#btn-mohon').click(function(){

		//validate
		if(($("#txtTarikh").val().length > 0)&&($("#txtFrom").val().length > 0)&&($("#txtTo").val().length > 0)&&($("#txtPerihalPermohonan").val().length > 0)) {
			var str = $('#frm-param-timeslip').serialize();
			$.ajax({
				type: 'POST',
				url: base_url+'mohon/timeslip_mohon',
				data: str,
				success: function(data, textStatus, qXHR){
						alert(data);
						//location.reload();
				},
				error: function(jqXHR, textStatus, errorThrown){
					alert(textStatus + ": " + errorThrown);
				}
			});
		} else {
			alert("Semua medan perlu dipenuhkan");
		}
	});

	$('#btn-mohon-away').click(function(){
		var str = $('#frm-param-away').serialize();
		$.ajax({
			type: 'POST',
			url: base_url+'mohon/away_mohon',
			data: str,
			success: function(d){
					alert(d);
					location.reload();
			}
		});
	});

	$( "#txtTarikh" ).datepicker({
		dateFormat: 'yy-mm-dd'
	});

	$('#txtFrom').timepicker({
       showLeadingZero: false,
       onSelect: tpStartSelect,
	   minTime: {
           hour: 7, minute: 30
       },
       maxTime: {
           hour: 17, minute: 30
       }
   });
   $('#txtTo').timepicker({
       showLeadingZero: false,
       onSelect: tpEndSelect,
       minTime: {
           hour: 7, minute: 30
       },
       maxTime: {
           hour: 17, minute: 30
       }
   });

   	$('#cmdHantarPermohonan').click(function(){
	var str = $('#frm-param-timeslip').serialize();
	$.ajax({
			type: 'POST',
			url: base_url+'index.php/timeslip/hantar_permohonan',
			data: str,
			success: function(d){
					alert(d);
			}
		});
	});

	$('.btn-timeslip-batal').click(function(){
		ans = confirm('Anda pasti ingin membatalkan permohonana ini?');
		if(ans)
		{
			var id = $(this).attr('data-timeslipid');
			$.ajax({
					type: 'POST',
					url: base_url+'mohon/timeslip_batal',
					data: {'id':id},
					success: function(d){
							if(d=='TRUE')
							{
								alert('Proses batal telah berjaya!');
								location.reload();
							}
							else
							{
								alert('Proses batal tidak berjaya! Permohonan ini mungkin telah diluluskan atau ditolak oleh seseorang');
								location.reload();
							}
					}
				});
		}
	});

	$('#btn-set-cuti').click(function(){
		var str = $('#frm-param-cuti').serialize();
		$.ajax({
			type: 'POST',
			url: base_url+'setting/cuti_umum_set',
			data: str,
			success: function(d){
					//alert(d);
					location.reload();
			}
		});
	});

	$('#cmdKelulusanJustifikasi').click(function(){
		if($('#comRptKakitangan').val() != 0 ){
    	var str = $('#frm-kelulusan-justifikasi').serialize();
			$("#senarai_justifikasi").empty().html('<br/><div class="att-loader"><img src="'+base_url+'assets/images/loaderb64.gif" /></div>');
			$.post(base_url+'kelulusan/justifikasi', str, function(data){
				$('#senarai_justifikasi').html(data);
			});
		}
		else {
			alert("Sila buat pilihan bahagian");
		}
	});

	$(document).on('click', '.btn-lulus-justifikasi', function() {
		var r = confirm("Anda pasti?");
		if(r == true)
		{
			var userid = $(this).attr('data-userid');
			var tarikh = $(this).attr('data-tarikh');
			var status = 'L';
			$.ajax({
				type: 'POST',
				url: base_url+'kelulusan/justifikasi',
				data: {'userid':userid,'tarikh':tarikh,'status':status},
				success: function(d){
					// load data back
					var str = $('#frm-kelulusan-justifikasi').serialize();
					$("#senarai_justifikasi").empty().html('<br/><div class="att-loader"><img src="'+base_url+'assets/images/loaderb64.gif" /></div>');
					$.post(base_url+'kelulusan/justifikasi', str, function(data){
						$('#senarai_justifikasi').html(data);
					});
				}
			});
		}
	});

	$(document).on('click', '.btn-tolak-justifikasi', function() {
		var r = confirm("Anda pasti?");
		if(r == true)
		{
			var userid = $(this).attr('data-userid');
			var tarikh = $(this).attr('data-tarikh');
			var status = 'T';
			$.ajax({
				type: 'POST',
				url: base_url+'kelulusan/justifikasi',
				data: {'userid':userid,'tarikh':tarikh,'status':status},
				success: function(d){
					// load data back
					var str = $('#frm-kelulusan-justifikasi').serialize();
					$("#senarai_justifikasi").empty().html('<br/><div class="att-loader"><img src="'+base_url+'assets/images/loaderb64.gif" /></div>');
					$.post(base_url+'kelulusan/justifikasi', str, function(data){
						$('#senarai_justifikasi').html(data);
					});
				}
			});
		}
	});
});

function rptSubmit()
{
	ans = confirm('Janaan laporan akan mengambil masa. Harap bersabar...');
	if(ans)
	{
		document.getElementById("frmRptBulanan").submit();
		return true;
	}
	else
	{
		return false;
	}
}

function rptSubmitCetak()
{
	ans = confirm('Janaan laporan akan mengambil masa. Harap bersabar...');
	if(ans)
	{
		document.getElementById("frm-param-kehadiran").action = base_url+'laporan/jana_harian/cetak';
		document.getElementById("frm-param-kehadiran").submit();
		return true;
	}
	else
	{
		return false;
	}
}

function rptStatXPunch()
{
	ans = confirm('Janaan laporan akan mengambil masa. Harap bersabar...');
	if(ans)
	{
		document.getElementById("frm_stat_lewat").submit();
		return true;
	}
	else
	{
		return false;
	}
}

function rptStatLewat3xSubmit()
{
	ans = confirm('Janaan laporan akan mengambil masa. Harap bersabar...');
	if(ans)
	{
		document.getElementById("frm_stat_lewat").submit();
		return true;
	}
	else
	{
		return false;
	}
}

function rptJanaTunjukSebab()
{
	ans = confirm('Janaan laporan akan mengambil masa. Harap bersabar...');
	if(ans)
	{
		document.getElementById("frmRptBulanan").submit();
		return true;
	}
	else
	{
		return false;
	}
}

// when start time change, update minimum for end timepicker
function tpStartSelect( time, endTimePickerInst ) {
   $('#txtTo').timepicker('option', {
       minTime: {
           hour: endTimePickerInst.hours,
           minute: endTimePickerInst.minutes
       }
   });
}

// when end time change, update maximum for start timepicker
function tpEndSelect( time, startTimePickerInst ) {
   $('#txtFrom').timepicker('option', {
       maxTime: {
           hour: startTimePickerInst.hours,
           minute: startTimePickerInst.minutes
       }
   });

}

function hapus_cuti(cuti_id)
{
	ans = confirm('Anda ingin menghapuskan cuti ini?');
	if(ans){
		$.ajax({
			type: 'POST',
			url: base_url+'setting/cuti_hapus',
			data: {'cuti_id':cuti_id},
			success: function(d){
					location.reload();
			}
		});
	}else{
		return false;
	}
}

$('#btn-set-sys-param').click(function(){
	var str = $('#frm-param').serialize();
	$.ajax({
		type: 'POST',
		url: base_url+'setting/sys_var/' + $('#kod').val(),
		data: str,
		success: function(d){
				//alert(d);
				location.reload();
		}
	});
});
</script>
<!--<script type="text/javascript">
	$(function () {
		$('#datetimepicker1').datetimepicker();
	});
</script>-->
