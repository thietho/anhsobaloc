function initMenu() {
  $('#menu ul').show();
  $('#menu li div.collape').click(
    function() {
        $(this).next().slideToggle('normal');	
      }
    );
  }
$(document).ready(function() {initMenu();});