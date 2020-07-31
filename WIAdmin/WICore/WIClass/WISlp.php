<?php

class WISlp
{

    public function __construct() {
        $this->WIdb = WIdb::getInstance();
         $this->Perm = new WIPermissions();
        $this->user   = new WIUser(WISession::get('user_id'));
    }

   

    public function flipcard()
    {

        $sound = $this->WIdb->select("SELECT * FROM `wi_sounds` ORDER BY RAND() LIMIT 3");
        $placement  = $this->WIdb->select("SELECT * FROM `wi_sound_placement` ORDER BY RAND()LIMIT 3");
        $cards  = $this->WIdb->select("SELECT * FROM `wi_flashcard` LIMIT 3");

       if($this->user->isAdmin() ){
        self::userIsAdmin($sound, $placement,$cards);

      }else if($this->Perm->hasPermission(WISession::get('user_id'), "2", "cards", "edit" ) )
      {
        self::userHasPermission($sound, $placement,$cards);

      }else{
          self::JustGuest($sound, $placement,$cards);
          }
    }

    public function userIsAdmin()
    {
          echo 'adim';
    }

    public function userHasPermission()
    {
         echo 'has perm';
    }

    public function JustGuest()
    {
      echo 'guest';    
    }


    public function slpManager()
    {
        $categories  = $this->WIdb->select("SELECT * FROM `wi_slp_categories`");

        echo '<script>
  $( function() {

    var index = "key";
    //  Define friendly data store name
    var dataStore = window.sessionStorage;
    //  Start magic!
    try {
        // getter: Fetch previous value
        var oldIndex = dataStore.getItem(index);
    } catch(e) {
        // getter: Always default to first tab in error state
        var oldIndex = 0;
    }

    $( "#tabs1" ).tabs({
        // The zero-based index of the panel that is active (open)
        active : oldIndex,
        // Triggered after a tab has been activated
        activate : function( event, ui ){
            //  Get future value
            var newIndex = ui.newTab.parent().children().index(ui.newTab);
            //  Set future value
            dataStore.setItem( index, newIndex ) 
        }
    }); 

    
    });
  </script>
  <div id="tabs1">
        <ul>';
        foreach($categories as $res){
          echo '<li><a href="#tabs-' .$res['id'] .'">' .$res['type'] .'</a></li>';
        }
        echo '</ul>';
        foreach($categories as $res){
          echo '<div id="tabs-' .$res['id'] .'">';

                  $type = $res['type'];
                  self::type($type);
                  $type = strtolower($type);
                        if (strpos($type," ") != false){
                          $type = str_replace(" ", "_", $type);
                        }
                  //include_once dirname(dirname(dirname(__FILE__))) .'/WIInc/site/slp/'.$type.'.php';

        echo '</div>';
        }
      echo '</div>';
    }

    public function type($type)
    {
      $slp = strtolower($type);

      if (strpos($slp," ") != false){
          $slp = str_replace(" ", "_", $slp);
        }
      echo '<form  class="form-horizontal database-form" id="' .$type .'">
                      <fieldset>
                        <div id="legend">
                          <legend class="">' .$type .'</legend>
                        </div>

                        <div class="col-lg-12">';
                        
                        if($slp =="sounds"){
                          self::editSlpSounds();
                        }elseif($slp == "sound_placement"){
                          self::editslpSoundPlacement();
                        }elseif($slp == "flashcard"){
                          self::editslpFlashcards();
                        }
                           
                        echo '</div>
                              <div class="form-group">
                        <!-- Button -->
                        <div class="controls col-lg-offset-4 col-lg-8">
                           <button id="add_lang_btn" onclick="WILang.AddLangModal()" class="btn btn-success" >Add</button> 
                        </div>
                      </div>
                      <div class="results" id="results"></div>
                    </fieldset>
                        <br /><br />
                  </form>';

    }


    public function soundCard()
    {
     $sound = $this->WIdb->select("SELECT * FROM `wi_sounds` ORDER BY RAND()");

     echo '<div class="horirow">';
     foreach($sound as $res){
      echo '<button class="btn tile" onclick="slp.play(`'. $res['play_id'].'-'. $res['id'].'`);">
        <input id="'. $res['play_id'].'-'. $res['id'].'" type="hidden" class="" value="'. $res['name'].'">'. $res['name'].'</button>
        ';
     }

     echo '</div>';

    }

