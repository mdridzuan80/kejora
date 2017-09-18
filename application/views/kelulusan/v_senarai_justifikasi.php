<div class="panel panel-default">
    <div class="panel-heading">
        <i class="glyphicon glyphicon-list"></i> Senarai Permohonan Menunggu Kelulusan
    </div>
    <div id="senarai_justifikasi" class="panel-body">

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Tarikh</th>
            <th>WBB</th>
            <th>Check-In</th>
            <th>Check-Out</th>
            <th>Kesalahan</th>
            <th>Status</th>
            <th>Operasi</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $b = 1;
            foreach($sen_permohonan->result() as $row){
				$shift = pcrs_wbb_starttime($row->justifikasi_user_id, $row->rpt_tarikh);
        ?>
        <tr>
            <td><?php echo $b++?></td>
            <td><?php echo strtoupper($row->NAME)?></td>
            <td><?php echo strtoupper($row->rpt_tarikh)?></td>
            <td><?php if(isset($shift[1])){echo pcrs_wbb_desc($shift[1]);}else{echo "WP?";} ?></td>
            <td><?php echo $row->rpt_check_in?></td>
            <td><?php echo $row->rpt_check_out?></td>
            <td>
            <?php
				if($row->rpt_check_in)
				{
					if(date("N", strtotime($row->rpt_tarikh))!=6)
					{
						if (date("N", strtotime($row->rpt_tarikh))!=7)
						{
							$dateString = date("Y-m-d", strtotime($row->rpt_tarikh)) . " " . $shift[0];
							if(strtotime($row->rpt_check_in) > strtotime($dateString))
							{
								$diff=strtotime($row->rpt_check_in) - strtotime($dateString);
								echo "<span style=\" color:red;\">" . pcrs_seconds_to_hms($diff) . "</span>";
							}
						}
					}
				}

				if(!$row->rpt_check_in && !$row->rpt_check_out)
				{
					echo "Tiada Rekod";
				}
				else
				{
					if(!$row->rpt_check_in)
					{
						echo "Tidak punch pagi";
					}

					if(!$row->rpt_check_out)
					{
						echo "Tidak punch petang";
					}
				}
            ?>
            </td>
            <td>
            	<?php if($row->justifikasi_status == 'M') { ?>
            	<div class="alert alert-warning" style="text-align:center">
                	<b>Permohonan Punch-In :</b> <?php echo $row->justikasi_masa ?>
                    <p>
                    	<?php echo $row->justifikasi_alasan ?>
                    </p>
                </div>
                <?php if($row->justifikasi_alasan_2){?>
                <div class="alert alert-warning" style="text-align:center">
                  	<b>Permohonan Punch-Out :</b> <?php echo $row->justikasi_masa ?>
                      <p>
                      	<?php echo $row->justifikasi_alasan_2 ?>
                      </p>
                  </div>
                  <?php } ?>
                <?php } ?>
            </td>
            <td>
                <button class="btn btn-success btn-xs btn-lulus-justifikasi" type="button" title="Meluluskan Permohoanan" data-placement="bottom" data-toggle="tooltip" data-original-title="Meluluskan Permohonan" data-tarikh="<?php echo $row->rpt_tarikh ?>" data-userid="<?php echo $row->justifikasi_user_id ?>"><span class="glyphicon glyphicon-ok-sign" ></span></button>
                <button class="btn btn-danger btn-xs btn-tolak-justifikasi" type="button" title="Menolak Permohonan" data-placement="bottom" data-toggle="tooltip" data-original-title="Menolak Permohonan" data-tarikh="<?php echo $row->rpt_tarikh ?>" data-userid="<?php echo $row->justifikasi_user_id ?>"><span class="glyphicon glyphicon-remove-sign"></span></button>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>
Jumlah : <?php echo $sen_permohonan->num_rows()?></div>
        </div>
    </div>

<div>
