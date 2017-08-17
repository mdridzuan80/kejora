<?php
	/*
		Author: Md Ridzuan bin Mohammad Latiah
		Date: 1 April 2014
		Desciption: Laporan Kehadiran Harian

		Edit Author: Md Ridzuan bin Mohammad Latiah
		Date: 24 November 2014
		Desciption:  i) Kod Kad tukar posisi.
		             ii) Tiada rekod warna grey.
					 iii) Lambat Bg warna putih, tulisan merah.
	*/
?>
<style type="text/css">
	.mel-lewat, .mel-awal{ background-color:#FFF; color:#F00;}
	.mel-xpunch{background-color: #CCC; color: #000;}
	.kod-kuning{ background-color:yellow; color:#060;}
	.kod-hijau{ background-color:green; color:#060;}
	.kod-merah{ background-color:red; color:#060;}
	.title{
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		font-size: 14px;
		font-weight: bold;
	}
	table.biasa{
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		font-size: 12px;
		border-collapse: collapse;
		border-color: #666666;
		border-width: 1px;
		box-shadow: 0 8px 4px -4px rgba(0, 0, 0, 0.1), 0 1px 0 rgba(255, 255, 255, 0.2) inset;
		color: #333333;
	}

	table.biasa th{
		background: #3C3C3E;
		border-color: #262628;
		border-style: solid;
		border-width: 1px;
		color: #FDFDFF;
		font-weight: bold;
		padding: 8px;
		text-shadow: 0 -1px 1px rgba(0, 0, 2, 0.6);
		text-transform: uppercase;
	}
</style>
<?php if($kakitangan->num_rows() != 0){?>
<table>
	<tr>
        <td colspan="3"><span class="title">[eMASA] - LAPORAN PENUH KEHADIRAN HARIAN</span></td>
    </tr>
	<tr>
    	<td class="title" style="vertical-align:top;">BAHAGIAN</td>
        <td class="title" style="vertical-align:top;">:</td>
        <td class="title" style="vertical-align:top;"><?php echo strtoupper($department)?></td>
    </tr>
    <tr>
    	<td class="title" style="vertical-align:top;">TARIKH</td>
        <td class="title" style="vertical-align:top;">:</td>
        <td class="title" style="vertical-align:top;"><?php echo strtoupper($hari[date('N', strtotime($tarikh))]) . ', ' . strtoupper(date('d', strtotime($tarikh))) . ' ' . strtoupper($bulan[date('m', strtotime($tarikh))]) . ' ' . strtoupper(date('Y', strtotime($tarikh)))?></td>
    </tr>
</table>
<table class="biasa" border="1" cellspacing="0" cellpadding="5">
    <tr>
        <th>Bil.</th>
        <th>Kod Kad</th>
        <th>Nama</th>
        <th>WBB</th>
        <th>Punch IN</th>
        <th>Punch OUT</th>
        <th>Info Lewat</th>
        <th>Catatan</th>
    </tr>
    <?php $bil = 1; foreach($kakitangan->result() as $row){$status_in = ''; $status_out = ''; $kod_kad = 'class="kod-kuning"';?>
    <?php ?>
	<?php $lewat = false; $punch_in = pcrs_get_punch_in($row->USERID, $tarikh); $punch_out = pcrs_get_punch_out($row->USERID, $tarikh)?>
    <?php
    if(!$punch_in)
		{
			$status_in = 'class="mel-xpunch"';
		}
		elseif(strtotime($punch_in) > strtotime('+60 second', strtotime($tarikh . ' ' . $row->STARTTIME)))
		{
			$status_in = 'class="mel-lewat"';
			$lewat = true; $diff=strtotime($punch_in) - strtotime('+60 second', strtotime($tarikh . ' ' . $row->STARTTIME));
		}

		$awal = false;
		if(!$punch_out)
		{
			$status_out = 'class="mel-xpunch"';
		}
		elseif(strtotime($punch_out) < strtotime($tarikh . ' ' . $row->ENDTIME))
		{
			$status_out = 'class="mel-awal"';
			$awal = true;
			$diff_awal = strtotime($tarikh . ' ' . $row->ENDTIME) - strtotime($punch_out);
		}
	?>

    <tr>
        <td><?php echo $bil++?></td>
        <?php
			if( strtotime(date('Y-m-d')) <= strtotime("+1 day",strtotime("+" . pcrs_get_param('P_JUSTIFIKASI') . " day", strtotime(date('Y', strtotime($tarikh)) . "-" . date('m', strtotime($tarikh)) . "-01"))) )
			{
				$kod = pcrs_get_warna_kad($row->USERID, date('m', strtotime('last month', $tarikh)), date('Y', strtotime('last month', $tarikh)));
			}
			else
			{
				$kod = pcrs_get_warna_kad($row->USERID, date('m', strtotime($tarikh)), date('Y', strtotime($tarikh)));
			}
			switch($kod)
			{
				case 1:
					$kod_kad = 'class="kod-kuning"';
				break;
				case 2:
					$kod_kad = 'class="kod-hijau"';
				break;
				case 3:
					$kod_kad = 'class="kod-merah"';
				break;
			}
		?>
        <td <?php echo $kod_kad?>>&nbsp;</td>
        <td><?php echo strtoupper($row->Nama)?></td>
        <td><?php echo $row->WBB?></td>
        <td <?php echo $status_in?>><?php echo ($punch_in)?date('g:i:s A', strtotime($punch_in)):'&nbsp;'?></td>
        <td <?php echo $status_out?>><?php echo ($punch_out)?date('g:i:s A', strtotime($punch_out)):'&nbsp;'?></td>
        <td>
					<?php
						if($lewat)
						{
							echo "<div>" . pcrs_seconds_to_hms($diff) . ' Saat<br/>';
						}
						$lewat = pcrs_get_stat_lewat($row->USERID, date('m', strtotime($tarikh)), date('Y', strtotime($tarikh)));
						if($lewat->num_rows()!=0)
						{
							echo $lewat->num_rows() . ' kali lewat dalam bulan ' . $bulan[date('m', strtotime($tarikh))];
						}
						echo "</div>"
					?>
					<?php
						if($awal)
						{
							echo "<div>Awal Punch-Out: " . pcrs_seconds_to_hms($diff_awal) . ' Saat</div>';
						}
					?>
        <td>
		<?php
			// jika dua-dua x takder rekod
			if(!$punch_in && !$punch_out)
			{
				$cuti=pcrs_semak_cuti($row->USERID, $tarikh);

				if($cuti)
				{
					echo "HRMIS: " . $cuti->hr_alasan;
				}
				else
				{
					echo "Tiada rekod";
				}
			}
			else if(!$punch_in || !$punch_out)
			{
				echo 'Rekod tidak lengkap';
			}
		?>
    </tr>
    <?php }?>
</table>&nbsp;
<div class="title">*Ini adalah makluman janaan komputer, maklumbalas tidak diperlukan. Sebarang permasalahan emailkan kepada mejabantu@mohr.gov.my</div>
<?php }?>