    public function soundPlacement()
    {
      $placement  = $this->WIdb->select("SELECT * FROM `wi_sound_placement` ORDER BY RAND()");

       echo '<div class="vertirow">
        <button class="btn tile" onclick="slp.play(`placement`);">
        <input id="placement" type="hidden" class="" value="'. $placement[0]['WI'].'">'. $placement[0]['WI'].'</button>
        <button class="btn tile" onclick="slp.play(`placement1`);">
        <input id="placement1" type="hidden" class="" value="'. $placement[1]['WM'].'">'. $placement[1]['WM'].'</button>
        <button class="btn tile" onclick="slp.play(`placement2`);">
        <input id="placement2" type="hidden" class="" value="'. $placement[2]['WF'].'">'. $placement[2]['WF'].'</button>
         </div>';
    }

    public function editSlpSounds()
    {
      $sound = $this->WIdb->select("SELECT * FROM `wi_sounds`");

      echo '<div class="col-xs-12 col-lg-12" id="sounding">
       <div class="horirow">';

      foreach($sound as $res){
            echo '<div class="col-xs-6 col-lg-6" id="sounding">
            <div class="col-sm-4 col-md-4 col-lg-4">
            <button class="btn tile" onclick="slp.play(`$type`);">
          <input id="$type" type="hidden" class="" value="'. $res['name'].'">
            '. $res['name'].'
            </button>
            </div>
            <div class="col-sm-1 col-md-1 col-lg-1">
            <a href="javascript:void(0);" onclick="WICSS.editcssCode(`' . $res['id'].'`)">
            <i class="fa fa-edit"></i>
            </a>
            </div>

            <div class="col-sm-1 col-md-1 col-lg-1">
            <a href="javascript:void(0);"" onclick="WICSS.CssDelete(' . $res['id'].')">
            <i class="fa fa-trash"></i>
            </a>
            </div></div>';
      }

      echo '</div>
     </div>';
    }

    public function editslpSoundPlacement()
    {
      $placement  = $this->WIdb->select("SELECT * FROM `wi_sound_placement` ORDER BY RAND()");

      echo '<div class="vertirow">';

      foreach ($placement as $key => $value) {
        echo $value;
        echo '<button class="btn tile" onclick="slp.play(`placement`);">
        <input id="placement" type="hidden" class="" value="'. $value.'">'. $value.'</button>
        <div class="col-sm-1 col-md-1 col-lg-1">
            <a href="javascript:void(0);" onclick="WICSS.editcssCode()">
            <i class="fa fa-edit"></i>
            </a>
            </div>

            <div class="col-sm-1 col-md-1 col-lg-1">
            <a href="javascript:void(0);"" onclick="WICSS.CssDelete()">
            <i class="fa fa-trash"></i>
            </a>
            </div>';
      }
       echo '</div>';
    }

    public function slpFlashcards()
    {

      $cards  = $this->WIdb->select("SELECT * FROM `wi_flashcard` LIMIT 3");
      foreach($cards as $card){
      echo '<div class="flashcards-' . $card['id'] . ' hide" id="flashy-'. $card['id'].'">
                  <div class="front">
                  <div class="caption">
                    <h4 class="group inner list-group-item-headings">
                       <p class="cardsP">
            <span class="btn-edit flash-' . $card['id'] . '">'. $card['name'].'</span>
                       </p>
                       </h4>
                  </div>
                  <div class="thumbnail flash" id="flash">
                <a class="cards_link" id="'. $card['id'].'" href="javascript:void(0);" onclick="slp.NextFlash(`'. $card['id'].'`,`'. $card['id'] .'`);"><img class="group list-group-image" style="border-radius: 36px;" src="WIMedia/Img/flashcards/'. $card['img'].'" alt="'. $card['name'].'" /></a>
              </div>
              </div>
                  <div class="back">
                  <div class="caption">
                    <h4 class="group inner list-group-item-headings">
                       <p class="cardsP">
            <span class="btn-edit flash-' . $card['id'] . '">'. $card['name'].'</span>
                       </p>
                       </h4>
                  </div>
                  <div class="thumbnail hide flash" id="flash">
                <a class="cards_link" id="'. $card['id'].'" href="javascript:void(0); onclick="slp.NextFlash(`'. $card['name'].'`);"><img class="group list-group-image" style="border-radius: 36px;" src="WIMedia/Img/flashcards/'. $card['img'].'" alt="'. $card['name'].'" /></a>
              </div></div>
              </div>';

              echo '<style>
              .flashcards-' . $card['id'] . ' {
                position: relative;
                width: 100%;
                height: auto;
                perspective: 638px;
                margin: 0px 0px 0px 1px;
                  }

                  .flash-' . $card['id'] . '{
                        background-color: #bf6cda;
                      color: white;
                      perspective: 638px;
                      margin-left: 10px;
                      margin-top: 10px;
                  }
                  .flashcards-' . $card['id'] . '.flip .front {
                    transform: rotateY(180deg);
                  }
                  .flashcards-' . $card['id'] . '.flip .back {
                    transform: rotateY(0deg);
                  }
                  .flashcards-' . $card['id'] . ' .back{
                    transform: rotateY(-180deg);
                  }
                  .flashcards-' . $card['id'] . ' .front, .flashcards-' . $card['id'] . ' .back
                  {
                      background-color: #eae8e8;
                      border: 1px solid #222;
                      border-radius: 5px;
                      box-shadow: 0 5px 15px rgba(0,0,0,.5);
                      position: absolute;
                      width: 100%;
                      height: auto;
                      box-sizing: border-box;
                      transition: all 1s ease 0s;
                      color: #a94442;
                      padding: 10px 5px;
                      backface-visibility: hidden;
                      top: -18px;
                      z-index: -1;
                  }
              </style>

                   
        <script type="text/javascript">
         $(document).ready(function(){

          $(".flash-' . $card['id'] . '").on("click", function(event) {
          event.stopPropagation();
          $(".flashcards-' . $card['id'] . '").toggleClass("flip");
          });
                             

        });

              </script>';
      }
    }

