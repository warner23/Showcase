<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<div class="row edit toolbox-reset">

<div class="col-md-12 col-sm-12 col-lg-12">
              <h1 class="emphasized3"> Create Custom Modules </h1>
              <div id="wresults"></div>
              </div>

                <nav class="navbar navbar-default" style="margin-top: 10%;">
<!--       <div class="navbar-header" style="margin-right: 100px;">
        <a class="navbar-brand emphasized3" href="javascript:void(0);">
        </a>
      </div> -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-3">
        <ul class="nav navbar-nav">
          <li class="resizeCanvas">
            <div class="btn-group" style="margin-right: 20px;width: 100%;">
              <button onclick="resizeCanvas('lg')" class="btn btn-default navbar-btn"><i class="fa fa-desktop"></i> </button>
              <button onclick="resizeCanvas('md')" class="btn btn-default navbar-btn"><i class="fa fa-laptop"></i> </button>
              <button onclick="resizeCanvas('sm')" class="btn btn-default navbar-btn"><i class="fa fa-tablet"></i> </button>
              <button onclick="resizeCanvas('xs')" class="btn btn-default navbar-btn"><i class="fa fa-mobile-phone"></i> </button>
            </div>
          </li>
          <li class="dev">
            <div class="btn-group" data-toggle="buttons-radio" style="width: 100%;">
              <button id="edit" class="btn btn-default navbar-btn">
                <i class="fa fa-edit"></i> Edit
              </button>
              <button type="button" class="btn btn-default navbar-btn" id="devpreview">
                <i class="fa icon-eye-close" style="color: #333;"></i> Developer
              </button>
              <button type="button" class="btn btn-default navbar-btn" id="sourcepreview" >
                <i class="fa icon-eye-open" style="color: #333;"></i> Preview
              </button>
            </div>
          </li>
          <li class="mod1">
            <div class="col-md-12 col-lg-8 col-xs-4">
          <input type="text" name="mod_name" id="mod_name" placeholder="Module Name" class="module_name_input"  autofocus>
          <button type="button" class="btn btn-primary" rel="/build/downloadModal" role="button" data-toggle="modal" data-target="#downloadModal" id="downloadModal">
                <i class="fa icon-chevron-down" ></i>Save
              </button>
          </div>
          </li>
        </ul>

      </div>
    </nav>


<div class="sidebar-nav">
               <div class="panelling">
            <div class="panel-wrap">
         

<div id="tabsMenu">

          <button class="prev-group" onclick="WIPageBuilder.RotateX()" title="Prevous Group" type="button" data-toggle="tooltip" data-placement="top" style="float:left;"><img src="WIMedia/Img/mfp-left.png" ></button>
  <ul class="panell">
    <li class="elementsG on">Grid</li>
    <li aria-hidden="true" class="elementsB off">Base</li>
    <li aria-hidden="true" class="elementsC off">Components</li>
    <li aria-hidden="true" class="elementsF off">Forms</li>
    <li aria-hidden="true" class="elementsJ off">Javscript</li>
    <li aria-hidden="true" class="elementsM off">Modules</li>
    <li aria-hidden="true" class="elementsA off">Actions</li>
  </ul>
   <button class="" onclick="WIPageBuilder.Rotate()" title="Next Group" type="button" data-toggle="tooltip" data-placement="top"><img src="WIMedia/Img/mfp-right.png"></button>
  <div id="grid" class="on">
    <?php  $mod->ActiveElementsGrid()  ?>
  </div>
  <div id="base" class="off">
    <?php  $mod->ActiveElementsBase()  ?>
  </div>
  <div id="components" class="off">
        <?php  $mod->ActiveElementsComponents()  ?>
  </div>

  <div id="forms" class="off">
        <?php  $mod->ActiveElementsForms()  ?>
  </div>
  <div id="javascript" class="off">
        <?php  $mod->ActiveElementsJavascript()  ?>
  </div>
    <div id="modulesM" class="off">
        <?php  $mod->ActiveElementsModules()  ?>
  </div>
  <div id="actionsA" class="off">
        <?php  $mod->ActiveElementsActions()  ?>
  </div>

