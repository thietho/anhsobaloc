<?php if(count($medias)){ ?>
<div class="ben-section">

	<div class="ben-section-title"><?php echo $sitemap['sitemapname']?></div>
    
    <div class="ben-section-content">
    	<?php foreach($medias as $media) {?>

            <?php if($media['imagethumbnail'] !=""){ ?>
            	<p>
            	<a href="<?php echo $media['link']?>"><img src='<?php echo $media['imagethumbnail']?>' /></a>
                </p>
            <?php }?>
   
		<?php } ?>
    	
    	
    </div>

</div>
<?php } ?>