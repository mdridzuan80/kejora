<?php
	if($tahun == date('Y')){
		if($this->session->userdata('role')==1) {
			$curr = 1;
		}
		elseif($this->session->userdata('role')==5) {
			$curr = date('n');
		} 
		else {
			$curr = date('n')+1;
		}
	}
	else {
		$curr = 1;
	}
	
	for($x=$curr;$x<=12;$x++){
		echo "<option value=\"$x\">$x</option>";
	}
?>
