<div style="background-color:#FFF; max-width:600px; margin: auto; padding: 20px; position:relative;">
    <h1 class="page-header" style="color:#F00;">Arkib Profile Kakitangan</h1>
    <?php
        $row = $userinfo->row();
    ?>
    <form id="frmProfile" role="form" >
        <input id="hddUserId" name="hddUserId" type="hidden" value="<?php echo $row->USERID?>">
        <div class="form-group">
            <label>Nama (*)</label>
            <input name="txtNama" type="text" class="form-control" id="txtNama" value="<?php echo $row->Name?>" readonly="readonly">
        </div>
        <div class="form-group">
            <label>No KP (*)</label>
            <input name="txtNoKP" type="text" class="form-control" id="txtNoKP" value="<?php echo $row->SSN?>" readonly="readonly">
        </div>
        <div class="form-group">
            <label>Jawatan (*)</label>
            <input name="txtJawatan" type="text" class="form-control" id="txtJawatan" value="<?php echo $row->TITLE?>" readonly="readonly">
        </div>
        <div class="form-group">
        	<?php $readonly = ($this->session->userdata('role')==1)? "" : "disabled"?>
            <label>Bahagian/Unit <?php echo ($this->session->userdata('role')==1)? "(*)" : "" ?> </label>
            <?php echo form_dropdown('comBahagian', $departments , $row->DEFAULTDEPTID, "id=\"comBahagian\" class=\"form-control disabled\" readonly=\"readonly\"");?>
            <?php if($readonly == 'disabled'){?>
				 <input type="hidden" class="form-control" name="comBahagian" value="<?php echo $row->DEFAULTDEPTID?>">
			<?php }?>
        </div>
        <div class="form-group">
            <label>Alamat Emel (*)</label>
            <input type="text" class="form-control" id="txtEmel" name="txtEmel" type="email" value="<?php echo $row->street?>" readonly="readonly">
        </div>
        <div class="form-group">
            <label>Telefon (*)</label>
            <input name="txtTelefon" type="text" class="form-control" id="txtTelefon" value="<?php echo $row->PAGER?>" readonly="readonly">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-danger btn-sm btn-simpan-profile" name="btn-simpan-profile">Arkib</button>
        </div>
    </form>
    <div id="ralat">
    </div>
</div>

<script type="text/javascript">
$().ready(function() {
	$(".btn-simpan-profile").click(function(){
		$.ajax({
			url: base_url+'index.php/kakitangan/arkib/<?php echo $row->USERID?>',
			type: "post",
			data: $('#frmProfile').serialize(),
			success: function(d) {
				//alert(d);
				resp = d;
				if(resp == 0){
					$('#ralat').html("<div class=\"alert alert-danger alert-dismissable\"><button class=\"close\" type=\"button\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><b>RALAT!</b> Sila penuhkan semua kawasan bertanda (*)</div>");	
				}else{
					alert("Maklumat telah berjaya diarkibkan\n");
					$.magnificPopup.close();
				}
			}
		});
	});
});
</script>
