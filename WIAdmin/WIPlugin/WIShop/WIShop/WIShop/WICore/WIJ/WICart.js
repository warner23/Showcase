
$(document).ready(function () {

//WICart.addTotals();




});




var WICart = {};

WICart.Cart = function(userId){
     event.preventDefault();
        //alert(0);

        $.ajax({
            url      : "WICore/WIClass/WIAjax.php",
            method   : "POST",
            data     : {
                action : "cart",
                getCart: 1,
                userId : userId
            },
            success  : function(data){
                //alert(data);
                $("#cart_product").html(data);
            }
    });
}

WICart.GetKart = function(userId){
     event.preventDefault();
        //alert(0);

        $.ajax({
            url      : "WICore/WIClass/WIAjax.php",
            method   : "POST",
            data     : {
                action : "getCart",
                userId : userId
            },
            success  : function(data){
                //alert(data);
                $("#cart_product").html(data);
            }
    });
}

WICart.refresh = function(id){
    
    var qty = $("#qty_"+id).val();
    total = $("#total_"+id).text();
    console.log(total);
        $.ajax({
            url      : "WICore/WIClass/WIAjax.php",
            method   : "POST",
            data     : {
                action : "update_cart",
                qty : qty,
                id  : id,
                total : total
            },
            success  : function(result){

                var res = JSON.parse(result);

                if(res.status == "successful"){
                    window.location.reload();
                }
            }
    });
}

WICart.Delete = function(id){
     event.preventDefault();
        //alert(0);

        $.ajax({
            url      : "WICore/WIClass/WIAjax.php",
            method   : "POST",
            data     : {
                action : "cart_delete",
                id : id
            },
            success  : function(result){

                var res = JSON.parse(result);

                if(res.status == "successful"){
                    $("#cart_product").empty();
                    WICart.GetKart(res.user);

                }
            }
    });
}

WICart.MainKartDelete = function(id){
     event.preventDefault();
        //alert(0);

        $.ajax({
            url      : "WICore/WIClass/WIAjax.php",
            method   : "POST",
            data     : {
                action : "cart_delete",
                id : id
            },
            success  : function(result){

                var res = JSON.parse(result);

                if(res.status == "successful"){
                   window.location.reload();

                }
            }
    });
}

WICart.addTotals = function(){
   var subtotal =  $(".subtotal").val();
   console.log(subtotal);
    $(subtotal).each(function(index){
        console.log(index);
    });
    var totalPrice = 0;

    $('#cart .subtotal').each(function()
{
totalPrice += parseFloat($(this).html());
  //alert($(this).html());
});


    //add VAT

var VAT = totalPrice * 20/100;
$("#vat").text("VAT : " + VAT);

//Total Price with VAT
var total = VAT;
    $("#currency").text("Total : £");
    $("#total").text(totalPrice);
}

