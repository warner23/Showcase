$(document).ready(function(){
  var product_id = $.cookie("product_id");
    WIProducts.getProductInfor(product_id);
    WIProducts.getProductOverView(product_id);
    WIProducts.getProductReviews(product_id);

});

var WIProducts = {};

WIProducts.getProductInfor = function(product_id){


            $.ajax({
                  url: "WICore/WIClass/WIAjax.php",
                  type: "POST",
                  data: { 
                      action : "getProductInfor",
                      product_id  : product_id
                  },
                  error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
          },
                  success : function(result){
                  $("#product_item").html(result);
          }

          });
}


WIProducts.getProductOverView = function(product_id){


            $.ajax({
                  url: "WICore/WIClass/WIAjax.php",
                  type: "POST",
                  data: { 
                      action : "getProductOverView",
                      product_id  : product_id
                  },
                  error: function(xhr, status, error) {
            var err = eval("(" + xhr.responseText + ")");
            alert(err.Message);
          },
                  success : function(result){
                  $("#description").html(result);
          }

          });
}

WIProducts.getProductReviews = function(product_id){

      $.ajax({
            url: "WICore/WIClass/WIAjax.php",
            type: "POST",
            data: { 
                action : "getProductReviews",
                product_id  : product_id
            },
            error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
    },
            success : function(result){
            $("#reviews").html(result);
    }

    });
}

WIProducts.OpenReview = function(id){

        $.ajax({
            url: "WICore/WIClass/WIAjax.php",
            type: "POST",
            data: { 
                action : "OpenReview",
                id  : id
            },
            error: function(xhr, status, error) {
      var err = eval("(" + xhr.responseText + ")");
      alert(err.Message);
    },
            success : function(result){
            WIProducts.getProductReviews(id);
    }

    });
}