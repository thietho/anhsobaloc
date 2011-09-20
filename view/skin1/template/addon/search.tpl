<?php foreach($medias as $media) {?>
<div class="ben-post">
	<?php if($media['imagethumbnail'] !=""){ ?>
	<a href='<?php echo $media['link']?>'><img src='<?php echo $media['imagethumbnail']?>' class='ben-left' /></a>
    <?php }?>
    <a href="<?php echo $media['link']?>"><h3><?php echo $media['title']?></h3></a>
    <div class="ben-post-date"><?php echo $media['statusdate']?></div>
    <div class="ben-post-body">
        <p><?php echo $media['summary']?></p>
    </div>
    <div class="clearer">&nbsp;</div>
</div>
<?php } ?>