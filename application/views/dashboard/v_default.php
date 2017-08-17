<div id="page-wrapper">
  <div class="row">
    <div class="col-lg-12">
      <div class="alert alert-warning alert-dismissible" role="alert" style="margin-top:20px">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        &nbsp;<span class="blink"><strong>MAKLUMAN!</strong> Permohonan justifikasi perlu diisi <b>SEBELUM atau PADA <?php echo pcrs_get_param('P_JUSTIFIKASI')?>hb</b> pada bulan berikutnya</span>
      </div>

      <?php if($bil_lewat->num_rows() >= 2) {?>
      <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        &nbsp;<span ><strong>PERINGATAN!</strong> Anda telah lewat sebanyak <?php echo $bil_lewat->num_rows(); ?> kali pada bulan ini</span>
      </div>
      <?php } ?>
    </div>
  </div>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4>Profil Individu</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
    	<div class="col-lg-12">
        	<div class="panel panel-default">
                <div class="panel-heading">
                    Justifikasi Kehadiran Bagi Bulan :
                    <div class="pull-right">
                        <form id="frmJustifikasi">
                            <select name="comBulan" class="comBulan">
                                <option value="1" <?php echo set_select('comBulan', '1', date('n')==1)?>>1</option>
                                <option value="2" <?php echo set_select('comBulan', '2', date('n')==2)?>>2</option>
                                <option value="3" <?php echo set_select('comBulan', '3', date('n')==3)?>>3</option>
                                <option value="4" <?php echo set_select('comBulan', '4', date('n')==4)?>>4</option>
                                <option value="5" <?php echo set_select('comBulan', '5', date('n')==5)?>>5</option>
                                <option value="6" <?php echo set_select('comBulan', '6', date('n')==6)?>>6</option>
                                <option value="7" <?php echo set_select('comBulan', '7', date('n')==7)?>>7</option>
                                <option value="8" <?php echo set_select('comBulan', '8', date('n')==8)?>>8</option>
                                <option value="9" <?php echo set_select('comBulan', '9', date('n')==9)?>>9</option>
                                <option value="10" <?php echo set_select('comBulan', '10', date('n')==10)?>>10</option>
                                <option value="11" <?php echo set_select('comBulan', '11', date('n')==11)?>>11</option>
                                <option value="12" <?php echo set_select('comBulan', '12', date('n')==12)?>>12</option>
                            </select>
                            <select name="comTahun" class="comTahun">
                                <?php foreach($years as $year): ?>
                                <option value="<?=$year->tahun?>" <?php echo set_select('comTahun', $year->tahun, date('Y')==$year->tahun)?>><?=$year->tahun?></option>
                                <?php endforeach?>
                            </select>
                            <button type="button" class="btn btn-link btn-xs"><span class="glyphicon glyphicon-refresh"></span></button>
                        </form>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div id="panelJustifikasi" class="panel-body">
                	&nbsp;
                </div>
                <!-- /.panel-body -->
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-lg-12">
            <hr />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h4>Profil Bahagian/Unit</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        <div class="col-lg-12">
          <!-- graph -->
          <div class="panel panel-default">
              <div class="panel-heading">
                  Statistik Kehadiran Lewat Dalam Tempoh 7 Hari
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                  <div id="morris-area-chart"></div>
              </div>
              <!-- /.panel-body -->
          </div>
        </div>
        <div class="col-lg-6">
          <div class="panel panel-default">
              <div class="panel-heading">
                  Senarai yg tidak punch in/punch out / tidak memberi justifikasi <?php echo date('m/Y')?>
              </div>
              <!-- /.panel-heading -->
              <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Nama</th>
                          <th>Bahagian / Unit</th>
                          <th>Bil. Tidak Punch-In</th>
                          <th>Bil. Tidak Punch-Out</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php
                        $b = 1;
                        foreach($stat_x_punch_inout->result() as $row){
                    ?>
                    <tr>
                      <td ><?php echo $b++?></td>
                      <td ><?php echo strtoupper($row->NAME)?></td>
                      <td ><?php echo strtoupper($row->DEPTNAME)?></td>
                      <td ><?php echo $row->jum_x_punch_in?></td>
                      <td ><?php echo $row->jum_x_punch_out?></td>
                    </tr>
                    <?php }?>
                  </tbody>
                </table>
              </div>
          </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Statistik kakitangan yang lewat lebih 3 kali <?php echo date('m/Y')?>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Bahagian / Unit</th>
                                            <th>Bilangan Lewat</th>
                                            <th>Warna Kad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php
											$b = 1;
											foreach($top_ten->result() as $row){
                        if( strtotime(date('Y-m-d')) <= strtotime("+10 day", strtotime($row->YEAR . "-" . $row->MONTH . "-01")) )
                        {
                          $warna = pcrs_get_warna_kad( $row->USERID, date('m', strtotime('last month')), date('Y', strtotime('last month')) );
                        }
                        else
                        {
                          $warna = pcrs_get_warna_kad($row->USERID, $row->MONTH, $row->YEAR);
                        }
                        switch($warna)
                        {
                          case 1:
                            $style = "yellow";
                            break;
                          case 2:
                            $style = "green";
                            break;
                          case 3:
                            $style = "red";
                            break;
                        }
										?>
                                        <tr>
                                            <td><?php echo $b++?></td>
                                            <td><?php echo strtoupper($row->NAME)?></td>
                                            <td><?php echo $row->DEPTNAME?></td>
                                            <td><?php echo $row->lewat?></td>
                                            <td style="background-color: <?php echo $style?>">
                                              &nbsp;
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
            <!-- /.row -->
</div>
<script>
function pulse() {
  $('.blink').fadeIn();
  $('.blink').fadeOut();
}
setInterval(pulse, 1000);
</script>
