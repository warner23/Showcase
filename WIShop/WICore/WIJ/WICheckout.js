$(document).ready(function()
{

});





var WICheckout ={};

WICheckout.stepOne = function(){
    $("#step_one").removeClass('show');
    $("#step_one").addClass('hide');
    $("#step_two").removeClass('hide');
    $("#step_two").addClass('show');

    $("#stepOne").removeClass('active');
    $("#stepOne").addClass('passActive');
    $("#stepTwo").removeClass('inactive');
    $("#stepTwo").addClass('active');


}


WICheckout.stepTwo = function(){
    $("#step_two").removeClass('show');
    $("#step_two").addClass('hide');
    $("#step_three").removeClass('hide');
    $("#step_three").addClass('show');
    $("#stepTwo").removeClass('active');
    $("#stepTwo").addClass('passActive');
    $("#stepThree").removeClass('inactive');
    $("#stepThree").addClass('active');


}

WICheckout.stepThree = function(){
    $("#step_three").removeClass('show');
    $("#step_three").addClass('hide');
    $("#step_four").removeClass('hide');
    $("#step_four").addClass('show');
    $("#stepThree").removeClass('active');
    $("#stepThree").addClass('passActive');
    $("#stepFour").removeClass('inactive');
    $("#stepFour").addClass('active');


}

WICheckout.stepFour = function(){
    $("#step_four").removeClass('show');
    $("#step_four").addClass('hide');
    $("#step_five").removeClass('hide');
    $("#step_five").addClass('show');
    $("#stepFour").removeClass('active');
    $("#stepFour").addClass('passActive');
    $("#stepFive").removeClass('inactive');
    $("#stepFive").addClass('active');


}

WICheckout.checkout = function(){


        $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "GET",
        data: {
            action  : "checkout"

        },
        success: function (result) {
           WICore.removeLoadingButton(btn);
           if( result.status === 'success' ){
               window.location.reload();
           }else {
               WICore.displayErrorMessage($("#login-username"));
               WICore.displayErrorMessage($("#login-password"), result.message);
           }

        }
    });
}


WICheckout.process = function(){

  var btn = $("#paypal-button");
        $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action  : "process"
        },
        success: function (result) {
           if( result.status === 'success' ){
               //window.location.reload();
           }else {
               WICore.displayErrorMessage($("#login-username"));
               WICore.displayErrorMessage($("#login-password"), result.message);
           }

        }
    });
}


WICheckout.GetCart = function(){

          $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "GET",
        data: {
            action  : "cart"
        },
        success: function (result) {
           if( result.status === 'success' ){
               //window.location.reload();
           }else {
               WICore.displayErrorMessage($("#login-username"));
               WICore.displayErrorMessage($("#login-password"), result.message);
           }

        }
    });
}