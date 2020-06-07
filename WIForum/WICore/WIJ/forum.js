$(document).ready(function () {


    $("body").delegate("a.cat_id", "click", function(event){
            var cat_id     = this.id;
            //alert(product_id);
            //$.cookie.set("product_id", "product_id");

             var date = new Date();
 var minutes = 30;
 date.setTime(date.getTime() + (minutes * 60 * 1000));
            $.cookie("cat_id", cat_id, {expires: date});
            
        });

});



/** cart NAMESPACE
 ======================================== */

var forum = {};

forum.new_cat = function(){

  var cat_title = $("#cat_Title").val();
    cat_descr  = $("#cat_desc").val();
    btn   = $("#cat");

        $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action  : "add_new_cat",
            cat_title    : cat_title,
            cat_descr   : cat_descr
        },
        success: function (result) {
            //return button to normal state
            WICore.removeLoadingButton(btn);

            console.log(result);
            
            //parse result to JSON
            var res = JSON.parse(result);
            
            if(res.status === "completed") {
             WICore.displaySuccessMessage($("#result"), res.msg);
             window.location = "index.php";
                }
            else {
                
            }
        }
    });  
}

forum.new_topic= function(){
      var topic_title = $("#topic_Title").val();
       cat_id = $.cookie("cat_id");
       btn = $("#new_topic");
      console.log(cat_id);
        $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action  : "add_new_topic",
            topic_title    : topic_title,
            cat_id       : cat_id
        },
        success: function (result) {
            //return button to normal state
            WICore.removeLoadingButton(btn);

            console.log(result);
            
             var res = JSON.parse(result);
            
            if(res.status === "completed") {
             WICore.displaySuccessMessage($("#result"), res.msg);
             window.location = "topic.php";
                }
            else {
                
            }
        }
    }); 
}