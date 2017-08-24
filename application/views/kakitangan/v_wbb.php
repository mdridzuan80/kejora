  	<div style="background-color:#FFF; max-width:600px; margin: auto; padding: 20px; position:relative;">
		<h1 class="page-header" style="color:#F00;">Waktu Berperingkat</h1>
		<ul class="nav nav-tabs">
          <li class="active"><a href="#bulanan" data-toggle="tab">Bulanan</a></li>
          <li ><a href="#harian" data-toggle="tab">Harian</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">

			<div class="tab-pane" id="harian">
				<div class="row">
                    <div class="col-xs-4">
                        <form id="frmWbbDay" role="form">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select id="comTahunHarian" name="comTahun" class="form-control">
                                <?php
                                    foreach($tahun as $key => $val)
                                    {
                                        if($key == date('Y'))
                                        {
                                            echo "<option value=\"$key\" selected>$val</option>";
                                        }
                                        else
                                        {
                                            echo "<option value=\"$key\">$val</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tarikh Dari</label>
                            <input id="from" name="mula" type="text" class="form-control input-sm" placeholder="Text input">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Tarikh Hingga</label>
                            <input id="to" name="akhir" type="text" class="form-control input-sm" placeholder="Text input">
                        </div>
                        
                        <div class="form-group">
                            <label >WBB</label>
                            <select name="comWbb" class="form-control">
                            <?php
                                foreach($dict_wbb->result() as $row)
                                {
                            ?>
                              <option value="<?php echo $row->NUM_RUNID?>"><?php echo $row->NAME?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm btn-simpan-harian">Simpan</button>
                        </div>
                        </form>
                        <div class="panel panel-info">
                                <div class="panel-heading">
                                    Info Panel
                                </div>
                                <div class="panel-body">
                                    <ul class="list-unstyled" style="font-size:11px;">
                                        <li>WP 1 : 7:30Pg - 4.30Ptg</li>
                                        <li>WP 2 : 8:00Pg - 5.00Ptg</li>
                                        <li>WP 3 : 8:30Pg - 5.30Ptg</li>
                                        <li>WP 4 : 7:30Pg - 4.00Ptg</li>
                                        <li>WP 5 : 8:00Pg - 4.30Ptg</li>
                                        <li>WP 6 : 8:30Pg - 5.00Ptg</li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                    <div class="col-xs-8">
                        <div id="att-rekod-wbb-harian">
                            &nbsp;
                        </div>
                    </div>
                </div>
			</div>
            
			<div class="tab-pane active" id="bulanan">
            	<div class="row">
                    <div class="col-xs-4">
                        <form id="frmWbbBulanan" role="form">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select id="comTahunBulanan" name="comTahun" class="form-control">
                                <?php
                                    foreach($tahun as $key => $val)
                                    {
                                        if($key == date('Y'))
                                        {
                                            echo "<option value=\"$key\" selected>$val</option>";
                                        }
                                        else
                                        {
                                            echo "<option value=\"$key\">$val</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label >Bulan</label>
                            <select id="comBulan" name="comBulan[]" multiple class="form-control">
                            </select>
                        </div>
                        <div class="form-group">
                            <label >WBB</label>
                            <select name="comWbb" class="form-control">
                            <?php
                                foreach($dict_wbb->result() as $row)
                                {
                            ?>
                              <option value="<?php echo $row->NUM_RUNID?>"><?php echo $row->NAME?></option>
                            <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-sm btn-simpan-bulanan">Simpan</button>
                        </div>
                        </form>
                        <div class="panel panel-info">
                                <div class="panel-heading">
                                    Info Panel
                                </div>
                                <div class="panel-body">
                                    <ul class="list-unstyled" style="font-size:11px;">
                                        <li>WP 1 : 7:30Pg - 4.30Ptg</li>
                                        <li>WP 2 : 8:00Pg - 5.00Ptg</li>
                                        <li>WP 3 : 8:30Pg - 5.30Ptg</li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                    <div class="col-xs-8">
                        <div id="att-rekod-wbb-bulanan">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    <script type="text/javascript">
	$().ready(function() {
		bulanan();
		harian();

		$('#comTahunBulanan').change(function(){
			bulanan();
		});

		$('#comTahunHarian').change(function(){
			harian();
		});

		$(".btn-simpan-harian").click(function(){
			loader = $("<div class=\"att-loader\"><img src=\""+base_url+"assets/images/loaderb64.gif\" /></div>");
			mula=$("#from").val();
			tamat=$("#to").val();
			$.ajax({
				url: base_url+"kakitangan/simpan_wbb_shift/<?php echo $userid?>",
				type: "post",
				data: $("#frmWbbDay").serialize(),
				beforeSend: function(){
					$("#att-rekod-wbb-harian").empty().html(loader);
				},
				success: function(d) {
					harian();
					bulanan();
					alert(d);
                    location.reload(true);
				},
				error: function(jqXHR, textStatus, errorThrown ){
					harian();
					bulanan();
					alert(errorThrown);
				}
			});
		});

		$(".btn-simpan-bulanan").click(function(){
			var loader = $("<div class=\"att-loader\"><img src=\""+base_url+"assets/images/loaderb64.gif\" /></div>");
			$.ajax({
				url: base_url+"kakitangan/simpan_wbb/<?php echo $userid?>",
				type: "post",
				data: $("#frmWbbBulanan").serialize(),
				success: function(d) {
					bulanan();
					harian();
					alert('Update successfully');
                    location.reload(true);
				},
				beforeSend: function(){
					$("#att-rekod-wbb-bulanan").empty().html(loader);
				},
				error: function(jqXHR, textStatus, errorThrown ){
					bulanan();
				  	harian();
				  	alert(errorThrown);
				}
			});
		});

		$( "#from" ).datepicker({
		  defaultDate: "+1w",
		  changeMonth: true,
		  numberOfMonths: 1,
		  dateFormat: 'yy-mm-dd',
		  onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
		  }
		});

		$( "#to" ).datepicker({
		  defaultDate: "+1w",
		  changeMonth: true,
		  numberOfMonths: 1,
		  dateFormat: 'yy-mm-dd',
		  onClose: function( selectedDate ) {
			$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		  }
		});

			$(document).on("click",".cmdHapus",function(e){
			e.preventDefault();
			var bulan = $(this).attr('data-bulan');
            var tahun = $(this).attr('data-tahun');
            var obj = $(this).parent().parent();
			$.ajax({
            	url: base_url+"kakitangan/hapus_wbb/<?php echo $userid?>",
            	type: "post",
            	data: {'bulan':bulan, 'tahun':tahun},
            	success: function(d) {
            		obj.hide();
					harian();
            	}
            });
		});

		$(document).on("click",".cmdHapusHarian",function(e){
			e.preventDefault();
			var mula = $(this).attr('data-tkh-mula');
            var akhir = $(this).attr('data-tkh-tamat');
            var obj = $(this).parent().parent();
            $.ajax({
            	url: base_url+"kakitangan/hapus_wbb_daily/<?php echo $userid?>",
            	type: "post",
            	data: {'mula':mula, 'akhir':akhir},
            	success: function(d) {
            		obj.hide();
					bulanan();
            	}
            });
		});
	});

	function bulanan()
	{
		var tahun="";
		var bulan="";
		$("#comTahunBulanan option:selected").each(function(){
			tahun = $(this).val();
		});
		$("#att-rekod-wbb-bulanan").empty().html("<div class=\"att-loader\"><img src=\""+base_url+"assets/images/loaderb64.gif\" /></div>");
		$("#att-rekod-wbb-bulanan").load(base_url+'kakitangan/rekod_wbb',{'userid':<?php echo $userid?>,'tahun':tahun});
		$("#comBulan").load(base_url+'kakitangan/jana_bulan',{'tahun':tahun});
	}

	function harian()
	{
		var tahun="";
		var bulan="";
		var mula="";
		var tamat="";

		$("#comTahunHarian option:selected").each(function(){
			tahun = $(this).val();
		});
		$("#att-rekod-wbb-harian").empty().html("<div class=\"att-loader\"><img src=\""+base_url+"assets/images/loaderb64.gif\" /></div>");
		$("#att-rekod-wbb-harian").load(base_url+'kakitangan/rekod_wbb_daily',{'userid':<?php echo $userid?>,'tahun':tahun});
	}
	</script>
  </body>
</html>
