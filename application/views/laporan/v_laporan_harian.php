<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Laporan Harian</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div id="lpr_param_kehadiran">
        <div class="row">
            <form id="frm-param-kehadiran" class="form-horizontal" role="form" method="post">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bahagian/Unit</label>
                        <div class="col-sm-8">
                            <?php //echo form_dropdown('deptid', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                            <?php echo form_dropdown('deptid', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:100%;\"");?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-8">
                          <select id="comRptKakitangan" name="staffid" class="form-control input-sm">
                            <option value="0">[all]</option>
                          </select>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tarikh Dari</label>
                        <div class="col-sm-4">
                          <input id="from" name="mula" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('Y-m-d')?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Tarikh Hingga</label>
                        <div class="col-sm-4">
                          <input id="to" name="akhir" type="text" class="form-control input-sm" placeholder="Text input" value="<?php echo date('Y-m-d')?>">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                	<button id="cmdJanaLaporanHarian" type="button" class="btn btn-primary btn-sm">Jana Laporan</button>
                    <button id="cmdCetakLaporanharian" type="button" class="btn btn-primary btn-sm" onclick="rptSubmitCetak()">Cetak Laporan</button>
                </div>
            </form>
        </div>
    </div>
    <br/>
    <div class="col-lg-12">
        <div id="rst-lpt-kehadiran">
            &nbsp;
        </div>
    </div>
</div>