$(document).ready(function(event)
{


    WIMod.Next();
 //executes code below when user click on pagination links
    $("#modList").on( "click", ".pagination a", function (e){
        e.preventDefault();
        $(".loading-div").removeClass('closed'); //remove closed element
        $(".loading-div").addClass('open'); //show loading element
        var page = $(this).attr("data-page"); //get page number from link

             $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "NextModPage",
            page : page
        },
        success: function(result)
        {
            $("#modList").html(result);
              $(".loading-div").removeClass('open'); //remove closed element
        $(".loading-div").addClass('closed'); //show loading element
        }
       
        
    });

 });


        $("a.pagination").on( "click", "a.pagination", function (e){
        e.preventDefault();
        $(".loading-div").removeClass('closed'); //remove closed element
        $(".loading-div").addClass('open'); //show loading element
        var page = $(this).attr("data-page"); //get page number from link

             $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "NextElementsPage",
            page : page
        },
        success: function(result)
        {
            $("#elementsContents").html(result);
              $(".loading-div").removeClass('open'); //remove closed element
        $(".loading-div").addClass('closed'); //show loading element
        }
       
        
    });

 });



});



var WIMod = {}

WIMod.install = function(mod_name){

//alert(mod_name);

 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "mod_install",
            mod_name : mod_name
        },
        success: function(result)
        {
            
        }
    })
}


WIMod.uninstall = function(mod_name){


 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "mod_uninstall",
            mod_name : mod_name
        },
        success: function(result)
        {

        }
    })

}

WIMod.enable = function(mod_name, enable){

//alert(mod_name);
//alert(enable);

 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "mod_enable",
            mod_name : mod_name,
            enable : enable
        },
        success: function(result)
        {
            
        }
    })

}

WIMod.disable = function(mod_name, disable){


 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "mod_disable",
            mod_name : mod_name,
            disable : disable
        },
        success: function(result)
        {

        }
    })

}

WIMod.installElement = function(element_name, author){

//alert(mod_name);

 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "element_install",
            element_name : element_name,
            author   : author
        },
        success: function(result)
        {
            
        }
    })

}


WIMod.uninstall = function(mod_name){


 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "mod_uninstall",
            mod_name : mod_name
        },
        success: function(result)
        {

        }
    })

}

WIMod.enableElement = function(element_name, enable){

 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "Element_enable",
            element_name : element_name,
            enable : enable
        },
        success: function(result)
        {
            
        }
    })

}

WIMod.disableElement = function(element_name, disable){


 $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "mod_disable",
            element_name : element_name,
            disable : disable
        },
        success: function(result)
        {

        }
    })

}

WIMod.drop = function(mod_name){
    //alert("droppped");
    //alert(mod_name);

     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "drop_call",
            mod_name : mod_name
        },
        success: function(result)
        {
            // check to see if another element is there first, if it is place after element
           
           if( $('.coldrop').is(':empty') ){
            alert("div empty");
           // $("#droppable1").html(result);
           $("#droppable1").html(result);
           }else{
alert("div not empty");
$("#droppable1").append(result);
           }
            
        }
    })
}

WIMod.dropping = function(mod_name){
    //alert("droppped");
    //alert(mod_name);

     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "drop_call",
            mod_name : mod_name
        },
        success: function(result)
        {
            $(".stage").html(result);
        }
    })
}


WIMod.displayColums = function(){
    
}