    public function editslpFlashcards()
    {
      $cards  = $this->WIdb->select("SELECT * FROM `wi_flashcard` LIMIT 3");
      foreach($cards as $card){
      echo '<div class="flashcards-' . $card['id'] . ' hide" id="flashy-'. $card['id'].'">
                  <div class="front">
                  <div class="caption">
                    <h4 class="group inner list-group-item-headings">
                       <p class="cardsP">
            <span class="btn-edit flash-' . $card['id'] . '">'. $card['name'].'</span>
                       </p>
                       </h4>
                  </div>
                  <div class="thumbnail flash" id="flash">
                <a class="cards_link" id="'. $card['id'].'" href="javascript:void(0);" onclick="slp.NextFlash(`'. $card['id'].'`,`'. $card['id'] .'`);"><img class="group list-group-image" style="border-radius: 36px;" src="WIMedia/Img/flashcards/'. $card['img'].'" alt="'. $card['name'].'" /></a>
              </div>
              </div>
                  <div class="back">
                  <div class="caption">
                    <h4 class="group inner list-group-item-headings">
                       <p class="cardsP">
            <span class="btn-edit flash-' . $card['id'] . '">'. $card['name'].'</span>
                       </p>
                       </h4>
                  </div>
                  <div class="thumbnail hide flash" id="flash">
                <a class="cards_link" id="'. $card['id'].'" href="javascript:void(0); onclick="slp.NextFlash(`'. $card['name'].'`);"><img class="group list-group-image" style="border-radius: 36px;" src="WIMedia/Img/flashcards/'. $card['img'].'" alt="'. $card['name'].'" /></a>
              </div></div>
              </div>';

              echo '<style>
              .flashcards-' . $card['id'] . ' {
                position: relative;
                width: 100%;
                height: auto;
                perspective: 638px;
                margin: 0px 0px 0px 1px;
                  }

                  .flash-' . $card['id'] . '{
                        background-color: #bf6cda;
                      color: white;
                      perspective: 638px;
                      margin-left: 10px;
                      margin-top: 10px;
                  }
                  .flashcards-' . $card['id'] . '.flip .front {
                    transform: rotateY(180deg);
                  }
                  .flashcards-' . $card['id'] . '.flip .back {
                    transform: rotateY(0deg);
                  }
                  .flashcards-' . $card['id'] . ' .back{
                    transform: rotateY(-180deg);
                  }
                  .flashcards-' . $card['id'] . ' .front, .flashcards-' . $card['id'] . ' .back
                  {
                      background-color: #eae8e8;
                      border: 1px solid #222;
                      border-radius: 5px;
                      box-shadow: 0 5px 15px rgba(0,0,0,.5);
                      position: absolute;
                      width: 100%;
                      height: auto;
                      box-sizing: border-box;
                      transition: all 1s ease 0s;
                      color: #a94442;
                      padding: 10px 5px;
                      backface-visibility: hidden;
                      top: -18px;
                      z-index: -1;
                  }
              </style>

                   
        <script type="text/javascript">
         $(document).ready(function(){

          $(".flash-' . $card['id'] . '").on("click", function(event) {
          event.stopPropagation();
          $(".flashcards-' . $card['id'] . '").toggleClass("flip");
          });
                             

        });

              </script>';
      }
    }


}