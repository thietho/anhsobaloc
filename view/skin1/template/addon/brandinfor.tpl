<div class="ben-post ben-brand-infor">
<table>
	<tr>
    	<td width="300"><img src="<?php echo $media['imagethumbnail']?>"></td>
        <td>
        	<h3><?php echo $media['title']?></h3>
            <p>
            	<?php echo $media['summary']?>
            </p>
        </td>
    </tr>
</table>
</div>
<div id="container">
    <ul>
        <li><a href="#fragment-listproduct"><span>Các sản phẩm <?php echo $media['title']?></span></a></li>
        
        <li><a href="#fragment-history"><span>Lịch sử <?php echo $media['title']?></span></a></li>
    </ul>
    <div id="fragment-listproduct">
    	<?php echo $saphamcungnhanhieu?>
    </div>
    <div id="fragment-history">
    	<div class="ben-post">
    	<?php echo $media['description']?>
        </div>
    </div>
</div>
<script language="javascript">
$(document).ready(function(e) {
    $('#container').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'slow' });
});
</script>