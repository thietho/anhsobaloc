<div class="ben-post">
	<?php if($media['imagethumbnail'] !=""){ ?>
	<img src='<?php echo $media['imagethumbnail']?>' class='ben-left' />
    <?php }?>
    <a href="<?php echo $media['link']?>"><h3><?php echo $media['title']?></h3></a>
    <div class="ben-post-date"><?php echo $media['statusdate']?></div>
    <div class="ben-post-body">
        <p><?php echo $media['summary']?></p>
    </div>
    <div class="clearer">&nbsp;</div>
    <div>
    	<?php echo $media['description']?>
    </div>
</div>