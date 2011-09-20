<script src="<?php echo DIR_JS?>jquery-1.4.2.js" type="text/javascript"></script>
<div class="section">
	<p>
    	<label>Choose from contacts</label><br>
        <input type="text" class="text" id="searchcontact" name="searchcontact">
    </p>
	<p>
		<table>
<?php
	foreach($usertype as $val)
    {
?>
			<tr>
                <td><input type="checkbox" class="usertype" onclick="$('input[name*=\'<?php echo $val['usertypeid']?>\']').attr('checked', this.checked);"/><strong><?php echo $val['usertypename']?></strong></td>
            </tr>
<?php
		$us = $this->string->array_Filter($user,"usertypeid",$val['usertypeid']);
        foreach($us as $item)
        {
?>
			<tr>
            	<td>&nbsp;&nbsp;&nbsp;<input type="checkbox" class="user" name="user[<?php echo $val['usertypeid']?>]" value="<?php echo $item['userid']?>"/><?php echo $item['fullname']?></td>
            </tr>
<?php
        }
    }
?>
        </table>
        <input type="button" name="btnOK" value="OK" onclick="alert(usertype)"/>
    </p>
</div>
<script language="javascript">
var usertype = '';
$(".user").click(function(){
	usertype ='';
	$(".user").each(function(){
		
		usertype+= $(this).val()+","
	})
	
});	
$(".usertype").click(function(){
	usertype ='';
	$(".user").each(function(){
		
		usertype+= $(this).val()+","
	})
	
});	
</script>