<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
    <tr style="background-color:#333;color:#FFF;">
        <th>Tarikh Mula</th>
        <th>Tarikh Tamat</th>
        <th>WBB</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach($rekod->result() as $row)
        {
    ?>
    <tr <?php
			if((strtotime($row->mula) <= strtotime(date('Y-m-d'))) && (strtotime($row->tamat) >= strtotime(date('Y-m-d'))))
			{
				echo "class=\"warning\"";
			}
    ?>>
        <td><?php echo $row->mula?></td>
        <td><?php echo $row->tamat?></td>
        <td><?php echo $row->NAME?></td>
        <td>
        	<?php if($this->session->userdata('role')==1 ) { ?>
        	<img data-tkh-mula="<?php echo $row->mula?>" data-tkh-tamat="<?php echo $row->tamat?>" class="cmdHapusHarian" style="cursor:pointer;" src="<?php echo base_url()?>assets/images/minus.png" width="16" height="16" alt="Hapus">
			<?php }elseif($this->session->userdata('role')==5 && strtotime($row->mula) >= strtotime(date("Y-m-") . "01") ){?>
        	<img data-tkh-mula="<?php echo $row->mula?>" data-tkh-tamat="<?php echo $row->tamat?>" class="cmdHapusHarian" style="cursor:pointer;" src="<?php echo base_url()?>assets/images/minus.png" width="16" height="16" alt="Hapus">
            <?php }?>
        </td>
    </tr>
    <?php
        }
    ?>
    </tbody>
  </table>
</div>
