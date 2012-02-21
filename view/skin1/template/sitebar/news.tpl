<?php if(count($medias)){ ?>
<div class="ben-section">

	<div class="ben-section-title">
    	<?php echo $sitemap['sitemapname']?>
    </div>
    
    <div class="ben-section-content ben-sitebar-news">
    <?php foreach($medias as $media) {?>
    	<p><a href="<?php echo $media['link']?>"><?php echo $media['title']?></a></p>
    <?php } ?>
    </div>

</div>
<?php } ?>