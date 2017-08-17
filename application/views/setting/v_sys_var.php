<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Set Pembolehubah Sistem</h1>
        </div>
        <!-- /.col-lg-12 -->

        <div class="col-lg-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <i class="fa fa-table fa-fw"></i>&nbsp;<span>Senarai Pembolehubah Sistem</span>
              </div>
              <div class="panel-body">
              	<?php if($params->num_rows() != 0){?>
              	<div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover">
                          <thead>
                              <tr>
                                  <th>#</th>
                                  <th>Nama Parameter</th>
                                  <th>Perihal</th>
                                  <th>Nilai</th>
                                  <th>Operasi</th>
                              </tr>
                          </thead>
                          <tbody>
                          	<?php $i=1; foreach($params->result() as $row){?>
                              <tr>
                                  <td><?php echo $i++?></td>
                                  <td><?php echo $row->param_title?></td>
                                  <td><?php echo $row->param_desc?></td>
                                  <td><?php echo $row->param_value?></td>
                                  <td>
                                    <a data-target="#myModal" data-toggle="modal" href="<?php echo base_url()?>setting/sys_var/<?php echo $row->param_kod?>" class="att-popup btn btn-primary btn-xs popup"><i class="glyphicon glyphicon-tag"></i>&nbsp;Edit</a>
                                  </td>
                              </tr>
                              <?php }?>
                          </tbody>
                      </table>
                  </div>
                  <?php }else{?>
                  	<div class="alert alert-warning">
                          <b>Amaran!</b> Tiada Rekod.
                      </div>
                  <?php }?>
              </div>
            </div>
          </div>
      </div>
    </div>
    <!-- /.row -->
</div>
