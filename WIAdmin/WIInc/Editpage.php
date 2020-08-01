<aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Edit Page
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Edit Page</li>
                    </ol>
                </section>

              ```
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->

                    <div class="row">

                         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                          <div class="col-lg-2 col-xs-2 col-md-2" style="float: left;">
                           <label for="select_page" id="page"> Select Page </label>
                          <select id="page_selection">
                          <?php $page->selectPage();   ?>
                          </select>
                          </div>
                      
                          <div class="col-lg-3 col-xs-4 col-xl-2">
                        <label class="col-lg-2 col-xs-2 col-md-2 col-sm-2"  for="page-title" id="page"> Page </label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <input type="text" id="page-title" name="title" placeholder="pagetitle" class="input-xlarge form-control" value=""> <br />
                        </div>
                      </div>

                      <div class="col-lg-3 col-xs-4 col-xl-4">
                        <label class="col-lg-2 col-xs-2 col-md-2 col-sm-2"  for="page-title" id="assigned"> Module Assigned </label>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                          <input type="text" id="mod-assigned" name="mod-assigned" placeholder="mod-assigned" class="input-xlarge form-control" value=""> 
                          <button onclick="WIEditpage.assignMod()">Assign Mod</button>
                        </div>
                      </div>

                    </div>

                    <div class="col-lg-3 col-xs-6 col-xl-12">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">  
                          <div id="page_options">

                           <form>
                           <div class="col-lg-4 col-md-4 col-sm-4">
                              <label>Left Hand Column</label>
                             <label class="switch">
                              <input type="checkbox" id="lsc">
                              <div class="slider round" onclick="WIEditpage.changeLHC()"></div>
                            </label>
                            </div>


                                     <div class="col-lg-4 col-md-4 col-sm-4">
                              <label>Right Hand Column</label>
                             <label class="switch">
                              <input type="checkbox" id="rsc">
                              <div class="slider round" onclick="WIEditpage.changeRHC()"></div>
                            </label>
                            </div>
                           </form>

                          </div>
                      </div>
                    </div>

                    <div class="col-lg-3 col-xs-6 col-xl-12">
                       <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">

                        <div class="sidebar-nav">
               <div class="panelling">
            <div class="panel-wrap">
         

<div id="tabsMenu">

          <button class="prev-group" onclick="WIPageBuilder.RotateX()" title="Prevous Group" type="button" data-toggle="tooltip" data-placement="top" style="float:left;"><img src="WIMedia/Img/mfp-left.png" ></button>
  <ul class="panell">
    <li class="elementsG on">Modules</li>

  </ul>
   <button class="" onclick="WIPageBuilder.Rotate()" title="Next Group" type="button" data-toggle="tooltip" data-placement="top"><img src="WIMedia/Img/mfp-right.png"></button>
  <div id="modules" class="on">
       <div class="module ui-widget-content" id="module">

        </div>
  </div>

</div>
  </div>
</div>
  </div>    
                      </div>
                       <div class="col-lg-8 col-md-8 col-sm-8">  
                          <div class="page" id="pages">

                          </div>
                          
                      </div>
                      <button onclick="WIEditpage.edit()">SAVE</button>
                    </div>
                        

                           
                        </div><!-- ./col -->
                     </div>
                     </section>
                     </aside>

                     <script type="text/javascript" src="WICore/WIJ/WIEditpage.js"></script>


                     <script type="text/javascript">
                       $(document).ready(function(){

                        $('select').on('change', function() {
                           // alert( this.value );

                            WIEditpage.changePage(this.value);

                          })
                       });
                     </script>
<?php
$modal->moduleModal('assign', 'Assign Module', 'WIEditpage', 'assign','Save','');  

?>

