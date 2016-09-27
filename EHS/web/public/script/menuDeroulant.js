$('.dropdown').on('show.bs.dropdown', function(e){
   $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
 });


 $('ul.nav li.dropdown').hover(function(e){
   $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
 });


 /*

 // VERSION AVEC DROPDOWN AUTOMATIQUE SUR HOVER //
  $('ul.nav li.dropdown').hover(function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown();
  },function(e){
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp();
  });


 */
