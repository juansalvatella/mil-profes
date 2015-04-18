$(document).ready(function() {
    $('#register-link').click(function(){
    	ga('send', 'event', 'attempts', 'registration','');
    });
    $('#register-submit-button').click(function(){
    	ga('send', 'event', 'actions', 'registration','submit');
    });
    $('#register-cancel-button').click(function(){
    	ga('send', 'event', 'actions', 'registration','cancel');
    });
});
