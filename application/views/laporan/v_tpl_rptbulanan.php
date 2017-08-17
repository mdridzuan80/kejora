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

<page backbottom="10mm" style="font-size: 10px">
	<page_footer style="font-size: 6px">
	   <table style="width: 100%;">
			 <tr>
					 <td style="text-align: left;    width: 50%">Tarikh Cetakkan : <?php echo date('d-m-Y H:m:s') ?></td>
					 <td style="text-align: right;    width: 50%">&nbsp;</td>
			 </tr>
       <tr>
           <td style="text-align: left;    width: 50%">eMOHR Attendance System Administration (eMASA)</td>
           <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
       </tr>
	   </table>
	</page_footer>
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

		$user_id = $row->USERID;
	?>
	<table width="564">
    	<tr>
    	  <td width="80" rowspan="6"><div align="center"><span style="width:100%; text-align:center;"><img src="assets/images/ksm.png" width="80" height="80" align="top" /></span></div></td>
    	  <td width="5" rowspan="6">&nbsp;</td>
    	  <td>LAPORAN</td>
    	  <td><strong>:</strong></td>
    	  <td>MAKLUMAT KEDATANGAN BULANAN </td>
  	  </tr>
    	<tr>
    	  <td>BAHAGIAN</td>
            <td><strong>:</strong></td>
            <td><?php echo strtoupper($row->DEPTNAME);?></td>
    	</tr>
    	<tr>
    	  <td width="105">NAMA</td>
            <td width="10"><strong>:</strong></td>
            <td width="340"><?php echo strtoupper($row->NAME);?></td>
        </tr>
        <tr>
          <td>BULAN</td>
            <td><strong>:</strong></td>
            <td><?php echo strtoupper($dict_bulan[$bulan])?></td>
        </tr>
        <!--<tr>
        	<td>WBB</td>
            <td><strong>:</strong></td>
            <td><?php //echo $shift?></td>
        </tr>-->
        <tr>
          <td>FINGERPRINT ID </td>
            <td><strong>:</strong></td>
            <td><?php echo $row->BADGENUMBER;?></td>
        </tr>
        <?php
			//$kod_warna = pcrs_get_warna_kad($row->USERID, $row->MONTH, $row->YEAR);
			$ct = strtotime($tahun . "-" . $bulan . "-01");
			if( strtotime(date('Y-m-d')) <= strtotime("+10 day", strtotime($tahun . "-" . $bulan . "-01")) )
			{
				$kod = pcrs_get_warna_kad($row->USERID, date('m', strtotime('last month',$ct)), date('Y', strtotime('last month',$ct)));
			}
			else
			{
				$kod = pcrs_get_warna_kad($row->USERID, $bulan, $tahun);
			}
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
          <td height="21">KOD. WARNA </td>
          <td><strong>:</strong></td>
          <td><?php echo strtoupper($warna[$kod])?></td>
        </tr>
    </table>
    <br />
    <br />
    <table width="61%" class="biasa">
    	<tr>
        	<th style="width:10%">Tarikh</th>
            <th style="width:10%">Hari</th>
            <th style="width:5%">WP</th>
            <th style="width:10%">Check-In</th>
            <th style="width:10%">Check-Out</th>
            <th style="width:8%">Lewat</th>
            <th style="width:11%">Nota</th>
            <th style="width:20%">justifikasi</th>
            <th style="width:5%">TT</th>
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
        	<td style="width:10%"><?php echo date("d/m/Y", strtotime($val['tarikh']))?></td>
            <td style="width:10%"><?php echo date("l", strtotime($val['tarikh']))?></td>
            <td style="width:5%"><?php if($val['wbb']) echo pcrs_wbb_desc($val['wbb'])?></td>
            <td style="width:10%"><?php if($val['chkin']) echo date("g:i:s a", strtotime($val['chkin']))?></td>
            <td style="width:10%"><?php if($val['chkout']) echo date("g:i:s a", strtotime($val['chkout']))?></td>
            <td style="width:8%">
        	<?php
				$start = pcrs_wbb_starttime($user_id, $val['tarikh']);
				if(!isset($cuti[date('Y-m-d', strtotime($val['tarikh']))]))
				{
					if($val['chkin'])
					{
						if(date("N", strtotime($val['tarikh']))!=6)
						{
							if (date("N", strtotime($val['tarikh']))!=7)
							{
								$dateString = date("Y-m-d", strtotime($val['tarikh'])) . " " . $start[0];
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
            <td style="width:11%" align="center">
            	<?php
					if(!isset($cuti[date('Y-m-d', strtotime($val['tarikh']))]))
					{
						if(date("N", strtotime($val['tarikh']))!=6)
						{
							if (date("N", strtotime($val['tarikh']))!=7)
							{
								if(!$cuti_ahad)
								{
									if(!$val['chkin'] && !$val['chkout'])
									{
										echo "Tidak punch pagi dan petang";
									}
									else
									{
										if(!$val['chkin'])
										{
											echo "Tidak punch pagi<br/>";
										}
										if(!$val['chkout'])
										{
											echo "Tidak punch petang<br/>";
										}
										else
										{
											$c_in=0;
											$c_in_fist=false;
											$pilih=false;
											$listCheckOut = pcrs_get_list_checkin_after_end_date($user_id, date("Y-m-d", strtotime($val['tarikh'])), $start);
											if($listCheckOut->num_rows()>1)
											{
												foreach($listCheckOut->result() as $checkOut)
												{
													if($c_in == 0)
													{
														$c_in_fist = $checkOut->checkout;
													}
													else
													{
														if(!$pilih)
														{
															if((strtotime($checkOut->checkout) - strtotime($c_in_fist))>=900)
															{
																$pilih = true;
																echo "punch-in: " . date("g:i:s a", strtotime($checkOut->checkout)) . "<br/>";

																if($listCheckOut->num_rows()-1==$c_in)
																{
																	echo "punch-out: " . date("g:i:s a", strtotime($checkOut->checkout)) . "<br/>";
																}
															}
															else
															{
																$c_in_fist = $checkOut->checkout;
															}
														}
														else
														{
															if($listCheckOut->num_rows()-1==$c_in)
															{
																echo "punch-out: " . date("g:i:s a", strtotime($checkOut->checkout)) . "<br/>";
															}
														}
													}
													$c_in++;
												}
											}
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
            <td style="width:20%">
			 <?php
				if($val['nota']->num_rows())
				{
						foreach($val['nota']->result() as $j)
						{
							if($j->justifikasi_alasan)
							{
								echo "<p>" . $j->justifikasi_alasan . "</p>";
							}
							if($j->justifikasi_alasan_2)
							{
								echo "<p>" . $j->justifikasi_alasan_2 . "</p>";
							}
						}
				}
			?>
            </td>
            <td style="width:5%">&nbsp;</td>
        </tr>
        <?php
					}
				}
			}
		?>
    </table>
</page>
