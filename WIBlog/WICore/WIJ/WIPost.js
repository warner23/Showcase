$(document).ready(function(){

  var id = $.cookie("id");

  WIPost.loadPost(id);

});

var WIPost = {};

WIPost.loadPost = function(id){


  $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "loadPost",
            id   : id
        },
        success: function(result)
        {
         $("#posts").html(result);
        }
       
        
    });
}