</div>
  </div>
</div>
  </div>

    <div class="container-fluid" style="margin-left: 225px;margin-top: 10px;padding: 30px 15px 15px;border: 1px solid #DDDDDD;border-radius: 4px;position: relative;word-wrap: break-word;">
      <div class="changeDimension">
        <div class="row-fluid">
          <div class="">
            <span></span>
           </div>

 <div class="WI ui-sortable" style="min-height: 304px; ">
            <div class="wicreate">

              
              <a href="#close" class="remove label label-important">
                <i class="icon-remove icon-white"></i>
                remove
              </a>
              <span class="drag label">
                <i class="icon-move"></i>
              drag
            </span>
            <span class="configuration">
                      <button type="button" class="btn btn-mini" role="b utton" id="editorModal" onclick="WIScript.Editor();">Editor</button>
                      <a class="btn btn-mini" href="javascript:void(0);" rel="well">Well</a> 
                    </span>
              <div class="preview">12</div>
              <div class="view">
            <div class="col-lg-12 col-md-12 col-sm-12 column ui-sortable" >
              <div class="box box-element ui-draggable" style="display: block; ">
              <a href="#close" class="remove label label-important">
                <i class="icon-remove icon-white"></i>
                remove
              </a>
              <span class="drag label">
                <i class="icon-move"></i>
              drag
            </span>
            <span class="configuration">
                      <button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal" onclick="WIScript.Editor();">Editor</button> 
                      <a class="btn btn-mini" href="#" rel="well">Well</a> 
                    </span>

                    <div class="preview">Jumbotron</div>
                      <div class="view">
              <div class="intro_box hero-unit" contenteditable="true">
              <h1><span>Hello, world!</span></h1>
              <p>This is a template for a simple marketing or informational website.
                          It includes a large callout called the hero unit and three supporting pieces of content.
                          Use it as a starting point to create something more unique.</p>
              </div>
            </div>
          </div>
          </div>
        </div>
        
      





              
            </div>
          </div>


         <div id="download-layout">
            <div class="container-fluid">
            </div>
          </div>
        </div>
       
      </div>
      
         <?php  
 $modal->moduleModal('editorModal', 'WIEditor', 'WIScript', 'SaveContent','Save', 'modalEditorButton'); 
 $modal->moduleModal('downloadingModal', 'Save', 'WIScript', 'saveHtml','Save','');

 $modal->moduleModal('media-edit', 'Change media', 'WIMedia', 'pagemedia','Save',''); 
 $modal->moduleModal('media-media', 'Change Media', 'WIMedia', 'PageMediaPics','Save',''); 
 $modal->moduleModal('media-upload', 'Upload Media', 'WIMedia', 'PageMediaUploadPics','Save','');
   ?>

    <script>
      function resizeCanvas(size)
      {

      var containerID = document.getElementsByClassName("changeDimension");
      var containerDownload = document.getElementById("download-layout").getElementsByClassName("container-fluid")[0];
      var row = document.getElementsByClassName("demo ui-sortable");
      var container1 = document.getElementsByClassName("container1");
      if (size == "md")
      {
      $(containerID).width('id', "MD");
      $(row).attr('id', "MD");
      $(container1).attr('id', "MD");
      $(containerDownload).attr('id', "MD");
      }
      if (size == "lg")
      {
      $(containerID).attr('id', "LG");
      $(row).attr('id', "LG");
      $(container1).attr('id', "LG");
      $(containerDownload).attr('id', "LG");
      }
      if (size == "sm")
      {
      $(containerID).attr('id', "SM");
      $(row).attr('id', "SM");
      $(container1).attr('id', "SM");
      $(containerDownload).attr('id', "SM");
      }
      if (size == "xs")
      {
      $(containerID).attr('id', "XS");
      $(row).attr('id', "XS");
      $(container1).attr('id', "XS");
      $(containerDownload).attr('id', "XS");

      }


      }
    </script>




                    </div><!-- /.row --> 


              