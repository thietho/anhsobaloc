<h2><?php echo $sitemap['sitemapname']?></h2>
<div class="ben-item-separator"></div>

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

<?php if($othernews) {?>
<h3>Các tin khác</h3>             
<div>
    <ul>
    	<?php foreach($othernews as $media) {?>
        <li><a href="<?php echo $media['link']?>"><?php echo $media['title']?>&nbsp;<span class="ben-other">(<?php echo $media['statusdate']?>)</span></a></li>
        <?php } ?>    
    </ul>
</div>
<?php } ?>

<div class="ben-post-pagination ben-post-pagination-bottom">
    <?php echo $prevlink?>
    <?php echo $nextlink?>
    <div class="clearer">&nbsp;</div>
</div>