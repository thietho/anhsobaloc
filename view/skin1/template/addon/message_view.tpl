<h2><?php echo $item['title']?></h2>
<div class="ben-editor">
    <p>
        <?php echo html_entity_decode($item['description'])?>
    </p>
</div>
<div>
				<?php
		if(count($attachment)>0)
		{
			
			foreach($attachment as $item)
			{
				if(count($item))
				{
?>
					<p>
						<img src="<?php echo $item['imagethumbnail']?>" />
                        <?php echo $item['filename']?>
                        <a href="<?php echo HTTP_SERVER.DIR_FILE?><?php echo $item['filepath']?>" target="_blank">Download</a>
                    </p>
<?php
				}
			}
		}
?>
					
</div>
<a class="ben-button" href="<?php echo $this->document->createLink('message')?>">Trở về</a>
<div class="clearer">&nbsp;</div>