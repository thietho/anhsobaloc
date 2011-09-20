<?php if(count($medias)){ ?>
<div class="ben-section">

	<div class="ben-section-title"><?php echo $sitemap['sitemapname']?></div>
    
    <div class="ben-section-content">
    <form id="frmQuestion">
    	<?php foreach($medias as $media) {?>
        <p>
        	<?php echo $media['title']?>
        </p>
        	<p>
        	<?php foreach($media['answers'] as $answer){ ?>
            	<input type="radio" name="answer" value="<?php echo $answer['mediaid']?>" />
                <?php echo $answer['title']?><br />
            <?php } ?>
            </p>
        <?php } ?>
    	<p>
        	<input type="button" class="ben-button" id="btnTraLoi" value="Trả lời" />
        </p>
    </form>	
    </div>

</div>
<div id="question_result" style="display:none" ></div>
<script language="javascript">
$("#btnTraLoi").click(function(){
	//$.blockUI({ message: "<h1>Please wait...</h1>" }); 
	
	$.post("<?php echo HTTP_SERVER?>?route=sitebar/question/answer", $("#frmQuestion").serialize(),
		function(data){
			if(data == "true")
			{
				$("#question_result").load("<?php echo HTTP_SERVER?>?route=sitebar/question/viewresult&questionid=<?php echo $medias[0]['mediaid']?>",function(){
					showPopup("#question_result",500,500,true)		
					
				});
			}
			else
			{
				
				//window.location = "<?php echo HTTP_SERVER?>site/default/login";
				
				
			}
			//$.unblockUI();
		}
	);					   
});
</script>
<?php } ?>
