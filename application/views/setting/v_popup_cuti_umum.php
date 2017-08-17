<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="myModalLabel">Set Cuti Umum</h4>
</div>
<div class="modal-body">
	<div class="row">
        <form id="frm-param-cuti" class="form-horizontal" role="form">
            <div class="col-lg-12">
            	<div class="form-group">
                    <label for="exampleInputEmail1">Tarikh</label>
                    <input id="from" name="txt_tkh_cuti" class="form-control">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Perihal</label>
                    <textarea name="txt_perihal_cuti" rows="5" class="form-control"></textarea>
                </div>
            </div>
        </form>
    </div>

</div>    
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
    <button id="btn-set-cuti" type="button" class="btn btn-primary" name="btn-mohon">Mohon</button>
</div>
<?php
	if(isset($js_plugin_xtra)){
		foreach($js_plugin_xtra as $js_plugin_x){
			echo $js_plugin_x;	
		}
	} 
?>
                                    