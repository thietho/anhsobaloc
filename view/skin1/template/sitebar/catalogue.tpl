<script type='text/javascript' language='javascript' src='<?php echo HTTP_SERVER.DIR_VIEW?>js/menu-collapsed.js'></script>
                    <div class="ben-section">
                    	
                        <div class="ben-section-content">
                        	<ul id="menu">
                                <?php echo $menu?>
                            </ul>
                        </div>
                    </div>
<script language="javascript">
$(document).ready(function(){
	<?php foreach($path as $item){ ?>
	$("#<?php echo $item['sitemapid']?>").show();
	<?php } ?>
});
</script>