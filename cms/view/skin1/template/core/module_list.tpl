<div class="section" id="modulelist">

	<div class="section-title">MODULE MANAGEMENT</div>
	
    <div class="section-content">
    
    	<form action="" name="f" method="post">
        
        	<div class="button right">
            	<p>
                <?php echo $btnAdd?>
            	<?php echo $btnDelete?>
            	<?php echo $btnUpdate?>
                </p>
            </div>
            <div class="clearer">^&nbsp;</div>
            
            <div class="sitemap treeindex">
                <table class="data-table" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr class="tr-head">
                        <th width="3%"><input class="inputchk" type="checkbox" onclick="$('input[name*=\'delete\']').attr('checked', this.checked);"></th>
                        <th width="10%">ModuleID</th>
                        <th width="25%">ModuleName</th>
                        <th width="10%">Pos</th>
                        <th width="5%">Status</th>                    
                        <th width="10%">Control</th>                                  
                    </tr>
        <?php
            foreach($modules as $module)
            {
        ?>
                    <tr>
                        <td class="check-column"><input class="inputchk" type="checkbox" name="delete[<?php echo $module['moduleid']?>]" value="1" ></td>
                        <td><?php echo $module['moduleid']?></td>
                        <td><?php echo $module['modulename']?></td>
                        <td><input class="text" maxlength="2" size="1" type="text" name="position[<?php echo $module['moduleid']?>]" value="<?php echo $module['position']?>"></td>
                        <td><?php echo $module['status']?></td>
                
                        <td class="link-control">
                            <?php echo $module['controlEdit']?>
                            <?php echo $module['controlDelete']?>
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
 function submitForm(value)
 {
 	document.f.type.value=value
	document.f.submit()
 }
 </script>