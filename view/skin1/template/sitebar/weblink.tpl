<div class="ben-section">

	<div class="ben-section-title"><?php echo $sitemap['sitemapname']?></div>
    
    <div class="ben-section-content">
    	<select onchange="window.open( this.value,'','','')">
        	<option value=""></option>
        	<?php foreach($medias as $media) {?>
            <option value="<?php echo $media['weblink']?>"><?php echo $media['title']?></option>
            <?php } ?>
        </select>
    	
    	
    </div>

</div>