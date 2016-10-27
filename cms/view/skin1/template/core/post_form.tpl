<form name="frmPost" id="frmPost"  action="" method="post" enctype="multipart/form-data">
<div class="section">

<div class="section-title">
    <?php echo $breadcrumb?>
</div>

<div class="section-content padding1">



<div class="left">

    <h3><?php echo $heading_title?></h3>

</div>

<div class="right">
    <input class="button" type="button" value="<?php echo $button_save?>" onclick="save()"/>
    <a class="button" href="<?php echo $DIR_CANCEL?>"><?php echo $button_cancel?></a>
    <input type="hidden" id="status" name="status" value="<?php echo $status?>" />
    <input type="hidden" id="mediaid" name="mediaid" value="<?php echo $mediaid?>" />
    <input type="hidden" id="mediatype" name="mediatype" value="<?php echo $mediatype?>" />
    <input type="hidden" id="refersitemap" name="refersitemap" value="<?php echo $refersitemap?>" />

    <input type="hidden" id="handler" />
    <input type="hidden" id="outputtype" />
</div>
<div class="clearer">&nbsp;</div>


<div id="container">


    <ul>
        <li class="tabs-selected"><a href="#fragment-content" ><span><?php echo $tab_editcontent?></span></a></li>
        <?php if(@$hasProperties) { ?>
        <li><a href="#fragment-properties"><span>Properties</span></a></li>
        <?php }?>
        <li><a href="#fragment-detail"><span>Detail</span></a></li>
        <?php if($hasVideo) { ?>
        <li><a href="#fragment-video"><span>Video</span></a></li>
        <?php }?>
        <?php if($hasSubInfor) { ?>
        <li><a href="#fragment-subinfor"><span>Information</span></a></li>
        <?php }?>
        <?php if($hasTabImages){ ?>
        <li><a href="#fragment-images"><span>Images</span></a></li>
        <?php } ?>
        <?php if($hasTabVideos){ ?>
        <li><a href="#fragment-videos"><span>Videos</span></a></li>
        <?php } ?>
        <?php if($hasTabDocuments){ ?>
        <li><a href="#fragment-documents"><span>Tài liệu</span></a></li>
        <?php } ?>
        <?php if(@$hasProductPrice) { ?>
        <li><a href="#fragment-productprice"><span><?php echo $text_price?></span></a></li>
        <?php }?>
        <?php if($hasTabMap) { ?>
        <li><a href="#fragment-map"><span><?php echo $tab_map?></span></a></li>
        <?php } ?>
        <?php if($hasTabComment) { ?>
        <li><a href="#fragment-comment"><span>Đánh giá</span></a></li>
        <?php } ?>



    </ul>


    <div id="fragment-content">

        <div style="<?php echo $displaynews?>">

            <div class="col2 left">

                <?php if($hasTitle) {?>
                <p>
                <label><?php echo $entry_title?></label><br>
                <input class="text" type="text" id="title" name="title" value="<?php echo $title?>" size="60" />
                </p>
                <p>
                <label><?php echo $text_alias?></label><br>
                <input class="text" type="text" id="alias" name="alias" value="<?php echo $alias?>" size="60" />
                </p>
                <script>
                $('#title').change(function(e) {

                $.ajax({
                url: "?route=common/api/getAlias&title=" + toBasicText(this.value),
                cache: false,
                success: function(html)
                {
                $("#alias").val(html);
                }
	});
});
</script>
                <p>
                    <label><?php echo $text_keyword?></label><br>
                    <textarea class="text" rows="3" cols="70" name="keyword"><?php echo $keyword?></textarea>
                </p>
                <?php } ?>

                <?php if(@$hasEvent) { ?>
                <p>
                <label>Ngày</label><br>
                <input class="text ben-datepicker" type="text" name="eventdate" value="<?php echo $this->date->formatMySQLDate($eventdate)?>" />
                </p>
                <p>
                <label>Thời gian</label><br>
                <input class="text" type="text" name="eventtime" value="<?php echo $eventtime?>" />
                </p>
                <?php } ?>
                <?php if($hasPrice) { ?>
                <p>
                <label><?php echo $text_price?></label><br>
                <input class="text number" type="text" name="price" value="<?php echo $price?>" size="60" />
                </p>
                <?php } ?>
            </div>
            <?php if($hasFile) { ?>
            <div class="col2 right">

            <p id="pnImage">
            <label for="image"><?php echo $entry_image?></label><br />
            <a  class="button" onclick="browserFileImage()"><?php echo $entry_selectphoto?></a><br />
            <img id="imagepreview" src="<?php echo $imagethumbnail?>" />
            <input type="hidden" id="imagepath" name="imagepath" value="<?php echo $imagepath?>" />
            <input type="hidden" id="imageid" name="imageid" value="<?php echo $imageid?>" />
            <input type="hidden" id="imagethumbnail" name="imagethumbnail" value="<?php echo $imagethumbnail?>" />
            </p>


            <div id="errorupload" class="error" style="display:none"></div>

            <div class="loadingimage" style="display:none"></div>
            <?php if($hasAttachment){ ?>
            <p>
            <a id="btnAddAttachment" class="button" onclick="browserFileAttachment()"><?php echo $entry_attachment?></a><br />
            </p>
            <p id="attachment">
            </p>

            <span id="delfile"></span>
            <?php } ?>
        </div>
        <?php }?>
        <script language="javascript">

            $(document).ready(function() {
                // put all your jQuery goodness in here.

                <?php
                        foreach($attachment as $item)
                {
                    if(count($item))
                    {
                        ?>
                        $('#attachment').append(attachment.creatAttachmentRow("<?php echo $item['fileid']?>","<?php echo $item['filename']?>","<?php echo $item['imagethumbnail']?>"));
                    <?php
                    }
                }
                ?>
            });

        </script>
        <div class="clearer">&nbsp;</div>

    </div>

    <div>



        <?php if($hasSummary) {?>
        <p>
        <label><?php echo $entry_summary?></label><br>
        <textarea class="text" rows="3" cols="70" id="summary" name="summary"><?php echo $summary?></textarea>
        <script language="javascript">
        $(document).ready(function(e) {
        setCKEditorType('summary',2);
        });
</script>
        </p>
        <?php } ?>
        <?php if($hasSource) {?>
        <p>
        <label><?php echo $entry_source?></label><br>
        <input class="text" type="text" name="source" value="<?php echo $source?>" size="40" />
        </p>
        <?php } ?>

    </div>


