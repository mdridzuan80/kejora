<script>
	$(document).ready(function() {
    $('#cmdRptBahagian').combotree({
      	onChange:function(newValue,oldValue){
          	//alert(newValue);
  				var bahagianID=$('#cmdRptBahagian').combotree('getValue');

  				if ( bahagianID != undefined ) {
  					$("#comRptKakitangan").load(base_url+"kakitangan/bahagian_user_ppp",{"id":bahagianID});
  				}
      	}
  	});
	});
</script>
