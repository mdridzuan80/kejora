<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Justifikasi Kehadiran</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div id="lpr_jastifikasi_kehadiran">
        <div class="row">
            <?php
                $attributes = array('class' => 'form-horizontal', 'id' => 'frmJustifikasi');
                echo form_open('mohon/jana_bulanan', $attributes);
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
                            <?php //echo form_dropdown('cmdRptBahagian', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                            <?php echo form_dropdown('cmdRptBahagian', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:100%;\"");?>
                        </div>
                    </div>
                    
                    <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
                    <div class="form-group">
                        <label class="col-sm-1 control-label">Anggota</label>
                        <div class="col-sm-4">
                            <select id="comRptKakitanganLayak" name="comRptKakitanganLayak" class="form-control input-sm">
                                <option value="0">[all]</option>
                            </select>
                        </div>
                    </div>
                    <?php }else{?>
                        <input id="comRptKakitangan" name="comRptKakitangan" type="hidden" value="<?php echo $this->session->userdata('uid')?>">
                    <?php }?>
                    <div class="form-group">
                    	 <label class="col-sm-1 control-label"></label>
                         <div class="col-sm-11">
                    		<a id="cmdPapar" class="btn btn-primary btn-sm">Papar Maklumat</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>