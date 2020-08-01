/***********
** WIProduct NAMESPACE
**************/
$(document).ready(function(event)
{


        $("#NewProduct").click(function()
    {

            var title  = $("#title").val(),
            metaTitle  = $("#meta_title").val(),
            summary  = $("#description").val(),
            price  = $("#price").val(),
            shipping  = $("#shipping").val(),
            photo  = $("#ProductPic").val(),
            category_id  = $("#cat_Selector option:selected").val(),
            brand_id  = $("#brand_selector option:selected").val(),
            quantity  = $("#quantity").val(),
            discount  = $("#discount").val(),
            sku  = $("#sku").val(),
            userId  = $("#user_id").val(),
            createdAt  = new Date().toISOString().substr(0,19).replace('T',' ');

             //create data that will be sent over server

              product = {
                UserData:{
                    title           : title,
                    metaTitle      : metaTitle,
                    summary     : summary,
                    price           : price,
                    shipping        : shipping,
                    category_id          : category_id,
                    brand_id        : brand_id,
                    quantity        : quantity,
                    discount        : discount,
                    sku             : sku,
                    photo             : photo,
                    userId             : userId,
                    createdAt             : createdAt

                },
                FieldId:{
                    title            : "title",
                    metaTitle       : "metaTitle",
                    summary      : "summary",
                    price            : "price",
                    shipping         : "shipping",
                    category_id           : "cat_Selector",
                    brand_id         : "brand_selector",
                    quantity         : "quantity",
                    discount         : "discount",
                    sku              : "sku",
                    photo              : "photo",
                    userId              : "user_id",
                    createdAt              : "createdAt"

                }
             };
             // send data to server
             WIProduct.sendData(product);
        
    });



});

var WIProduct = {}




WIProduct.sendData = function(product){

var btn = $("#NewProduct");
    event.preventDefault();

    
    // put button into the loading state
    WICore.loadingButton(btn, $_lang.creating_Account);

$(".ajax-loading").removeClass("hide").addClass("show");
     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "new_product",
            product   : product
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
                WICore.displaySuccessfulMessage($("#pstatus"), res.msg);
               window.location.reload();
            }
        }
    });
}
