$(document).ready(function(){

    $('#login-hl').click(function(){
        $('#login-form').slideUp(function(){
            $('#signup-form').slideDown();
        });
        
    })
    $('#signup-hl').click(function(){
        $('#signup-form').slideUp(function(){
            $('#login-form').slideDown();
        });
    })
    $('#signup-form').submit(function(event){
        var username = $('#signup-username').val();
        var email = $('#signup-email').val();
        var password = $('#signup-password').val();
        var passwordRepeat = $('#signup-password-repeat').val();
        var userPassRegex = /^[a-zA-Z0-9]+$/;
        var emailRegex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (username == '' || password == ''){
            $('#error-login-message').text('Fill in the fields');
            event.preventDefault();
        }
        else{
            $('#error-login-message').text('');
        }
    })
});