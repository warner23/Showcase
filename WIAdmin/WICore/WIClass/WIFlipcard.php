<?php
/**
* Maintenace Class
* Created by Warner Infinity
* Author Jules Warner
*/

class WIFlipcard
{
	public function __construct()
	{
		$this->WIdb = WIdb::getInstance();

	}

	public function Flipcard()
	{
		echo '<div class="item  col-xs-4 col-lg-4 col-md-4">
        <div class="flipcard-' . $show['id'] . '">
        <span class="btn-edit editing-' . $show['id'] . '">Edit</span>
        <span class="btn-edit show-delete" onclick="WIShow.delete(`' . $show['id'] . '`);">Delete</span>
        <div class="back">';
           	self::backSideFlip();
         echo '</div>

                  
        
         <div class="front text-center">';
         	self::frontSideFlip();
          echo '</div>
              </div>

              <style>
               .editing-' . $show['id'] . '{
                        background-color: #bf6cda;
                      color: white;
                      perspective: 638px;
                      margin-left: 10px;
                      margin-top: 10px;
                  }
                    .flipcard-' . $show['id'] . ' {
                      position: relative;
                      width: 100%;
                      height: 200px;
                      perspective: 638px;
                      margin: 0px 6px 10px 0px;
                  }
                  .flipcard-' . $show['id'] . '.flip .front {
                    transform: rotateY(180deg);
                  }
                  .flipcard-' . $show['id'] . '.flip .back {
                    transform: rotateY(0deg);
                  }
                  .flipcard-' . $show['id'] . ' .back{
                    transform: rotateY(-180deg);
                  }
                  .flipcard-' . $show['id'] . ' .front, .flipcard-' . $show['id'] . ' .back
                  {
                      background-color: #eae8e8;
                      border: 1px solid #222;
                      border-radius: 5px;
                      box-shadow: 0 5px 15px rgba(0,0,0,.5);
                      position: absolute;
                      width: 100%;
                      height: 100%;
                      box-sizing: border-box;
                      transition: all 1s ease 0s;
                      color: #a94442;
                      padding: 10px 5px;
                      backface-visibility: hidden;
                      top: 5px;
                      z-index: -1;
                  }
                    </style>
                              <script type="text/javascript">
                              $(document).ready(function(){

                               $(".editing-' . $show['id'] . '").on("click", function(event) {
                                event.stopPropagation();
                                $(".flipcard-' . $show['id'] . '").toggleClass("flip");
                                          });

                              var obj = $("#dragandrophandler-' . $show['id'] . '");
                              var dir = $(".supload").attr("value");
                              var ele_id = $(".img-preview-' . $show['id'] . '").attr("id");

                            obj.on("dragenter", function (e) 
                            {
                                e.stopPropagation();
                                e.preventDefault();
                                $(this).css("border", "2px solid #0B85A1");
                            });
                            obj.on("dragover", function (e) 
                            {
                                 e.stopPropagation();
                                 e.preventDefault();
                            });
                            obj.on("drop", function (e)
                            {
                             
                                 $(this).css("border", "2px dotted #0B85A1");
                                 e.preventDefault();
                                 var files = e.originalEvent.dataTransfer.files;
                                 //We need to send dropped files to Server
                                 showCreationhandleFileUpload(files,obj, dir, ele_id);
                            });
                            $(document).on("dragenter", function (e) 
                            {
                                e.stopPropagation();
                                e.preventDefault();
                            });
                            $(document).on("dragover", function (e)
                            {
                            e.stopPropagation();
                              e.preventDefault();
                              obj.css("border", "2px dotted #0B85A1");
                            });
                            $(document).on("drop", function (e) 
                            {
                                e.stopPropagation();
                                e.preventDefault();
                            });

                            });
                            </script>';
	}

	public function frontSideFlip()
	{
		echo '<div class="front text-center">
         <div class="item">
            <div class="thumbnail">
                <a class="show_link" id="'. $show['id'].'" href="show.php" ><img class="group list-group-image" style="border-radius: 36px;" src="WIAdmin/WIMedia/Img/shows/'. $photo.'" alt="'. $show['name'].'" /></a>
                <div class="caption">
                    <h4 class="group inner list-group-item-headings">
                       <p class="showP"><a class="show_link" id="'. $show['id'].'" href="show.php" >'. $show['name'].'</a></p></h4>
                                <p class="showP"><a class="theatre_link" id="'. $show['theatre_id'].'" href="theatre.php" >'. $show['theatre'].'</a></p>
                                <p class="group inner list-group-item-text">
                        '. $show['theatre_company'].'</p>
                        </div>
                        

                    
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <p class="lead">
                                                    </div>
                </div>
            </div>
            </div>
              </div>';
	}

	public function backSideFlip()
	{
		echo ' <div class="back">
           <div class="item  col-xs-4 col-lg-4">
            <div class="thumbnail">
            <div class="col-xs-12 col-md-6">
                            <a class="show_link" id="'. $show['id'].'" href="show.php" >'. $show['name'].'</a>
                        </div>
                <img class="group list-group-image" style="border-radius: 36px;" src="WIAdmin/WIMedia/Img/shows/'. $photo.'" alt="'. $show['name'].'" />
                <div class="caption">
                    <h4 class="group inner list-group-item-heading">
                       <p><a class="show_link" id="'. $show['id'].'" href="show.php" >'. $show['name'].'</a></p></h4>
                      <p> </p>
                                <p><a class="theatre_link" id="'. $show['theatre_id'].'" href="theatre.php" >'. $show['theatre'].'</a></p>
                              <p class="group inner list-group-item-text stbio">
                        '. $show['theatre_company'].'</p>  
                        </div>
                        
            </div>
            </div>
                  </div>';
	}



}