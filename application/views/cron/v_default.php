<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Kakitangan</h1>
        </div>
        <form method="post" action="<?php echo base_url()?>welcome/sub_department">
        <div class="col-lg-6">
            <div class="form-group">
                <label class="col-sm-3 control-label">Bahagian/Unit</label>
                <div class="col-sm-9">
                    <?php echo form_dropdown('deptid[]', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department',onlyLeafCheck:true\"");?>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <input name="cmdSubmit" type="submit" class="btn btn-primary" value="Submit" />
        </div>
        </form>
    </div>
    <!-- /.row -->
</div>