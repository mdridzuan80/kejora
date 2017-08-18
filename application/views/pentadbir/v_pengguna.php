<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Pentadbir Pengguna</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-user fa-fw"></i> Senarai Pengguna
            <div class="pull-right">
                <div class="btn-group">
                   <a href="<?php echo base_url()?>pentadbir/pengguna_cipta" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">Cipta Pengguna</a>
               </div>
            </div>
        </div>
        <div class="panel-body">
        	<div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="dataTables-kakitangan">
                    <thead>
                        <tr>
                            <th>Id Pengguna</th>
                            <th>Domain</th>
                            <th>Peranan</th>
                            <th>Operasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pengguna->result() as $row){?>
                        <tr>
                            <td><?php echo $row->username?></td>
                            <td><?php echo $row->domain?></td>
                            <td><?php echo $row->role_name?></td>
                            <td>
                            	<button  class="btn btn-success btn-xs btn-pengguna-hapus" onclick="return hapus_pengguna(<?php echo $row->id?>)"><i class="glyphicon glyphicon-remove-sign"></i> Hapus</button>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                ...
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
</div>
