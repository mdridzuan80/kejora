<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Punctuality Cascading Reporting System - PCRS</title>

    <!-- Core CSS - Include with every page -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/themes/icon.css">
    <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/ui-lightness/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url() ?>assets/css/calendar.css" rel="stylesheet">
    <?php
    	if(isset($js_plugin)){
			foreach($js_plugin as $js_plg){
				switch($js_plg){
					case 'table':
						echo '<!-- Page-Level Plugin CSS - Tables -->';
						echo '<link href="' . base_url() . 'assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
					break;
					case 'popup':
						echo '<!-- Page-Level Plugin CSS - Popup -->';
						echo '<link href="' . base_url() . 'assets/css/plugins/magnific-popup/magnific-popup.css" rel="stylesheet">';
					break;
					case 'datepicker':
						echo '<!-- Page-Level Plugin CSS - Popup -->';
						echo '<link href="' . base_url() . 'assets/css/plugins/date-picker/datepicker.css" rel="stylesheet">';
					break;
					case 'bs_datepicker':
						echo '<!-- Page-Level Plugin CSS - Popup -->';
						echo '<link href="' . base_url() . 'assets/css/plugins/bs-datetime/bootstrap-datetimepicker.min.css" rel="stylesheet">';
					break;
				}
			}
		}
	?>
    <!-- Page-Level Plugin CSS - Tables -->
    <link href="<?php echo base_url() ?>assets/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?php echo base_url() ?>assets/css/sb-admin.css" rel="stylesheet">

    <style type="text/css">
<!--
.style2 {
	font-size: 18px;
	font-family: Georgia, "Times New Roman", Times, serif;
	font-style: italic;
}
-->
    </style>
</head>

