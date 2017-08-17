<style type="text/css">
	td{
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		font-size: 12px;
	}

	.mel-lewat td{ background-color:#F00; color:#FFF;}
	.mel-xpunch td{ background-color:#FF0; color:#060;}
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
		margin: 0 auto;
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
<table class="biasa" border="1" cellspacing="0" cellpadding="5">
	<tr>
    	<th>MEMOHON KELULUSAN JUSTIFIKASI KEHADIRAN</th>
    </tr>
    <tr>
    	<td>
        	<table>
            	<tr>
                	<td>Pemohon</td>
                    <td>:</td>
                    <td><?php echo $pemohon?></td>
                </tr>
                <tr>
                	<td>Tarikh</td>
                    <td>:</td>
                    <td>
											<?php if($tkh_akhir){?>
												<?php echo $hari[date('N',strtotime($tkh_mula))] . ' ' . date('d-m-Y',strtotime($tkh_mula)) . ' hingga ' . $hari[date('N',strtotime($tkh_akhir))] . ' ' . date('d-m-Y',strtotime($tkh_akhir))?>
											<?php } else {?>
												<?php echo $hari[date('N',strtotime($maklumat_permohonan['justifikasi_tkh_terlibat']))] . ' ' . date('d-m-Y',strtotime($maklumat_permohonan['justifikasi_tkh_terlibat']))?>
											<?php }?>
										</td>
                </tr>
								<?php if($maklumat_permohonan['justifikasi_alasan']){?>
                <tr>
                	<td>Catatan Punch-In</td>
                    <td>:</td>
                    <td><?php echo $maklumat_permohonan['justifikasi_alasan']?></td>
                </tr>
								<?php } ?>
								<?php if($maklumat_permohonan['justifikasi_alasan_2']){?>
                <tr>
                	<td>Catatan Punch-Out</td>
                    <td>:</td>
                    <td><?php echo $maklumat_permohonan['justifikasi_alasan_2']?></td>
                </tr>
								<?php } ?>
                <tr>
                	<td colspan="3"><a href="<?php echo base_url()?>kelulusan/justifikasi">Sila klik di sini untuk melihat permohonan</a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
