/***********
** WISITE NAMESPACE
**************/

$(document).ready(function(event)
{

    $("#shop_settings").click(function(event)
    {
       event.preventDefault();
         var shop_name       = $("#shop_name").val(),
             business_email  = $("#business_email").val(),
             paypal_id  = $("#paypal_id").val(),
             paypal_secret  = $("#paypal_secret").val(),
             paypal_callback  = $("#paypal_callback").val(),
             cancel_url  = $("#cancel_url").val(),
             notify_url  = $("#notify_url").val(),

             //create data that will be sent over server

              shop_settings = {
                ShopData:{
                    shop_name           : shop_name,
                    business_email          : business_email,
                    paypal_id          : paypal_id,
                    paypal_secret          : paypal_secret,
                    paypal_callback          : paypal_callback,
                    cancel_url          : cancel_url,
                    notify_url          : notify_url

                },
                FieldId:{
                    shop_name           : "shop_name",
                    business_email          : "business_email",
                    paypal_id          : "paypal_id",
                    paypal_secret          : "paypal_secret",
                    paypal_callback          : "paypal_callback",
                    cancel_url          : "cancel_url",
                    notify_url          : "notify_url"

                }
             };
             // send data to server
             WIShop.sendData(shop_settings);
    });

  });


var WIShop = {};

WIShop.ChangeProduct = function(pid) {
    event.preventDefault();
    //alert('click');
    jQuery.noConflict();


    var username    = $("#modal-username"),
        Category       = $("#modal-Category"),
        brand        = $("#modal-brand"),
        productname    = $("#modal-product-name"),
        desc     = $("#modal-product-desc"),
        price       = $("#modal-product-price"),
        image  = $("#modal-product-image"),
        ajaxLoading = $("#ajax-loading"),
        detailsBody = $("#details-body"),
        modal       = $("#modal-product-details");

   //display modal
   modal.css("display", "block");
   //modal('show');

   // set username (title of modal window) to loading...
   username.text($_lang.loading);
   
   //display ajax loading gif
   ajaxLoading.show();
   
   //hide details body
   detailsBody.hide();
   
   $.ajax({
       url      : "WICore/WIClass/WIAjax.php",
            method   : "POST",
            data     : {
                action : "selectedProduct",
                addProduct: 1,
                pid : pid
            },
       success: function (result) {
           //parse result as JSON
           var res = JSON.parse(result);
           //console.log(res);
           //update modal fields
           username .text(res.username);
           Category    .attr("value", res.cat)
           brand.text(res.brand);
           productname .text(res.title);
           desc  .text(res.desc);
           price    .text(res.price);
           image.text(res.image);

           //hide ajax loading
           ajaxLoading.hide();
           
           //display user info
           detailsBody.show();
       }
   });
   
};


WIShop.hide = function(){
    modal = $("#modal-product-details");

   //display modal
   modal.css("display", "none");
}

WIShop.sendData = function(shop_settings){
  var btn = $("#shop_settings");
  console.log(shop_settings)
    // put button into the loading state
    WICore.loadingButton(btn, $_lang.creating_Account);

$(".ajax-loading").removeClass("hide").addClass("show");
     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "shop_settings",
            shop_settings   : shop_settings
        },
        success: function(result)
        {
            
            console.log(result);
            // return the button to normasl state
            WICore.removeLoadingButton(btn);
            
            //window.alert(result);
            //parse the data to json
            //var res = JSON.stringify(result);
            var res = JSON.parse(result);
            //var res = $.parseJSON(result);
            console.log(res);
            if(res.status === "error")
            {
                /// display all errors
                 for(var i=0; i<res.errors.length; i++) 
                 {
                    var error = res.errors[i];
                    WICore.displayadminerrorsMessage($("#"+error.id), error.msg);
                }
            }
            else if(res.status === "success")
            {
              $(".ajax-loading").removeClass("show").addClass("hide");
                // dispaly success message
                WICore.displaySuccessfulMessage($("#wresults"), res.msg);
               window.location.reload();
            }
        }
    });
}