</div>
<div id="fragment-properties">
    <div>


        <p>
            <label><?php echo $text_status?></label>
            <?php foreach($statuspro as $it){ ?>
        <div>

            <?php echo $this->string->getPrefix("&nbsp;&nbsp;&nbsp;&nbsp;",$it['level']) ?>
            <input type="checkbox"  name="loaisp[<?php echo $it['categoryid']?>]" value="<?php echo $it['categoryid']?>" <?php echo in_array($it['categoryid'],$properties)?'checked="checked"':''; ?> />
            <?php echo $it['categoryname']?>
        </div>
        <?php } ?>
        </p>
    </div>
</div>
<div id="fragment-detail">
    <a class="button" onclick="browserFileEditor()">Select image</a>
    <input type="hidden" id="listselectfile" name="listselectfile" />
    <div>
        <p>
            <textarea name="description" id="editor1" cols="80" rows="10"><?php echo $description?></textarea>
        </p>
    </div>
</div>
<?php if($hasVideo) {?>
<div id="fragment-video">
<p id="pnVideo">
<label for="file">File</label><br />
<a onclick="browserFile()" class="button">Select file</a><br />
<span id="filename"><?php echo $filepath?></span>
<input type="hidden" id="filepath" name="filepath" value="<?php echo $filepath?>" />
<input type="hidden" id="fileid" name="fileid" value="<?php echo $fileid?>" />
<div id="sub_errorupload" class="error" style="display:none"></div>


</p>


<div id="errorupload" class="error" style="display:none"></div>

<div class="loadingimage" style="display:none"></div>
</div>
<?php } ?>
<?php if($hasSubInfor) {?>
<div id="fragment-subinfor">
<input type="hidden" name="sub_mediaid" id="sub_mediaid" />
<div>
<p>
Tiêu đề:<br />
<input class="text" type="text" name="sub_title" id="sub_title" value="" size="40" />
</p>
<p id="sub_pnImage">
<label for="image">Image</label><br />
<a id="btnAddSubImage" class="button">Select Image</a><br />
<img id="sub_preview" src="" />
<input type="hidden" id="sub_imagepath" name="sub_imagepath" />
<input type="hidden" id="sub_imageid" name="sub_imageid"  />
<input type="hidden" id="sub_imagethumbnail" name="sub_imagethumbnail" />
</p>
<p>
<textarea name="sub_description" id="sub_description" cols="80" rows="10"></textarea>
</p>
<p>
<input type="button" class="button" value="<?php echo $button_save?>" onclick="postSubInfor()"/>
<input type="button" class="button" value="<?php echo $button_cancel?>"/>
</p>
</div>
<div id="subinforlist">
</div>
<script language="javascript">
function postSubInfor()
{
var oEditor = CKEDITOR.instances['sub_description'] ;
var pageValue = oEditor.getData();
$('textarea#sub_description').val(pageValue);
$.post("?route=core/postcontent/savepost",
{
mediaid : $("#sub_mediaid").val(),
mediaparent : $("#mediaid").val(),
title : $("#sub_title").val(),
mediatype : 'subinfor',
description : $("#sub_description").val(),
imageid : $("#sub_imageid").val(),
imagepath : $("#sub_imagepath").val()
},
		function(data){
			if(data=="true")
			{
				$("#subinforlist").load("?route=core/postcontent/loadSubInfor&mediaid="+$("#mediaid").val());
				$("#sub_mediaid").val("");
				$("#sub_title").val("");
				$("#sub_summary").val("");
				$("#sub_author").val("");
				$("#sub_imageid").val("");
				$("#sub_imagepath").val("");
				$("#sub_preview").attr("src", "");
				var oEditor = CKEDITOR.instances.sub_description ;
				oEditor.setData("") ;
				$("#subimageerror").hide('slow');
			}
			else
			{
				$("#subimageerror").html(data);
				$("#subimageerror").show('slow');
			}

		});
}
function editeSubInfor(mediaid)
{

	$.getJSON("?route=core/postcontent/getSubInfor&mediaid="+mediaid,
			function(data)
			{
				//alert(data.subimage.imagepreview);
				$("#sub_mediaid").val(data.subinfor.mediaid);
				$("#sub_title").val(data.subinfor.title);
				$("#sub_summary").val(data.subinfor.summary);
				$("#sub_author").val(data.subinfor.author);
				$("#sub_imageid").val(data.subinfor.imageid);
				$("#sub_imagepath").val(data.subinfor.imagepath);
				$("#sub_imagethumbnail").val(data.subinfor.imagepreview);
				$("#sub_preview").attr("src", data.subinfor.imagepreview);
				var oEditor = CKEDITOR.instances.sub_description ;
				oEditor.setData(data.subinfor.description);

			});
}

function removeSubInfor(mediaid)
{
	//$.blockUI({ message: "<h1>Đang xử lý...</h1>" });
$.ajax({
url: "?route=core/postcontent/removeSubImage&mediaid="+mediaid,
cache: false,
success: function(html)
{
$("#subinforlist").load("?route=core/postcontent/loadSubInfor&mediaid="+$("#mediaid").val());
}
});

}
</script>
<script language="javascript">
$(document).ready(function() {
    setCKEditorType('sub_description',2);
    $("#subinforlist").load("?route=core/postcontent/loadSubInfor&mediaid="+$("#mediaid").val());
})
</script>
</div>
<?php }?>
<?php if($hasTabImages){ ?>
<div id="fragment-images">
</div>
<?php } ?>
<?php if($hasTabVideos){ ?>
<div id="fragment-videos">
</div>
<?php } ?>
<?php if($hasTabDocuments){ ?>
<div id="fragment-documents">
</div>
<?php } ?>
<?php if(@$hasProductPrice) { ?>
<div id="fragment-productprice">
<input type="hidden" name="price_mediaid" id="price_mediaid" />
<div>
<p>
Tiêu đề:<br />
<input class="text" type="text" name="price_title" id="price_title" value="" size="40" />
</p>
<p>
Code sản phẩm:<br />
<input class="text" type="text" name="price_code" id="price_code" value="" size="40" onchange="price.loadPrice(this.value)"/> <input type="button" class="button" value="Lấy giá" onclick="price.loadPrice($('#price_code').val())" />
</p>
<p>
Giá thị trường:<br />
<input class="text number" type="text" name="price_thitruong" id="price_thitruong" value="" size="40" />
</p>
<p>
Giá:<br />
<input class="text number" type="text" name="price_gia" id="price_gia" value="" size="40" />
</p>
<p>
Khuyến mãi:<br />
<input class="text number" type="text" name="price_khuyenmai" id="price_khuyenmai" value="" size="40" />
</p>
<p>
Chương trình khuyến mãi:
<input type="hidden" name="machuongtrinh" id="machuongtrinh"/>
<span id="tenchuongtrinh"></span>
<input type="button" class="button" id="btnSelectKhuyenMai" value="Chọn chương trình khuyến mãi" />
</p>
<p>
<input type="button" class="button" id="btnSavePrice" value="<?php echo $button_save?>"/>
<input type="button" class="button" value="<?php echo $button_cancel?>"/>
</p>
</div>
<div id="pricelist">
</div>
<script language="javascript">
$(document).ready(function(e) {
$("#pricelist").load("?route=core/postcontent/loadPrice&mediaid="+$("#mediaid").val());
});
$("#btnSavePrice").click(function(){
	 price.save();
});

$('#btnSelectKhuyenMai').click(function(e) {
    price.selectChuongTrinh();
});
var price = new Price();
function Price()
{
	this.loadPrice = function(code)
	{
		$.getJSON("<?php echo HTTP_SERVER?>ric/getSanPham.php?masanpham="+code,
function(data)
{
if(data.sanpham == false)
alert('Không tồn tại code sản phẩm này');
else
$('#price_gia').val(formateNumber(data.sanpham.HH_GiaBan+""));


});
}

this.save = function()
{
var price = $("#price_gia").val().replace(/,/g,"");
if($("#price_khuyenmai").val()!= 0)
price = $("#price_khuyenmai").val().replace(/,/g,"")
$.post("?route=core/postcontent/savepost",
{
mediaid : $("#price_mediaid").val(),
mediaparent : $("#mediaid").val(),
title : $("#price_title").val(),
mediatype : 'price',
summary : "[code="+ $('#price_code').val() +"][thitruong="+ $("#price_thitruong").val().replace(/,/g,"") +"][gia="+ $("#price_gia").val().replace(/,/g,"") +"][khuyenmai="+ $("#price_khuyenmai").val().replace(/,/g,"") +"][makhuyenmai="+ $('#machuongtrinh').val() +"]",
price : price
},
function(data){
if(data=="true")
{
$("#pricelist").load("?route=core/postcontent/loadPrice&mediaid="+$("#mediaid").val());
$("#price_mediaid").val("");
$("#price_code").val("");
$("#price_title").val("");
$("#price_thitruong").val(0);
$("#price_gia").val(0);
$("#price_khuyenmai").val(0);
$('#machuongtrinh').val('');
$('#tenchuongtrinh').html('');

}
else
{
$("#subimageerror").html(data);
$("#subimageerror").show('slow');
}

});
}
this.edit = function(mediaid)
{
$.getJSON("?route=core/postcontent/getPrice&mediaid="+mediaid,
function(data)
{

$("#price_mediaid").val(data.price.mediaid);
$("#price_title").val(data.price.title);
$("#price_code").val(data.price.code);
$("#price_thitruong").val(formateNumber(formateNumber(data.price.thitruong)));
$("#price_gia").val(formateNumber(formateNumber(data.price.gia)));
$("#price_khuyenmai").val(formateNumber(data.price.khuyenmai));

price.loadKhuyenMai(data.price.makhuyenmai);
numberReady();

});
}
this.remove = function(mediaid)
{
//$.blockUI({ message: "<h1>Đang xử lý...</h1>" });
$.ajax({
url: "?route=core/postcontent/removeSubImage&mediaid="+mediaid,
cache: false,
success: function(html)
{
$("#pricelist").load("?route=core/postcontent/loadPrice&mediaid="+$("#mediaid").val());
}
});
}
this.selectChuongTrinh = function()
{
$('#popup-content').load('?route=core/mediapopup&sitemapid=tinkhuyenmai',
function()
{
showPopup('#popup', 350, 500, true );
});
}

this.loadKhuyenMai = function(makhuyenmai)
{
if(makhuyenmai != '')
{
$.getJSON("?route=core/media/getMedia&col=mediaid&val=" + makhuyenmai,
function(data)
{
$('#machuongtrinh').val(data.medias[0].mediaid);
$('#tenchuongtrinh').html(data.medias[0].title);
$.unblockUI();
});
}


}
}



function selectCallBack()
{
var arr = new Array();
$('.selectmedia').each(function(index, element) {
if(this.checked == true)
{
arr.push(this.value);
}

});

price.loadKhuyenMai(arr[0]);

}
</script>
</div>

<?php }?>
<?php if($hasTabMap) {?>
            <div id="fragment-map">
                <div>
                	<table>
                    	<thead>
                        	<th width="50%"><?php echo $column_menu?></th>
                            <th width="50%"><?php echo $column_parent?></th>
                        </thead>
                        <tbody>
                        	<?php echo $listReferSiteMap?>
                        </tbody>
                    </table>


                </div>
            </div>
            <?php } ?>
