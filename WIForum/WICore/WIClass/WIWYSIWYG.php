<?php


class WIWYSIWYG
{
	function __contruct(){
	    $this->WIdb = WIdb::getInstance();
	}

  public function Editor()
  {
    echo '<div class="editor">
            <div class="editor-control" id="editor-control">
            <div class="toolbar" id="toolbar">
              <a href="javascript:void(0);" data-command="undo"><i class="fa fa-undo"></i></a>
            <a href="javascript:void(0);" data-command="redo"><i class="fa fa-repeat"></i></a>
            <div class="fore-wrapper closed" onclick="WIWYSIWYG.ForeWrapper()" id="fore-wrapper"><i class="fa fa-font" style="color:#C96;"></i>
              <div class="fore-palette hide" id="fore-palette">
              </div>
            </div>
            <div class="back-wrapper closed" onclick="WIWYSIWYG.BackWrapper()" id="back-wrapper"><i class="fa fa-font" style="background:#C96;"></i>
              <div class="back-palette hide" id="back-palette">
              </div>
            </div>
            <a href="javascript:void(0);" data-command="bold"><i class="fa fa-bold"></i></a>
            <a href="javascript:void(0);" data-command="italic"><i class="fa fa-italic"></i></a>
            <a href="javascript:void(0);" data-command="underline"><i class="fa fa-underline"></i></a>
            <a href="javascript:void(0);" data-command="strikeThrough"><i class="fa fa-strikethrough"></i></a>
            <a href="javascript:void(0);" data-command="justifyLeft"><i class="fa fa-align-left"></i></a>
            <a href="javascript:void(0);" data-command="justifyCenter"><i class="fa fa-align-center"></i></a>
            <a href="javascript:void(0);" data-command="justifyRight"><i class="fa fa-align-right"></i></a>
            <a href="javascript:void(0);" data-command="justifyFull"><i class="fa fa-align-justifyFull"></i></a>
            <a href="javascript:void(0);" data-command="indent"><i class="fa fa-indent"></i></a>
            <a href="javascript:void(0);" data-command="outdent"><i class="fa fa-outdent"></i></a>
            <a href="javascript:void(0);" data-command="insertUnorderedList"><i class="fa fa-list-ul"></i></a>
            <a href="javascript:void(0);" data-command="insertOrderedList"><i class="fa fa-list-ol"></i></a>
            <a href="javascript:void(0);" data-command="h1">H1</a>
            <a href="javascript:void(0);" data-command="h2">H2</a>
            <a href="javascript:void(0);" data-command="createlink"><i class="fa fa-link"></i></a>
            <a href="javascript:void(0);" data-command="unlink"><i class="fa fa-unlink"></i></a>
            <a href="javascript:void(0);" data-command="insertimage"><i class="fa fa-image"></i></a>
            <a href="javascript:void(0);" data-command="p">P</a>
            <a href="javascript:void(0);" data-command="subscript"><i class="fa fa-subscript"></i></a>
            <a href="javascript:void(0);" data-command="superscript"><i class="fa fa-superscript"></i></a>
            <a href="javascript:void(0);" data-command="code"><i class="fa fa-code"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-quote"></i></a>
            <a href="javascript:void(0);"<i class="fa fa-hr"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-lorem"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-undo"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-rotate-right"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-select"></i></a>
            <a href="javascript:void(0);"><i class="fa fa-intro"></i></a>
            <a href="javascript:void(0);" id="eye" title="Preview">
            <i class="fa fa-eye"></i></a>
            </div>
            <textarea class="editor-area" id="editor-area" placeholder="Start here..">

        <h2>Html editor </h2>

        <p>Click in eye to see the result.</p>

        <p>Graece donan, Latine voluptatem vocant. <i>Hoc sic expositum dissimile est superiori.</i> Tria genera bonorum; Nam Pyrrho, Aristo, Erillus iam diu abiecti. <b>Ratio quidem vestra sic cogit.</b> </p>


            </textarea>
          
          <div class="result"></div>
          <script type="text/javascript">';

             echo " $('.toolbar a').click(function(e) {
              console.log('clicked');

              var textarea = document.getElementById('editor-area');  
var selection = (textarea.value).substring(textarea.selectionStart,textarea.selectionEnd);
 console.log(selection);

  var command = $(this).data('command');
  console.log(command);

  if (command == 'h1' || command == 'h2' || command == 'p') {
    console.log('h1');
    document.execCommand('formatBlock', false, command);
  }
  if (command == 'forecolor' || command == 'backcolor') {
    document.execCommand($(this).data('command'), false, $(this).data('value'));
  }
    if (command == 'createlink' || command == 'insertimage') {
  url = prompt('Enter the link here: ','http:\/\/'); document.execCommand($(this).data('command'), false, url);
  }

  else window.document.execCommand($(this).data('command'), false, selection);

  const newElement = document.createElement($(this).data('command'));
  newElement.append(selection);
  console.log(newElement);
    var text = $('#editor-area').html();
    //var markUp = text.replace(selection, newElement.outerHTML);
    //console.log(markUp);
    $('#editor-area').html(text.replace(selection, newElement.outerHTML));

});
    


// the eye
var e = document.querySelector(`#eye`),
    i =  document.querySelector(`#editor-area`),
    o = document.querySelector(`.result`);

e.onclick = function(){ 
   o.innerHTML = i.value;
   o.classList.toggle(`show`);
   this.classList.toggle(`active`);
}

</script></div></div>";


  }


	
}


?>