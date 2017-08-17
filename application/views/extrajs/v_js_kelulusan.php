<script type="text/javascript">
// JavaScript Document
$().ready(function() {
	$('.btn-lulus').click(function(){
		ans = confirm('Anda ingin meluluskan permohonan ini?');
		if(ans){
			mohonid=$(this).attr('data-mohonid');
			$.ajax({
				type: 'POST',
				url: base_url+'kelulusan/timeslip',
				data: {'mohon_id':mohonid, 'flag':'L'},
				success: function(d){
						location.reload();
				}			
			});
		}else{
			return false;	
		}
	});
	
	$('.btn-pengesahan').click(function(){
		ans = confirm('Adakah anda ingin membuat pengesahan ini?');
		if(ans){
			mohonid=$(this).attr('data-mohonid');
			$.ajax({
				type: 'POST',
				url: base_url+'kelulusan/timeslip_pulang',
				data: {'mohon_id':mohonid},
				success: function(d){
						location.reload();
				}			
			});
		}else{
			return false;	
		}
	});
	
	$('.btn-tolak').click(function(){
		ans = confirm('Anda ingin menolak permohonan ini?');
		if(ans){
			mohonid=$(this).attr('data-mohonid');
			$.ajax({
				type: 'POST',
				url: base_url+'kelulusan/timeslip',
				data: {'mohon_id':mohonid, 'flag':'T'},
				success: function(d){
						location.reload();
				}			
			});
		}else{
			return false;	
		}
	});
});

</script>
