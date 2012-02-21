<script language="">
function GetKey(evt)
{
	if(navigator.appName=="Netscape"){theKey=evt.which}
	if(navigator.appName.indexOf("Microsoft")!=-1)
	{
		theKey=window.event.keyCode
	}
	window.status=theKey;
	if(theKey==13)
	{
		sendMessage()
	}
}
function sendMessage()
{
	$.post(HTTP_SERVER+"?route=module/contact/sendMessage", 
			$("#contractForm").serialize(), 
			function(data)
			{
				if(data!="true")
				{
					$('.ben-error').html(data)
					$('.ben-error').fadeIn("slow")
					//linkto("?<?php echo $refres?>")
				}
				else
				{
					alert("<?php echo $war_contactsuccess?>")
					window.location.reload();
				}
			}
	);
}
</script>
<div class="ben-post">
<p>
    <?php echo $post['description']?>
</p>
<?php echo $sododuongdi?>
<div class="clearer">&nbsp;</div>
<div class="ben-error ben-hidden"></div>
<form method="post" action="" id="contractForm" name="contractForm">
<div>
    <input type="hidden" name="sitemapid" value="<?php echo $this->document->sitemapid;?>" />
    <p>
        <label for="input-1"><?php echo $text_fullname?></label><br/>
        <input type="text" name="fullname" id="fullname" class="ben-textbox" size="60" onkeypress='GetKey(event)'/>
    </p>
    
    <p>
        <label for="input-1"><?php echo $text_email?></label><br/>
        <input type="text" name="email" id="email" class="ben-textbox" size="60" onkeypress='GetKey(event)'/>
    </p>

    <p>
        <label for="input-1"><?php echo $text_address?></label><br/>
        <input type="text" name="address" id="address" class="ben-textbox" size="60" onkeypress='GetKey(event)'/>
    </p>
    
    <p>
        <label for="input-1"><?php echo $text_phone?></label><br/>
        <input type="text" name="phone" id="phone" class="ben-textbox" size="60" onkeypress='GetKey(event)'/>
    </p>

    <p>
        <label for="input-3"><?php echo $text_note?></label><br/>
        <textarea name="description" id="description" class="ben-textbox" rows="10" cols="90"></textarea>
    </p>
	<p>
        <input type="button" class="ben-button" value="<?php echo $button_send?>" onclick="sendMessage()"/>
        <input type="reset" class="ben-button" value="<?php echo $button_reset?>"/>
    </p>
</div>			
</form>
</div>