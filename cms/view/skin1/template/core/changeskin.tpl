<div class="section">

	<div class="section-title"><?php echo $heading_title?></div>
    
    <div class="section-content">
    	
        <form action="" method="get" id="listitem" name="listitem">
        
        	<div class="button right">
            	
                <a class="button" onclick="save()">Save</a>
                
                <a class="button" href="index.php">Cancel</a>   
            </div>
            <div class="clearer">&nbsp;</div>
            
            <div id="container">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="5%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        <th>Skin id</th>
                        <th>Skin name</th>
                        <th>Image</th>
                        
                        <th width="18%">&nbsp;</th>                 
                    </tr>
        
        
        <?php
            foreach($skins as $item)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $item['skinid']?>]" value="<?php echo $item['skinid']?>" ></td>
                        <td><?php echo $item['skinid']?></td>
                        <td><?php echo $item['skinname']?></td>
                        <td><?php echo $item['imagepreview']?></td>
                        
                        <td class="link-control">
                            
                            <input type="radio" name="selectskin" value="<?php echo $item['skinid']?>" <?php if($curentskin == $item['skinid']) echo 'checked="checked"'; ?> />
                            
                        </td>
                    </tr>
        <?php
            }
        ?>
                        
                                                    
                </tbody>
                </table>
                <?php echo $pager?>
            </div>
        
        
        </form>
    </div>
</div>
<iframe id="printvoucher" src="" width="1px" height="1px"></iframe>
<script language="javascript">
$(document).ready(function() {
  	
});
function save()
{
	
	$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	$.post("index.php?route=core/changeskin/save", 
		   $("#listitem").serialize(),
		   function(data)
		   {
			   $.blockUI({ message: "<h1>"+data+"</h1>" }); 
				window.location.reload();
			}
		   );
	
}
</script>

