<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
    <tr style="background-color:#333;color:#FFF;">
        <th>Tahun</th>
        <th>Bulan</th>
        <th>WBB</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach($rekod->result() as $row)
        {
    ?>
    <tr <?php echo $row->MONTH == date('n')?'class="warning"':''?>>
        <td><?php echo $row->YEAR?></td>
        <td><?php echo $row->MONTH?></td>
        <td><?php echo $row->NAME?></td>
        <?php
          if($this->session->userdata('role')!=1)
          {
            if($row->YEAR == date('Y'))
            {
                if($row->MONTH >= date('n'))
                {
        ?>
        <td>
        	<?php if ($this->session->userdata('role')==5 && $row->MONTH != date('n')){?>
        	<img data-bulan="<?php echo $row->MONTH?>" data-tahun="<?php echo $row->YEAR?>" class="cmdHapus" style="cursor:pointer;" src="<?php echo base_url()?>assets/images/minus.png" width="16" height="16" alt="Hapus">
            <?php }?>
       	</td>
        <?php
                }else{
        ?>
        <td>&nbsp;</td>
        <?php

            }}else{
        ?>
        <td><img data-bulan="<?php echo $row->MONTH?>" data-tahun="<?php echo $row->YEAR?>" class="cmdHapus" style="cursor:pointer; src="<?php echo base_url()?>assets/images/minus.png" width="16" height="16" alt="Hapus"></td>
        <?php
      }} else { ?>
        <td>
        <img data-bulan="<?php echo $row->MONTH?>" data-tahun="<?php echo $row->YEAR?>" class="cmdHapus" style="cursor:pointer;" src="<?php echo base_url()?>assets/images/minus.png" width="16" height="16" alt="Hapus">
      </td>
      <?php }
        ?>
    </tr>
    <?php
        }
    ?>
    </tbody>
  </table>
</div>
