<?php

/**
* 
*/
class About_Us
{
    function __construct()
    {
        $this->WIdb = WIdb::getInstance();
        $this->Web  = new WIWebsite();
        $this->site = new WISite();
        $this->mod  = new WIModules();
        $this->page = new WIPage();
    }

    public function editMod()
    {
        
    $this->Web->EditModTemp();
     $result = $this->WIdb->select("SELECT `edit_page_mod` FROM `wi_pages` WHERE `page_name` =:page", array("page" => $page,));
        if(count($result) < 1)
        {
            echo "No Page Found.";
        }
        else{
           echo $result[0]["edit_page_mod"];
        }
 
    }

    public function editPageContent($page)
    {
      $result = $this->WIdb->select("SELECT `edit_page_mod` FROM `wi_pages` WHERE `page_name` =:page", array("page" => $page,));
        if(count($result) < 1)
        {
            echo "No Page Found.";
        }
        else{
           echo $result[0]["edit_page_mod"];
        }

    }

    public function mod_name($module, $page)
    {
        if(isset($page)){
        $left_sidePower = $this->Web->pageModPower($page, "left_sidebar");
        $leftSideBar = $this->Web->PageMod($page, "left_sidebar");
        if ($left_sidePower === 0) {
            
        }else{

            $this->mod->getMod($leftSideBar,$page);
        }
        }

        $result = $this->WIdb->select("SELECT `pagemod` FROM `wi_pages` WHERE `page_name` =:page", array("page" => $page) );
        if(count($result) < 1)
        {
            echo "No Page Found.";
        }
        else{
           echo $result[0]["pagemod"];
        }
        

      if(isset($page)){         
        $right_sidePower = $this->Web->pageModPower($page, "right_sidebar");
        $rightSideBar = $this->Web->PageMod($page, "right_sidebar");
        //echo $Panel;
        if ($right_sidePower === 0) {
            
        }else{

            $this->mod->getMod($rightSideBar,$page);
        }

        }           
                    

    echo "</div>
            </div>";
    }  
}