<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title" id="myModalLabel">Cipta Pengguna</h4>
</div>
<div class="modal-body">
	<div class="row">
		<div class="row">
            <div class="col-lg-12">
                <div id="msgAddUserInternalAlert" class="alert alert-success" style="display:none;"><strong>Berjaya!</strong>&nbsp;Pengguna telah berjaya ditambah</div>
                <div id="msgAddUserInternalDanger" class="alert alert-danger" style="display:none;"><strong>Gagal!</strong>&nbsp;Proses tidak berjaya</div>
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#internal" data-toggle="tab">KEJORA INTERNAL</a></li>
                  <li><a href="#melaka" data-toggle="tab">KEJORA.GOV.MY</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                  <div class="tab-pane active" id="internal">
                    <form id="frm-param-internal" class="form-horizontal" role="form">
                        <div>&nbsp;</div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Jabatan</label>
                            <div class="col-sm-5">
                              <?php //echo form_dropdown('cmdRptBahagian', $departments ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm\"");?>
                              <?php echo form_dropdown('cmdRptBahagian', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:350px;\"");?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Nama</label>
                            <div class="col-sm-5">
                              <select id="comRptKakitangan" name="comRptKakitangan" class="form-control input-sm">
                                <option value="0">[none]</option>
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Username</label>
                            <div class="col-sm-5">
                              <input id="txtAddUserInternal" name="txtAddUserInternal" type="text" class="form-control input-sm" placeholder="Text input" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Password</label>
                            <div class="col-sm-5">
                              <input type="password" name="txtAddUserInternalPassword" class="form-control input-sm" id="txtAddUserInternalPassword" placeholder="Password" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">Peranan</label>
                            <div class="col-sm-5">
                              <?php echo form_dropdown('comPeranan', $role ,0, "id=\"comPeranan\" class=\"form-control input-sm\"");?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label">&nbsp;</label>
                            <div class="col-sm-5">
                                <button id="cmdAddInternalUser" type="button" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                  </div>
                  <div class="tab-pane" id="melaka">
                    <form id="frm-param-domain" class="form-horizontal" role="form">
                        <div>&nbsp;</div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Jabatan</label>
                                    <div class="col-sm-10">
                                        <?php //echo form_dropdown('cmdRptBahagianDomain', $departments ,0, "id=\"cmdRptBahagianDomain\" class=\"form-control input-sm\"");?>
                                    	<?php echo form_dropdown('cmdRptBahagianDomain', array() ,0, "id=\"cmdRptBahagianDomain\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:350px;\"");?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Nama</label>
                                    <div class="col-sm-10">
                                      <select id="comRptKakitanganDomain" name="comRptKakitanganDomain" class="form-control input-sm">
                                        <option value="0">[none]</option>
                                      </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Peranan</label>
                                    <div class="col-sm-10">
                                      <?php echo form_dropdown('comPeranan', $role ,0, "id=\"comPeranan\" class=\"form-control input-sm\"");?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">&nbsp;</label>
                                    <div class="col-sm-10">
                                        <button id="cmdAddDomainUser" type="button" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                            	<div class="form-group">
                                    <label class="control-label" style="text-align:left;">@melaka.gov</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input id="txtCariUserDomain" type="text" class="form-control input-sm" placeholder="Text input" />
                                        </div>
                                    </div>
                                </div>
                             	<div class="form-group">
                                      <button id="cmdCariUserDomain" type="button" class="btn btn-success btn-xs">Cari &raquo;</button>
                                </div>
                                <div id="lstUserDomain"></div>
                            </div>
                        </div>
                    </form>
                  </div>
                </div>
           </div>
        </div>
    </div>
</div>
<?php
if(isset($js_plugin_xtra)){
	foreach($js_plugin_xtra as $js_plugin_x){
		echo $js_plugin_x;
	}
}
?>
