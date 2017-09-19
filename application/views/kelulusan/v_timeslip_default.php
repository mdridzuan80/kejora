<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Kelulusan Keluar Pejabat</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="glyphicon glyphicon-list"></i> Senarai Permohonan Menunggu Kelulusan
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
                            <th>BAHAGIAN</th>
                            <th>WAKTU KELUAR</th>
                            <th>WAKTU MASUK</th>
                            <th>ALASAN</th>
                            <th colspan="3">TINDAKAN</th>
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
                            <td><?php echo $row->DEPTNAME?></td>
                            <td><?php echo date("d-m-Y g:i a", strtotime($row->ts_chkin))?></td>
                            <td><?php echo date("d-m-Y g:i a", strtotime($row->ts_chkout))?></td>
                            <td><?php echo $row->ts_alasan?></td>
                            <td style="text-align:center;">
                            	<button class="btn btn-success btn-xs btn-lulus" type="button" title="Meluluskan Permohoanan" data-placement="bottom" data-toggle="tooltip" data-original-title="Meluluskan Permohoanan" data-mohonid="<?php echo $row->ts_id ?>"><span class="glyphicon glyphicon-ok-sign" ></span></button>
                            	<button class="btn btn-danger btn-xs btn-tolak" type="button" title="Menolak Permohonan" data-placement="bottom" data-toggle="tooltip" data-original-title="Menolak Permohonan" data-mohonid="<?php echo $row->ts_id ?>"><span class="glyphicon glyphicon-remove-sign"></span></button>
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
