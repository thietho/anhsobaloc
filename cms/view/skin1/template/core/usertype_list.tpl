<div class="indent">
    <div class="heading_title">
        <h1>Application Management</h1>                
    </div>	
</div> 
<script language="javascript">
function submitForm(value)
{
	document.f.type.value=value
	document.f.submit()
}
</script>
<form action="" name="f" method="post">
<!-- main indent-->
<div class="indent-center">
   <!-- <div class="btncontrol">
        <div class="fleft">
            <?php echo $btnAdd?>
            <input type="hidden" name="type" value="" />
        </div>
        <div class="clear"></div>
    </div>-->
    
    
    <div class="sitemap treeindex" style="width:500px;margin:0 auto">
        <table class="tbl" cellpadding="0" cellspacing="0">
        <tbody>
            <tr class="tr-head">
               
                <th width="5%">ID</th>
                <th width="45%">User Type</th>  
                <th width="25%">Parent</th>                      
                <th width="25%" style="text-align:right">Control</th>                                  
            </tr>
            
<?php
	foreach($usertypes as $item)
    {
?>
			<tr>
				<td><?php echo $item['usertypeid']?></td>
                <td><?php echo $item['Prefix']?><?php echo $item['usertypename']?></td>
                <td><?php echo $item['UserTypeParent']?></td>
                <td align="right">
                	<?php echo $item['btnAddMember']?>
                    <?php echo $item['btnEdit']?>
                    
                    
                </td>
            </tr>
<?php
    }
?>
                
             	                             
        </tbody>
        </table>
    </div>
</div> 
<!-- main indent end-->  
</form>


