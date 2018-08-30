<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Tarikh</th>
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
            foreach($rst_justifikasi->result() as $row){
				//$shift = pcrs_wbb_by_date($this->session->userdata('uid'), $row->rpt_tarikh);
				$shift = pcrs_wbb_starttime($this->session->userdata('uid'), $row->rpt_tarikh);
        ?>
        <tr>
            <td><?php echo $b++?></td>
            <td><?php echo strtoupper($row->rpt_tarikh)?></td>
            <td><?php echo $row->rpt_check_in?></td>
            <td><?php echo $row->rpt_check_out?></td>
            <td>
            <?php
				if($row->rpt_check_in && $row->rpt_check_out)
				{
					if(date("N", strtotime($row->rpt_tarikh))!=6)
					{
						if (date("N", strtotime($row->rpt_tarikh))!=7)
						{
							$dateString = date("Y-m-d", strtotime($row->rpt_tarikh)) . $shift[0];
							if(strtotime($row->rpt_check_in) > strtotime($dateString))
							{
								$diff=strtotime($row->rpt_check_in) - strtotime($dateString);
								echo "Lewat Hadir : <span style=\" color:red;\">" . pcrs_seconds_to_hms($diff) . "</span><br/>";
							}

                            $dateString = (date("N", strtotime($row->rpt_tarikh)) == 4) ? strtotime("-90 minutes", strtotime($row->rpt_tarikh . ' ' . $shift[2])) : date("Y-m-d", strtotime($row->rpt_tarikh)) . $shift[2];

							if(strtotime($row->rpt_check_out) < strtotime($dateString))
							{
								$diff=strtotime($dateString)-strtotime($row->rpt_check_out);
								echo "Pulang Awal : <span style=\" color:red;\">" . pcrs_seconds_to_hms($diff) . "</span><br/>";
							}
						}
					}
				}

				if(!$row->rpt_check_in && !$row->rpt_check_out)
				{
					echo "Tiada Rekod<br/>";
				}
				else
				{
					if(!$row->rpt_check_in)
					{
						echo "Tidak punch pagi<br/>";
					}

					if(!$row->rpt_check_out)
					{
						echo "Tidak punch petang<br/>";
					}
				}
            ?>
            </td>
            <td>
            	<?php if($row->justifikasi_status == 'M'){?>
                <?php if($row->justifikasi_alasan){?>
            	<div class="alert alert-warning" style="text-align:center">
                	<b>Permohonan Punch-In :</b> <?php echo $row->justikasi_masa ?>
                    <p>
                    	<?php echo $row->justifikasi_alasan ?>
                    </p>
                </div>
                <?php } ?>
                <?php if($row->justifikasi_alasan_2){?>
                <div class="alert alert-warning" style="text-align:center">
                  	<b>Permohonan Punch-Out :</b> <?php echo $row->justikasi_masa ?>
                    <p>
                    <?php echo $row->justifikasi_alasan_2 ?>
                    </p>
                </div>
                <?php } ?>
                <?php } ?>

                <?php if($row->justifikasi_status == 'L'){?>
                <?php if($row->justifikasi_alasan){?>
            	<div class="alert alert-success" style="text-align:center">
                	<b>Lulus Punch-In :</b> <?php echo $row->justikasi_masa ?>
                    <p>
                    	<?php echo $row->justifikasi_alasan ?>
                    </p>
                    <div style="font-size:10px; border-top:solid 1px #000;">Pelulus : <?php echo $row->justifikasi_verifikasi ?> <?php echo $row->justifikasi_tkh_verifikasi ?></div>
                </div>
                <?php } ?>
                <?php if($row->justifikasi_alasan_2){?>
                <div class="alert alert-success" style="text-align:center">
                <b>Lulus Punch-Out :</b> <?php echo $row->justikasi_masa ?>
                    <p>
                    <?php echo $row->justifikasi_alasan_2 ?>
                    </p>
                </div>
                <?php } ?>
                <?php } ?>

                <?php if($row->justifikasi_status == 'T'){?>
                <?php if($row->justifikasi_alasan){?>
            	<div class="alert alert-danger" style="text-align:center">
                	<b>Tolak Punch-In :</b> <?php echo $row->justikasi_masa ?>
                    <p>
                    	<?php echo $row->justifikasi_alasan ?>
                    </p>
                </div>
                <?php } ?>
                <?php if($row->justifikasi_alasan_2){?>
                <div class="alert alert-success" style="text-align:center">
                  	<b>Tolak Punch-Out :</b> <?php echo $row->justikasi_masa ?>
                    <p>
                        <?php echo $row->justifikasi_alasan_2 ?>
                    </p>
                </div>
                <?php } ?>
                <?php } ?>
            </td>
            <td width="1px">
                <?php if(pcrs_get_param('P_JUSTIFIKASI')) : ?>
                    <?php if(!$row->justifikasi_status && strtotime(date('Y-m-d')) < strtotime("+" . pcrs_get_param('P_JUSTIFIKASI') . " day", strtotime("+1 month",strtotime($year . "-" . $month . "-01")))){?>
                    <a class="btn btn-primary btn-xs" data-target="#myModal" data-toggle="modal" href="<?php echo base_url()?>mohon/justifikasi_mohon/<?php echo $row->rpt_tarikh?>">Mohon</a>
                    <?php } ?>
                <?php else : ?>
                    <?php if(!$row->justifikasi_status) : ?>
                    <a class="btn btn-primary btn-xs" data-target="#myModal" data-toggle="modal" href="<?php echo base_url()?>mohon/justifikasi_mohon/<?php echo $row->rpt_tarikh?>">Mohon</a>
                    <?php endif ?>
                <?php endif ?>
                <?php if($row->justifikasi_status == 'M'){?>
                <button class="btn btn-danger btn-xs cmdHapusjustifikasi" data-justifikasi_id="<?= $row->justifikasi_id ?>" title="Menghapus permohonan justifikasi ini">Hapus</button>
                <?php } ?>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>
<div>Jumlah : <?php echo $rst_justifikasi->num_rows()?></div>
