$(document).ready(function(){
    var cat = $('#aside-selector').attr('name');
    $('#aside-' + cat).show();
    $('#aside-' + cat).addClass('aside-button-active');
    $('#stats-' + cat).show();
    $('#stats-show-' + cat).show();
    SetKeyframes();

    // Aside button pressed function
    $('.aside-button').click(function(){
        $('.aside-button').removeClass('aside-button-active');
        $(this).addClass('aside-button-active');
        var tab = $(this).text().toLowerCase();
        $('.stats-info').hide();
        $('#stats-'+ tab).show();
        $('.stats-show').hide();
        $('#stats-show-'+ tab).show();
        SetKeyframes();
    });
    $('.navigation-phone-btn').click(function(){
        if (!$('.navigation-container').is(':visible')){
            $('.navigation-container').slideDown();
        }
        else{
            $('.navigation-container').slideUp();
        }
    })
    //Setting Keyframes till lvl up
    function SetKeyframes(){
        var cat = getCat();
        var proc = ProcentageCalc(cat).toFixed(2);
        $('.stats-procentage').text(proc+'%');
        $('#stats-keyframes').text(`
            @keyframes progress-animation{
                from {
                    --progress: 0;
                }
                to {
                    --progress: `+ proc +`;
                }
            }
        `);
    };
    //Calculate procentage
    function ProcentageCalc(cat){
        var getXp = $('#stats-show-' + cat).find('.stats-xp-get').text();
        var needXp = $('#stats-show-' + cat).find('.stats-xp-need').text();
        var dif = $('#stats-show-' + cat).find('.test').attr('name');
        getXp = getXp - dif;
        needXp = needXp - dif;
        return (100 * getXp) / needXp;
    };
    //Get category
    function getCat(){
        var cat = $('.stats-aside').find('.aside-button-active').text().toLowerCase();
        return cat;
    }
});