<body>

    <div id="wrapper">

        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
              <a class="navbar-brand" href="<?php echo base_url() ?>"><!--<img src="assets/images/jata.png" width="60" height="40" border="0"> &nbsp;-->
              <span class="style2"> Punctuality Cascading Reporting System (PCRS)</span></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>-->
                <!-- /.dropdown -->
                <!--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <!-- /.dropdown -->
                <!--<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                </li> -->
                <!-- /.dropdown -->

                <!--<li>
                    <a data-target="#myModal" data-toggle="modal" class="btn btn-link" title="Away" href="<?php echo base_url()?>mohon/away_mohon">Away</a>
                </li>
                <li class="dropdown">
                	<a class="dropdown-toggle" data-toggle="dropdown" href="#" title="Timeslip">Timeslip&nbsp;<i class="fa fa-caret-down"></i></a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a data-target="#myModal" data-toggle="modal" href="<?php echo base_url()?>mohon/timeslip_mohon">Permohonan</a></li>
                        <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5 || $this->session->userdata('pelulus')==true){?>
                        <li><a href="<?php echo base_url()?>kelulusan/timeslip">Kelulusan</a></li>
						<?php }?>
                		<?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
                        <li><a href="<?php echo base_url()?>kelulusan/timeslip_pulang">Pengesahan Pulang</a></li>
                		<?php }?>
                    </ul>
                </li>-->
                <li>
                    <?php if(ENVIRONMENT != 'PRODUCTION') {?>
                        <span style="color:red">(<?php echo ENVIRONMENT ?>)</span>
                    <?php } ?>
                </li>
                <li class="dropdown">

                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="<?php echo $this->session->userdata('userid') ?>">
                        <i class="fa fa-user fa-fw"></i>&nbsp;<?php echo $this->session->userdata('userid') ?>&nbsp;<i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
						<li><a href="<?php echo base_url()?>pentadbir/pengguna"><i class="fa fa-user fa-fw"></i> Pengurusan Pengguna</a></li>
						<li><a href="<?php echo base_url()?>import/csv"><i class="fa fa-user fa-fw"></i> Import</a></li>
                        <li class="divider"></li>
						<?php }?>
                        <li><a href="<?php echo base_url()?>auth/logout"><i class="fa fa-sign-out fa-fw"></i> Keluar</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a target="_blank" href="#"><i class="glyphicon glyphicon-question-sign"></i> Manual Pengguna</a></a></li>
                        <li><a data-target="#myModal" data-toggle="modal" title="About" href="<?= base_url("welcome/about")?>"><i class="glyphicon glyphicon-info-sign"></i> About PCRS</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="<?php echo base_url() ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-tags fa-fw"></i> Permohonan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url("mohon/keluar")?>">Keluar Pejabat</a>
                                </li>
                            </ul>
                        </li>
                        <?php if($this->session->userdata('role')==1 || $this->session->userdata('ppp')){?>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-check"></i> Justifikasi<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($this->session->userdata('asPPP')){?>
                                <li>
                                    <!-- <a href="<?php echo base_url() ?>kelulusan/justifikasi">Sokong</a> -->
                                    <a href="<?php echo base_url() ?>kelulusan/sen_justifikasi">Sokong</a>
                                </li>
                                <?php }?>
                                <?php if($this->session->userdata('asPPK')){?>
                                <li>
                                    <a href="<?php echo base_url() ?>kelulusan/sen_justifikasi_lulus">Lulus</a>
                                </li>
                                <?php }?>
                            </ul>
                        </li>
                        <?php }?>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Laporan<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url()?>laporan/harian">Laporan harian</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>laporan/bulanan">Laporan Bulanan</a>
                                </li>
                                <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
                                <li>
                                    <a href="<?php echo base_url()?>laporan/stat_03">Laporan Kod Warna</a>
                                </li>
                                <?php }?>
								<!--<?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>-->
                                <li>
                                    <a href="#">Laporan Statistik<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="height: auto;">
                                        <li>
                                            <a href="<?php echo base_url()?>laporan/stat_01">Lewat Lebih 3 Kali</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo base_url()?>laporan/stat_02">Tidak Punch-In/Out</a>
                                        </li>
                                    </ul>
                                </li>
								<?php }?>
                           	<!--<li>
                                    <a href="#">Laporan Arkib<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level" style="height: auto;">
                                        <li>
                                            <a href="<?php echo base_url()?>laporan/arkib_bulanan">Bulanan</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="<?php echo base_url()?>welcome/sub_department">Sub Jabatan</a>
                                </li>-->
                                <!--<li>
                                    <a href="<?php echo base_url()?>laporan/tunjuk_sebab">Jana Laporan Surat Tunjuk Sebab</a>
                                </li>-->
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
			            <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
                        <li>
                            <a href="#"><i class="fa fa-gear fa-fw"></i> Setting<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo base_url() ?>setting/ketua_bahagian">Ketua Bahagian</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>setting/Pentadbir_Bahagian">Pentadbir Bahagian</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>setting/pegawai_penilai">Pegawai Penilai</a>
                                </li>
                                <?php if($this->session->userdata('role')==1) {?>
                                <li>
                                    <a href="<?php echo base_url() ?>setting/cuti_umum">Cuti Umum</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>setting/system_variable">Pembolehubah Sistem</a>
                                </li>
                                <?php }?>
                            </ul>
                        </li>
                        <?php }?>
                        <li>
                            <a href="<?php echo base_url() ?>kakitangan"><i class="fa fa-user fa-fw"></i> Maklumat Kakitangan</a>
                        </li>
                        <!--<li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>-->
                        <!--<li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>-->
                        <!--<li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>-->
                        <!--<li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                        </li>-->
                    </ul>
                    <!-- /#side-menu -->
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <?php echo $main_content ?>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

	 <!-- Modal -->
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                ...
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Core Scripts - Include with every page -->
    <script src="<?php echo base_url() ?>assets/js/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/jquery.easyui.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    
    <!-- Page-Level Plugin Scripts - Blank -->
    <?php
    	if(isset($js_plugin)){
			foreach($js_plugin as $js_plg){
				switch($js_plg){
					case 'table':
						echo '<!-- Page-Level Plugin Scripts - Tables -->';
						echo '<script src="' . base_url() . 'assets/js/plugins/dataTables/jquery.dataTables.js"></script>';
						echo '<script src="' . base_url() . 'assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>';
					break;
					case 'popup':
						echo '<!-- Page-Level Plugin Scripts - popup -->';
						echo '<script src="' . base_url() . 'assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>';
					break;
					case 'timepicker':
						/*echo '<!-- Page-Level Plugin Scripts - timepicker -->';
						echo '<script src="' . base_url() . 'assets/js/plugins/time-picker/jquery.ui.timepicker.js"></script>';*/
					break;
					case 'morris':
						echo '<!-- Page-Level Plugin Scripts - Morris -->';
						echo '<script src="' . base_url() . 'assets/js/plugins/morris/raphael-2.1.0.min.js"></script>';
    					echo '<script src="' . base_url() . 'assets/js/plugins/morris/morris.js"></script>';
					break;
					//case 'bs_datepicker':
    				//	echo '<script src="' . base_url() . 'assets/js/plugins/bs-datetime/bootstrap-datetimepicker.min.js"></script>';
					//break;
				}
			}
		}
	?>
    <!-- Page-Level Plugin Scripts - timepicker -->
	<script src="<?php echo base_url() ?>assets/js/plugins/time-picker/jquery.ui.timepicker.js"></script>
    <script type="text/javascript">
		// < ![CDATA[
		base_url = '<?php echo base_url();?>';
		$('#myModal').on('hide.bs.modal', function(e) {
			$(this).removeData('bs.modal');
		});
		//]] >
	</script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?php echo base_url() ?>assets/js/sb-admin.js"></script>
    <?php
		if(isset($js_plugin_xtra)){
			foreach($js_plugin_xtra as $js_plugin_x){
				echo $js_plugin_x;
			}
		}
	?>


    <!-- Page-Level Demo Scripts - Blank - Use for reference -->

</body>

</html>
