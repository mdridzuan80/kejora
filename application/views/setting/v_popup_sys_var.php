<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="myModalLabel">Set Pembolehubah <?php echo $params->param_title ?></h4>
</div>
<div class="modal-body">
	<div class="row">
        <form id="frm-param" class="form-horizontal" role="form">
            <div class="col-lg-12">
            	<div class="form-group">
                    <input id="kod" type="hidden" name="txt_kod" value="<?php echo $params->param_kod ?>" >
                    <label><?php echo $params->param_title ?></label>
                    <input name="txt_value" value="<?php echo $params->param_value ?>" class="form-control">
                </div>
            </div>
        </form>
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
    <button id="btn-set-sys-param" type="button" class="btn btn-primary" name="btn-mohon">Simpan</button>
</div>
<?php
	if(isset($js_plugin_xtra)){
		foreach($js_plugin_xtra as $js_plugin_x){
			echo $js_plugin_x;
		}
	}
?>
