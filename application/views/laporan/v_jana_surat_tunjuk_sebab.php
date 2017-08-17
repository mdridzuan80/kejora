<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Jana Laporan Surat Tunjuk Sebab</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div id="lpr_param_kehadiran">
        <div class="row">
            <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'frmRptBulanan');
                echo form_open('laporan/tunjuk_sebab', $attributes);
            ?>
            
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Bulan</label>
                        <div class="col-sm-1">
                          <input id="txtBulan" name="txtBulan" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('m') - 1?>">
                        </div>
                    </div>
                    <div class="form-group">
                         <label class="col-sm-1 control-label">Tahun</label>
                        <div class="col-sm-1">
                          <input id="txtTahun" name="txtTahun" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('Y')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Bahagian/Unit</label>
                        <div class="col-sm-4">
                            <?php echo form_dropdown('cmdRptBahagian', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                        </div>
                    </div>
                    <div class="form-group">
                    	 <label class="col-sm-1 control-label"></label>
                         <div class="col-sm-11">
                    		<a id="cmdJanaLaporan" class="btn btn-primary btn-sm" onclick="return rptJanaTunjukSebab()" >Jana Laporan</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
