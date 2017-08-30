<div style="background-color:#FFF; max-width:600px; margin: auto; padding: 20px; position:relative;">
    <h1 class="page-header" style="color:#F00;">Pegawai Penilai</h1>
    <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
    <form id="frmPPP" role="form">
        <div class="form-group">
            <label>Bahagian/Unit</label>
            <?php //echo form_dropdown('cmdRptBahagian', $departments , 0, "id=\"cmdRptBahagianPPP\" class=\"form-control\"");?>
        </div>
        <?php echo form_dropdown('cmdRptBahagian', array() ,0, "id=\"cmdRptBahagian\" class=\"form-control input-sm easyui-combotree\" data-options=\"url:'" . base_url() . "welcome/department'\" style=\"width:570px;\"");?>
        <div class="form-group">
            <label>Nama</label>
              <select id="comRptKakitangan" name="comRptKakitangan" class="form-control">
                <option value="0">[sila pilih]</option>
              </select>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm btn-simpan">Kemaskini</button>
        </div>
    </form>
    <hr>
    <?php }?>
    <?php
        $row = $ppp->row();
    ?>
    <div class="row">
        <p><strong>REKOD SEMASA PEGAWAI PENILAI PERTAMA</strong></p>
            <div class="table-responsive">
              <table class="table table-bordered table-hover">
                <thead>
                <tr style="background-color:#333;color:#FFF;">
                    <th>No. KP</th>
                    <th>Nama</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    if($ppp->num_rows())
                    {
                ?>
                    <tr>
                        <td><?php echo $row->SSN?></td>
                        <td><?php echo $row->NAME?></td>
                    </tr>
                <?php
                    }else{
                ?>
                    <tr>
                        <td colspan="2">Tiada Rekod Pegawai Penilai Pertama!</td>
                    </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
          </div>
        </div>
    </div>
</div>

<?php
	if(isset($js_plugin_xtra)){
		foreach($js_plugin_xtra as $js_plugin_x){
			echo $js_plugin_x;
		}
	}
?>

<script type="text/javascript">
	$("#cmdRptBahagianPPP").change(function(){
		var bahagianID="";
		$("#cmdRptBahagianPPP option:selected").each(function(){
			bahagianID = $(this).val();
		});
		$("#comRptKakitanganPPP").load(base_url+"kakitangan/bahagian",{"id":bahagianID});
	});
</script>
<script type="text/javascript">
    $(".btn-simpan").click(function(){
        $.ajax({
            url: base_url+"kakitangan/simpan_ppp/<?php echo $userid?>",
            type: "post",
            data: $("#frmPPP").serialize(),
            success: function(d) {
                alert("Maklumat telah berjaya disimpan\n");
                location.reload(true);
            }
        });
    });
</script>
