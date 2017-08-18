<script type="text/javascript">
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
		$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user",{"id":bahagianID});
	});

	$('#cmdRptBahagianDomain').combotree({
    	onChange:function(newValue,oldValue){
        	//alert(newValue);
			var bahagianID=$('#cmdRptBahagianDomain').combotree('getValue');
			$("#cmdRptBahagianDomain option:selected").each(function(){
				bahagianID = $(this).val();
			});
			$("#comRptKakitanganDomain").load(base_url+"kakitangan/bahagian_user",{"id":bahagianID});
			}
	});
	
	$("#cmdRptBahagianDomain").change(function(){
		var bahagianID="";
		$("#cmdRptBahagianDomain option:selected").each(function(){
			bahagianID = $(this).val();
		});
		$("#comRptKakitanganDomain").load(base_url+"kakitangan/bahagian_user",{"id":bahagianID});
	});
	
	$('#cmdAddInternalUser').click(function(){
		var str = $('#frm-param-internal').serialize();
		$.ajax({
			type: 'POST',
			url: base_url+'pentadbir/do_tambah_pengguna_internal',
			data: str,
			success: function(){
						//alert(str);
						$('#msgAddUserInternalAlert').show();
						$('#msgAddUserInternalAlert').delay(2000).hide('slow');
						$(location).delay(5000).attr('href',base_url+'pentadbir/pengguna');
					},
			error: function(jqXHR, textStatus, errorThrown){
				alert(textStatus + ": " + errorThrown);
			}
		});
	});
	
	$('#cmdAddDomainUser').click(function(){
	var str = $('#frm-param-domain').serialize();
	$.ajax({
			type: 'POST',
			url: base_url+'pentadbir/do_tambah_pengguna_domain',
			data: str,
			success: function(){
					//alert(str);
					$('#msgAddUserInternalAlert').show();
					$('#msgAddUserInternalAlert').delay(2000).hide('slow');
					$(location).delay(5000).attr('href',base_url+'pentadbir/pengguna');
				},
			error: function(jqXHR, textStatus, errorThrown){
				alert(textStatus + ": " + errorThrown);
			}
		});
	});
	
	$('#cmdCariUserDomain').click(function(){
		var key = $('#txtCariUserDomain').val();
		//alert(key);
		$('#lstUserDomain').load(base_url+'pentadbir/chk_ad_user', {'key': key});
	});
	
	$('.btn-pengguna-hapus').click(function(){
		ans = confirm('Anda ingin menghapuskan pengguna ini?');
		if(ans){
			userid=$(this).attr('data-userid');
			$.ajax({
				type: 'POST',
				url: base_url+'pentadbir/pengguna_hapus',
				data: {'user_id':userid},
				success: function(d){
						location.reload();
				}			
			});
		}else{
			return false;	
		}	
	});
});

function hapus_pengguna(user_id)
{
	ans = confirm('Anda ingin menghapuskan pengguna ini?');
		if(ans){
			$.ajax({
				type: 'POST',
				url: base_url+'pentadbir/pengguna_hapus',
				data: {'user_id':user_id},
				success: function(d){
						location.reload(); 
				}			
			});
		}else{
			return false;	
		}	
}
</script>