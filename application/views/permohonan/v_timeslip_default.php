<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Permohonan Keluar Pejabat</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-table fa-fw"></i>&nbsp;<span>Senarai Permohonan</span>&nbsp;&nbsp;&nbsp;<strong>Petunjuk :</strong> <button class="btn btn-warning btn-xs" type="button" title="Masih dalam Permohonan" data-placement="bottom" data-toggle="tooltip" data-original-title="Masih dalam Permohonan"><span class="glyphicon glyphicon-question-sign"></span></button>&nbsp;<span>Dalam Permohonan</span>&nbsp;&nbsp;&nbsp;<button class="btn btn-success btn-xs" type="button" title="Permohonan Lulus" data-placement="bottom" data-toggle="tooltip" data-original-title="Permohonan Lulus"><span class="glyphicon glyphicon-ok-sign"></span></button>&nbsp;<span>Permohonan Lulus</span>&nbsp;&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" title="Permohonan Ditolak" data-placement="bottom" data-toggle="tooltip" data-original-title="Permohonan Ditolak"><span class="glyphicon glyphicon-remove-sign"></span></button>&nbsp;<span>Permohonan Ditolak</span>&nbsp;&nbsp;&nbsp;<button class="btn btn-danger btn-xs" type="button" title="Permohonan Ditolak" data-placement="bottom" data-toggle="tooltip" data-original-title="Tiada Pengesahan Pulang"><span class="glyphicon glyphicon-thumbs-down"></span></button>&nbsp;<span>Tiada pengesahan Pulang</span>&nbsp;&nbsp;&nbsp;<button class="btn btn-primary btn-xs" type="button" title="Permohonan Ditolak" data-placement="bottom" data-toggle="tooltip" data-original-title="Pengesahan Pulang"><span class="glyphicon glyphicon-thumbs-up"></span></button>&nbsp;<span>Pengesahan Pulang</span>
            <div class="pull-right">
                <div class="btn-group">
                   <a data-target="#myModal" data-toggle="modal" class="btn btn-primary btn-xs" href="<?php echo base_url()?>mohon/timeslip_mohon">Mohon</a>
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
                            <th>STATUS</th>
                            <th>OPERASI</th>
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
                            <td width="1px"><?php echo $row->BADGENUMBER?></td>
                            <td><?php echo $row->NAME?></td>
                            <td><?php echo $row->SSN?></td>
                            <td><?php echo $row->TITLE?></td>
                            <td><?php echo date("d-m-Y g:i a", strtotime($row->ts_chkin))?></td>
                            <td><?php echo date("d-m-Y g:i a", strtotime($row->ts_chkout))?></td>
                            <td style="text-align:center;">
                            	<?php
									switch($row->ts_status){
										case 'M':
											echo '<button class="btn btn-warning btn-xs" type="button" title="Masih dalam Permohonan" data-placement="bottom" data-toggle="tooltip" data-original-title="Masih dalam Permohonan"><span class="glyphicon glyphicon-question-sign"></span></button>';
										break;
										case 'L':
											echo '<button class="btn btn-success btn-xs" type="button" title="Permohonan Diluluskan oleh : ' . $row->ts_validatename . ' Pada :' . date('d-m-Y h:i a',strtotime($row->ts_validate)) . '" data-placement="bottom" data-toggle="tooltip" data-original-title="Permohonan Lulus"><span class="glyphicon glyphicon-ok-sign"></span></button>';
											if ($row->ts_date){
												echo '<br/><button class="btn btn-primary btn-xs" type="button" title="Pengesahan Pulang Oleh : ' . $row->ts_pengesah . ' Pada :' . date("d-m-Y h   h:i a", strtotime($row->ts_date)) . '" data-placement="bottom" data-toggle="tooltip" data-original-title="Permohonan Lulus"><span class="glyphicon glyphicon-thumbs-up"></span></button>';
											}
											else
											{
												echo '<br/><button class="btn btn-danger btn-xs" type="button" title="Tiada Pengesahan Pulang" data-placement="bottom" data-toggle="tooltip" data-original-title="Permohonan Lulus"><span class="glyphicon glyphicon-thumbs-down"></span></button>';
											}
										break;
										case 'T':
											echo '<button class="btn btn-danger btn-xs" type="button" title="Permohonan Ditolak oleh : ' . $row->ts_validatename . ' Pada :' . date('d-m-Y g:i:s a',strtotime($row->ts_validate)) . '" data-placement="bottom" data-toggle="tooltip" data-original-title="Permohonan Ditolak"><span class="glyphicon glyphicon-remove-sign"></span></button>';
										break;
									}
								?>
                            </td>
                            <td>
                            	<?php if($row->ts_status == 'M'){?>
                            	<button name="windowX" class="btn btn-success btn-xs btn-timeslip-batal" data-timeslipid=<?php echo $row->ts_id?>><i class="glyphicon glyphicon-remove-sign"></i> Batal</button>
                            	<?php }?>

                            </td>
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
