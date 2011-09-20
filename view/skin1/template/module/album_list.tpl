<link rel='stylesheet' type='text/css' href='<?php echo HTTP_SERVER.DIR_VIEW?>css/album.css'>
<?php
if(count($medias))
{
?>
<div>
	<?php foreach($medias as $media) {?>
    <div class="ben-cellalbum ben-left">
	<a href="<?php echo $media['link']?>"><img src="<?php echo $media['imagethumbnail']?>" width="150px"></a>
    </div>
    <?php } ?>
    
    <div class="clearer">&nbsp;</div>
   
	<?php echo $pager?>
</div>
<?php } ?>