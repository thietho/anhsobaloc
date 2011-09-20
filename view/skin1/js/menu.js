function mainmenu(){
$(" #ben-main-nav ul ").css({display: "none"}); // Opera Fix
$(" #ben-main-nav li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(400);
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
}

 $(document).ready(function(){					
	mainmenu();
});