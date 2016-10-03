$(window).scroll(function(e){
    parallax();
});

function parallax(){
    var scrolled = $(window).scrollTop();
    $('.bg').css('bottom',(scrolled*0.5)+'px');

}

var divs = $('.bg');
$(window).on('scroll', function() {
   var st = $(this).scrollTop();
   divs.css({ 'opacity' : (1 - st/350) });
});
