<div style="background-color:#FFF; max-width:600px; margin: auto; padding: 20px; position:relative;">
    <h1 class="page-header" style="color:#F00;">Profile Kakitangan</h1>
    <?php
        $row = $userinfo->row();
    ?>
    <form id="frmProfile" role="form" >
        <input id="hddUserId" name="hddUserId" type="hidden" value="<?php echo $row->USERID?>">
        <div class="form-group">
            <label>Nama (*)</label>
            <input type="text" class="form-control" id="txtNama" name="txtNama" value="<?php echo $row->NAME?>">
        </div>
        <div class="form-group">
            <label>No KP (*)</label>
            <input type="text" class="form-control" id="txtNoKP" name="txtNoKP" value="<?php echo $row->SSN?>">
        </div>
        <div class="form-group">
            <label>Jawatan (*)</label>
            <input type="text" class="form-control" id="txtJawatan" name="txtJawatan" value="<?php echo $row->TITLE?>">
        </div>
        <div class="form-group">
        	<?php $readonly = ($this->session->userdata('role')==1)? "" : "disabled"?>
            <label>Bahagian/Unit <?php echo ($this->session->userdata('role')==1)? "(*)" : "" ?> </label>
            <input type="text" class="form-control" name="txtNamaBahagian" type="email" value="<?php echo $row->DEPTNAME?>" disabled>
            <?php if($this->session->userdata('role')==1){echo form_dropdown('comBahagian', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:570px;\"");}?>
        </div>
        <div class="form-group">
            <label>Alamat Emel (*)</label>
            <input type="text" class="form-control" id="txtEmel" name="txtEmel" type="email" value="<?php echo $row->Email?>">
        </div>
        <div class="form-group">
            <label>Telefon (*)</label>
            <input name="txtTelefon" type="text" class="form-control" id="txtTelefon" value="<?php echo $row->PAGER?>">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm btn-simpan-profile" name="btn-simpan-profile">Simpan</button>
        </div>
    </form>
    <div id="ralat">
    </div>
</div>
<?php
	if(isset($js_plugin_xtra)){
		foreach($js_plugin_xtra as $js_plugin_x){
			echo $js_plugin_x;
		}
	}
?>
<script type="text/javascript">
$().ready(function() {
	$(".btn-simpan-profile").click(function(){
		$.ajax({
			url: base_url+'index.php/kakitangan/profile/<?php echo $row->USERID?>',
			type: "post",
			data: $('#frmProfile').serialize(),
			success: function(d) {
				//alert(d);
				resp = d;
				if(resp == 0){
					$('#ralat').html("<div class=\"alert alert-danger alert-dismissable\"><button class=\"close\" type=\"button\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><b>RALAT!</b> Sila penuhkan semua kawasan bertanda (*)</div>");
				}else{
					alert("Maklumat telah berjaya disimpan\n");
					$.magnificPopup.close();
				}
			}
		});
	});
});
</script>
