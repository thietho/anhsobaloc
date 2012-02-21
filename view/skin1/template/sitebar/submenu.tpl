<div class="ben-section">

	<div class="ben-section-title"><?php echo $sitemap['sitemapname']?></div>
    
    <div class="ben-section-content">
    	<ul class="ben-submenu">
        	<?php foreach($brands as $brand){ ?>
            <li><a href="<?php echo $brand['link']?>"><?php echo $brand['categoryname']?></a></li>
            <?php } ?>
            
        </ul>
        
        <a class="ben-right" href="<?php echo $this->document->createLink($sitemap['sitemapid'])?>">Xem tất cả</a>
        <div class="clearer">&nbsp;</div>
    </div>
</div>
