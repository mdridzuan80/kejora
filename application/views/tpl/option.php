<?php
	$option = '';
	foreach($pilihan as $key=>$val)
	{
		$option .= '<option value="' . $key . '">' . $val . '</option>';
	}
	echo $option;
?>