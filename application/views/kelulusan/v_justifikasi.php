<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Kelulusan Justifikasi Kehadiran</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div id="lpr_param_kehadiran">
        <div class="row">
            <form id="frm-kelulusan-justifikasi" class="form-horizontal" role="form">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bahagian/Unit</label>
                        <div class="col-sm-8">
                            <?php //echo form_dropdown('cmdRptBahagian', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                            <input id="segmen" type="hidden" name="segmen" value="<?php echo $segmen ?>" />
                            <?php echo form_dropdown('deptid', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:100%;\"");?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-8">
                          <select id="comRptKakitangan" name="comRptKakitangan" class="form-control input-sm">
                            <option value="0">[all]</option>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bulan</label>
                        <div class="col-sm-4">
                          <input id="txtBulan" name="txtBulan" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('m')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tahun</label>
                        <div class="col-sm-4">
                          <input id="txtTahun" name="txtTahun" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('Y')?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
					<button id="cmdKelulusanJustifikasi" type="button" class="btn btn-primary btn-sm" name="cmdKelulusanJustifikasi">Jana</button>
				</div>
            </form>
        </div>
    </div>

    <br />
    <div id="senarai_justifikasi">
    </div>
</div>