<style type="text/css">
	table.biasa, table.listing {
		border-collapse: collapse;
		border-color: #666666;
		border-width: 1px;
		color: #333333;
	}
	table.biasa th, table.listing th {
		background: #333;
		border-color: #262628;
		border-style: solid;
		border-width: 1px;
		color: #FDFDFF;
		font-weight: bold;
		padding: 3px 8px;
		text-transform: uppercase;
	}
	table.biasa tr, table.listing tr {
		background-color: #FFFFFF;
	}
	table.biasa tr.even, table.listing tr.even {
		background-color: #F5F5F7;
	}
	table.biasa td, table.listing td {
		border-color: #D2D2D4;
		border-style: solid;
		border-width: 1px;
		padding: 3px 8px;
	}
	</style>

<page style="font-size: 10px">
	<?php
		$cuti_ahad = false;
		$dict_bulan = array(1=>'Januari',
							2=>'Februari',
							3=>'Mac',
							4=>'April',
							5=>'Mei',
							6=>'Jun',
							7=>'Julai',
							8=>'Ogos',
							9=>'September',
							10=>'Oktober',
							11=>'November',
							12=>'Disember');
		$row = $info->row();
		$s['WP1'] = "7:31 am";
		$s['WP2'] = "8:01 am";
		$s['WP3'] = "8:31 am";
		
		$warna = array(1=>"Kuning", 2=>"Hijau", 3=>"Merah");
	?>
    <table style="width:100%">
    	<tr>
        	<td style="width:100%; text-align:center;"><img src="assets/images/jata.jpg" /></td>
        </tr>
    </table>
	<table>
    	<tr>
        	<td colspan="2"><?php echo $row->DEPTNAME;?></td>
        </tr>
    	<tr>
        	<td>Nama</td>
            <td>: <?php echo strtoupper($row->NAME);?></td>
        </tr>
        <tr>
        	<td>Bulan</td>
            <td>: <?php echo strtoupper($dict_bulan[$bulan])?></td>
        </tr>
        <tr>
        	<td>WBB</td>
            <td>: <?php echo $shift?></td>
        </tr>
        <tr>
        	<td>No.&nbsp;Kad</td>
            <td>: <?php echo $row->BADGENUMBER;?></td>
        </tr>
        <?php
			$kod = pcrs_get_kod_warna_kad($row->USERID);
			switch($kod)
			{
				case 1:
					$kod_kad = 'KUNING';
				break;
				case 2:
					$kod_kad = 'HIJAU';
				break;
				case 3:
					$kod_kad = 'MERAH';
				break;
			}
		?>
        <tr>
          <td>Kod.&nbsp;Warna</td>
          <td>:&nbsp;<?php echo strtoupper($warna[$kod])?></td>
        </tr>
    </table>
    <br />
    <table class="biasa">
    	<tr>
        	<th style="width:11%">Tarikh</th>
            <th style="width:11%">Hari</th>
            <th style="width:11%">Check-In</th>
            <th style="width:11%">Check-Out</th>
            <th style="width:10%">Lewat</th>
            <th style="width:16%">Nota</th>
            <th style="width:24%">justifikasi</th>
            <th style="width:6%">TT</th>
        </tr>
        <?php
			if($staff != FALSE)
			{
				foreach($staff as $anggota)
				{
					foreach($anggota as $val)
					{
		?>
        <tr <?php if(date("N", strtotime($val['tarikh']))==6 || date("N", strtotime($val['tarikh']))==7) echo "style=\"background-color:#EEE;\"" ?>>
        	<td style="width:11%"><?php echo date("d/m/Y", strtotime($val['tarikh']))?></td>
            <td style="width:11%"><?php echo date("l", strtotime($val['tarikh']))?></td>
            <td style="width:11%"><?php if($val['chkin']) echo date("g:i:s a", strtotime($val['chkin']))?></td>
            <td style="width:11%"><?php if($val['chkout']) echo date("g:i:s a", strtotime($val['chkout']))?></td>
            <td style="width:10%">
				<?php
                	if(!isset($cuti[date('Y-m-d', strtotime($val['tarikh']))]))
					{
						if($val['chkin'])
						{
							if(date("N", strtotime($val['tarikh']))!=6)
							{
								if (date("N", strtotime($val['tarikh']))!=7)
								{
									$dateString = date("Y-m-d", strtotime($val['tarikh'])) . $s[$shift];
									if(strtotime($val['chkin']) > strtotime($dateString))
									{
										$diff=strtotime($val['chkin']) - strtotime($dateString);
										echo "<span style=\" color:red;\">" . pcrs_seconds_to_hms($diff) . "</span>";
									}
								}
							}
						}
					}
				?>
            </td>
            <td style="width:16%" align="center">
            	<?php
					if(!isset($cuti[date('Y-m-d', strtotime($val['tarikh']))]))
					{
						if(date("N", strtotime($val['tarikh']))!=6)
						{
							if (date("N", strtotime($val['tarikh']))!=7)
							{
								if($cuti_ahad)
								{
									//echo 'Cuti AM Jatuh Hari Ahad : ' . $cuti[date('Y-m-d', strtotime('-1 day', strtotime($val['tarikh'])))];
									//$cuti_ahad = false;
								}
								else
								{
									if(!$val['chkin'] && !$val['chkout'])
									{
										echo "Tidak punch pagi dan petang";
									}
									else
									{
										if(!$val['chkin'])
										{
											echo "Tidak punch pagi";	
										}
										if(!$val['chkout'])
										{
											echo "Tidak punch petang";	
										}
									}
								}
							}
						}
					}
					else
					{
						//$cuti_ahad = (date('N', strtotime($val['tarikh']))==7)?true:false;
						echo 'Cuti AM : ' . $cuti[date('Y-m-d', strtotime($val['tarikh']))];
					}
				?>
            </td>
            <td style="width:24%">
			 <?php
				if($val['nota']->num_rows())
				{
					echo "<ul>";
					foreach($val['nota']->result() as $row)
					{
						echo "<li>" . $row->justifikasi_alasan . "</li>";	
					}
					echo "</ul>";
				}
			?>
            </td>
            <td style="width:6%">&nbsp;</td>
        </tr>
        <?php
					}
				}
			}
		?>
    </table>
</page>