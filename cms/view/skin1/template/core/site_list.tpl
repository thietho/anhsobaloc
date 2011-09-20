<div class="section" id="sitemaplist">

	<div class="section-title">MULTI WEBSITES MANAGEMENT</div>
    
    <div class="section-content">
    	
        <form action="" name="formlist" id="formlist" method="post">
        
        	<div class="button right">
                <input class="button" value="Add new" type="button" onclick="linkto('<?php echo $insert?>')">
            	<input class="button" type="button" name="delete_all" value="Delete" onclick="deleteList()"/>  
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="1%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        <th width="10%"><?php echo $column_siteid?></th>
                        <th width="25%"><?php echo $column_sitename?></th>
                        <th width="25%"><?php echo $column_status?></th>                    
                        <th width="10%">Control</th>                                  
                    </tr>
        
        
        <?php
            foreach($sites as $site)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $site['siteid']?>]" value="<?php echo $site['siteid']?>" ></td>
                        <td><?php echo $site['siteid']?></td>
                        <td><?php echo $site['sitename']?></td>
                        <td><?php echo $site['status']?></td>
                
                        <td class="link-control">
                            <a class="button" href="<?php echo $site['link_edit']?>" title="<?php echo $site['text_edit']?>">Edit</a>
                            <?php if($site['siteid']!="default"){ ?>
                            <a class="button" onclick="copySite('<?php echo $site['siteid']?>')">Copy default</a>
                            <?php }?>
                        </td>
                    </tr>
        <?php
            }
        ?>
                        
                                                    
                </tbody>
                </table>
            </div>
        
        
        </form>
        
    </div>
    
</div>
<script language="javascript">
function deleteList()
{
	$.post("?route=core/site/delete", 
			$("#formlist").serialize(), 
			function(data)
			{
				if(data!="")
				{
					alert(data)
					linkto("?<?php echo $refres?>")
				}
			}
	);
}
function copySite(siteid)
{
	$.ajax({
		url: "?route=core/site/copySite&siteid="+siteid,
		cache: false,
		success: function(html){
			alert(html)
		}
	});	
}
</script>
