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
	<table style="width:100%;">
			<tr>
					<td style="width:1%;"><img src="assets/images/logo.gif" /></td>
					<td style="width:90%; vertical-align:top;">
					<strong>LAPORAN SENARAI KOD WARNA<br />
			BULAN : <?php echo $bulan?><br />
			TAHUN : <?php echo $tahun?>
					</strong></td>
			</tr>
	</table>
    <table class="biasa">
        <thead>
            <tr>
                <th style="width:1%;">#</th>
                <th style="width:45%;">Nama</th>
								<th style="width:39%;">Bahagian</th>
                <th style="width:10%;">Kod Warna</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $b = 1;
                foreach($sen_kod_warna->result() as $row){
            ?>
            <tr>
                <td style="width:1%;"><?php echo $b++?></td>
                <td style="width:45%;"><?php echo strtoupper($row->NAME)?></td>
								<td style="width:39%;"><?php echo strtoupper($row->DEPTNAME)?></td>
                <td style="width:10%;"><?php
								switch($row->kod_warna)
								{
									case 1:
										echo "KUNING";
										break;
									case 2:
										echo "HIJAU";
										break;
									case 3:
										echo "MERAH";
										break;
								}
								?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</page>
