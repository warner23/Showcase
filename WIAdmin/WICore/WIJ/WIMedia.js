$(document).ready(function(){

  $("img").click(function() {      
    $(this).toggleClass("hover");
    var id = $(".hover").attr("id");
   // alert(id);
    WIMedia.change(id);
  });


  var obj = $("#dragandrophandler");
  var dir = $("#supload").attr("value");
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px solid #0B85A1');
});
obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});
obj.on('drop', function (e) 
{
 
     $(this).css('border', '2px dotted #0B85A1');
     e.preventDefault();
     var files = e.originalEvent.dataTransfer.files;
 
     //We need to send dropped files to Server
     handleFileUpload(files,obj,dir);
});
$(document).on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});
$(document).on('dragover', function (e) 
{
  e.stopPropagation();
  e.preventDefault();
  obj.css('border', '2px dotted #0B85A1');
});
$(document).on('drop', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});

});

var WIMedia = {};

WIMedia.media = function(){
   $("#modal-header-edit").removeClass("on");
    $("#modal-header-edit").addClass("off");
     $("#modal-header-media").removeClass("off");
    $("#modal-header-media").addClass("on");
}

WIMedia.changeiconPic = function(){
   $("#modal-favicon-edit").removeClass("on");
    $("#modal-favicon-edit").addClass("off");
     $("#modal-favicon-media").removeClass("off");
    $("#modal-favicon-media").addClass("on");
}


  WIMedia.changePic = function(){

  	     $("#modal-header-edit").removeClass("off");
    $("#modal-header-edit").addClass("on");
  }

WIMedia.changefaviconPic = function(){

         $("#modal-favicon-edit").removeClass("off");
    $("#modal-favicon-edit").addClass("on");
  }

  WIMedia.closeEdit = function(){

  	 $("#modal-header-edit").removeClass("on");
    $("#modal-header-edit").addClass("off");
  }

    WIMedia.closeFEdit = function(){

     $("#modal-favicon-edit").removeClass("on");
    $("#modal-favicon-edit").addClass("off");
  }

  WIMedia.closeMedia = function(){
    $("#modal-header-media").removeClass("on");
    $("#modal-header-media").addClass("off");
  }

    WIMedia.closeFMedia = function(){
    $("#modal-favicon-media").removeClass("on");
    $("#modal-favicon-media").addClass("off");
  }

  WIMedia.closeUpload = function(){
    $("#modal-header-upload").removeClass("on");
    $("#modal-header-upload").addClass("off");
  }

    WIMedia.closeFUpload = function(){
    $("#modal-favicon-upload").removeClass("on");
    $("#modal-favicon-upload").addClass("off");
  }

  WIMedia.change = function(img){

  	  	$("#modal-header-media").removeClass("on");
    $("#modal-header-media").addClass("off");
    $(".cp").attr("src", "WIMedia/Img/header/"+img);
    $(".cp").attr("id", img);
  }



  WIMedia.savePic = function(){

  	var img = $(".cp").attr("id");
  	//alert(img);

  	    $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "changePic",
            img    : img
                    },
        success: function(result)
        {
            var res = JSON.parse(result);
            if (res.status === "successful") {
             $("#results").append(res.msg).fadeOut("slow");
            
        }
    }
    });
  }

    WIMedia.savefaviconPic = function(){

    var img = $(".cp").attr("id");
    //alert(img);

        $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "changefaviconPic",
            img    : img
                    },
        success: function(result)
        {
            var res = JSON.parse(result);
            if (res.status === "successful") {
             $("#favresults").append(res.msg).fadeOut(5000);
            
        }
    }
    });
  }


  WIMedia.upload = function(){
  	  	     $("#modal-header-edit").removeClass("on");
    $("#modal-header-edit").addClass("off");
  	  	$("#modal-header-upload").removeClass("off");
    $("#modal-header-upload").addClass("on");

  }

    WIMedia.faviconupload = function(){
             $("#modal-favicon-edit").removeClass("on");
    $("#modal-favicon-edit").addClass("off");
        $("#modal-favicon-upload").removeClass("off");
    $("#modal-favicon-upload").addClass("on");

  }

  WIMedia.ImageMedia = function(){
   // e.preventDefault();
  var files = files;
  var obj = $("#manmed");
 
     //We need to send dropped files to Server
     handleFileUpload(files,obj);


  }

  WIMedia.Folder = function(folder){
    
     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "folder",
            folder : folder
                    },
        success: function(result)
        {
          $("#images").html(result);
            
        }
    });
  }

  WIMedia.goback= function(){

         $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "back",
                    },
        success: function(result)
        {
          $("#images").html(result);
            
        }
    });
  }
