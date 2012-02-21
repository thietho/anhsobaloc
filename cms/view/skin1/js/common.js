// JavaScript Document
function confirm_check(url,mess)
{
	anser=confirm(mess)
	
	if(anser==true)
		window.location = url
}
function linkto(url)
{
	window.location = url
}

function searchMatrix(matrix,col,need)
{
	for(i=0;i < matrix.length ;i++)
		if(matrix[i][col]==need)
			return i
	return -1
}
function getPosOfNode(idparent,eid)
{
	var e = document.getElementById(idparent);
	i=0
	chi=e.childNodes[i]
	while(chi)
	{
		if(chi.id == eid)
			return i
		
		i++
		chi=e.childNodes[i]
	}
	return -1
}

function setCKEditorType(strID, intType)
{
	switch (intType)
	{
		case 0: // giao dien full
		CKEDITOR.replace( strID,
				{
					toolbar : [ ['Source','-','Save','NewPage','Preview','-','Templates'],['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print','SpellChecker','Scayt'],['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],'/',['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Link','Unlink','Anchor'],['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],'/',['Styles','Format','Font','FontSize'],['TextColor','BGColor'],['Maximize','ShowBlocks','-','About'] ]
				});
		//CKEDITOR.config.contentsCss = ['../view/skin1/css/ckeditor.css'];
		CKEDITOR.config.height = '400px';
		CKEDITOR.config.width = '640px';
		break;
		
		case 1: //Giao dien simply nhat
		CKEDITOR.replace( strID,
				{
					toolbar : [ ['Bold','Italic','Underline'],['Font','FontSize','TextColor','BGColor'],['Smiley'],['Link','Unlink'],['NumberedList','BulletedList'],['Outdent','Indent'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['RemoveFormat'],['Maximize'] ]
				});
		//CKEDITOR.config.contentsCss = ['../view/skin1/css/ckeditor.css'];
		CKEDITOR.config.height = '400px';
		CKEDITOR.config.width = '640px';
		break;
		
		case 2: //giao dien edit content
		CKEDITOR.replace( strID,
				{
					toolbar : [ ['Source','Bold','Italic','Underline'],['Font','FontSize','TextColor','BGColor'],['Smiley'],['Link','Unlink'],['NumberedList','BulletedList'],['Outdent','Indent'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['RemoveFormat'],['Maximize'],['PasteText','PasteFromWord'],['Flash','Table','SpecialChar'] ]
				});
		//CKEDITOR.config.contentsCss = ['../view/skin1/css/ckeditor.css'];
		CKEDITOR.config.height = '400px';
		CKEDITOR.config.width = '640px';
		break;
		
		case 3:
		CKEDITOR.replace( strID,
				{
					toolbar : [ ['Source','-','Save','NewPage','Preview','-','Templates'],['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print','SpellChecker','Scayt'],['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['Form','Checkbox','Radio','TextField','Textarea','Select','Button','ImageButton','HiddenField'],'/',['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],['Link','Unlink','Anchor'],['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],'/',['Styles','Format','Font','FontSize'],['TextColor','BGColor'],['Maximize','ShowBlocks','-','About'] ]
				});
		//CKEDITOR.config.contentsCss = ['../view/skin1/css/ckeditor.css'];
		CKEDITOR.config.height = '400px';
		CKEDITOR.config.width = '640px';
		break;
		case 4: //giao dien edit content
		CKEDITOR.replace( strID,
				{
					toolbar : [['Font'] ]
				});
		//CKEDITOR.config.contentsCss = ['../view/skin1/css/ckeditor.css'];
		CKEDITOR.config.height = '100px';
		CKEDITOR.config.width = '300px';
		break;
	}
	
	
}


function importJavaScript(jsFile) {
	
	var scriptElt = document.createElement('script');
	
	scriptElt.type = 'text/javascript';
	
	scriptElt.src = jsFile;
	
	document.getElementsByTagName('head')[0].appendChild(scriptElt);

}


function showPopup(popupid, width, height, overlayclose )
{
	$(document).ready(function() { 
		$.blockUI({ 
			message: $(popupid),
			css: { 
				top:  ($(window).height() - height) /2 + 'px', 
				left: ($(window).width() - width) /2 + 'px', 
				width: width+'px',
				height: height+'px'
			} 			
		});
		
		if(overlayclose != false)
		{
			$('.blockOverlay').attr('title','Click to close').click(function(){closePopup();});  
		}
	});	
}

function closePopup()
{
	$.unblockUI();	
	if (CKEDITOR.instances['editorPopup']) {
		CKEDITOR.instances.editorPopup.destroy();
	}
}

function loadPopup(id)
{
	$("#popupbody").load("index.php?route=core/fileadjust&id="+id);
	
	$.blockUI(
	{ 
		message: $('#popup'),
		css: { 
			top:  ($(window).height() - 500) /2 + 'px', 
			left: ($(window).width() - 600) /2 + 'px', 
			width: '700px',
			height: '500px'
			}
	});
}

function postStringData(object) {
	var str = "";
	$(object).each(function(){
		str += $(this).attr('name') + "=" + $(this).val() + "&";
	});
	return str;
}

function openDialog(url,width,height) {
    var result = window.showModalDialog(url, "", "dialogWidth:"+width+"px; dialogHeight:"+height+"px;");
}
function daysInMonth(month,year) 
{
	var m = [31,28,31,30,31,30,31,31,30,31,30,31];
	if (month != 2) return m[month - 1];
	if (year%4 != 0) return m[1];
	if (year%100 == 0 && year%400 != 0) return m[1];
	return m[1] + 1;
} 

function toMonth(month)
{
	if(month<10)
		return "0"+month;
	else
		return month;
}

function formateNumber(num)
{
	if(num =="")
		return 0;
	
	num = num.replace(/,/g,"");
	
	ar = (""+num).split("\.");
	div = ar[0];
	mod = ar[1];
	
	arr = new Array();
	block = "";
	
	for(i=div.length-1; i>=0 ; i--)
	{
		
		block = div[i] + block;
		
		if(block.length == 3)
		{
			arr.unshift(block);
			block ="";
		}
		
	}
	arr.unshift(block);
	
	divnum = arr.join(",");
	divnum = trim(divnum,",")
	divnum = divnum.replace("-,","-")
	if(mod == undefined)
		return divnum;
	else
		return divnum+"\."+mod;
}

function trim(str, chars) {
	return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function toBasicText(str)
{
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?"; 
	for (var i = 0; i < str.length; i++) 
	{ 
		if (iChars.indexOf(str.charAt(i)) != -1) 
		{ 
			
			str = str.replace(str.charAt(i),"");
		}
		//alert(str.charAt(i))
	}
	return str;
}

function isNumber(char)
{
	if( char!=8 && char!=0 && (char<45 || char>57) )
	{
	//display error message
	//$("#errmsg").html("Digits Only").show().fadeOut("slow");
		return false;
	}
	else true
}
function getFileExt(filepath)
{
	arr = filepath.split("\.");
	return arr[arr.length-1];
}

function numberReady()
{
	$(".number").keyup(function (e)
	{
		num = formateNumber($(this).val().replace(/,/g,""));
		$(this).val(num)
	});
	$(".number").keypress(function (e)
	{
		
	  	return isNumber(e.which);
	});

	
}
$(document).ready(function(){
	
	$(".error").each(function(index){
		if($(this).text() == "")
		{
			$(this).hide();	
		}
	});
	
	numberReady();
	$(".number").each(function(index){
		//alert(formateNumber($(this).val()))
		$(this).val(formateNumber($(this).val()))
		
	});					   
});