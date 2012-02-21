<div class="ben-section">

	<div class="ben-section-title"><span style="color:#b10606">Nước hoa</span> theo ABC</div>
    
    <div class="ben-section-content">
    	<?php foreach($bangchucai as $key => $item){ ?>
        <div class="ben-char ben-left"><a href="<?php echo $this->document->createLink('kt',$key)?>"><?php echo $item?></a></div>
        <?php } ?>
        <div class="clearer">&nbsp;</div>
    </div>
</div>
