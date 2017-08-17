<style type="text/css">
p
{
	text-align:justify;
	line-height:150%;
}
</style>
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
<?php
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
?>
<page style="font-size: 12px">
    <table>
        <tr>
          <td><img src="assets/images/1.png" /></td>
      </tr>
      <tr>
        <td><hr></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="450">&nbsp;</td>
            <td width="25%" align="right"><table width="160" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="60">Ruj. Kami </td>
                <td width="100" align="left">:&nbsp;</td>
              </tr>
              <tr>
                <td width="60">Tarikh</td>
                <td width="100" align="left">:&nbsp;<?php echo date('d') . ' ' . $dict_bulan[date('n')] . ' ' . date('Y') ?></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="5">
          <tr>
            <td width="100"><strong>Nama</strong></td>
            <td><strong>:&nbsp;<?php echo strtoupper($nama)?></strong></td>
          </tr>
          <tr>
            <td width="100"><strong>Jawatan</strong></td>
            <td><strong>:&nbsp;<?php echo strtoupper($jawatan)?></strong></td>
          </tr>
          <tr>
            <td width="100"><strong>Bahagian/Unit</strong></td>
            <td><strong>:&nbsp;<?php echo strtoupper($bahagian)?></strong></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Tuan/Puan,</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong><u>PERLANGGARAN KAD PERAKAM WAKTU TANPA SEBAB DAN ALASAN MUNASABAH</u></strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Dengan segala hormatnya merujuk kepada perkara di atas.</td>
      </tr>
      <tr>
        <td><p style="text-align:justify">2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Berdasarkan rekod kad perakam waktu tuan,<strong> <?php echo strtoupper($nama)?> <?php echo strtoupper($no_kp)?> </strong>didapati telah melanggar  Peraturan Kad Perakam Waktu sepertimana ketetapan Surat  Pekeliling Am Bil. 1 Tahun 2004 dan Surat  Pekeliling Am Bilangan 11 Tahun 1981 pada tarikh-tarikh seperti berikut:</p>
          <?php
		  	$i= 0;
          	$bil_rekod = $ts_rekod->num_rows();
		  ?>
           <table class="biasa">
            <tr>
              <th width="100"><p align="center"><strong>Waktu Peringkat</strong></p></th>
              <th width="10%"><p align="center"><strong>Tarikh</strong></p></th>
              <th width="10%"><p align="center"><strong>Waktu Masuk</strong></p></th>
              <th width="10%"><p align="center"><strong>Waktu Keluar</strong></p></th>
              <th width="50%"><p align="center"><strong>Catatan Kesalahan</strong></p></th>
            </tr>
            <?
				foreach($ts_rekod->result() as $rekod)
				{
			?>
            <?php if($i==0){?>
            <tr>
              <td width="100" valign="top" rowspan="<?php echo $bil_rekod?>" ><p><?php echo strtoupper($wbb)?></p></td>
              <td width="10%" valign="top"><p align="center"><?php echo strtoupper(date('d-m-Y', strtotime($rekod->rpt_tarikh)))?></p></td>
              <td width="10%" valign="top"><p align="center"><?php echo ($rekod->rpt_check_in)?date('g:i:s a', strtotime($rekod->rpt_check_in)):'&nbsp;'?></p></td>
              <td width="10%" valign="top"><p align="center"><?php echo ($rekod->rpt_check_out)?date('g:i:s a', strtotime($rekod->rpt_check_out)):'&nbsp;'?></p></td>
              <td width="50%" valign="top">&nbsp;</td>
            </tr>
            <?php }else{?>
            <tr>
              <td width="10%" valign="top"><p align="center"><?php echo strtoupper(date('d-m-Y', strtotime($rekod->rpt_tarikh)))?></p></td>
              <td width="10%" valign="top"><p align="center"><?php echo ($rekod->rpt_check_in)?date('g:i:s a', strtotime($rekod->rpt_check_in)):'&nbsp;'?></p></td>
              <td width="10%" valign="top"><p align="center"><?php echo ($rekod->rpt_check_out)?date('g:i:s a', strtotime($rekod->rpt_check_out)):'&nbsp;'?></p></td>
              <td width="50%" valign="top">&nbsp;</td>
            </tr>
            <?php }?>
            <?php $i++;}?>
          </table>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><p style="text-align:justify">3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sehubungan dengan itu, tuan adalah dengan ini adalah dikehendaki mengemukakan surat tunjuk sebab kerana melanggar Peraturan Kad Perakam Waktu dalam masa tujuh (7) hari dari tarikh tuan menerima surat ini. Kegagalan tuan untuk mengemukakan surat tunjuk sebab ini menyebabkan tuan boleh dikenakan tindakan tatatertib selaras dengan Peraturan 23, Peraturan-Peraturan Pegawai Awam (Kelakuan dan Tatatertib) 1993 dan melanggar tatakelakuan di bawah Peraturan 4(2)(g) dan 4(2)(i), Peraturan-Peraturan Pegawai Awam yang sama iaitu boleh diertikan sebagai tidak bertanggungjawab dan ingkar perintah atau berkelakuan dengan apa-apa cara yang boleh ditafsirkan dengan munasabah sebagai ingkar perintah.</p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Sekian, terima kasih.</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>&ldquo;MELAKA MAJU NEGERIKU  SAYANG FASA II&rdquo;</strong></td>
      </tr>
      <tr>
        <td><strong>&ldquo;BERKAT, TEPAT, CEPAT&rdquo;</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>&ldquo;BERKHIDMAT UNTUK  NEGARA&rdquo;</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Saya yang menurut perintah,</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><strong>(<?php echo strtoupper($pegawai)?>)</strong></td>
      </tr>
      <tr>
        <td><?php echo strtoupper($bahagian)?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>SURAT INI ADALAH JANAAN KOMPUTER DAN TIDAK MEMERLUKAN TANDATANGAN</td>
      </tr>
    </table>
</page>