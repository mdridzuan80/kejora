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
                <div class="col-lg-12">
                    <input type="hidden" name="deptid" value="1">
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
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Nama</label>
                        <div class="col-sm-4">
                          <select id="comRptKakitangan" name="comRptKakitangan" class="form-control input-sm">
                            <option value="0">[semua]</option>
                            <?php foreach($sen_pyd as $pyd) : ?>
                                <option value="<?=$pyd->USERID?>"><?=$pyd->NAME?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-8">
                          <button id="cmdKelulusanJustifikasi" type="button" class="btn btn-primary btn-sm" name="cmdKelulusanJustifikasi">Jana</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <br />
    <div id="senarai_justifikasi">
    </div>
</div>
