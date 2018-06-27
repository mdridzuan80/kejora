<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <?php if(pcrs_get_param('P_JUSTIFIKASI')) : ?>
                <div class="alert alert-warning alert-dismissible" role="alert" style="margin-top:20px">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    &nbsp;<span class="blink"><strong>MAKLUMAN!</strong> Permohonan justifikasi perlu diisi <b>SEBELUM atau PADA <?php echo pcrs_get_param('P_JUSTIFIKASI')?>hb</b> pada bulan berikutnya</span>
                </div>
            <?php endif ?>
            <?php if($bil_lewat->num_rows() >= 2) {?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    &nbsp;<span ><strong>PERINGATAN!</strong> Anda telah lewat sebanyak <?php echo $bil_lewat->num_rows(); ?> kali pada bulan ini</span>
                </div>
            <?php } ?>
        </div>
    </div>
  
    <div>
        <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <?php if ($this->session->userdata('role') == 1 || $this->session->userdata('ppp')) : ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="panel panel-yellow">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?= $bil_kelulusan_justifikasi->num_rows(); ?></div>
                                            <div>Permohonan justifikasi untuk diluluskan</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('kelulusan/justifikasi') ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <div class="panel panel-red">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-map-marker fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge"><?= $bil_Kelulusan_timeslip->num_rows() ?></div>
                                            <div>Permohonan keluar pejabat untuk diluluskan</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('kelulusan/timeslip') ?>">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif ?>

                <div class="row">     
                    <div class="col-lg-12">
                       <div class="panel-heading">
                            <span style="font-size:18px">Kalendar</span>
                            <div class="pull-right">
                                <div class="btn-group">
                                <a data-target="#myModal" data-toggle="modal" class="btn btn-primary" href="<?php echo base_url()?>mohon/timeslip_mohon">
                                    Mohon Justifikasi
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                        <?=$calendar ?>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
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
                            Senarai yg tidak punch in/punch out / tidak memberi justifikasi <?php echo date('m/Y') ?>
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
                                foreach ($stat_x_punch_inout->result() as $row) {
                                    ?>
                                <tr>
                                <td ><?php echo $b++ ?></td>
                                <td ><?php echo strtoupper($row->NAME) ?></td>
                                <td ><?php echo strtoupper($row->DEPTNAME) ?></td>
                                <td ><?php echo $row->jum_x_punch_in ?></td>
                                <td ><?php echo $row->jum_x_punch_out ?></td>
                                </tr>
                                <?php 
                            } ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Senarai anggota yang lewat hadir pada hari ini <?= date('d-m-Y') ?>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama</th>
                                                        <th>Bahagian / Unit</th>
                                                        <th>Check-In</th>
                                                        <th>Bilangan Lewat</th>
                                                        <th>Warna Kad</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                $b = 1;
                                                foreach ($sen_lewat_hari->result() as $row) {
                                                    if (strtotime(date('Y-m-d')) <= strtotime("+10 day", strtotime($row->YEAR . "-" . $row->MONTH . "-01"))) {
                                                        $warna = pcrs_get_warna_kad($row->USERID, date('m', strtotime('last month')), date('Y', strtotime('last month')));
                                                    } else {
                                                        $warna = pcrs_get_warna_kad($row->USERID, $row->MONTH, $row->YEAR);
                                                    }
                                                    switch ($warna) {
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
                                                        <td><?php echo $b++ ?></td>
                                                        <td><?php echo strtoupper($row->NAME) ?></td>
                                                        <td><?php echo $row->DEPTNAME ?></td>
                                                        <td><?php echo $row->CHECKTIME ?></td>
                                                        <td><?php echo pcrs_get_stat_lewat($row->USERID, $row->MONTH, $row->YEAR)->num_rows() ?></td>
                                                        <td style="background-color: <?php echo $style ?>">
                                                        &nbsp;
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                } ?>
                                                </tbody>
                                            </table>
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Statistik kakitangan yang lewat lebih 3 kali <?php echo date('m/Y') ?>
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
                                                foreach ($top_ten->result() as $row) {
                                                    if (strtotime(date('Y-m-d')) <= strtotime("+10 day", strtotime($row->YEAR . "-" . $row->MONTH . "-01"))) {
                                                        $warna = pcrs_get_warna_kad($row->USERID, date('m', strtotime('last month')), date('Y', strtotime('last month')));
                                                    } else {
                                                        $warna = pcrs_get_warna_kad($row->USERID, $row->MONTH, $row->YEAR);
                                                    }
                                                    switch ($warna) {
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
                                                        <td><?php echo $b++ ?></td>
                                                        <td><?php echo strtoupper($row->NAME) ?></td>
                                                        <td><?php echo $row->DEPTNAME ?></td>
                                                        <td><?php echo $row->lewat ?></td>
                                                        <td style="background-color: <?php echo $style ?>">
                                                        &nbsp;
                                                        </td>
                                                    </tr>
                                                    <?php 
                                                } ?>
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
</div>
<script>
function pulse() {
  $('.blink').fadeIn();
  $('.blink').fadeOut();
}
setInterval(pulse, 1000);
</script>
