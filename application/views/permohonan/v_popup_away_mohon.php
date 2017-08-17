<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="myModalLabel">Catatan Away</h4>
</div>
<div class="modal-body">
	<div class="row">
        <form id="frm-param-away" class="form-horizontal" role="form">
            <div class="col-lg-12">
            	<?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
                <div class="form-group">
                    <label class="control-label">Bahagian/Unit</label>
                    <?php //echo form_dropdown('cmdRptBahagian', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                    <?php echo form_dropdown('cmdRptBahagian', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:100%;\"");?>
                </div>
                <div class="form-group">
                    <label class="control-label">Nama</label>
                    <select id="comRptKakitangan" name="comRptKakitangan" class="form-control input-sm">
                        <option value="0">[all]</option>
                    </select>
                </div>
                <?php }else{?>
                	<input id="comRptKakitangan" name="comRptKakitangan" type="hidden" value="<?php echo $this->session->userdata('uid')?>">
                <?php }?>
                <div class="form-group">
                    <label class="control-label">Tarikh dan Masa Mula</label>
                    <input id="txtTarikh" name="txtTarikh" type="text" class="form-control input-sm" >
                    <input id="txtFrom" name="txtFrom" type="text" class="form-control input-sm" >
                </div>
                <div class="form-group">
                    <label class="control-label">Masa Keluar</label>
                    <input id="txtFrom" name="txtFrom" type="text" class="form-control input-sm" >
                </div>
                <div class="form-group">
                    <label class="control-label">Masa Balik</label>
                    <input id="txtTo" name="txtTo" type="text" class="form-control input-sm" >
                </div>
                <div class="form-group">
                    <label class="control-label">Kategori</label>
                    <?php echo form_dropdown('com_ktg_away', $ktg_aways ,0, "id=\"com_ktg_away\" class=\"form-control input-sm\"");?>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Lokasi</label>
                    <textarea name="txtPerihalPermohonan" rows="5" class="form-control"></textarea>
                </div>
            </div>
        </form>
    </div>

</div>    
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
    <button id="btn-mohon-away" type="button" class="btn btn-primary" name="btn-mohon-away">Mohon</button>
</div>
<?php
	if(isset($js_plugin_xtra)){
		foreach($js_plugin_xtra as $js_plugin_x){
			echo $js_plugin_x;	
		}
	} 
?>
                                    