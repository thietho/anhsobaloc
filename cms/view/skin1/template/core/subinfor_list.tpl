                                <table>
                                    <tbody>
<?php
	foreach($child as $item)
    {
?>
                                    <tr>
                                    	
                                        <td>
                                        	<?php echo $item['title']?>
                                        </td>
                                        <td>
                                        	<input type="text" class="text number pos" id="pos-<?php echo $item['mediaid']?>" name="pos[<?php echo $item['mediaid']?>]" value="<?php echo $item['position']?>" size="3" style="text-align:right"/>
                                        </td>
                                        <td>
                                        	<?php echo $item['imagepreview']?>
                                        </td>
                                        <td>
                                        	
                                        	<a class="button" onclick="editeSubInfor('<?php echo $item['mediaid']?>')">Edit</a>&nbsp;<a class="button" onclick="removeSubInfor('<?php echo $item['mediaid']?>')">Remove</a>
                                        </td>
                                        
                                    </tr>
<?php
	}
?>                                    
                                    </tbody>
                                	<tfoot>
                                    	<tr>
                                        	<td colspan="3">
                                            	<center><input type="button" class="button" id="btnUpdatePos" name="btnUpdatePos"  value="Update position" /></center>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
<script language="javascript">
$(document).ready(function() {
	$(".number").keyup(function (e)
	{
		num = formateNumber($(this).val().replace(/,/g,""));
		$(this).val(num)
	});
	$(".number").keypress(function (e)
	{
		
	  	return isNumber(e.which);
	});
})

$("#btnUpdatePos").click(function(){
	$(".pos").each(function(index){
		var arr = this.id.split('-');
		var mediaid = arr[1];
		var pos = $(this).val().replace(/,/g,"");
		$.post("?route=core/postcontent/updatePos", 
					{
						mediaid : mediaid, 
						position : pos
					},
		function(data){
			if(data=="true")
			{
				
			}
		});
	})
});
</script>