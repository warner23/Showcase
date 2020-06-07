
$(document).ready(function(event)
{

var obj = $(".stage");
//var drag = $("#draggable li");
obj.on('dragenter', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $(this).css('border', '2px solid #0B85A1');
    $('<li class="stageRow" data-hover-tag="Row" data data-editing-hover-tag="Editing Row" id="dropStage"></li>').insertAfter('ul.stage');
});


obj.on('dragleave', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
    $("#dropStage").remove();

});

obj.on('dragover', function (e) 
{
     e.stopPropagation();
     e.preventDefault();
});

/*drag.on( "dragstart", function( event, ui ) 
{
        event.stopPropagation();
    event.preventDefault();
     $(this).attr("id");
});*/

obj.on('drop', function (e) 
{
 
     $(this).css('border', '2px dotted #0B85A1');
     e.preventDefault();
     //var files = e.originalEvent.dataTransfer.files;
     alert('dropped');
    var mod_name = contents
           // alert(id);
    alert(mod_name);
    WIMod.dropping(mod_name);
 
     //We need to send dropped files to Server
     //handleFileUpload(files,obj,dir);
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

$(document).on('dragstart', function (e) 
{
    e.stopPropagation();
    e.preventDefault();
});




       

               
});


var WIPageBuilder = {};

WIPageBuilder.Rotate = function(){

	if($(".elementsE").hasClass('on') ) {
	$(".elementsE").removeClass('on').addClass('off');
	$(".elementsL").removeClass('off').addClass('on');
	$( "#html" ).removeClass('on').addClass('off');
	$( "#layout" ).removeClass('off').addClass('on');
	}
	if ($(".elementsC").hasClass('on') ) {
	$(".elementsC").removeClass('on').addClass('off');
	$(".elementsE").removeClass('off').addClass('on');
	$( "#common" ).removeClass('on').addClass('off');
	$( "#html" ).removeClass('off').addClass('on');
    }


	
}

WIPageBuilder.RotateX = function(){
	
	    if ($(".elementsE").hasClass('on') ) {
	$(".elementsE").removeClass('on').addClass('off');
	$(".elementsC").removeClass('off').addClass('on');
	$( "#html" ).removeClass('on').addClass('off');
	$( "#common" ).removeClass('off').addClass('on');
    }

	if ($(".elementsL").hasClass('on') ) {
	$(".elementsL").removeClass('on').addClass('off');
	$(".elementsE").removeClass('off').addClass('on');
	$( "#layout" ).removeClass('on').addClass('off');
	$( "#html" ).removeClass('off').addClass('on');
    }

}

WIPageBuilder.Draggable = function(){
	$("#appearing_button").attr('draggable', true);
}

