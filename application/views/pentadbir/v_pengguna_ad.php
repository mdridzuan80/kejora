<table class="table table-bordered">
    <tr class="active">
        <th>&nbsp;</th>
        <th>NAMA PERTAMA</th>
        <th>NAMA KEDUA</th>
        <th>LOGIN</th>
    </tr>
    <?php
		foreach($user_ad as $user)
		{
	?>
	<tr>
    	<td><input name="chkAdUser[]" type="checkbox" value="<?php echo $user['userprincipalname']?>"></td>
        <td><?php echo $user['givenname']?></td>
        <td><?php echo $user['sn']?></td>
        <td><?php echo $user['userprincipalname']?></td>
    </tr>
    <?php
		}
	?>
    </table>
</table>
