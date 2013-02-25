function initMenu() {
  $('#menu ul').hide();
  $('#menu li div.collape').click(
    function() {
        $(this).next().slideToggle('normal');	
      }
    );
  }
$(document).ready(function() {initMenu();});