<?php if($hasTabComment) {?>
            <div id="fragment-comment">
            	<div id="listcommet">
                </div>
            </div>
<script language="javascript">
function Comment()
{
	this.loadComment = function(mediaid)
	{
		$('#listcommet').load('?route=core/comment&mediaid='+mediaid+"&popup=true");
	}
        }
function callbackLoadCommnet()
{
    objComment.loadComment('<?php echo $mediaid?>');
}
var objComment = new Comment();
$(document).ready(function(e) {
    objComment.loadComment('<?php echo $mediaid?>');
});
</script>
<?php } ?>


</div>
</form>

        

    
    </div>

</div>

<script src='<?php echo DIR_JS?>ajaxupload.js' type='text/javascript' language='javascript'> </script>
<script src="<?php echo DIR_JS?>jquery.tabs.pack.js" type="text/javascript"></script>

<script type="text/javascript" charset="utf-8">
function save()
{
	$.blockUI({ message: "<h1>Đang xử lý...</h1>" }); 
	var oEditor = CKEDITOR.instances['editor1'] ;
	var pageValue = oEditor.getData();
	$('textarea#editor1').val(pageValue);
	<?php if($hasSummary) {?>
	var oEditor = CKEDITOR.instances['summary'] ;
	var pageValue = oEditor.getData();
	$('textarea#summary').val(pageValue);
	<?php } ?>
	$.post("?route=core/postcontent/savepost",$('#frmPost').serialize(),
		function(data){
			if(data=="true")
			{
				if("<?php echo $_GET['sitemapid']?>"!= "")
				{
					var sitemapid = $('#refersitemap').val().replace('[',"");
					sitemapid = sitemapid.replace("]","");
					window.location = "?route=<?php echo $this->getRoute()?>&sitemapid=<?php echo $_GET['sitemapid']?>";	
				}
				else
					window.location = "?route=core/media";	
			}
			else
			{
				$.unblockUI();
			}
			
		});
}
var DIR_UPLOADPHOTO = "<?php echo $DIR_UPLOADPHOTO?>";
var DIR_UPLOADATTACHMENT = "<?php echo $DIR_UPLOADATTACHMENT?>";
$(document).ready(function() { 
	
	setCKEditorType('editor1',2);
	$('#container').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'slow' });
	
});
</script>
<?php if($hasFile) {?>

<?php if($hasSubInfor) {?>
<script src="<?php echo DIR_JS?>uploadsubimage.js" type="text/javascript"></script>
<?php } ?>

<?php }?>