WIMod.Col12 = function(){
         $("#droppable1").html('<div class="col-sm-12 col-md-12 col-lg-12 column_drop " id="col12"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col11 = function(){
         $("#droppable1").html('<div class="col-sm-11 col-md-11 col-lg-11 column_drop " id="col11"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col10 = function(){
         $("#droppable1").html('<div class="col-sm-10 col-md-10 col-lg-10 column_drop " id="col10"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col9 = function(){
         $("#droppable1").html('<div class="col-sm-9 col-md-9 col-lg-9 column_drop " id="col9"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col8 = function(){
         $("#droppable1").html('<div class="col-sm-8 col-md-8 col-lg-8 column_drop " id="col8"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col7 = function(){
         $("#droppable1").html('<div class="col-sm-7 col-md-7 col-lg-7 column_drop " id="col7"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col6 = function(){
         $("#droppable1").html('<div class="col-sm-6 col-md-6 col-lg-6 column_drop " id="col6"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col5 = function(){
         $("#droppable1").html('<div class="col-sm-5 col-md-5 col-lg-5 column_drop " id="col5"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}


WIMod.Col4 = function(){
         $("#droppable1").html('<div class="col-sm-4 col-md-4 col-lg-4 column_drop " id="col4"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col3 = function(){
         $("#droppable1").html('<div class="col-sm-3 col-md-3 col-lg-3 column_drop " id="col3"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}


WIMod.Col2 = function(){
         $("#droppable1").html('<div class="col-sm-2 col-md-2 col-lg-2 column_drop " id="col2"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}

WIMod.Col1 = function(){
         $("#droppable1").html('<div class="col-sm-1 col-md-1 col-lg-1 column_drop " id="col1"></div>')
         $(".column_drop").droppable({
               activeClass: "dropping",
               hoverClass:  "hover",
               drop: function( event, ui ) {
                  $( this )
                  .addClass( "ui-state-highlight" )
                   var container = $(event.target).attr('id')
      alert(container); 

        $( this )
            var mod_name = ui.draggable.attr('id');
          alert(mod_name);
          WIMod.dropping(mod_name, container);
               }
            });

}



WIMod.Col11 = function(){
    var col11 = ('<div class="col-sm-11 col-md-11 col-lg-11 column_drop" id="col11"></div>');
         $("#droppable1").append(col12);

}

WIMod.column = function(mod_name){
    //alert("droppped");
    //alert(mod_name);
 var i = 0;
     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "col_call",
            mod_name : mod_name
        },
        success: function(result)
        {
                     if( $('.dropcol').is(':empty') ){
            alert("div empty");
           // $("#droppable1").html(result);
 i++;

        $("#droppable1").html(result);


           }else{
alert("div not empty");

        $("#droppable1").append(result);
    
        }
    }
    
    })
}



WIMod.columns = function(mod_name, id){
    //alert("droppped");
    //alert(mod_name);

     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "col_call",
            mod_name : mod_name
        },
        success: function(result)
        {
            $("#"+id).html(result);
        }
    })
}

WIMod.editdrop = function(mod_name,  page_id){
    //alert("droppped");
    //alert(mod_name);

     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "edit_drop_mod",
            mod_name : mod_name,
            page_id : page_id
        },
        success: function(result)
        {
            $("#droppable").html(result);
        }
    })
}



 WIMod.Next = function(){
     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "Next"
        },
        success: function(result)
        {
            $("#modList").html(result);
              $(".loading-div").removeClass('open'); //remove closed element
        $(".loading-div").addClass('closed'); //show loading element
        }
       
        
    });
 }

 WIMod.closed = function(){
    $("#modal-edit-title").removeClass("on")
    $("#modal-edit-title").addClass("off")
 }

  WIMod.closed1 = function(){
    $("#modal-edit-para").removeClass("on")
    $("#modal-edit-para").addClass("off")
 }

 WIMod.delete = function(e){
         e.preventDefault();
    $( "#dialog-confirm" ).removeClass( "hide" );
    $( "#dialog-confirm" ).addClass( "show" );
 }

  WIMod.remove = function(e){
         e.preventDefault();
         $( "#remove" ).remove();
 }

   WIMod.removecol = function(e, id){
         e.preventDefault();
         $( "#"+id ).remove();
 }

  WIMod.close = function(e){
         e.preventDefault();
    $( "#dialog-confirm" ).removeClass( "show" );
    $( "#dialog-confirm" ).addClass( "hide" );
 }

  WIMod.createMod = function(){

    var contents = $("#droppable1").html();
    mod_name = $("#mod_name").val();

     $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "createMod",
            contents : contents,
            mod_name   : mod_name
        },
        success: function(result)
        {
           WICore.removeLoadingButton(btn);
           // console.log(result);
            //window.alert(result);
            //parse the data to json
            //var res = JSON.stringify(result);
            var res = JSON.parse(result);
            //var res = $.parseJSON(result);
            console.log(res);
            if(res.status === "success"){
            WICore.displaySuccessMessage($("#result"), res.msg);
                //WICore.displaySuccessMessage($(".msg"), res.msg);
          }

        }
    });
 }

 WIMod.EditMod = function(){
    var title = $("#title").val();
    var para  = $("#history").val();
    var mod_name  = $(".mod").attr('id');

    //alert(title);
    //alert(para);
    //alert(mod_name);

    $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "EditMod",
            title : title,
            para   : para,
            mod_name   : mod_name
        },
        success: function(result)
        {
           WICore.removeLoadingButton(btn);
           // console.log(result);
            //window.alert(result);
            //parse the data to json
            //var res = JSON.stringify(result);
            var res = JSON.parse(result);
            //var res = $.parseJSON(result);
            console.log(res);
            if(res.status === "success"){
            WICore.displaySuccessMessage($("#result"), res.msg);
                //WICore.displaySuccessMessage($(".msg"), res.msg);
          }

        }
    });
 }

