$(function(){

    function validate(section,e){
        let inputs  = $(`${section}  input`).not('[type=hidden]').not('[type=submit]');
        let selects = $(`${section}  select`);
        let alert= $(`${section} .alert-danger`);
        alert.empty();
        for(input of inputs){
            if(input.value == ''){
                e.preventDefault();
                const field = `${input.attributes.name.value} Field`;
                alert.append(`<p>${field} shouldn't be empty</p>`);
            }
        }
        if(selects){
            for(select of selects){
                if(select.value == 0){
                    e.preventDefault();
                    const field = `${select.attributes.name.value} Field`;
                    alert.append(`<p>${field} shouldn't be empty</p>`);
                }
            }
        }
    }
    // validate login
    $('.sign .login form').on('submit',function(e){
        validate('.login form',e);
    });

    // validate signup
    $('.sign .signup form').on('submit',function(e){
        validate('.signup form',e);
        if($('.sign .signup form .password').val() != 
        $('.sign .signup form .password-confirm').val()){
            e.preventDefault();
            $('.sign .signup .alert-danger').append(`<p>passwords are not equal</p>`);
        }
    });

    // validate add product
    $('.add-prod form').on('submit',function(e){
        validate('.add-prod form',e);
    });
});