<script language="javascript">


function browserFileImage()
{
    //var re = openDialog("?route=core/file&dialog=true",800,500);
	$('#handler').val('image');
	$('#outputtype').val('image');
	showPopup("#popup", 800, 500);
	$("#popup").html("<img src='view/skin1/image/loadingimage.gif' />");
	$("#popup").load("?route=core/file&dialog=true");
		
}
function browserFileAttachment()
{
	$('#handler').val('attachment');
	$('#outputtype').val('attachment');
	showPopup("#popup", 800, 500);
	$("#popup").html("<img src='view/skin1/image/loadingimage.gif' />");
	$("#popup").load("?route=core/file&dialog=true");
}
function browserFile()
{
    //var re = openDialog("?route=core/file&dialog=true",800,500);
	$('#handler').val('file');
	$('#outputtype').val('file');
	showPopup("#popup", 800, 500);
	$("#popup").html("<img src='view/skin1/image/loadingimage.gif' />");
	$("#popup").load("?route=core/file&dialog=true")
		
}

function browserFileEditor()
{
    //var re = openDialog("?route=core/file&dialog=true",800,500);
	$('#handler').val('editor1');
	$('#outputtype').val('editor');
	showPopup("#popup", 800, 500);
	$("#popup").html("<img src='view/skin1/image/loadingimage.gif' />");
	$("#popup").load("?route=core/file&dialog=true")
		
}

