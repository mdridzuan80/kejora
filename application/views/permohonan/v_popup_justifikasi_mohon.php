<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="myModalLabel">Justifikasi Kehadiran pada : <?php echo $rpt_id?></h4>
</div>
<div class="modal-body">
	<div class="row">
        <form id="frm-param-justifikasi" class="form-horizontal" role="form">
            <input id="hdd_rpt_id" name="hdd_rpt_id" type="hidden" value="<?php echo $rpt_id ?>" />
            <input id="hdd_punch_in" name="hdd_punch_in" type="hidden" value="<?php echo $punch_in ?>" />
            <input id="hdd_punch_out" name="hdd_punch_out" type="hidden" value="<?php echo $punch_out ?>" />
            <div class="col-lg-12">
                <?php if(!$punch_out){?>
                <div class="checkbox">
                    <label>
                      <input id="kursus" name="kursus" type="checkbox"> Kursus/Bengkel, catatan perlu diisi selepas kursus/bengkel tamat dihadiri
                    </label>
                  </div>
                  <div id="panelTkhKursus" style="display:none;">
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Tarikh Dari</label>
                    <div class="col-sm-4">
                      <input id="from" name="mula" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo $rpt_id?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-3 control-label">Tarikh Hingga</label>
                    <div class="col-sm-4">
                      <input id="to" name="akhir" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo $rpt_id?>">
                    </div>
                  </div>
                </div>
                <?php }?>
                <div id="dateRange">
                  <?php if(!$punch_in || $lewat){?>
                  <div class="form-group">
                      <label for="txtCatatanPunchIn">Catatan Punch-In</label>
                      <textarea id="txtCatatanPunchIn" name="txtCatatanPunchIn" rows="3" class="form-control"></textarea>
                  </div>
                  <?php }?>

                  <?php if(!$punch_in && !$punch_out){?>
                  <div class="checkbox">
                    <label>
                      <input id="sama" name="sama" type="checkbox"> Catatan punch-out sama seperti punch-In
                    </label>
                  </div>
                  <?php }?>

                  <?php if(!$punch_out || $awal){?>
                  <div class="form-group">
                      <label for="txtCatatanPunchOut">Catatan Punch-Out</label>
                      <textarea id="txtCatatanPunchOut" name="txtCatatanPunchOut" rows="3" class="form-control"></textarea>
                  </div>
                  <?php }?>
                </div>

                <div id="dateRangeOver" style="display:none;">
                  <div class="form-group">
                      <label for="txtCatatanPunchOut">Catatan</label>
                      <textarea id="txtCatatan" name="txtCatatan" rows="3" class="form-control"></textarea>
                  </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
    <button id="btn-mohon-justifikasi" type="button" class="btn btn-primary" name="btn-mohon-away">Mohon</button>
</div>
<?php
	if(isset($js_plugin_xtra)){
		foreach($js_plugin_xtra as $js_plugin_x){
			echo $js_plugin_x;
		}
	}
?>
