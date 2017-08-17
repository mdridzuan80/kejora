<table class="table table-bordered">
    <tr>
        <th>BIL.</th>
        <th>NAMA</th>
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
							if($val['nota']->num_rows())
							{
								foreach($val['nota']->result() as $row)
								{
                    if($row->justifikasi_alasan)
      							{
      								echo "<p>" . $row->justifikasi_alasan . "</p>";
      							}
      							if($row->justifikasi_alasan_2)
      							{
      								echo "<p>" . $row->justifikasi_alasan_2 . "</p>";
      							}
								}
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
