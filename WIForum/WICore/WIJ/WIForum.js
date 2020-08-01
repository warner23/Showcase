$(document).ready(function(){

  $("#opencatModal").click(function(e){
    event.preventDefault();
    $("#modal-new-cat-details").removeClass('hide').addClass('show')
  });

    $("#opensectionModal").click(function(e){
        event.preventDefault();
    $("#modal-new-section-details").removeClass('hide').addClass('show')
  });

});

var WIForum = {};

WIForum.cat = function(){

}


WIForum.select_cat = function(){

}

WIForum.ForumCategory = function(e){
    event.preventDefault();

    var new_cat = $("#cat_name").val();

        Cat = {
        CatData:{
            new_cat           : new_cat
        },
        FieldId:{
            new_cat           : "new_cat"
        }
     };

     $(".ajax-loading").removeClass('hide').addClass('show');
        $.ajax({
            type: 'POST',
            url: 'WICore/WIClass/WIAjax.php',
            data: {
              action   : "new_category",
              Cat : Cat              
            },
            success: function (result) {
            var res = JSON.parse(result);

                if(res.status == "completed"){
                $(".ajax-loading").removeClass('show').addClass('hide');
                WICore.Refresh();
                }
            }
    });

}


WIForum.ForumSection = function(e){

        event.preventDefault();

    var new_section = $("#section_name").val()
     cat = $( "#category_selector option:selected" ).val();

        Section = {
        SectionData:{
            new_section           : new_section,
            cat                   : cat
        },
        FieldId:{
            new_section           : "new_section",
            cat                   : "cat"
        }
     };

     $(".ajax-loading").removeClass('hide').addClass('show');
        $.ajax({
            type: 'POST',
            url: 'WICore/WIClass/WIAjax.php',
            data: {
              action   : "new_section",
              Section : Section              
            },
            success: function (result) {
            var res = JSON.parse(result);

                if(res.status == "completed"){
                $(".ajax-loading").removeClass('show').addClass('hide');
                WICore.Refresh();
                }
            }
    });
}

WIForum.DeleteCategory = function(){
    var id = $(".delete_id").attr('id');
    console.log(id);
        $(".ajax-loading").removeClass('hide').addClass('show');
        $.ajax({
            type: 'POST',
            url: 'WICore/WIClass/WIAjax.php',
            data: {
              action   : "delete_category",
              id : id              
            },
            success: function (result) {
            var res = JSON.parse(result);

                if(res.status == "completed"){
                $(".ajax-loading").removeClass('show').addClass('hide');
                WICore.Refresh();
                }
            }
    });
}

WIForum.SCF = function(id){
    $("#category-"+id).addClass('ui-state-active');
    console.log(id);
        $.ajax({
            type: 'POST',
            url: 'WICore/WIClass/WIAjax.php',
            data: {
              action   : "scf",
              id : id              
            },
            success: function (result) {
            //var res = JSON.parse(result);
            $('ul#forum_section').empty()
            $("ul#forum_section").html(result);
            }
    });
}

WIForum.CSF = function(id){
    $("#section-"+id).addClass('ui-state-active');
    console.log(id);
        $.ajax({
            type: 'POST',
            url: 'WICore/WIClass/WIAjax.php',
            data: {
              action   : "csf",
              id : id              
            },
            success: function (result) {
            //var res = JSON.parse(result);
            $('ul#postviewer').empty()
            $("ul#postviewer").html(result);
            }
    });
}

WIForum.CreatePost = function(cat_id, section_id){
    console.log(cat_id);
    $.ajax({
            type: 'POST',
            url: 'WICore/WIClass/WIAjax.php',
            data: {
              action   : "createpost",
              cat_id : cat_id,
              section_id : section_id          
            },
            success: function (result) {
            $(result).insertAfter('ul#postviewer>li:last');
            WIWYSIWYG.palettes();
            $('#forumCreatePost').remove();
            }
    });  
}


WIForum.ShowEditCategory = function(id){
    $("#modal-edit-cat-details").removeClass('hide').addClass('show')
}

WIForum.DeleteCategoryModel= function(id){
    console.log(id);
    $(".delete_id").attr("id",id);
    $("#modal-delete-cat-details").removeClass('hide').addClass('show');
}

WIForum.newPost = function(cat_id, section_id){

    

    var fposting = tinyMCE.get('mytextarea').getContent();
        title = $("#title").val();

        console.log(fposting);
        if (fposting == "") 
        {
            alert("Post cant be empty.");
        }

        $.ajax({
            type: 'POST',
            url: 'WICore/WIClass/WIAjax.php',
            data: {
              action   : "new_post",
              cat_id : cat_id,
              section_id : section_id,
              fposting    : fposting,
              title  : title       
            },
            success: function (result) {
           var res = JSON.parse(result);
            WIForum.CSF(res.id);
            }
    });

}
