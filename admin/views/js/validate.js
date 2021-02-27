$(function(){

    function validate(section,e){
        let inputs;
        if(section === '.edit'){
            inputs  = $(`${section} form input`).not('[type=hidden]').not('[type=submit]').not('[type=password]');
        }else{
            inputs  = $(`${section} form input`).not('[type=hidden]').not('[type=submit]');
        }
        let alert= $(`${section} .alert-danger`);
        alert.empty();
        for(input of inputs){
            if(input.value == ''){
                e.preventDefault();
                const field = `${input.attributes.name.value} Field`;
                alert.append(`<p>${field} shouldn't be empty</p>`);
            }
        }
    }
    // validate add user
    $('.add form').on('submit',function(e){
        validate('.add',e)
        if($('.add form input[name=Password]').val() !== $('.add form input[name=Password-confirm]').val()){
            e.preventDefault();
            $('.add .alert').append(`<passwords are not equal</p>`);
        }
    });

    // validate edit user
    $('.edit form').on('submit',function(e){
        validate('.edit',e);
    });

    // validate add Catgory
    $('.addCategory form').on('submit',function(e){
        validate('.addCategory',e);
    });

    // validate edit category
    $('.edit-category form').on('submit',function(e){
        validate('.edit-category',e);
    });
    // validate edit category
    $('.add-product form').on('submit',function(e){
        validate('.add-product',e);
        if($('.add-product select').val() == 0){
            e.preventDefault();
            $('.add-product .alert').append(`<p class="lead">Status Field shouldn't be empty</p>`);
        }
    });
});