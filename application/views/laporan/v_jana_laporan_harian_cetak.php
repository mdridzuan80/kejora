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
<table width="100%" height="57">
    	<tr>
        	<td width="100%" height="51" nowrap="nowrap"><strong>LAPORAN HARIAN</strong></td>
        </tr>
</table>
<table class="biasa">
    <tr>
        <th>BIL.</th>
        <th>NAMA</th>
				<th>BAHAGIAN/UNIT</th>
        <th>WBB</th>
        <th>TARIKH</th>
        <th>CHECK-IN</th>
        <th>CHECK-OUT</th>
        <th>NOTA</th>
    </tr>
  	<?php
	$cuti_ahad = false;
	$i=1;
	foreach($laporan as $staff)
	{
		foreach($staff as $val)
		{
	?>
    <tr <?php if(date("N", strtotime($val['tarikh']))==6 || date("N", strtotime($val['tarikh']))==7) echo "class=\"success\"" ?>>
        <td><?php echo $i++?></td>
        <td><?php echo $val['name']?></td>
				<td><?php echo $val['bahagian']?></td>
        <td><?php echo $val['wbb']?></td>
        <td><?php echo date("l d/m/Y", strtotime($val['tarikh']))?></td>
        <td><?php if($val['chkin']) echo date("g:i:s a", strtotime($val['chkin']))?></td>
        <td><?php if($val['chkout']) echo date("g:i:s a", strtotime($val['chkout']))?></td>
        <td>
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
								echo "Tiada Rekod";
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
    </tr>
    <?php
		}
	}
	?>
</table>
</page>
