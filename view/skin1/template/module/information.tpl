<div class="ben-post">

<div class="ben-editor">
    <p>
        <?php echo $post['description']?>
    </p>
</div>

<?php if(count($child)){ ?>
<style>
.faq-item
{
	display:none;	
}
</style>
<div>
	<?php foreach($child as $item){ ?>
    <p>
    	<a class="faq-title" href="#<?php echo $item['mediaid']?>" rel="<?php echo $item['mediaid']?>"><?php echo $item['title']?></a>
        <div id="faq-item-<?php echo $item['mediaid']?>" class="faq-item">
        	<?php echo html_entity_decode($item['description'])?>
        </div>
    </p>
    <?php } ?>
</div>
<script language="javascript">
$(document).ready(function(e) {
    url = document.location;
		arr = (""+url).split('#');
	mediaid = arr[1];
	showFAQ(mediaid);
});
function showFAQ(mediaid)
{
	$(".faq-item").hide("slow");
	$("#faq-item-"+mediaid).delay(100).show("show");
}
$(".faq-title").click(function(){
	showFAQ($(this).attr("rel"));
	
});
</script>
<?php } ?>
<div class="clearer">&nbsp;</div>
</div>