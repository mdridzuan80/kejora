<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Laporan Arkib Bulanan</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div id="lpr_param_kehadiran">
        <div class="row">
            <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'frmRptBulanan');
                echo form_open('laporan/jana_arkib_bulanan', $attributes);
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
                            <?php //echo form_dropdown('cmdRptBahagian', $departments ,0, "id=\"cmdRptArkibBahagian\" class=\"form-control input-sm\"");?>
                            <?php echo form_dropdown('deptid', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:100%;\"");?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Anggota</label>
                        <div class="col-sm-11">
                            <select id="comRptKakitangan" name="comRptKakitangan[]" multiple class="form-control" size="24">
                                <option value="0">[none]</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                    	 <label class="col-sm-1 control-label"></label>
                         <div class="col-sm-11">
                    		<a id="cmdJanaLaporan" class="btn btn-primary btn-sm" onclick="return rptSubmit()" >Jana Laporan</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
