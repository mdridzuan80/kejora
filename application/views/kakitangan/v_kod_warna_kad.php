<div style="background-color:#FFF; max-width:600px; margin: auto; padding: 20px; position:relative;">
    <h1 class="page-header" style="color:#F00;">Kod Warna Kad</h1>
    <?php if($this->session->userdata('role')==1 || $this->session->userdata('role')==5){?>
    <form id="frmKodWarna" role="form">
        <div class="form-group">
            <label>Kod Warna</label>
              <select id="comKodWarna" name="comKodWarna" class="form-control">
                <option value="0">[pilih]</option>
                <option value="1">Kuning</option>
                <option value="2">Hijau</option>
                <option value="3">Merah</option>
              </select>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary btn-sm btn-simpan">Kemaskini</button>
        </div>
    </form>
    <hr>
    <?php }?>
    <?php
        $row = $warna->row();
    ?>
    <div class="row">
        <div class="col-lg-12">
        	<span>
            	<?php if($row->kw_kod == 1){?>
        		<button type="button" class="btn btn-warning btn-lg btn-block" >KUNING</button>
                <?php }?>
                <?php if($row->kw_kod == 2){?>
        		<button type="button" class="btn btn-success btn-lg btn-block" >HIJAU</button>
                <?php }?>
                <?php if($row->kw_kod == 3){?>
        		<button type="button" class="btn btn-danger btn-lg btn-block" >MERAH</button>
                <?php }?>
        	</span>
        </div>
    </div>
    </div>
</div>
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
            url: base_url+"kakitangan/warna_kad/<?php echo $userid?>",
            type: "post",
            data: $("#frmKodWarna").serialize(),
            success: function(d) {
                alert("Maklumat telah berjaya disimpan\n");
                $.magnificPopup.close();
            }
        });
    });
</script>
