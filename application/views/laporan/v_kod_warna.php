<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Laporan Kod Warna</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div id="lpr_param_stat_lewat">
        <div class="row">
            <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'frm_stat_lewat');
                echo form_open('laporan/stat_03', $attributes);
            ?>

                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-sm-1 control-label">
                        <div align="left">Bulan</div>
                        </label>
                        <div class="col-sm-1">
                          <input id="txtBulan" name="txtBulan" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('m') - 0?>">
                        </div>
                    </div>
                    <div class="form-group">
                         <label class="col-sm-1 control-label">
                         <div align="left">Tahun</div>
                         </label>
                        <div class="col-sm-1">
                          <input id="txtTahun" name="txtTahun" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('Y')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">
                        <div align="left">Bahagian/<br />
                        Unit</div>
                        </label>
                        <div class="col-sm-4">
                            <?php //echo form_dropdown('cmdRptBahagian', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                            <?php echo form_dropdown('deptid', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:100%;\"");?>
                        </div>
                    </div>
                    <div class="form-group">
                    	 <label class="col-sm-1 control-label"></label>
                         <div class="col-sm-11">
                    		<a id="cmdJanaLaporan_x_punch" class="btn btn-primary btn-sm" onclick="return rptStatXPunch()" >Jana Laporan</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
