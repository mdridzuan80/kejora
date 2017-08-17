<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Set Ketua Bahagian</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
		<form method="post" action="<?php echo base_url() ?>setting/ketua_bahagian" class="form-horizontal" role="form">
        	<?php if($this->session->userdata('dept') == 0) {?>
        	<div class="form-group">
                <label class="col-sm-1 control-label">Untuk Bahagian/Unit</label>
                <div class="col-sm-5">
                    <?php echo form_dropdown('cmdDeptFor', $departments ,0, "id=\"cmdDeptFor\" class=\"form-control input-sm\"");?>
                </div>
            </div>
            <?php }?>
            <div class="form-group">
                <label class="col-sm-1 control-label">Bahagian/<br />
                Unit</label>
                <div class="col-sm-5">
                    <?php //echo form_dropdown('cmdBahagian', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                    <?php echo form_dropdown('cmdBahagian', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:100%;\"");?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label">Nama</label>
                <div class="col-sm-5">
                  <select name="comKakitangan" id="comRptKakitangan" class="form-control input-sm">
                    <option value="0">[all]</option>
                  </select>
                </div>
            </div>
            <div class="form-group">
            	<label class="col-sm-1 control-label"></label>
                    <div class="col-sm-5 checkbox">
                        <label>
                            <input name="chkKetuaBahagian" type="checkbox" value="Y">Ketua Bahagian
                        </label>
                    </div>
            </div>
            <div class="form-group">
                <label class="col-sm-1 control-label"></label>
                <div class="col-sm-5">
                  <button id="btn-set-ketua-bahagian" name="btn-set-ketua-bahagian" type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>            
    	</form>
	</div>
    <div class="row">
    	<div class="col-lg-12">
        	<?php if($pelulus->num_rows() != 0){?>
        	<div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Bahagian</th>
                            <th>Untuk Bahagian</th>
                            <th>Ketua Jabatan</th>
                            <th>Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $i=1; foreach($pelulus->result() as $row){?>
                        <tr>
                            <td><?php echo $i++?></td>
                            <td><?php echo $row->Name?></td>
                            <td><?php echo $row->DEPTNAME?></td>
                            <td><?php echo $row->pl_dept?></td>
                            <td><?php echo $row->pl_role?></td>
                            <td><button  class="btn btn-success btn-xs btn-pelulus-hapus" onclick="return hapus_ketua_bahagian(<?php echo $row->pl_id?>)"><i class="glyphicon glyphicon-remove-sign"></i> Hapus</button></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <?php }else{?>
            	<div class="alert alert-warning">
                    <b>Amaran!</b> Tiada Rekod.
                </div>
            <?php }?>
        </div>
    </div>
</div>