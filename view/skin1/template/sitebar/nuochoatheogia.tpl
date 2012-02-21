<div class="ben-section">

	<div class="ben-section-title"><span style="color:#b10606">Nước hoa</span> theo giá</div>
    
    <div class="ben-section-content ben-search-price">
    	<?php foreach($gia as $it){ ?>
    	<p><a href="<?php echo $this->document->createLink('product','search','[gia='.$it['categoryid'].']')?>">>> <?php echo $it['categoryname']?></a></p>
        <?php } ?>
        
        
    </div>
</div>