function addImageTo()
{
	var str= trim($("#listselectfile").val(),",");
	var arr = str.split(",");
	
	if(str!="")
	{
		for (i=0;i<arr.length;i++)
		{
			$.getJSON("?route=core/file/getFile&fileid="+arr[i], 
				function(data) 
				{
					switch($('#outputtype').val())
					{
						case 'editor':
							width = "";
							
							var value = "<img src='<?php echo HTTP_IMAGE?>"+data.file.filepath+"'/>";
							
							var oEditor = CKEDITOR.instances[$('#handler').val()] ;
							
							
							// Check the active editing mode.
							if (oEditor.mode == 'wysiwyg' )
							{
								// Insert the desired HTML.
								oEditor.insertHtml( value ) ;
								$("#listselectfile").val('');
								var temp = oEditor.getData()
								oEditor.setData( temp );
							}
							else
								alert( 'You must be on WYSIWYG mode!' ) ;
							break;
						case 'image':
							var handler = $('#handler').val();
							$('#'+handler+'id').val(data.file.fileid)
							$('#'+handler+'path').val(data.file.filepath)
							$.getJSON("?route=core/file/getFile&fileid="+data.file.fileid+"&width=200", 
							function(file) 
							{
								$('#'+handler+'thumbnail').val(file.file.imagepreview)
								$('#'+handler+'preview').attr('src',file.file.imagepreview)
							});
							break;
						case 'file':
							var handler = $('#handler').val();
							$('#'+handler+'id').val(data.file.fileid);
							$('#'+handler+'path').val(data.file.filepath);
							$('#'+handler+'name').html(data.file.filename);
							break;
						case 'attachment':
							var handler = $('#handler').val();
							$.getJSON("?route=core/file/getFile&fileid="+data.file.fileid+"&width=50", 
							function(file) 
							{
								$('#'+handler).append(attachment.creatAttachmentRow(data.file.fileid,data.file.filename,file.file.imagepreview));
								
							});
							
							break;
					}
				});
		}
	}
}
function Attachment()
{
	this.index = 0;
	this.removeAttachmentRow = function(index)
	{
		$("#delfile").append('<input type="hidden" id="attimageid'+attachment.index+'" name="delfile['+index+']" value="'+$("#attimageid"+index).val()+'" />');
		$("#attrows"+index).html("")
	}
	this.creatAttachmentRow = function(iid,path,thums)
	{
		row = '<div id="attrows'+attachment.index+'"><img src="'+thums+'" /><input type="hidden" id="attimageid'+attachment.index+'" name="attimageid['+attachment.index+']" value="'+iid+'" />'+path+' <a id="removerow'+attachment.index+'" onclick="attachment.removeAttachmentRow('+attachment.index+')" class="button" >Remove</a></div>';
		attachment.index++;
		return row;	
	}
	this.creatAttachmentRowView = function(iid,name,path,thums)
	{
		row = '<div id="attrows'+attachment.index+'"><img src="'+thums+'" /><input type="hidden" id="attimageid'+attachment.index+'" name="attimageid['+attachment.index+']" value="'+iid+'" />'+'<a href="'+path+'" target="_blank">'+name+'</a>';
		attachment.index++;
		return row;
	}

}
var attachment = new Attachment();

</script>
