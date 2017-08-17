<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Cuti Umum</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-table fa-fw"></i>&nbsp;<span>Senarai Cuti Bagi Negeri Melaka</span>
            <div class="pull-right">
                <div class="btn-group">
                   <a data-target="#myModal" data-toggle="modal" class="btn btn-primary btn-xs" href="<?php echo base_url()?>setting/cuti_umum_set">Set Cuti</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
        	<?php if($cuti->num_rows() != 0){?>
        	<div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tarikh</th>
                            <th>Perihal</th>
                            <th>Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php $i=1; foreach($cuti->result() as $row){?>
                        <tr>
                            <td><?php echo $i++?></td>
                            <td><?php echo date('l d-m-Y', strtotime($row->cuti_mula))?></td>
                            <td><?php echo $row->cuti_perihal?></td>
                            <td><button  class="btn btn-success btn-xs btn-pengguna-hapus" onclick="return hapus_cuti(<?php echo $row->cuti_id?>)"><i class="glyphicon glyphicon-remove-sign"></i> Hapus</button></td>
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
<!-- Modal -->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            ...
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
