$(document).ready(function(){
    $('.achievments-list[name=1]').addClass('achievments-list-finished');
    $('#achievments-list-total-all').show();

    $('.navigation-phone-btn').click(function(){
        if (!$('.navigation-container').is(':visible')){
            $('.navigation-container').slideDown();
        }
        else{
            $('.navigation-container').slideUp();
        }
    })
    // Aside button pressed function
    $('.aside-button').click(function(){
        $('.aside-button').removeClass('aside-button-active');
        $(this).addClass('aside-button-active');
        var tab = $(this).text().toLowerCase();
        $('.achievments-full-list').hide();
        $('#achievments-list-total-' + tab).show();
        if (tab !== 'all'){
            $('.achievments-list').hide();
            $('.list-cat-' + tab).show();

        }
        else if (tab == 'all'){
            $('.achievments-list').show();
        }
    });
    $('#filter-completed').change(function(){
        if (this.checked){
            $('.achievments-list[name=1]').show();
        }
        else{
            $('.achievments-list[name=1]').hide();
        }
    })
    $('#filter-incompleted').change(function(){
        if (this.checked){
            $('.achievments-list[name=0]').show();
        }
        else{
            $('.achievments-list[name=0]').hide();
        }
    })
});