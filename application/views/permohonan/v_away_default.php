<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Away</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-table fa-fw"></i>&nbsp;<span>Senarai Rekod Away</span>
            <div class="pull-right">
                <div class="btn-group">
                   <a data-target="#myModal" data-toggle="modal" class="btn btn-primary btn-xs" href="<?php echo base_url()?>mohon/away_mohon">Mohon</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
        	<div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width="1px">BIL.</th>
                            <th width="1px">BADGE&nbsp;NO.</th>
                            <th>NAMA</th>
                            <th>NO. KP</th>
                            <th>JAWATAN</th>
                            <th>WAKTU KELUAR</th>
                            <th>WAKTU MASUK</th>
                            <th>CATATAN</th>
                    	</tr>
                    </thead>
                    <tbody>
                    	<?php
						$x =1;
						foreach ($permohonan->result() as $row)
						{
						?>
                        <tr>
                            <td width="1px"><?php echo $x++;?></td>
                            <td width="1px"><?php echo $row->Badgenumber?></td>
                            <td><?php echo $row->Name?></td>
                            <td><?php echo $row->SSN?></td>
                            <td><?php echo $row->TITLE?></td>
                            <td><?php echo date("d-m-Y g:i a", strtotime($row->aw_chkin))?></td>
                            <td><?php echo date("d-m-Y g:i a", strtotime($row->aw_chkout))?></td>
                            <td><?php echo $row->aw_alasan?></td>
                    	</tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Button trigger modal -->
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
</div>
<?php
	if(isset($js_plugin_xtra)){
		foreach($js_plugin_xtra as $js_plugin_x){
			echo $js_plugin_x;	
		}
	} 
?>
