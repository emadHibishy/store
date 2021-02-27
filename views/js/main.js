$(function(){
    // hide placeholder on focus
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    // swith login & signup
    $('.sign h2 span').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active');
        $('.'+$(this).data('target')).siblings().hide();
        $('.'+$(this).data('target')).fadeIn(500);
    });
    
    // toggle popup
    $('.profile .insider .fa-photo').on('click',function(){
        $('.profile .parent').fadeIn(300);
    });
});