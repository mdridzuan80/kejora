<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Import</h1>
        </div>
        <!-- /.col-lg-12 -->
        <div class="col-lg-12">
        	<form id="frm-param-import" class="form-horizontal" role="form">
            	<div class="form-group">
                    <label>Bahagian</label>
                    <?php echo form_dropdown('comBahagian', $departments ,0, "id=\"comBahagian\"");?>
            	</div>
                <div class="form-group">
                    <label>File input csv</label>
                    <?php echo form_upload('userfile');?>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" id="cmdAddInternalUser" name="mysubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.row -->
</div>