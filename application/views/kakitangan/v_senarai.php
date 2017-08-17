<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Kakitangan</h1>
        </div>
    </div>

	<div class="row">
        <div class="col-lg-12">
            <!--<div class="panel panel-default">
                <div class="panel-heading">
                    DataTables Advanced Tables
                </div>
                <!-- /.panel-heading
                <div class="panel-body">-->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-kakitangan">
                            <thead>
                                <tr>
                                    <th>No. Badge</th>
                                    <th>Nama</th>
                                    <th>No. KP</th>
                                    <th>Jawatan</th>
                                    <th>E-Mel</th>
                                    <th>Operasi</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php foreach($staff as $row){?>
                                <tr>
                                    <td><?php echo $row->BADGENUMBER?></td>
                                    <td><?php echo $row->NAME?></td>
                                    <td><?php echo $row->SSN?></td>
                                    <td><?php echo $row->TITLE?></td>
                                    <td><?php echo $row->Email?></td>
                                    <td width="1px">
                                    	<table>
                                        	<tr>
                                            	<td style="padding:1px;">
                                        			<a data-target="#myModal" data-toggle="modal" href="<?php echo base_url()?>kakitangan/profile/<?php echo $row->USERID?>" class="att-popup btn btn-success btn-xs popup"><i class="fa fa-user fa-fw"></i>Profil<?php if(pcrs_chk_profil($row->USERID)!=0){echo '<img style="position: relative; left: 2px; top: -10px;" src="' . base_url() . 'assets/images/exclamation.png" />';}?></a>
                                                </td>
                                                <td style="padding:1px;">
                                        			<a data-target="#myModal" data-toggle="modal" href="<?php echo base_url()?>kakitangan/wbb/<?php echo $row->USERID?>" class="att-popup btn btn-success btn-xs popup"><i class="fa fa-tasks fa-fw"></i>WB<?php if(pcrs_chk_wbb_current_month($row->USERID, date('m'), date('Y'))==FALSE){echo '<img style="position: relative; left: 2px; top: -10px;" src="' . base_url() . 'assets/images/exclamation.png" />';}?></a>
                                                </td>
                                                <td style="padding:1px;">
                                        			<a data-target="#myModal" data-toggle="modal" name="windowX" href="<?php echo base_url()?>kakitangan/ppp/<?php echo $row->USERID?>" class="att-popup btn btn-success btn-xs popup"><i class="fa fa-upload fa-fw"></i>PPP<?php if(pcrs_chk_ppp($row->USERID)==0){echo '<img style="position: relative; left: 2px; top: -10px;" src="' . base_url() . 'assets/images/exclamation.png" />';}?></a>
                                                </td>
                                                <?php if($this->session->userdata('role')==1){?>
                                                <td style="padding:1px;">
                                        			<a data-target="#myModal" data-toggle="modal" href="<?php echo base_url()?>kakitangan/arkib/<?php echo $row->USERID?>" class="att-popup btn btn-danger btn-xs popup"><i class="glyphicon glyphicon-floppy-open"></i>&nbsp;Arkib</a>
                                                </td>
                                                <?php }?>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                <!--</div>-->
                <!-- /.panel-body -->
            <!--</div>-->
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