WIMod.multiLang = function(){

    $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "multiLang"
        },
        success: function(result)
        {
            //alert(result);
            WIMod.modEdit(result);
        }
    })
}

WIMod.multiLangtext = function(){

    $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "multiLang"
        },
        success: function(result)
        {
            //alert(result);
            WIMod.modEdittext(result);
        }
    })
}

 WIMod.modEdittext = function(multiLang){

    
    //alert(multiLang);
    if(multiLang === "on"){
         $("#modal-edit-para").removeClass("off")
    $("#modal-edit-para").addClass("on")
}else{
   //alert("multi off");
}
   
}

 WIMod.modEdit = function(multiLang){

    
    //alert(multiLang);
    if(multiLang === "on"){
         $("#modal-edit-title").removeClass("off")
    $("#modal-edit-title").addClass("on")
}else{
   //alert("multi off");
}
   
}

WIMod.editPageTrans = function(){
        var code = $("#lang_name").val();
    var keyword  = $("#keyword").val();
    var trans  = $("#translation").val();
    var mod_name  = $(".mod").attr('id');

var btn = $("#btn-trans");
WICore.loadingButton(btn, $_lang.logging_in);
        $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "EditModLang",
            code : code,
            keyword   : keyword,
            trans   : trans,
            mod_name   : mod_name
        },
        success: function(result)
        {
           WICore.removeLoadingButton(btn);
           // console.log(result);
            //window.alert(result);
            //parse the data to json
            //var res = JSON.stringify(result);
            var res = JSON.parse(result);
            //var res = $.parseJSON(result);
            console.log(res);
            if(res.status === "success"){
        $("#modal-edit-title").removeClass("on")
    $("#modal-edit-title").addClass("of")
    var input = $( "#title" );
input.val( input.val() + res.trans );
            //$("#title").text(res.trans);
            WICore.displaySuccessMessage($("#result"), res.msg);
                //WICore.displaySuccessMessage($(".msg"), res.msg);
          }

        }
    });
}

WIMod.editPageTransPara = function(){
        var code = $("#lang_namep").val();
    var keyword  = $("#keywordp").val();
    var trans  = $("#translationp").val();
    var mod_name  = $(".mod").attr('id');

var btn = $("#btn-trans");
WICore.loadingButton(btn, $_lang.logging_in);
        $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "EditModLangpara",
            code : code,
            keyword   : keyword,
            trans   : trans,
            mod_name   : mod_name
        },
        success: function(result)
        {
           WICore.removeLoadingButton(btn);
           // console.log(result);
            //window.alert(result);
            //parse the data to json
            //var res = JSON.stringify(result);
            var res = JSON.parse(result);
            //var res = $.parseJSON(result);
            console.log(res);
            if(res.status === "success"){
        $("#modal-edit-para").removeClass("on")
    $("#modal-edit-para").addClass("of")
    var input = $( "#history" );
input.val( input.val() + res.trans );
            //$("#title").text(res.trans);
            WICore.displaySuccessMessage($("#result"), res.msg);
                //WICore.displaySuccessMessage($(".msg"), res.msg);
          }

        }
    });
}


WIMod.nextElement = function(page){

        $(".loading-div").removeClass('closed'); //remove closed element
        $(".loading-div").addClass('open'); //show loading element
        //var page = $(this).attr("data-page"); //get page number from link

             $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
            action : "NextElementsPage",
            page : page
        },
        success: function(result)
        {
            $("#elementsContents").html(result);
              $(".loading-div").removeClass('open'); //remove closed element
        $(".loading-div").addClass('closed'); //show loading element
        }
       
    });
}


WIMod.nextMod = function(page){

        $(".loading-div").removeClass('closed'); //remove closed element
        $(".loading-div").addClass('open'); //show loading element
        //var page = $(this).attr("data-page"); //get page number from link

             $.ajax({
        url: "WICore/WIClass/WIAjax.php",
        type: "POST",
        data: {
           action : "NextModPage",
            page : page
        },
        success: function(result)
        {
            $("#elementsContents").html(result);
              $(".loading-div").removeClass('open'); //remove closed element
        $(".loading-div").addClass('closed'); //show loading element
        }
       
    });
}
 

