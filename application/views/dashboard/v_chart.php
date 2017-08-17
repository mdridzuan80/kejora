<script type="application/javascript">
$(function() {
	
	var bar_chart = Morris.Bar({
	  element: 'morris-area-chart',
	  dataType: 'json',
	  axes: true,
	  data: [0,0],
	  xkey: 'tarikh',
	  ykeys: ['jumlah'],
	  labels: ['Jumlah']
	});
	
	$.ajax({
		url: base_url+'laporan/chart_hari',
		success: function (data) {
			bar_chart.setData(data);
		}
	});

});

</script>