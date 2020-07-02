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


WICheckout.confirmation = function(){

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


WICheckout.pushpayment = function(res){

    if (res.ack) {
        if(WICheckout.getUrlParams('commit') === 'true') {
          console.log('execute');
             WICheckout.showPaymentExecute(res.data);
        } else {
          console.log('payGet');
             WICheckout.showPaymentGet(res.data);
        }
    } else {
        alert('Something went wrong');
    } 

}
WICheckout.success = function(res){
  $.ajax({
      type: 'POST',
      url: 'WICore/WIVendor/paypal/V2/api/captureOrder.php',
      data: postPatchOrderData,
      success: function (response) {
          console.log('Patch Order Response : '+ JSON.stringify(response));
          if (response.ack)
              return WICheckout.callPaymentCapture();
          else
              alert('Something went wrong');
      }
                });
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
          console.log(res);
         if(res.status == "APPROVED"){
           $("#paypalCheckoutContainer").css("display", "none");
            $("#paypalpay").removeClass('hide').addClass('show');
            $("#paypalpay").html(res.receipt);
            
            let shipping = res.shipping;
        let shipping_address = res.shipping_address;
        console.log('Get Order result' + JSON.stringify(res));
        console.log('shipping add' + JSON.stringify(shipping));
        document.getElementById('confirmRecipient').innerText = shipping.name.full_name;
        document.getElementById('confirmAddressLine1').innerText = shipping_address.address_line_1;
        if(shipping_address.address_line_2)
            document.getElementById('confirmAddressLine2').innerText = shipping_address.address_line_1;
        else
            document.getElementById('confirmAddressLine2').innerText = "";
        document.getElementById('confirmCity').innerText = shipping_address.admin_area_2;
        document.getElementById('confirmState').innerText = shipping_address.admin_area_1;
        document.getElementById('confirmZip').innerText = shipping_address.postal_code;
        document.getElementById('confirmCountry').innerText = shipping_address.country_code;
        $('#orderConfirm').css('display', 'block');
        //showDom('orderConfirm');

        // Listen for click on confirm button
        document.querySelector('#confirmButton').addEventListener('click', function () {
            let shippingMethodSelect = document.getElementById("shippingMethod"),
                updatedShipping = shippingMethodSelect.options[shippingMethodSelect.selectedIndex].value,
                currentShipping = res.purchase_units[0].amount.breakdown.shipping.value;

            let postPatchOrderData = {
                    "order_id": res.id,
                    "item_amt": res.purchase_units[0].amount.breakdown.item_total.value,
                    "tax_amt": res.purchase_units[0].amount.breakdown.tax_total.value,
                    "handling_fee": res.purchase_units[0].amount.breakdown.handling.value,
                    "insurance_fee": res.purchase_units[0].amount.breakdown.insurance.value,
                    "shipping_discount": res.purchase_units[0].amount.breakdown.shipping_discount.value,
                    "total_amt": res.purchase_units[0].amount.value,
                    "currency": res.purchase_units[0].amount.currency_code,
                    "current_shipping": currentShipping
                };

            console.log('patch data: '+ JSON.stringify(postPatchOrderData));
            // Execute the payment
            $('#confirmButton').css('display', 'none');
            $('#loadingAlert').css('display', 'block');


            console.log('Current shipping '+ currentShipping + ' and updated shipping is '+ updatedShipping);
            console.log('order id: '+res.id);
            if(currentShipping == updatedShipping) {
                return callPaymentCapture(); 
            } else {
                WICheckout.success(postPatchOrderData);
            }
        });

           }else{
            console.log("something went wrong.");
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

WICheckout.addAddress = function(){

         $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "GET",
        data: {
            action  : "newAddress"
        },
        success: function (result) {
          $("#new_address").html(result);
        }
    });
  
}


WICheckout.changeShipping = function(cost){

    $.ajax({
            url      : "WICore/WIClass/WIAjax.php",
            method   : "POST",
            data     : {
                action : "changeShipping",
                cost : cost
            },
            success  : function(data){
                
            }
        });
}

WICheckout.callPaymentCapture = function(){
        $.ajax({
                    type: 'POST',
                    url: 'WICore/WIVendor/paypal/V2/api/captureOrder.php',
                    success: function (response) {
                        hideDom('orderConfirm');
                        hideDom('loadingAlert');
                        console.log('Capture Response : '+ JSON.stringify(response));
                        if (response.ack)
                            WICheckout.showPaymentExecute(response.data);
                        else
                            alert("Something went wrong");
                    }
        });
    }