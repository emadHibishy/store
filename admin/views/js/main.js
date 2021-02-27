$(function(){
    // hide placeholder on focus
    $('[placeholder]').focus(function(){
        $(this).attr('data-text',$(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    // convert password field to input
    $('.eye-pass').on('click',function(){
        if($(this).hasClass('fa-eye-slash')){
            $(this).removeClass('fa-eye-slash').addClass('fa-eye').siblings(['password']).attr('type','password');
        }else{
            $(this).addClass('fa-eye-slash').removeClass('fa-eye').siblings(['password']).attr('type','text');
        }

    });

    function showPopup(el,page,item){
        const id = $(el).data('target');
        $('.parent').show().children('.popup').children('.delete').attr('href',`${page}.php?action=Remove&${item}=${id}`);
    }
    // showing popup when click on delete at users page
    $('.manage .remove').on('click',function(){
        showPopup(this,'users','userId');
    });

    // showing popup when click on delete at categories page
    $('.categories .remove').on('click',function(){
        showPopup(this,'categories','catId');
    });

    // showing popup when click on delete at products page
    $('.manage-products .remove').on('click',function(){
        showPopup(this,'products','prodId');
    });
    // showing popup when click on delete at comments page
    $('.manage-comments .remove').on('click',function(){
        showPopup(this,'comments','commId');
    });

    // hide popup on click
    $('.popup .btn').on('click',function(){
        $('.parent').hide();
    });

    // toggle dashboard card-body
    $('.toggle-content').on('click',function(){
        $(this).toggleClass('slided').parent('.card-header').next('.card-body').slideToggle(700);
        if($(this).hasClass('slided')){
            $(this).html('<i class="fa fa-plus fa-lg toggle-content"></i>');
        }else{
            $(this).html('<i class="fa fa-minus fa-lg toggle-content"></i>');
        }
    })
});