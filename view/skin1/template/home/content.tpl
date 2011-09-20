<div id="ben-home-content">
	<?php foreach($medias as $media) { ?>
    <div class="ben-home-content ben-left">
        <div class="ben-title-content">
            <?php echo $media['headertitle']?>
        </div>
        <div class="ben-content">
            <h6><?php echo $media['title']?></h6>
            <img src="<?php echo $media['imagethumbnail']?>">
            <div class="ben-right ben-viewmore">
        		<a href="<?php echo $media['link']?>">Chi tiết>></a>
        	</div>
            <div class="clearer">&nbsp;</div>
        </div>
        
    </div>
    <?php } ?>
    <div class="clearer">&nbsp;</div>
</div>