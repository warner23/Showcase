<?php

/**
* 
*/
class WICMS
{
    function __construct()
    {
        $this->WIdb = WIdb::getInstance();
        $this->Web  = new WIWebsite();
        $this->site = new WISite();
        $this->mod  = new WIModules();
        $this->page = new WIPage();
        $this->Bootstrap  = new WIBootstrap();
    }


    public function editMod()
    {
        
    
 
    }

    public function editPageContent($page)
    {


    }

    public function mod_name($module, $page)
    {
        $this->Bootstrap->startMod();
        if(isset($page)){
        $left_sidePower = $this->Web->pageModPower($page, "left_sidebar");
        $leftSideBar = $this->Web->PageMod($page, "left_sidebar");
        if ($left_sidePower === "0") {
            
        }else{

            $this->mod->getMod($leftSideBar);
        }
        }

        if($this->user->isAdmin()){
            $this->Bootstrap->blogAdmin();
        } else {
          $this->Bootstrap->blogNotAdmin();
        }
        
        $this->Bootstrap->contents();

      if(isset($page)){         
        $right_sidePower = $this->Web->pageModPower($page, "right_sidebar");
        $rightSideBar = $this->Web->PageMod($page, "right_sidebar");
        //echo $Panel;
        if ($right_sidePower === "0") {
            
        }else{

            $this->mod->getMod($rightSideBar);
        }

        }           
                    

    echo "</div>
            </div>";
    }  
}