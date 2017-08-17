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
    	<th>STATUS PERMOHONAN TIMESLIP</th>
    </tr>
    <tr>
    	<td>
        	<table>
            	<tr>
                	<td>Pemohon</td>
                    <td>:</td>
                    <td><?php echo $pemohon->Name?></td>
                </tr>
                <tr>
                	<td>Tarikh</td>
                    <td>:</td>
                    <td><?php echo $hari[date('N',strtotime($pemohon->ts_chkin))] . ' ' . date('d-m-Y',strtotime($pemohon->ts_chkin))?></td>
                </tr>
                <tr>
                	<td>Masa Keluar</td>
                    <td>:</td>
                    <td><?php echo date('H:i',strtotime($pemohon->ts_chkin))?></td>
                </tr>
                <tr>
                	<td>Masa Masuk</td>
                    <td>:</td>
                    <td><?php echo date('H:i',strtotime($pemohon->ts_chkout))?></td>
                </tr>
                <tr>
                	<td>Alasan</td>
                    <td>:</td>
                    <td><?php echo $pemohon->ts_alasan?></td>
                </tr>
                <tr>
                	<td colspan="3">
                    	<?php if($pemohon->ts_status == 'L'){echo "<h1 style=\"color:green\">LULUS</h1>";} ?>
                        <?php if($pemohon->ts_status == 'T'){echo "<h1 style=\"color:red\">TOLAK</h1>";} ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

