<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Senarai Pentadbir Bahagian</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            Senarai Pentadbir Bahagian
          </div>
          <!-- /.panel-heading -->
          <div class="panel-body">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>No. KP</th>
                        <th>Bahagian/Unit</th>
                    </tr>
                </thead>
                <tbody>
                  <?php $i=1; foreach($senPentadbirBahagian->result() as $row) {?>
                  <tr>
                      <td><?php echo $i++ ?></td>
                      <td><?php echo $row->NAME ?></td>
                      <td><?php echo $row->SSN ?></td>
                      <td><?php echo $row->DEPTNAME ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
          </div>
          <!-- /.panel-body -->
        </div>
      </div>
    </div>
</div>
