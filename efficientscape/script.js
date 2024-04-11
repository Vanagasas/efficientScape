$(document).ready(function(){
    $('.index-content-container').click(function(){
        $(this).children('.index-pop-up').fadeIn(700);
        $('.index-outer-pop-up').fadeIn(700);
    });
    $('.index-close-button').click(function (e) { 
        $(this).parent('.index-pop-up').fadeOut(700);
        $('.index-outer-pop-up').fadeOut(700);
        e.stopPropagation();
      });
    $('.index-outer-pop-up').click(function(e){
        $('.index-pop-up').fadeOut(700);
        $('.index-outer-pop-up').fadeOut(700);
        e.stopPropagation();
    })
    $('.navigation-phone-btn').click(function(){
        if (!$('.navigation-container').is(':visible')){
            $('.navigation-container').slideDown();
        }
        else{
            $('.navigation-container').slideUp();
        }
    })
});