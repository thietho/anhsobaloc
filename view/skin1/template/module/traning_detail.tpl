<div class="ben-post">
	<?php if($post['imagethumbnail'] !=""){ ?>
	<img src='<?php echo $post['imagethumbnail']?>' class='ben-alignleft' />
	<?php }?>
    <h2><?php echo $post['title']?></h2>
    <div class="ben-post-date">Khai giảng ngày: <?php echo $this->date->formatMySQLDate($post['startdate'])?></div>
    <div class="ben-post-date">Kết thúc ngày: <?php echo $this->date->formatMySQLDate($post['enddate'])?></div>
    
    <div class="clearer">&nbsp;</div>
</div>
<div class="ben-hline"></div>
<p>
    <?php echo $post['description']?>
</p>


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
	$.post(HTTP_SERVER+"?route=module/traning/register", 
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
					alert("Thông tin của bạn đã gửi đến chúng tôi")
					//linkto("?")
				}
			}
	);
}
</script>

<div class="ben-error ben-hidden"></div>
<form method="post" action="" id="contractForm" name="contractForm">
<div>
    <input type="hidden" name="sitemapid" value="<?php echo $this->document->sitemapid;?>" />
    <input type="hidden" name="mediaid" value="<?php echo $post['mediaid']?>" />
    <p>
        <label for="input-1">Họ tên</label><br/>
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
        <label for="input-3">Lời nhắn</label><br/>
        <textarea name="description" id="description" rows="10" cols="90"></textarea>
    </p>
	<p>
        
        <a href="#" class="ben-button" onclick="sendMessage()">Đăng ký</a>
    </p>
</div>			
</form>


<div class="clearer">&nbsp;</div>