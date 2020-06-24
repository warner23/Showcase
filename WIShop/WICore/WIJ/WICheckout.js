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


WICheckout.success = function(res){

    if (res.ack) {
        if(WICheckout.getUrlParams('commit') === 'true') {
             WICheckout.showPaymentExecute(res.data);
        } else {
             WICheckout.showPaymentGet(res.data);
        }
    } else {
        alert('Something went wrong');
    } 

}

WICheckout.showPaymentExecute = function(response){

            $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action  : "showPaymentExecute",
            response     : response
        },
        success: function (response) {
         var res = JSON.parse(response);

         if(res.status == "APPROVED"){

            WICheckout.stepTwo();
            $("#confirmation_t").html(res.receipt);
         }else{

         }

        }
    });
}

WICheckout.showPaymentGet = function(response){
  
       $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action  : "showPaymentGet",
            response     : response
        },
        success: function (response) {
          var res = JSON.parse(response);

         if(res.status == "APPROVED"){

            WICheckout.stepTwo();
            $("#confirmation_t").html(res.receipt);
         }else{

         }
        }
    });
}

WICheckout.showDom = function(id) {
    let arr;
    if (!Array.isArray(id)) {
        arr = [id];
    } else {
        arr = id;
    }
    arr.forEach(function (domId) {
        document.getElementById(domId).style.display = 'block';
    });
}

WICheckout.hideDom = function(id) {
    let arr;
    if (!Array.isArray(id)) {
        arr = [id];
    } else {
        arr = id;
    }
    arr.forEach(function (domId) {
        document.getElementById(domId).style.display = 'none';
    });
}

WICheckout.getUrlParams = function(prop) {
    let params = {},
        search = decodeURIComponent( window.location.href.slice( window.location.href.indexOf( '?' ) + 1 ) ),
        definitions = search.split( '&' );

    definitions.forEach( function(val) {
        let parts = val.split( '=', 2 );
        params[ parts[ 0 ] ] = parts[ 1 ];
    } );

    return ( prop && prop in params ) ? params[ prop ] : params;
}
