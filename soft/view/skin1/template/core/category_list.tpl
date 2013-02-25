<div class="section">

	<div class="section-title">Category</div>
    
    <div class="section-content">
    	
        <form action="" method="post" id="listitem" name="listitem">
        
        	<div class="button right">
            	<input class="button" type="button" name="btnUpdate" value="Update" onclick="updateposition()"/>
                <input class="button" value="Add new" type="button" onclick="linkto('<?php echo $insert?>')">
            	<input class="button" type="button" name="delete_all" value="Delete" onclick="deleteitem()"/>  
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div class="sitemap treeindex">
            	<link href="<?php echo DIR_VIEW?>css/jquery.treeTable.css" rel="stylesheet" type="text/css" />
                  <script type="text/javascript" src="<?php echo DIR_VIEW?>js/jquery.treeTable.js"></script>
                  <script type="text/javascript">
                  $(document).ready(function() {
                    // TODO Fix issue with multiple treeTables on one page, each with different options
                    // Moving the #example3 treeeTable call down will break other treeTables that are expandable...
                    $(".example").treeTable();
                  });
                  
                  </script>
                <table class="example data-table" width="100%">
                <thead>
                    <tr class="tr-head">
                        
                        
                        <th><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"> CategoryID</th>
                        <th>Category name</th>
                        <th>Position</th>
                                     
                        <th>Control</th>                                  
                    </tr>
        		</thead>
                <tbody>
        
        <?php
        	
            foreach($datas as $item)
            {
        ?>
                    <tr  id="<?php echo $item['eid']?>" class="<?php echo $item['class']?>">
                        
                        
                        <td>
                        	<?php echo $item['tab']?><input class="inputchk" type="checkbox" name="delete[<?php echo $item['categoryid']?>]" value="<?php echo $item['categoryid']?>" >
                        	<?php echo $item['categoryid']?>
                        </td>
                        <td><?php echo $item['categoryname']?></td>
                        <td><input type="text" name="position[<?php echo $item['categoryid']?>]" value="<?php echo $item['position']?>" size=3 class="text number"/></td>
                        <td class="link-control">
                            <a class="button" href="<?php echo $item['link_edit']?>" title="<?php echo $item['text_edit']?>"><?php echo $item['text_edit']?></a>
                            <a class="button" href="<?php echo $item['link_editcontent']?>" title="<?php echo $item['text_editcontent']?>"><?php echo $item['text_editcontent']?></a>
                            <a class="button" href="<?php echo $item['link_addchild']?>" title="<?php echo $item['text_edit']?>"><?php echo $item['text_addchild']?></a>
                           
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

function deleteitem()
{
	var answer = confirm("Bạn có muốn xóa không?")
	if (answer)
	{
		$.post("?route=core/category/delete", 
				$("#listitem").serialize(), 
				function(data)
				{
					if(data!="")
					{
						alert(data)
						window.location.reload();
					}
				}
		);
	}
}

function updateposition()
{
	$.post("?route=core/category/updateposition", 
			$("#listitem").serialize(), 
			function(data)
			{
				if(data!="")
				{
					alert(data)
					window.location.reload();
				}
			}
	);
	
}

</script>