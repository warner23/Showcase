  <?php
/**
* WIModules Class
* Created by Warner Infinity
* Author Jules Warner
*/
class WIModules
{

    public function __construct() {
        $this->WIdb = WIdb::getInstance();
        $this->Page = new WIPagination();
    }


  public function displayElements()
  {
       if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 15;


        $onclick = "nextElement";
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        $dir = dirname(dirname(dirname(__FILE__))) . '/WIModule/elements/';
        $modules = scandir($dir);
        $modTotal = count($modules);
        //echo $modTotal;

        //break records into pages
        $total_pages = ceil($modTotal/$item_per_page);

        foreach ($modules as $module => $value) {
            
        if ($value === '.' or $value === '..') continue;
        if (is_dir($dir.$value)) {
        //code to use if directory
                echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $value . '</div>
        <div class="panel-body">

             <button type="button" name="' . $value . '" value="enabled" id="' . $value . '-Install"  class="btn">Install</button>
         <button type="button" name="' . $value . '" value="disabled" id="' . $value . '-Uninstall" class="btn btn-danger active" >Unistall</button>
        </div>
        <div class="panel-footer">
            Author: Jules Warner
        </div>
        </div>
    </div>  <script type="text/javascript">
     
    var module = "' . $this->InstallElementToggle($value) . '";

                       if (module === "power_off"){
                        $("#' . $value . '-Install").removeClass("btn-success active");
                        $("#' . $value . '-Uninstall").addClass("btn-danger active");
                       }else if (module === "power_on"){
                        $("#' . $value . '-Uninstall").removeClass("btn-danger active");
                        $("#' . $value . '-Install").addClass("btn-success active");
                       }

                    $("#' . $value . '-Install").click(function(){
                        $("#' . $value . '-Uninstall").removeClass("btn-danger active")
                        $("#' . $value . '-Install").addClass("btn-success active");
                        WIMod.installElement("' . $value . '","Jules Warner");
                    })

                    $("#' . $value . '-Uninstall").click(function(){
                       $("#' . $value . '-Install").removeClass("btn-success active")
                        $("#' . $value . '-Uninstall").addClass("btn-danger active");
                        WIMod.uninstallElements("' . $value . '","Jules Warner");
                    })
</script>';
        }

        }

          $Pagin = $this->Page->Pagination($item_per_page, $page_number, $modTotal, $total_pages, $onclick);
    //print_r($Pagination);


         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';
  }

  public function displayModules()
  {
    if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 15;


        $onclick = "NextInstalledMod";
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        $dir = dirname(dirname(dirname(__FILE__))) . '/WIModule/modules/';
        $modules = scandir($dir);
        $modTotal = count($modules);
        //echo $modTotal;

        //break records into pages
        $total_pages = ceil($modTotal/$item_per_page);

        foreach ($modules as $module => $value) {
            
        if ($value === '.' or $value === '..') continue;
        if (is_dir($dir.$value)) {
        //code to use if directory
                echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $value . '</div>
        <div class="panel-body">

             <button type="button" name="' . $value . '" value="enabled" id="' . $value . '-Install"  class="btn">Install</button>
         <button type="button" name="' . $value . '" value="disabled" id="' . $value . '-Uninstall" class="btn btn-danger active" >Unistall</button>
        </div>
        <div class="panel-footer">
            Author: Jules Warner
        </div>
        </div>
    </div>  <script type="text/javascript">
     
    var module = "' . $this->InstallToggle($value) . '";

                       if (module === "disabled"){
                        $("#' . $value . '-Install").removeClass("btn-success active");
                        $("#' . $value . '-Uninstall").addClass("btn-danger active");
                       }else if (module === "enabled"){
                        $("#' . $value . '-Uninstall").removeClass("btn-danger active");
                        $("#' . $value . '-Install").addClass("btn-success active");
                       }



                    $("#' . $value . '-Install").click(function(){
                        $("#' . $value . '-Uninstall").removeClass("btn-danger active")
                        $("#' . $value . '-Install").addClass("btn-success active");
                        WIMod.install("' . $value . '", "Jules Warner");
                    })

                    $("#' . $value . '-Uninstall").click(function(){
                       $("#' . $value . '-Install").removeClass("btn-success active")
                        $("#' . $value . '-Uninstall").addClass("btn-danger active");
                        WIMod.uninstall("' . $value . '");
                    })
</script>';
        }

        }

          $Pagin = $this->Page->Pagination($item_per_page, $page_number, $modTotal, $total_pages, $onclick);
    //print_r($Pagination);


         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';
  }

  public function getElements()
    {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 30;
        $power = "power_on";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE element_powered =:power",
                     array(
                       "power" => $power
                ));
        $rows = count($result);

        $onclick = "nextElement";
        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        

/*        $sql = "SELECT * FROM `wi_elements` WHERE element_powered =:power ORDER BY `element_id` ASC LIMIT :page, :item_per_page";
        $query = $this->WIdb->prepare($sql);
        $query->bindParam(':page', $page_position, PDO::PARAM_INT);
         $query->bindParam(':power' ,$power, PDO::PARAM_STR);
        $query->bindParam(':item_per_page', $item_per_page, PDO::PARAM_INT);
        $query->execute();*/

        echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="elementsContents">';
        
        echo '<ul class="contents">';
        //selectwithOptions
        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_powered` =:power ORDER BY `element_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "power" => $power
                ));
        //while ($res = $query->fetch(PDO::FETCH_ASSOC)) {
        foreach($results as $res){
            $element_name = $res['element_name'];

            if (strpos($element_name," ") != false){
                $element_name = preg_replace('/\s+/', '_', $element_name);
            }
            
             echo '<div class="col-mods">
        <div class="panel panel-info">
        <div class="panel-heading">' . $element_name . '</div>
        <div class="panel-body">
        <input type="hidden" name="' . $element_name . '"  class="btn-group-value" id="' . $element_name . '" value="'. $res['element_status'] . '" />
             <button type="button" name="' . $element_name . '" value="enabled" id="' . $element_name . '-enabled"  class="btn">Enabled</button>
         <button type="button" name="' . $element_name . '" value="disabled" id="' . $element_name . '-disabled" class="btn btn-danger active" >Disabled</button>
        </div>
        <div class="panel-heading">
            
        </div>
        </div>';

             
    echo '</div>  <script type="text/javascript">
     
    var element = "' . $res['element_status'] . '";

                       if (element === "disabled"){
                        $("#' . $element_name . '-enabledd").removeClass("btn-success active");
                        $("#' . $element_name. '-disable").addClass("btn-danger active");
                       }else if (element === "enabled"){
                        $("#' . $element_name . '-disabled").removeClass("btn-danger active");
                        $("#' . $element_name . '-enabled").addClass("btn-success active");
                       }



                    $("#' . $element_name . '-enabled").click(function(){
                        
                        $("#' . $element_name . '-enabled").attr("value", "enabled")
                        $("#' . $element_name . '-disabled").removeClass("btn-danger active")
                        $("#' . $element_name. '-enabled").addClass("btn-success active");
                        WIMod.enableElement("' . $element_name . '", "enabled");
                    })

                    $("#' . $element_name . '-disabled").click(function(){
                       
                        $("#' . $element_name . '-disabled").attr("value", "disabled")
                        $("#' . $element_name . '-enabled").removeClass("btn-success active")
                        $("#' . $element_name . '-disabled").addClass("btn-danger active");
                        WIMod.disableElement("' . $element_name . '", "disabled");
                    })
</script>';
        }
        

         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</ul>';

         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div></div>';
    }


    public function getModules()
    {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 15;
        $mod_type = "module";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_modules`");
        $rows = count($result);

        $onclick = "nextMod";
        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);

        echo '<ul class="contents">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_modules` ORDER BY `module_id` ASC LIMIT $page_position, $item_per_page");
        foreach($results as $res){
             echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $res['module_name'] . '</div>
        <div class="panel-body">
        <input type="hidden" name="' . $res['module_name'] . '" class="btn-group-value" id="' . $res['module_name'] . '" value="'. $res['module_name'] . '" />
             <button type="button" name="' . $res['module_name'] . '" value="enabled" id="' . $res['module_name'] . '-enabled"  class="btn">Enabled</button>
         <button type="button" name="' . $res['module_name'] . '" value="disabled" id="' . $res['module_name'] . '-disabled" class="btn btn-danger active" >Disabled</button>
        </div>
        <div class="panel-heading">
            
        </div>
        </div>
    </div>  <script type="text/javascript">
     
    var module = "' . $res['module_status'] . '";

                       if (module === "disabled"){
                        $("#' . $res['module_name'] . '-enabledd").removeClass("btn-success active");
                        $("#' . $res['module_name'] . '-disable").addClass("btn-danger active");
                       }else if (module === "enabled"){
                        $("#' . $res['module_name'] . '-disabled").removeClass("btn-danger active");
                        $("#' . $res['module_name'] . '-enabled").addClass("btn-success active");
                       }



                    $("#' . $res['module_name'] . '-enabled").click(function(){
                        
                       // $("#' . $res['module_name'] . '-enabled").attr("value", "enabled")
                        $("#' . $res['module_name'] . '-disabled").removeClass("btn-danger active")
                        $("#' . $res['module_name'] . '-enabled").addClass("btn-success active");
                        WIMod.enable("' . $res['module_name'] . '", "enabled");
                    })

                    $("#' . $res['module_name'] . '-disabled").click(function(){
                       
                       // $("#' . $res['module_name'] . '-disabled").attr("value", "disabled")
                        $("#' . $res['module_name'] . '-enabled").removeClass("btn-success active")
                        $("#' . $res['module_name'] . '-disabled").addClass("btn-danger active");
                        WIMod.disable("' . $res['module_name'] . '", "disabled");
                    })
</script>';
        }
        echo '</ul>';

         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);


         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';
    }

        public function getPageModules()
    {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 15;
        $mod_type = "custom";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_modules`");
        $rows = count($result);

        $onclick = "nextMod";
        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);

         echo '<ul class="nav nav-list accordion-group">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_modules` ORDER BY `id` ASC LIMIT :page, :item_per_page",
                     array(
                       "page" => $page_position,
                       "item_per_page" => $item_per_page
                ));

        foreach($results as $res){
            //var_dump($res);
            echo '<div class="wicreate ui-draggable">';
                     echo $res['name'] . '
                  </div>';
        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';
    }


    public function getInstalledModules()
    {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 15;

        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_modules`");
        $rows = count($result);
        $onclick = "nextInstalledModule";
        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        $mod_type = "element";

        echo '<ul class="contents">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_modules` WHERE `mod_type` =:mod_type ORDER BY `module_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "page" => $page_position,
                       "mod_type" => $mod_type,
                       "item_per_page" => $item_per_page
                ));
        foreach($results as $res) {
             echo '<div class="col-md-4">
        <div class="panel panel-info">
        <div class="panel-heading">' . $res['module_name'] . '</div>
        <div class="panel-body">
        <input type="hidden" name="' . $res['module_name'] . '" class="btn-group-value" id="' . $res['module_name'] . '" value="'. $res['module_status'] . '" />
             <button type="button" name="' . $res['module_name'] . '" value="enabled" id="' . $res['module_name'] . '-enabled"  class="btn">Enabled</button>
         <button type="button" name="' . $res['module_name'] . '" value="disabled" id="' . $res['module_name'] . '-disabled" class="btn btn-danger active" >Disabled</button>
        </div>
        <div class="panel-heading">
            
        </div>
        </div>
    </div>  <script type="text/javascript">
     
    var module = "' . $res['module_status'] . '";

                       if (module === "disabled"){
                        $("#' . $res['module_name'] . '-enabledd").removeClass("btn-success active");
                        $("#' . $res['module_name'] . '-disable").addClass("btn-danger active");
                       }else if (module === "enabled"){
                        $("#' . $res['module_name'] . '-disabled").removeClass("btn-danger active");
                        $("#' . $res['module_name'] . '-enabled").addClass("btn-success active");
                       }



                    $("#' . $res['module_name'] . '-enabled").click(function(){
                        
                       // $("#' . $res['module_name'] . '-enabled").attr("value", "enabled")
                        $("#' . $res['module_name'] . '-disabled").removeClass("btn-danger active")
                        $("#' . $res['module_name'] . '-enabled").addClass("btn-success active");
                        WIMod.enable("' . $res['module_name'] . '", "enabled");
                    })

                    $("#' . $res['module_name'] . '-disabled").click(function(){
                       
                       // $("#' . $res['module_name'] . '-disabled").attr("value", "disabled")
                        $("#' . $res['module_name'] . '-enabled").removeClass("btn-success active")
                        $("#' . $res['module_name'] . '-disabled").addClass("btn-danger active");
                        WIMod.disable("' . $res['module_name'] . '", "disabled");
                    })
</script>';
        }
        echo '</ul>';

         $Pagination = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);


         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagination;
    echo '</div>';
    }



    public static function moduleToggle($column, $mod_name) 
    {
        
        $result['$column'] = $this->WIdb->selectColumn('SELECT * FROM `wi_modules` WHERE `module_name` = :mod_name', 
            array(
                'mod_name' => $mod_name
                ), 
            $column);
        return $result[$column];
    }

        public function InstallToggle($mod_name) 
    {

        $result = $this->WIdb->select("SELECT * FROM `wi_modules` WHERE `module_name` = :mod_name", 
            array(
            "mod_name" => $mod_name
            )
        );

        foreach($result as $result){

        if($result['module_name'] === $mod_name)
            return "enabled";
        else
            return "disabled";
        }
    }

   public  function InstallElementToggle($mod_name) 
    {

        $result = $this->WIdb->select("SELECT * FROM `wi_elements` WHERE `element_type` = :mod_name or `element_name` =:mod_name", 
            array(
            "mod_name" => $mod_name
            )
        );
        foreach($result as $result){

        if($result['element_name'] || $result['element_type']  === $mod_name)
            return "power_on";
        else
            return "power_off";
        }
    }

    public function installElement($mod_name)
    {
        //echo dirname(dirname(dirname(__FILE__))) . '/WIModule/elements/' . $mod_name . '/' . $mod_name . '.php';

        require_once dirname(dirname(dirname(__FILE__))) . '/WIModule/elements/' . $mod_name . '/' . $mod_name . '.php';

        $elementName = $mod_name;
        $WIElement = new $elementName();
        $WIElement->Install($mod_name);
    
        $msg = "Successfully Installed " . $mod_name . " element";

        $result = array(
            "status"  => "success",
            "msg"     => $msg
        );

        echo json_encode($result);
    }

    public function unistall_Element($mod_name)
    {

        $this->WIdb->delete("wi_elements", "element_name = :mod_name", array( "mod_name" => $mod_name ));

    }

    public function install_mod($mod_name)
    {
       require_once dirname(dirname(dirname(__FILE__))) . '/WIModule/modules/' . $mod_name . '/' . $mod_name . '.php';

        $elementName = $mod_name;
        $WIElement = new $elementName();
        $WIElement->Install($mod_name);
    
        $msg = "Successfully Installed " . $mod_name . " element";

        $result = array(
            "status"  => "success",
            "msg"     => $msg
        );

        echo json_encode($result);

    }

    public function uninstall_mod($mod_name)
    {

        $this->WIdb->delete("wi_modules", "module_name = :mod_name", array( "module_name" => $mod_name ));

    }


    public function active_available_mod($mod_name, $enable)
    {

        $this->WIdb->update('wi_modules',array("mod_status" => $enable),
            "`module_name` = :mod_name",
        array("module_name" => $mod_name)
        );
    }

        public function activateAvailableElements($element_name, $enable)
    {

        $element_font = "wi_" .$element_name;

        if (strpos($element_name,"_") != faslse){
                $element_name = str_replace("_", " ", $element_name);
            }

        $this->WIdb->update(
                    'wi_elements',
                     array(
                         "element_status" => $enable,
                         "element_font" => $element_font
                     ),
                     "`element_name` = :element_name",
                     array("element_name" => $element_name)
                );


    }

    public function active_available_elements($mod_name, $enable)
    {

        $this->WIdb->update(
                    'wi_modules',
                     array(
                         "module_status" => $enable
                     ),
                     "`module_name` = :module_name",
                     array("module_name" => $mod_name)
                );


    }

    public function deactive_available_mod($mod_name, $disable)
    {
        $this->WIdb->update(
                    'wi_modules',
                     array(
                         "module_status" => $disable
                     ),
                     "`module_name` = :mod_name",
                     array("mod_name" => $mod_name)
                );
    }

     public function ActiveMods()
     {

                 if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $onclick = "nextMod";
        $element_status = "enabled";
        $item_per_page = 15;
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_modules`",
                     array(
                       "element_status" => $element_status
                ));
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);

        echo '<ul id="draggable" class="ui-widget-header">';

        
        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_modules` ORDER BY `module_id` ASC LIMIT $page_position, $item_per_page");
        foreach($results as $res) {
            echo '<li id="'.$res['module_name'] . '" title="'.$res['module_name'] . '" class="ui-draggable ui-draggable-handle '.$res['module_font'] . '"></li>';
        }
        echo '</ul>';

     }


          public function ActiveElements()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $onclick = "nextElement";
        $element_status = "enabled";
        $item_per_page = 15;
        $mod_type = "element";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status",
                     array(
                       "element_status" => $element_status
                ));
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);

        echo '<ul id="draggable" class="ui-widget-header">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status ORDER BY `element_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "element_status" => $element_status
                ));
       foreach($results as $res) {
            echo '<li id="'.$res['element_name'] . '" title="'.$res['element_name'] . '" class="ui-draggable ui-draggable-handle '.$res['element_font'] . '"></li>
                $( "button#modEle" ).mousedown(function() {
              $("li#'.$res['element_name'] . '").attr("draggable", true);
            });';
        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</ul>';

         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }


     public function modules()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $onclick = "nextElement";
        $element_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "Grid";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_mods`");
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);

        echo '<ul class="nav nav-list accordion-group">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_mods` ORDER BY `module_id` ASC LIMIT $page_position, $item_per_page");

        foreach($results as $res) {
            //var_dump($res);
            echo '<div class="wicreate ui-draggable">
            <a href="javascript:void(0);" id="editting-' .$res['module_id'] . '" class="editting editting-' .$res['module_id'] . ' label label-important"><i class="fas fa-edit"></i>Edit</a>
                    <script>
                  $(".editting-' .$res['module_id'] . '").click(function() {
                    $(".attrsPanels").css("display","block")
                 });
                  </script>
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a>
                     <span class="drag label"><i class="icon-move"></i>Drag</span>
                     <div class="preview">' .$res['module_name'] . '</div>
                    <div class="view">';
                    self::attrsPanels(); 
                     //echo $res['element'] . '
                    echo '</div>';
                  echo '</div>';
        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }

     public function ActiveElementsGrid()
     {
         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }
        $onclick = "nextElement";
        $element_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "Grid";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type`=:type",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);


        echo '<ul class="nav nav-list accordion-group">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type` =:type ORDER BY `element_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));

        foreach($results as $res) {
            //var_dump($res);
            echo '<div class="grid box-element wicreate ui-draggable" id="grid_id">
                <input type="hidden" id="' .$res['element_id'] . '" >
                <div class="rowActions groupActions hide" id="' . self::numberGenerator(). '">';
                self::LgroupActions();
               echo '</div>
               <div class="rowEdit groupConfig">';
                    self::groupConfig();
                    echo '</div>
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a>
                     <span class="drag label"><i class="icon-move"></i>Drag</span>
                     <div class="column-actions hide" id="' . self::numberGenerator(). '"><i class="fas fa-th" aria-hidden="true"></i>';
                          self::MgroupActions();
                          echo '</div>';
                     echo '<div class="fieldPreview">
                        '. $res['element'] . '</div></div>';
        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }

          public function ActiveElementsBase()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $onclick = "nextElement";
        $element_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "Base";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type`=:type",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        
        echo '<ul class="nav nav-list accordion-group">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type` =:type ORDER BY `element_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));

        foreach($results as $res) {
            //var_dump($res);

            if($res["element_name"] === "Font Awesome")
            {
                 echo '<div class="base box box-element ui-draggable" id="base_id">
                 <div id="gridbase"><a href="javascript:void(0);" id="' .$res['element_id'] . '" onclick="WIScript.BaseEdit(`' .$res['element_name'] . '`)" class="fieldEdit editting-' .$res['element_id'] . ' label label-important remove"><i class="fas fa-edit"></i>edit div</a></div>
                    <div class="optset">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    <span class="configuration">
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Align <span class="caret">Styles</span></a>
                        <ul class="dropdown-menu">';
                          self::font_awesome_options();
                        echo '</ul>
                      </span>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" onclick="WIScript.font_awesome()">All the Icons <span class="caret">All the Icons</span></a>
                        <ul class="dropdown-menu" id="font_awesome">
                        </ul>
                      </span>
                    </span>
                    </div>
                    <div class="fieldActions groupActions hide" id="' . self::numberGenerator(). '">';
                      self::RgroupActions();
                      echo '</div>
                    <div class="fieldEdit slideToggle panelsWrap panelCount" style="display:none; position:relative; opacity:1; height:auto;">';
                          //self::fieldEdit();
                          echo '</div><div class="panels" style="height:116.313px;display:none;">
                          <div class="Fpanel attrsPanels">';
                          self::attrsPanels();
                          echo '</div>
                          </div>';
                   echo $res['element'] . '
                  </div>';
            }else if($res["element_name"] === "Image")
            {
                echo '<div class="base box box-element ui-draggable" id="base_id">
                           <div id="gridbase"><a href="javascript:void(0);" id="' .$res['element_id'] . '" onclick="WIScript.BaseEdit(`' .$res['element_name'] . '`)" class="fieldEdit editting-' .$res['element_id'] . ' label label-important remove"><i class="fasr fas-edit"></i>edit div</a></div>
                    <div class="optset">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    <span class="configuration">
                      <button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">Editor</button>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Align <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li class="active"><a href="javascript:void(0); "rel="">Defasult</a></li>
                          <li ><a href="javascript:void(0);" rel="text-left">Left</a></li>
                          <li ><a href="=javascript:void(0);" rel="text-center">Center</a></li>
                          <li ><a href="javascript:void(0);" rel="text-right">Right</a></li>
                        </ul>
                      </span>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Emphasis <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li class="active"><a href="javascript:void(0);" rel="">Defasult</a></li>
                          <li ><a href="#" rel="emphasized">Emphasized</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized2">Emphasized 2</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized3">Emphasized 3</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized4">Emphasized 4</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized-orange">Emphasized orange</a></li>
                        </ul>
                      </span>
                    </span>
                    </div>
                    <div class="fieldActions groupActions hide" id="' . self::numberGenerator(). '">';
                      self::RgroupActions();
                      echo '</div>
                    <div class="fieldEdit slideToggle panelsWrap panelCount" style="display:none; position:relative; opacity:1; height:auto;">';
                         // self::fieldEdit();
                          echo '</div>
                          <div class="panels" style="height:116.313px;display:none;">
                          <div class="Fpanel attrsPanels">';
                          self::attrsPanels();
                          echo '</div>
                          </div>';
                   echo $res['element'] . '
                  </div>';
            }else if($res["element_name"] === "Color")
            {
            echo '<div class="base box box-element ui-draggable" id="base_id">
            <div id="gridbase"><a href="javascript:void(0);" id="' .$res['element_id'] . '" onclick="WIScript.BaseEdit(`' .$res['element_name'] . '`)" class="fieldEdit editting-' .$res['element_id'] . ' label label-important remove"><i class="fasr fas-edit"></i>edit div</a></div>
                    <div class="optset">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    <span class="configuration">
                      <button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">Editor</button>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Align <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li class="active"><a href="javascript:void(0); "rel="">Defasult</a></li>
                          <li ><a href="javascript:void(0);" rel="text-left">Left</a></li>
                          <li ><a href="=javascript:void(0);" rel="text-center">Center</a></li>
                          <li ><a href="javascript:void(0);" rel="text-right">Right</a></li>
                        </ul>
                      </span>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Emphasis <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li class="active"><a href="javascript:void(0);" rel="">Defasult</a></li>
                          <li ><a href="#" rel="emphasized">Emphasized</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized2">Emphasized 2</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized3">Emphasized 3</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized4">Emphasized 4</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized-orange">Emphasized orange</a></li>
                        </ul>
                      </span>
                    </span>
                    </div>
                    <div class="fieldActions groupActions hide" id="' . self::numberGenerator(). '">';
                          self::RgroupActions();
                          echo '</div>
                    <div class="fieldEdit slideToggle panelsWrap panelCount" style="display:none; position:relative; opacity:1; height:auto;">';
                          //self::fieldEdit();
                          echo '</div>
                          <div class="panels" style="height:116.313px;display:none;">
                          <div class="Fpanel attrsPanels">';
                          self::attrsPanels();
                          echo '</div>
                          </div>';
                   echo $res['element'] . '
                  </div>';
            }else{
                           echo '<div class="base box box-element ui-draggable" id="base_id">
                           <div id="gridbase"><a href="javascript:void(0);" id="' .$res['element_id'] . '" onclick="WIScript.BaseEdit(`' .$res['element_name'] . '`)" class="fieldEdit editting-' .$res['element_id'] . ' label label-important remove"><i class="fasr fas-edit"></i>edit div</a></div>
                    <div class="optset">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    <span class="configuration">
                      <button type="button" class="btn btn-mini" role="button" id="editorModal" onclick="WIScript.Editor();">Editor</button>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">Align <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li class="active"><a href="javascript:void(0); "rel="">Defasult</a></li>
                          <li ><a href="javascript:void(0);" rel="text-left">Left</a></li>
                          <li ><a href="=javascript:void(0);" rel="text-center">Center</a></li>
                          <li ><a href="javascript:void(0);" rel="text-right">Right</a></li>
                        </ul>
                      </span>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Emphasis <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li class="active"><a href="javascript:void(0);" rel="">Defasult</a></li>
                          <li ><a href="#" rel="emphasized">Emphasized</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized2">Emphasized 2</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized3">Emphasized 3</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized4">Emphasized 4</a></li>
                          <li ><a href="javascript:void(0);" rel="emphasized-orange">Emphasized orange</a></li>
                        </ul>
                      </span>
                    </span>
                    </div>
                    <div class="fieldActions groupActions hide" id="' . self::numberGenerator(). '">';
                          self::RgroupActions();
                          echo '</div>
                    <div class="fieldEdit slideToggle panelsWrap panelCount" id="' . self::numberGenerator(). '" style="display:none; position:relative; opacity:1; height:auto;">';
                          //self::fieldEdit();
                          echo '</div>';
                   echo $res['element'] . '
                  </div>';
            }

        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }

      public function ActiveElementsComponents()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $onclick = "nextElement";
        $element_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "Components";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type`=:type",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);


        echo '<ul class="nav nav-list accordion-group">';
         $results = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type` =:type ORDER BY `element_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));

        foreach($results as $res) {
            //var_dump($res);
            echo '<div class="box box-element ui-draggable">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    <span class="configuration">
                    <button type="button" class="btn btn-mini" role="button" id="editorModal" onclick="WIScript.Editor();">Editor</button>
                      <span class="btn-group">
                        <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">Orientation<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                          <li class="active"><a href="#" rel="">Defasult</a></li>
                          <li ><a href="#" rel="btn-group-vertical">Vertical</a></li>
                        </ul>
                      </span>
                    </span>
                    ' . $res['element'] .'
                  </div>';
        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }

      public function ActiveElementsForms()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $onclick = "nextElement";
        $element_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "Forms";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type`=:type",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);


        echo '<ul class="nav nav-list accordion-group">';
        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type` =:type ORDER BY `element_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));

        foreach($results as $res) {
            //var_dump($res);
            echo '<div class="box box-element ui-draggable">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    <span class="configuration">
                      <button type="button" class="btn btn-mini" data-target="#editorModal" role="button" data-toggle="modal">Editor</button>
                    </span>
                    '.$res['element'] . '
                  </div>';
        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }

      public function ActiveElementsJavascript()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $onclick = "nextElement";
        $element_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "Javascript";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type`=:type",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);

        echo '<ul class="nav nav-list accordion-group">';
        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :element_status AND `element_powered` =:power AND `element_type` =:type ORDER BY `element_id` ASC LIMIT $page_position, $item_per_page",
                     array(
                       "element_status" => $element_status,
                       "power" => $power,
                       "type" => $type
                ));

        foreach($results as $res) {
            //var_dump($res);
            echo '<div class="javascript box box-element ui-draggable" id="javascript_id">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    ' . $res['element'] . '
                  </div>';
        }
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }


     public function ActiveElementsModules()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }
        $onclick = "nextElement";
        $module_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "module";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_modules` WHERE `module_status` = :module_status AND `module_powered` =:power AND `module_type`=:type",
                     array(
                       "module_status" => $module_status,
                       "power" => $power,
                       "type" => $type,
                ));
        //var_dump($result);
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        

        echo '<ul class="nav nav-list accordion-group">';

        $res = $this->WIdb->select(
                    "SELECT * FROM `wi_modules` WHERE `module_status` = :module_status AND `module_powered` =:power AND `module_type` =:type",
                     array(
                       "module_status" => $module_status,
                       "power" => $power,
                       "type" => $type
                ));
        foreach($res as $r){

            echo '<div class="module box box-element ui-draggable" id="modules">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    ' . $r['module'] . '
                  </div>';
        }

        
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }


     public function ActiveElementsActions()
     {

         if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }
        $onclick = "nextElement";
        $module_status = "enabled";
        $item_per_page = 15;
        $power = "power_on";
        $type = "action";
        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :module_status AND `element_powered` =:power AND `element_type`=:type",
                     array(
                       "module_status" => $module_status,
                       "power" => $power,
                       "type" => $type,
                ));
        //var_dump($result);
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        

        echo '<ul class="nav nav-list accordion-group">';

        $res = $this->WIdb->select(
                    "SELECT * FROM `wi_elements` WHERE `element_status` = :module_status AND `element_powered` =:power AND `element_type`=:type",
                     array(
                       "module_status" => $module_status,
                       "power" => $power,
                       "type" => $type
                ));
        foreach($res as $r){

            echo '<div class="action callToAction box-element ui-draggable" id="action">
                    <a href="#close" class="remove label label-important"><i class="icon-remove icon-white"></i>Remove</a> <span class="drag label"><i class="icon-move"></i>Drag</span>
                    ' . $r['element'] . '
                  </div>';
        }

        
         $Pagin = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);
    //print_r($Pagination);
         echo '</li></ul>';
         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagin;
    echo '</div>';

     }


    public function editDropElement($mod_name, $page_id)
     {
        include_once dirname(dirname(dirname(__FILE__))) . '/WIModule/' .$mod_name.'/'.$mod_name.'.php';

        $mod_name = new $mod_name;

        $mod_name->editPageContent($page_id);

     }

     public function getActiveMods()
     {

        if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 25;

        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_modules`");
        $rows = count($result);
        //echo "row". $rows;
        //break records into pages
        $total_pages = ceil($rows/$item_per_page);
        
        //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);
        $onclick = "nextActiveMod";
        
        echo '<ul id="editable" class="ui-widget-header">';

        $results = $this->WIdb->select(
                    "SELECT * FROM `wi_modules` ORDER BY `module_id` ASC LIMIT $page_position, $item_per_page");

        foreach($results as $res) {
            echo '<li id="'.$res['module_name'] . '" title="'.$res['module_name'] . '" class="ui-draggable ui-draggable-handle '.$res['module_font'] . '"></li>';
        }
        echo '</ul>';
         $Pagination = $this->Page->Pagination($item_per_page, $page_number, $rows, $total_pages, $onclick);

         echo '<div align="center">';
    /* We call the pagination function here to generate Pagination link for us. 
    As you can see I have passed several parameters to the function. */
    echo $Pagination;
    echo '</div>';

     }


    public function getMod($mod, $page, $name)
    {
        //echo $mod;
        //echo   'WIAdmin/WIModule/' .$mod.'/'.$mod.'.php';
        $directory = dirname(dirname(dirname(__FILE__)));
        require_once $directory . '/WIModule/pages/' .$mod.'/'.$mod.'.php';
       // echo $mod;
        $mod = new $mod;

        $mod->mod_name($mod, $page);
    }

    public function EditMod($mod)
    {
        //echo $mod;
        //echo   'WIAdmin/WIModule/' .$mod.'/'.$mod.'.php';
        require_once  'WIAdmin/WIModule/pages/' .$mod.'/'.$mod.'.php';
        
       // echo $mod;
        $mod = new $mod;

        $mod->mod_name();
    }

    public function editContents($mod_name, $title, $para)
    {
/*        $sql = "SELECT  FROM `wi_site` WHERE `id` =:id";

        $query = $this->WIdb->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();*/

        $result = $this->WIdb->select("SELECT  FROM `wi_site` WHERE `id` =:id", 
            array(
            "id" => $id
            )
        );
    }


    public function module($page_id, $column)
    {
        $id = "1";
        $name = $page_id;

        /*$sql = "SELECT `multi_lang` FROM `wi_site` WHERE `id` =:id";

        $query = $this->WIdb->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch();*/
        //echo $result['multi_lang'];

        $result = $this->WIdb->select("SELECT `multi_lang` FROM `wi_site` WHERE `id` =:id", 
            array(
            "id" => $id
            )
        );
        $mlang = $result[0]['multi_lang'];
        

        $res = $this->WIdb->select("SELECT * FROM `wi_modules` WHERE `name`=:name", 
            array(
            "name" => $name
            )
        );
        if ($column === "text") {
            $trans = "trans";
        }elseif ($column === "text1") {
            $trans = "trans1";
        }elseif ($column === "text2") {
            $trans = "trans2";
        }elseif ($column === "text3") {
            $trans = "trans3";
        }elseif ($column === "text4") {
            $trans = "trans4";
        }elseif ($column === "text5") {
            $trans = "trans5";
        }elseif ($column === "text6") {
            $trans = "trans6";
        }

        $lange = $res[0][$trans];
        
        $text  = $res[0][$column];

       // echo $lange;
        if ($mlang === "off"){
            echo $text;
        }else{
            echo WILang::get($lange);
        }

    }

    public function ModName($page)
    {
        $result = $this->WIdb->select("SELECT * FROM `wi_page` WHERE `name`=:page", 
            array(
            "name" => $name
            )
        );
        $mod_name = $result[0]['contents'];

        return $mod_name;
    }

    public function save_mod( $mod_name, $contents, $content)
    {
        $modules = $this->WIdb->select("SELECT * FROM `wi_mods`
                     WHERE `module_name` = :n",
                     array(
                       "n" => $mod_name
                     ));


        if(count($modules) >0){
            $id = $modules[0]['module_id'];
                $this->WIdb->update(
                    "wi_mods", 
                    array("module" => $content, 
                        "edit_module" => $contents 
                    ), 
                    "`module_id` = :id",
                    array( "id" => $id )
               );
        }else{
            $this->WIdb->insert('wi_mods', array(
            "module_name"     => $mod_name,
            "module"     => $content,
            "edit_module"     => $contents
        ));

        }

        $pages = $this->WIdb->select("SELECT * FROM `wi_pages`
                     WHERE `page_name` = :n",
                     array(
                       "n" => $mod_name
                     ));


        if(count($pages) >0){

            $id = $pages[0]['page_id'];
                $this->WIdb->update(
                    "wi_pages", 
                    array("pagemod" => $content, 
                        "edit_page_mod" => $contents,
                        "page_status" => "enabled"
                    ), 
                    "`page_id` = :id",
                    array( "id" => $id )
               );
        }else{
            $this->WIdb->insert('wi_pages', array(
            "page_name"     => $mod_name,
            "pagemod"     => $content,
            "edit_page_mod" => $contents
        ));

        }

        $file_saved = self::saving_mod($mod_name, $contents, $content);
        if($file_saved == "1")
        {
            $msg = "Successfully created Module and saved as file";

    $result = array(
                "status" => "success",
                "msg"    => $msg
            );
            
            echo json_encode($result);
        }else{


        $msg = "Successfully created Module";

    $result = array(
                "status" => "success",
                "msg"    => $msg
            );
            
            echo json_encode($result);
        }
    }

    public function saving_mod($mod_name, $contents, $content)
    {
      
        $dir = dirname(dirname(dirname(__FILE__))) .'/WIModule/pages/' .$mod_name;
             if (!file_exists($dir)) {
                  mkdir($dir, 0777, true);
              }

       if (strpos($contents,'') != false){
                $contents = preg_replace('/\s+/', '', $contents);
            }
        //$contents = str_replace("`", "'", $contents);

      $NewPage = fopen($dir. '/' .$mod_name . '.php', "w") or die("Unable to open file!");

      $File = 
'<?php

/**
* 
*/
class ' . $mod_name . '
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
        if ($left_sidePower === "0") {
            
        }else{

            $this->mod->getMod($leftSideBar);
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
        if ($right_sidePower === "0") {
            
        }else{

            $this->mod->getMod($rightSideBar);
        }

        }           
                    

    echo "</div>
            </div>";
    }  
}';


     
      fwrite($NewPage, $File);
      fclose($NewPage);
    

      return "1";
    }


        public function moduleImg($page_id, $column)
    {

        $res = $this->WIdb->select("SELECT * FROM `wi_modules` WHERE `name`=:name", 
            array(
            "name" => $name
            )
        );
            if ($res[0] > 0) {
                echo ' <img class="img-responsive cp" id="Pic" src="WIMedia/Img/'. $page_id . '/'. $res[0][$column] . '.PNG" style="width:120px; height:120px;">
                    <button class="btn mediaPic" onclick="WIMedia.changePic()">Change Picture</button>
                                
                            </div>';
            }else{

        echo '
        <div class="col-lg-8 col-md-3 col-sm-2">
             <img class="img-responsive cp" id="Pic" src="WIMedia/Img/placeholder.png" style="width:120px; height:120px;">
        <button class="btn mediaPic" onclick="WIMedia.changePic()">Change Picture
        </button>    
        </div>';
        }

    }

     


  public function font_awesome_options()
  {
    echo '<li  rel="fas-6"><a href="#" rel="fas-6">Large</a></li>
          <li  rel="fas-5"><a href="#" rel="fas-5">Big</a></li>
           <li  rel="fas-4"><a href="#" rel="fas-4">Medium</a></li>
           <li  rel="fas-3"><a href="#" rel="fas-3">Normal</a></li>
          <li  rel="fas-2"><a href="#" rel="fas-2">Small</a></li>
<li  rel="fas-1"><a href="#" rel="fas-1">Tiny</a></li>';
  }

  public function font_awesome()
  {
    echo '<li ><a href="#" rel="fas fa-address-book fas-3"><i class="fas fa-address-book"></i></a></li>
          <li ><a href="#" rel="fas fa-address-book-o fas-3"><i class="fas fa-address-book-o"></i></a></li>
          <li ><a href="#" rel="fas fa-address-card fas-3"><i class="fas fa-address-card"></i></a></li>
          <li ><a href="#" rel="fas fa-address-card-o fas-3"><i class="fas fa-address-card-o"></i></a></li>
          <li ><a href="#" rel="fas fa-address-book fas-3"><i class="fas fa-address-book"></i></a></li>
          <li ><a href="#" rel="fas fa-bandcamp fas-3"><i class="fas fa-bandcamp"></i></a></li>
          <li ><a href="#" rel="fas fa-bath fas-3"><i class="fas fa-bath"></i></a></li>
          <li ><a href="#" rel="fas fa-id-card fas-3"><i class="fas fa-id-card"></i></a></li>
          <li ><a href="#" rel="fas fa-id-card-o fas-3"><i class="fas fa-id-card-o"></i></a></li>
          <li ><a href="#" rel="fas fa-eercast fas-3"><i class="fas fa-eercast"></i></a></li>
          <li ><a href="#" rel="fas fa-envelope-open fas-3"><i class="fas fa-envelope-open"></i></a></li>
          <li ><a href="#" rel="fas fa-envelope-open-o fas-3"><i class="fas fa-envelope-open-o"></i></a></li>
          <li ><a href="#" rel="fas fa-etsy fas-3"><i class="fas fa-etsy"></i></a></li>
          <li ><a href="#" rel="fas fa-free-code-camp fas-3"><i class="fas fa-free-code-camp"></i></a></li>
          <li ><a href="#" rel="fas fa-grav fas-3"><i class="fas fa-grav"></i></a></li>
          <li  ><a href="#" rel="fas fas fa-handshake-o fas-3"><i class="fas fa-handshake-o"></i></a></li>
          <li  ><a href="#" rel="fas fa-id-badge fas-3"><i class="fas fa-id-badge"></i></a></li>
          <li  ><a href="#" rel="fas fa-id-card fas-3"><i class="fas fa-id-card"></i></a></li>
          <li  ><a href="#" rel="fas fa-id-card-o fas-3"><i class="fas fa-id-card-o"></i></a></li>
          <li  ><a href="#" rel="fas fa-imdb fas-3"><i class="fas fa-imdb"></i></a></li>
          <li ><a href="#" rel="fas fa-linode fas-3"><i class="fas fa-linode"></i></a></li>
          <li ><a href="#" rel="fas fa-meetup fas-3"><i class="fas fa-meetup"></i></a></li>
          <li ><a href="#" rel="fas fa-microchip fas-3"><i class="fas fa-microchip"></i></a></li>
          <li ><a href="#" rel="fas fa-podcast fas-3"><i class="fas fa-podcast"></i></a></li>
          <li ><a href="#" rel="fas fa-quora fas-3"><i class="fas fa-quora"></i></a></li>
          <li ><a href="#" rel="fas fa-ravelry fas-3"><i class="fas fa-ravelry"></i></a></li>
          <li ><a href="#" rel="fas fa-shower fas-3"><i class="fas fa-shower"></i></a></li>
          <li ><a href="#" rel="fas fa-snowflake-o fas-3"><i class="fas fa-snowflake-o"></i></a></li>
          <li ><a href="#" rel="fas fa-superpowers fas-3"><i class="fas fa-superpowers"></i></a></li>
          <li ><a href="#" rel="fas fa-telegram fas-3"><i class="fas fa-telegram"></i></a></li>
          <li ><a href="#" rel="fas fa-thermometer-full fas-3"><i class="fas fa-thermometer-full"></i></a></li>
          <li ><a href="#" rel="fas fa-thermometer-empty fas-3"><i class="fasfas-thermometer-empty"></i></a></li>
          <li ><a href="#" rel="fas fa-thermometer-quarter fas-3"><i class="fas fa-thermometer-quarter"></i></a></li>
          <li ><a href="#" rel="fas fa-thermometer-half fas-3"><i class="fas fa-thermometer-half"></i></a></li>
          <li ><a href="#" rel="fas fa-thermometer-three-quarters fas-3"><i class="fas fa-thermometer-three-quarters"></i></a></li>
          <li ><a href="#" rel="fas fa-window-close fas-3"><i class="fas fa-window-close"></i></a></li>
          <li ><a href="#" rel="fas fa-window-close-o fas-3"><i class="fas fa-window-close-o"></i></a></li>
          <li ><a href="#" rel="fas fa-window-maximize fas-3"><i class="fas fa-window-maximize"></i></a></li>
          <li ><a href="#" rel="fas fa-window-minimize fas-3"><i class="fas fa-window-minimize"></i></a></li>
          <li ><a href="#" rel="fas fa-window-restore fas-3"><i class="fas fa-window-restore"></i></a></li>
          <li ><a href="#" rel="fas fa-user-circle fas-3"><i class="fas fa-user-circle"></i></a></li>
          <li ><a href="#" rel="fas fa-user-circle-o fas-3"><i class="fas fa-user-circle-o"></i></a></li>
          <li ><a href="#" rel="fas fa-user fas-3"><i class="fas fa-user"></i></a></li>
          <li ><a href="#" rel="fas fa-user-o fas-3"><i class="fas fa-user-o"></i></a></li>
           <li ><a href="#" rel="fas fa-wpexplorer fas-3"><i class="fas fa-wpexplorer"></i></a></li>
          <li ><a href="#" rel="fas fa-adjust fas-3"><i class="fas fa-adjust"></i></a></li>
          <li ><a href="#" rel="fas fa-american-sign-language-interpreting fas-3"><i class="fas fa-american-sign-language-interpreting"></i></a></li>
          <li ><a href="#" rel="fas fa-anchor fas-3"><i class="fas fa-anchor"></i></a></li>
          <li ><a href="#" rel="fas fa-archive fas-3"><i class="fas fa-archive"></i></a></li>
          <li ><a href="#" rel="fas fa-area-chart fas-3"><i class="fas fa-area-chart"></i></a></li>
          <li ><a href="#" rel="fas fa-arrows fas-3"><i class="fas fa-arrows"></i></a></li>
          <li ><a href="#" rel="fas fa-arrows-h fas-3"><i class="fas fa-arrows-h"></i></a></li>
          <li ><a href="#" rel="fas fa-arrows-v fas-3"><i class="fas fa-arrows-v"></i></a></li>
          <li ><a href="#" rel="fas fa-assistive-listening-systems fas-3"><i class="fas fa-assistive-listening-systems"></i></a></li>
          <li ><a href="#" rel="fas fa-asterisk fas-3"><i class="fas fa-asterisk"></i></a></li>
          <li ><a href="#" rel="fas fa-at fas-3"><i class="fas fa-at"></i></a></li>
          <li ><a href="#" rel="fas fa-audio-description"><i class="fas fa-audio-description"></i></a></li>
          <li ><a href="#" rel="fas fa-car fas-3"><i class="fas fa-car"></i></a></li>
          <li ><a href="#" rel="fas fa-balance-scale fas-3"><i class="fas fa-balance-scale"></i></a></li>
          <li ><a href="#" rel="fas fa-ban fas-3"><i class="fas fa-ban"></i></a></li>
          <li ><a href="#" rel="fas fa-university fas-3"><i class="fas fa-university"></i></a></li>
          <li ><a href="#" rel="fas fa-bar-chart fas-3"><i class="fas fa-bar-chart"></i></a></li>
          <li ><a href="#" rel="fas fa-barcode fas-3"><i class="fas fa-barcode"></i></a></li>
          <li ><a href="#" rel="fas fa-bars fas-3"><i class="fas fa-bars"></i></a></li>
          <li ><a href="#" rel="fas fa-battery-full fas-3"><i class="fas fa-battery-full"></i></a></li>
          <li ><a href="#" rel="fas fa-battery-empty fas-3"><i class="fas fa-battery-empty"></i></a></li>
          <li ><a href="#" rel="fas fa-battery-quarter fas-3"><i class="fas fa-battery-quarter"></i></a></li>
          <li ><a href="#" rel="fas fa-battery-half fas-3"><i class="fas fa-battery-half"></i></a></li>
          <li ><a href="#" rel="fas fa-battery-three-quarters fas-3"><i class="fas fa-battery-three-quarters"></i></a></li>
          <li ><a href="#" rel="fas fa-battery-full fas-3"><i class="fas fa-battery-full"></i></a></li>
           <li ><a href="#" rel="fas fa-bed fas-3"><i class="fas fa-bed"></i></a></li>
          <li ><a href="#" rel="fas fa-beer fas-3"><i class="fas fa-beer"></i></a></li>
          <li ><a href="#" rel="fas fa-bell fas-3"><i class="fas fa-bell"></i></a></li>
          <li ><a href="#" rel="fas fa-bell-o fas-3"><i class="fas fa-bell-o"></i></a></li>
          <li ><a href="#" rel="fas fa-bell-slash fas-3"><i class="fas fa-bell-slash"></i></a></li>
           <li ><a href="#" rel="fas fa-bell-slash-o fas-3"><i class="fas fa-bell-slash-o"></i></a></li>
          <li ><a href="#" rel="fas fa-bicycle fas-3"><i class="fas fa-bicycle"></i></a></li>
          <li ><a href="#" rel="fas fa-binoculars fas-3"><i class="fas fa-binoculars"></i></a></li>
          <li ><a href="#" rel="fas fa-birthday-cake fas-3"><i class="fas fa-birthday-cake"></i></a></li>
          <li ><a href="#" rel="fas fa-blind fas-3"><i class="fas fa-blind"></i></a></li>
           <li ><a href="#" rel="fas fa-bluetooth fas-3"><i class="fas fa-bluetooth"></i></a></li>
          <li ><a href="#" rel="fas fa-bluetooth-b fas-3"><i class="fas fa-bluetooth-b"></i></a></li>
          <li ><a href="#" rel="fas fa-bolt fas-3"><i class="fas fa-bolt"></i></a></li>
          <li ><a href="#" rel="fas fa-bomb fas-3"><i class="fas fa-bomb"></i></a></li>
          <li ><a href="#" rel="fas fa-book fas-3"><i class="fas fa-book"></i></a></li>
           <li ><a href="#" rel="fas fa-bookmark fas-3"><i class="fas fa-bookmark"></i></a></li>
          <li ><a href="#" rel="fas fa-bookmark-o fas-3"><i class="fas fa-bookmark-o"></i></a></li>
          <li ><a href="#" rel="fas fa-braille fas-3"><i class="fas fa-braille"></i></a></li>
          <li ><a href="#" rel="fas fa-briefcase fas-3"><i class="fas fa-briefcase"></i></a></li>
          <li ><a href="#" rel="fas fa-bug fas-3"><i class="fas fa-bug"></i></a></li>
           <li ><a href="#" rel="fas fa-building fas-3"><i class="fas fa-building"></i></a></li>
          <li ><a href="#" rel="fas fa-building-o fas-3"><i class="fas fa-building-o"></i></a></li>
          <li ><a href="#" rel="fas fa-bullhorn fas-3"><i class="fas fa-bullhorn"></i></a></li>
          <li ><a href="#" rel="fas fa-bullseye fas-3"><i class="fas fa-bullseye"></i></a></li>
          <li ><a href="#" rel="fas fa-bus fas-3"><i class="fas fa-bus"></i></a></li>
           <li ><a href="#" rel="fas fa-taxi fas-3"><i class="fas fa-taxi"></i></a></li>
          <li ><a href="#" rel="fas fa-calculator fas-3"><i class="fas fa-calculator"></i></a></li>
          <li ><a href="#" rel="fas fa-calendar fas-3"><i class="fas fa-calendar"></i></a></li>
          <li ><a href="#" rel="fas fa-calendar-check-o fas-3"><i class="fas fa-calendar-check-o"></i></a></li>
          <li ><a href="#" rel="fas fa-calendar-minus-o fas-3"><i class="fas fa-calendar-minus-o"></i></a></li>
           <li ><a href="#" rel="fas fa-calendar-o fas-3"><i class="fas fa-calendar-o"></i></a></li>
          <li ><a href="#" rel="fas fa-calendar-plus-o fas-3"><i class="fas fa-calendar-plus-o"></i></a></li>
          <li ><a href="#" rel="fas fa-calendar-times-o fas-3"><i class="fas fa-calendar-times-o"></i></a></li>
          <li ><a href="#" rel="fas fa-camera fas-3"><i class="fas fa-camera"></i></a></li>
          <li ><a href="#" rel="fas fa-camera-retro fas-3"><i class="fas fa-camera-retro"></i></a></li>
           <li ><a href="#" rel="fas fa-caret-square-o-down fas-3"><i class="fas fa-caret-square-o-down"></i></a></li>
          <li ><a href="#" rel="fas fa-caret-square-o-left fas-3"><i class="fas fa-caret-square-o-left"></i></a></li>
          <li ><a href="#" rel="fas fa-caret-square-o-right fas-3"><i class="fas fa-caret-square-o-right"></i></a></li>
          <li ><a href="#" rel="fas fa-caret-square-o-up fas-3"><i class="fas fa-caret-square-o-up"></i></a></li>
          <li ><a href="#" rel="fas fa-cart-arrow-down fas-3"><i class="fas fa-cart-arrow-down"></i></a></li>
           <li ><a href="#" rel="fas fa-cart-plus fas-3"><i class="fas fa-cart-plus"></i></a></li>
          <li ><a href="#" rel="fas fa-cc fas-3"><i class="fas fa-cc"></i></a></li>
          <li ><a href="#" rel="fas fa-certificate fas-3"><i class="fas fa-certificate"></i></a></li>
          <li ><a href="#" rel="fas fa-check fas-3"><i class="fas fa-check"></i></a></li>
          <li ><a href="#" rel="fas fa-check-circle fas-3"><i class="fas fa-check-circle"></i></a></li>
           <li ><a href="#" rel="fas fa-check-circle-o fas-3"><i class="fas fa-check-circle-o"></i></a></li>
          <li ><a href="#" rel="fas fa-check-square fas-3"><i class="fas fa-check-square"></i></a></li>
          <li ><a href="#" rel="fas fa-check-square-o fas-3"><i class="fas fa-check-square-o"></i></a></li>
          <li ><a href="#" rel="fas fa-child fas-3"><i class="fas fa-child"></i></a></li>
          <li ><a href="#" rel="fas fa-circle fas-3"><i class="fas fa-circle"></i></a></li>
           <li ><a href="#" rel="fas fa-circle-o fas-3"><i class="fas fa-circle-o"></i></a></li>
          <li ><a href="#" rel="fas fa-circle-o-notch fas-3"><i class="fas fa-circle-o-notch"></i></a></li>
          <li ><a href="#" rel="fas fa-circle-thin fas-3"><i class="fas fa-circle-thin"></i></a></li>
          <li ><a href="#" rel="fas fa-clock-o fas-3"><i class="fas fa-clock-o"></i></a></li>
          <li ><a href="#" rel="fas fa-clone fas-3"><i class="fas fa-clone"></i></a></li>
           <li ><a href="#" rel="fas fa-times fas-3"><i class="fas fa-times"></i></a></li>
          <li ><a href="#" rel="fas fa-cloud fas-3"><i class="fas fa-cloud"></i></a></li>
          <li ><a href="#" rel="fas fa-cloud-download fas-3"><i class="fas fa-cloud-download"></i></a></li>
          <li ><a href="#" rel="fas fa-cloud-upload fas-3"><i class="fas fa-cloud-upload"></i></a></li>
          <li ><a href="#" rel="fas fa-code fas-3"><i class="fas fa-code"></i></a></li>
           <li ><a href="#" rel="fas fa-code-fork fas-3"><i class="fas fa-code-fork"></i></a></li>
          <li ><a href="#" rel="fas fa-coffee fas-3"><i class="fas fa-coffee"></i></a></li>
          <li ><a href="#" rel="fas fa-cog fas-3"><i class="fas fa-cog"></i></a></li>
          <li ><a href="#" rel="fas fa-cogs fas-3"><i class="fas fa-cogs"></i></a></li>
          <li ><a href="#" rel="fas fa-comment fas-3"><i class="fas fa-comment"></i></a></li>
           <li ><a href="#" rel="fas fa-comment-o fas-3"><i class="fas fa-comment-o"></i></a></li>
          <li ><a href="#" rel="fas fa-commenting fas-3"><i class="fas fa-commenting"></i></a></li>
          <li ><a href="#" rel="fas fa-commenting-o fas-3"><i class="fas fa-commenting-o"></i></a></li>
          <li ><a href="#" rel="fas fa-comments fas-3"><i class="fas fa-comments"></i></a></li>
          <li ><a href="#" rel="fas fa-comments-o fas-3"><i class="fas fa-comments-o"></i></a></li>
          <li ><a href="#" rel="fas fa-spinner fas-spin fas-3 fas-fw"><i class="fas fa-spinner fas-spin"></i></a></li>
           <li ><a href="#" rel="fas fa-circle-o-notch fas-spin fas-3 fas-fw"><i class="fas fa-circle-o-notch fas-spin"></i></a></li>
          <li ><a href="#" rel="fas fa-refresh fas-spin fas-3 fas-fw"><i class="fas fa-refresh fas-spin"></i></a></li>
          <li ><a href="#" rel="fas fa-compass fas-3"><i class="fas fa-compass"></i></a></li>
          <li ><a href="#" rel="fas fa-copyright fas-3"><i class="fas fa-copyright"></i></a></li>
          <li ><a href="#" rel="fas fa-creative-commons fas-3"><i class="fas fa-creative-commons"></i></a></li>
          <li ><a href="#" rel="fas fa-credit-card fas-3"><i class="fas fa-credit-card"></i></a></li>
          <li ><a href="#" rel="fas fa-credit-card-alt fas-3"><i class="fas fa-credit-card-alt"></i></a></li>
          <li ><a href="#" rel="fas fa-crop fas-3"><i class="fas fa-crop"></i></a></li>
          <li ><a href="#" rel="fas fa-crosshairs fas-3"><i class="fas fa-crosshairs"></i></a></li>
          <li ><a href="#" rel="fas fa-cube fas-3"><i class="fas fa-cube"></i></a></li>
           <li ><a href="#" rel="fas fa-cubes fas-3"><i class="fas fa-cubes"></i></a></li>
            <li ><a href="#" rel="fas fa-cutlery fas-3"><i class="fas fa-cutlery"></i></a></li>
            <li ><a href="#" rel="fas fa-tachometer fas-3"><i class="fas fa-tachometer"></i></a></li>
             <li ><a href="#" rel="fas fa-database fas-3"><i class="fas fa-database"></i></a></li>
             <li ><a href="#" rel="fas fa-deaf fas-3"><i class="fas fa-deaf"></i></a></li>
             <li ><a href="#" rel="fas fa-desktop fas-3"><i class="fas fa-desktop"></i></a></li>
             <li ><a href="#" rel="fas fa-diamond fas-3"><i class="fas fa-diamond"></i></a></li>
             <li ><a href="#" rel="fas fa-download fas-3"><i class="fas fa-download"></i></a></li>
             <li ><a href="#" rel="fas fa-dot-circle-o fas-3"><i class="fas fa-dot-circle-o"></i></a></li>
            <li ><a href="#" rel="fas fa-pencil-square-o fas-3"><i class="fas fa-pencil-square-o"></i></a></li>
            <li ><a href="#" rel="fas fa-ellipsis-h fas-3"><i class="fas fa-ellipsis-h"></i></a></li>
             <li ><a href="#" rel="fas fa-ellipsis-v fas-3"><i class="fas fa-ellipsis-h"></i></a></li>
            <li ><a href="#" rel="fas fa-envelope fas-3"><i class="fas fa-envelope"></i></a></li>
            <li ><a href="#" rel="fas fa-envelope-o fas-3"><i class="fas fa-envelope-o"></i></a></li>
             <li ><a href="#" rel="fas fa-envelope-square fas-3"><i class="fas fa-envelope-square"></i></a></li>
            <li ><a href="#" rel="fas fa-eraser fas-3"><i class="fas fa-eraser"></i></a></li>
            <li ><a href="#" rel="fas fa-exchange fas-3"><i class="fas fa-exchange"></i></a></li>
             <li ><a href="#" rel="fas fa-exclamation fas-3"><i class="fas fa-exclamation"></i></a></li>
              <li ><a href="#" rel="fas fa-exclamation-circle fas-3"><i class="fas fa-exclamation-circle"></i></a></li>
              <li ><a href="#" rel="fas fa-exclamation-triangle fas-3"><i class="fas fa-exclamation-triangle"></i></a></li>
              <li ><a href="#" rel="fas fa-external-link fas-3"><i class="fas fa-external-link"></i></a></li>
              <li ><a href="#" rel="fas fa-external-link-square fas-3"><i class="fas fa-external-link-square"></i></a></li>
              <li ><a href="#" rel="fas fa-eye fas-3"><i class="fas fa-eye"></i></a></li>
              <li ><a href="#" rel="fas fa-eye-slash fas-3"><i class="fas fa-eye-slash"></i></a></li>
              <li ><a href="#" rel="fas fa-eyedropper fas-3"><i class="fas fa-eyedropper"></i></a></li>
              <li ><a href="#" rel="fas fa-fasx fas-3"><i class="fas fa-fasx"></i></a></li>
               <li ><a href="#" rel="fas fa-rss fas-3"><i class="fas fa-rss"></i></a></li>
                <li ><a href="#" rel="fas fa-rss-square fas-3"><i class="fas fa-rss-square"></i></a></li>
               <li ><a href="#" rel="fas fa-female fas-3"><i class="fas fa-female"></i></a></li>
               <li ><a href="#" rel="fas fa-fighter-jet fas-3"><i class="fas fa-fighter-jet"></i></a></li>
               <li ><a href="#" rel="fas fa-file fas-3"><i class="fas fa-file"></i></a></li>
               <li ><a href="#" rel="fas fa-file-o fas-3"><i class="fas fa-file-o"></i></a></li>
               <li ><a href="#" rel="fas fa-file-archive-o fas-3"><i class="fas fa-file-archive-o"></i></a></li>
               <li ><a href="#" rel="fas fa-file-audio-o fas-3"><i class="fas fa-file-audio-o"></i></a></li>
               <li ><a href="#" rel="fas fa-file-code-o fas-3"><i class="fas fa-file-code-o"></i></a></li>
                <li ><a href="#" rel="fas fa-file-excel-o fas-3"><i class="fas fa-file-excel-o"></i></a></li>
                <li ><a href="#" rel="fas fa-file-image-o fas-3"><i class="fas fa-file-image-o"></i></a></li>
                <li ><a href="#" rel="fas fa-file-video-o fas-3"><i class="fas fa-file-video-o"></i></a></li>
                <li ><a href="#" rel="fas fa-file-pdf-o fas-3"><i class="fas fa-file-pdf-o"></i></a></li>
                <li ><a href="#" rel="fas fa-file-powerpoint-o fas-3"><i class="fas fa-file-powerpoint-o"></i></a></li>
                <li ><a href="#" rel="fas fa-file-text fas-3"><i class="fas fa-file-text"></i></a></li>
                <li ><a href="#" rel="fas fa-file-text-o fas-3"><i class="fas fa-file-text-o"></i></a></li>
                <li ><a href="#" rel="fas fa-file-word-o fas-3"><i class="fas fa-file-word-o"></i></a></li>
                <li ><a href="#" rel="fas fa-film fas-3"><i class="fas fa-film"></i></a></li>
                <li ><a href="#" rel="fas fa-filter fas-3"><i class="fas fa-filter"></i></a></li>
                <li ><a href="#" rel="fas fa-fire fas-3"><i class="fas fa-fire"></i></a></li>
                 <li ><a href="#" rel="fas fa-fire-extinguisher fas-3"><i class="fas fa-fire-extinguisher"></i></a></li>
                 <li ><a href="#" rel="fas fa-flag fas-3"><i class="fas fa-flag"></i></a></li>
                 <li ><a href="#" rel="fas fa-flag-checkered fas-3"><i class="fas fa-flag-checkered"></i></a></li>
                <li ><a href="#" rel="fas fa-flag-o fas-3"><i class="fas fa-flag-o"></i></a></li>
                <li ><a href="#" rel="fas fa-flask fas-3"><i class="fas fa-flask"></i></a></li>
                <li ><a href="#" rel="fas fa-folder fas-3"><i class="fas fa-folder"></i></a></li>
                <li ><a href="#" rel="fas fa-folder-o fas-3"><i class="fas fa-folder-o"></i></a></li>
                <li ><a href="#" rel="fas fa-folder-open fas-3"><i class="fas fa-folder-open"></i></a></li>
                <li ><a href="#" rel="fas fa-folder-open-o fas-3"><i class="fas fa-folder-open-o"></i></a></li>
                <li ><a href="#" rel="fas fa-frown-o fas-3"><i class="fas fa-frown-o"></i></a></li>
                <li ><a href="#" rel="fas fa-futbol-o fas-3"><i class="fas fa-futbol-o"></i></a></li>
               <li ><a href="#" rel="fas fa-gamepad fas-3"><i class="fas fa-gamepad"></i></a></li>
               <li ><a href="#" rel="fas fa-gavel fas-3"><i class="fas fa-gavel"></i></a></li>
               <li ><a href="#" rel="fas fa-gift fas-3"><i class="fas fa-gift"></i></a></li>
               <li ><a href="#" rel="fas fa-glass fas-3"><i class="fas fa-glass"></i></a></li>
               <li ><a href="#" rel="fas fa-globe fas-3"><i class="fas fa-globe"></i></a></li>
               <li ><a href="#" rel="fas fa-graduation-cap fas-3"><i class="fas fa-graduation-cap"></i></a></li>
               <li ><a href="#" rel="fas fa-users fas-3"><i class="fas fa-users"></i></a></li>
               <li ><a href="#" rel="fas fa-hand-rock-o fas-3"><i class="fas fa-hand-rock-o"></i></a></li>
               <li ><a href="#" rel="fas fa-hand-lizard-o fas-3"><i class="fas fa-hand-lizard-o"></i></a></li>
               <li ><a href="#" rel="fas fa-hand-paper-o fas-3"><i class="fas fa-hand-paper-o"></i></a></li>
               <li ><a href="#" rel="fas fa-hand-peace-o fas-3"><i class="fas fa-hand-peace-o"></i></a></li>
               <li ><a href="#" rel="fas fa-hand-pointer-o fas-3"><i class="fas fa-hand-pointer-o"></i></a></li>
               <li ><a href="#" rel="fas fa-hand-scissors-o fas-3"><i class="fas fa-hand-scissors-o"></i></a></li>
               <li ><a href="#" rel="fas fa-hand-spock-o fas-3"><i class="fas fa-hand-spock-o"></i></a></li>
               <li ><a href="#" rel="fas fa-hashtag fas-3"><i class="fas fa-hashtag"></i></a></li>
               <li ><a href="#" rel="fas fa-hdd-o fas-3"><i class="fas fa-hdd-o"></i></a></li>
               <li ><a href="#" rel="fas fa-headphones fas-3"><i class="fas fa-headphones"></i></a></li>
               <li ><a href="#" rel="fas fa-heart fas-3"><i class="fas fa-heart"></i></a></li>
               <li ><a href="#" rel="fas fa-heart-o fas-3"><i class="fas fa-heart-o"></i></a></li>
               <li ><a href="#" rel="fas fa-heartbeat fas-3"><i class="fas fa-heartbeat"></i></a></li>
               <li ><a href="#" rel="fas fa-history fas-3"><i class="fas fa-history"></i></a></li>
               <li ><a href="#" rel="fas fa-home fas-3"><i class="fas fa-home"></i></a></li>
               <li ><a href="#" rel="fas fa-hourglass fas-3"><i class="fas fa-hourglass"></i></a></li>
               <li ><a href="#" rel="fas fa-hourglass-start fas-3"><i class="fas fa-hourglass-start"></i></a></li>
               <li ><a href="#" rel="fas fa-hourglass-half fas-3"><i class="fas fa-hourglass-half"></i></a></li>
               <li ><a href="#" rel="fas fa-hourglass-end fas-3"><i class="fas fa-hourglass-end"></i></a></li>
               <li ><a href="#" rel="fas fa-hourglass-o fas-3"><i class="fas fa-hourglass-o"></i></a></li>
               <li ><a href="#" rel="fas fa-i-cursor fas-3"><i class="fas fa-i-cursor"></i></a></li>
               <li ><a href="#" rel="fas fa-inbox fas-3"><i class="fas fa-inbox"></i></a></li>
                <li ><a href="#" rel="fas fa-industry fas-3"><i class="fas fa-industry"></i></a></li>
                <li ><a href="#" rel="fas fa-info fas-3"><i class="fas fa-info"></i></a></li>
                <li ><a href="#" rel="fas fa-info-circle fas-3"><i class="fas fa-info-circle"></i></a></li>
                <li ><a href="#" rel="fas fa-key fas-3"><i class="fas fa-key"></i></a></li>
                <li ><a href="#" rel="fas fa-keyboard-o fas-3"><i class="fas fa-keyboard-o"></i></a></li>
                <li ><a href="#" rel="fas fa-language fas-3"><i class="fas fa-language"></i></a></li>
                <li ><a href="#" rel="fas fa-laptop fas-3"><i class="fas fa-laptop"></i></a></li>
                <li ><a href="#" rel="fas fa-leaf fas-3"><i class="fas fa-leaf"></i></a></li>
                <li ><a href="#" rel="fas fa-lemon-o fas-3"><i class="fas fa-lemon-o"></i></a></li>
                <li ><a href="#" rel="fas fa-level-down fas-3"><i class="fas fa-level-down"></i></a></li>
                <li ><a href="#" rel="fas fa-level-up fas-3"><i class="fas fa-level-up"></i></a></li>
                <li ><a href="#" rel="fas fa-life-ring fas-3"><i class="fas fa-life-ring"></i></a></li>
                <li ><a href="#" rel="fas fa-lightbulb-o fas-3"><i class="fas fa-lightbulb-o"></i></a></li>
                <li ><a href="#" rel="fas fa-line-chart fas-3"><i class="fas fa-line-chart"></i></a></li>
                <li ><a href="#" rel="fas fa-location-arrow fas-3"><i class="fas fa-location-arrow"></i></a></li>
                <li ><a href="#" rel="fas fa-lock fas-3"><i class="fas fa-lock"></i></a></li>
                <li ><a href="#" rel="fas fa-low-vision fas-3"><i class="fas fa-low-vision"></i></a></li>
                <li ><a href="#" rel="fas fa-magic fas-3"><i class="fas fa-magic"></i></a></li>
                <li ><a href="#" rel="fas fa-magnet fas-3"><i class="fas fa-magnet"></i></a></li>
                <li ><a href="#" rel="fas fa-share fas-3"><i class="fas fa-share"></i></a></li>
                <li ><a href="#" rel="fas fa-reply fas-3"><i class="fas fa-reply"></i></a></li>
                <li ><a href="#" rel="fas fa-reply-all fas-3"><i class="fas fa-reply-all"></i></a></li>
                <li ><a href="#" rel="fas fa-male fas-3"><i class="fas fa-male"></i></a></li>
                <li ><a href="#" rel="fas fa-map fas-3"><i class="fas fa-map"></i></a></li>
                <li ><a href="#" rel="fas fa-map-marker fas-3"><i class="fas fa-map-marker"></i></a></li>
                <li ><a href="#" rel="fas fa-map-o fas-3"><i class="fas fa-map-o"></i></a></li>
                <li ><a href="#" rel="fas fa-map-pin fas-3"><i class="fas fa-map-pin"></i></a></li>
                <li ><a href="#" rel="fas fa-map-signs fas-3"><i class="fas fa-map-signs"></i></a></li>
                <li ><a href="#" rel="fas fa-meh-o fas-3"><i class="fas fa-meh-o"></i></a></li>
                <li ><a href="#" rel="fas fa-microchip fas-3"><i class="fas fa-microchip"></i></a></li>
                <li ><a href="#" rel="fas fa-microphone fas-3"><i class="fas fa-microphone"></i></a></li>
                <li ><a href="#" rel="fas fa-microphone-slash fas-3"><i class="fas fa-microphone-slash"></i></a></li>
                <li ><a href="#" rel="fas fa-minus fas-3"><i class="fas fa-minus"></i></a></li>
                <li ><a href="#" rel="fas fa-minus-circle fas-3"><i class="fas fa-minus-circle"></i></a></li>
                <li ><a href="#" rel="fas fa-minus-square fas-3"><i class="fas fa-minus-square"></i></a></li>
                <li ><a href="#" rel="fas fa-minus-square-o fas-3"><i class="fas fa-minus-square-o"></i></a></li>
                <li ><a href="#" rel="fas fa-mobile fas-3"><i class="fas fa-mobile"></i></a></li>
                <li ><a href="#" rel="fas fa-money fas-3"><i class="fas fa-money"></i></a></li>
                <li ><a href="#" rel="fas fa-moon-o fas-3"><i class="fas fa-moon-o"></i></a></li>
                <li ><a href="#" rel="fas fa-motorcycle fas-3"><i class="fas fa-motorcycle"></i></a></li>
                <li ><a href="#" rel="fas fa-mouse-pointer fas-3"><i class="fas fa-mouse-pointer"></i></a></li>
                <li ><a href="#" rel="fas fa-music fas-3"><i class="fas fa-music"></i></a></li>
                <li ><a href="#" rel="fas fa-newspaper-o fas-3"><i class="fas fa-newspaper-o"></i></a></li>
               <li ><a href="#" rel="fas fa-object-group fas-3"><i class="fas fa-object-group"></i></a></li>
               <li ><a href="#" rel="fas fa-object-ungroup fas-3"><i class="fas fa-object-ungroup"></i></a></li>
               <li ><a href="#" rel="fas fa-paint-brush fas-3"><i class="fas fa-paint-brush"></i></a></li>
               <li ><a href="#" rel="fas fa-paper-plane fas-3"><i class="fas fa-paper-plane"></i></a></li>
               <li ><a href="#" rel="fas fa-paper-plane-o fas-3"><i class="fas fa-paper-plane-o"></i></a></li>
               <li ><a href="#" rel="fas fa-paw fas-3"><i class="fas fa-paw"></i></a></li>
               <li ><a href="#" rel="fas fa-pencil fas-3"><i class="fas fa-pencil"></i></a></li>
               <li ><a href="#" rel="fas fa-pencil-square fas-3"><i class="fas fa-pencil-square"></i></a></li>
               <li ><a href="#" rel="fas fa-pencil-square-o fas-3"><i class="fas fa-pencil-square-o"></i></a></li>
               <li ><a href="#" rel="fas fa-percent fas-3"><i class="fas fa-percent"></i></a></li>
               <li ><a href="#" rel="fas fa-phone fas-3"><i class="fas fa-phone"></i></a></li>
               <li ><a href="#" rel="fas fa-phone-square fas-3"><i class="fas fa-phone-square"></i></a></li>
               <li ><a href="#" rel="fas fa-picture-o fas-3"><i class="fas fa-picture-o"></i></a></li>
               <li ><a href="#" rel="fas fa-pie-chart fas-3"><i class="fas fa-pie-chart"></i></a></li>
               <li ><a href="#" rel="fas fa-plane fas-3"><i class="fas fa-plane"></i></a></li>
               <li ><a href="#" rel="fas fa-plug fas-3"><i class="fas fa-plug"></i></a></li>
               <li ><a href="#" rel="fas fa-plus fas-3"><i class="fas fa-plus"></i></a></li>
               <li ><a href="#" rel="fas fa-plus-circle fas-3"><i class="fas fa-plus-circle"></i></a></li>
               <li ><a href="#" rel="fas fa-plus-square fas-3"><i class="fas fa-plus-square"></i></a></li>
               <li ><a href="#" rel="fas fa-plus-square-o fas-3"><i class="fas fa-plus-square-o"></i></a></li>
               <li ><a href="#" rel="fas fa-podcast fas-3"><i class="fas fa-podcast"></i></a></li>
              <li ><a href="#" rel="fas fa-power-off fas-3"><i class="fas fa-power-off"></i></a></li>
              <li ><a href="#" rel="fas fa-print fas-3"><i class="fas fa-print"></i></a></li>
              <li ><a href="#" rel="fas fa-puzzle-piece fas-3"><i class="fas fa-puzzle-piece"></i></a></li>
              <li ><a href="#" rel="fas fa-qrcode fas-3"><i class="fas fa-qrcode"></i></a></li>
              <li ><a href="#" rel="fas fa-question fas-3"><i class="fas fa-question"></i></a></li>
              <li ><a href="#" rel="fas fa-question-circle fas-3"><i class="fas fa-question-circle"></i></a></li>
              <li ><a href="#" rel="fas fa-question-circle-o fas-3"><i class="fas fa-question-circle-o"></i></a></li>
              <li ><a href="#" rel="fas fa-quote-left fas-3"><i class="fas fa-quote-left"></i></a></li>
              <li ><a href="#" rel="fas fa-quote-right fas-3"><i class="fas fa-quote-right"></i></a></li>
              <li ><a href="#" rel="fas fa-random fas-3"><i class="fas fa-random"></i></a></li>
              <li ><a href="#" rel="fas fa-recycle fas-3"><i class="fas fa-recycle"></i></a></li>
              <li ><a href="#" rel="fas fa-refresh fas-3"><i class="fas fa-refresh"></i></a></li>
              <li ><a href="#" rel="fas fa-registered fas-3"><i class="fas fa-registered"></i></a></li>
              <li ><a href="#" rel="fas fa-retweet fas-3"><i class="fas fa-retweet"></i></a></li>
              <li ><a href="#" rel="fas fa-road fas-3"><i class="fas fa-road"></i></a></li>
              <li ><a href="#" rel="fas fa-rocket fas-3"><i class="fas fa-rocket"></i></a></li>
              <li ><a href="#" rel="fas fa-search fas-3"><i class="fas fa-search"></i></a></li>
              <li ><a href="#" rel="fas fa-search-minus fas-3"><i class="fas fa-search-minus"></i></a></li>
              <li ><a href="#" rel="fas fa-search-plus fas-3"><i class="fas fa-search-plus"></i></a></li>
              <li ><a href="#" rel="fas fa-server fas-3"><i class="fas fa-server"></i></a></li>
              <li ><a href="#" rel="fas fa-share-alt fas-3"><i class="fas fa-share-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-share-alt-square fas-3"><i class="fas fa-share-alt-square"></i></a></li>
              <li ><a href="#" rel="fas fa-share-square fas-3"><i class="fas fa-share-square"></i></a></li>
              <li ><a href="#" rel="fas fa-share-square-o fas-3"><i class="fas fa-share-square-o"></i></a></li>
              <li ><a href="#" rel="fas fa-shield fas-3"><i class="fas fa-shield"></i></a></li>
              <li ><a href="#" rel="fas fa-ship fas-3"><i class="fas fa-ship"></i></a></li>  
              <li ><a href="#" rel="fas fa-shopping-bag fas-3"><i class="fas fa-shopping-bag"></i></a></li>
              <li ><a href="#" rel="fas fa-shopping-basket fas-3"><i class="fas fa-shopping-basket"></i></a></li>
              <li ><a href="#" rel="fas fa-shopping-cart fas-3"><i class="fas fa-shopping-cart"></i></a></li>
              <li ><a href="#" rel="fas fa-shower fas-3"><i class="fas fa-shower"></i></a></li>
              <li ><a href="#" rel="fas fa-sign-in fas-3"><i class="fas fa-sign-in"></i></a></li>
              <li ><a href="#" rel="fas fa-sign-language fas-3"><i class="fas fa-sign-language"></i></a></li>
              <li ><a href="#" rel="fas fa-sign-out fas-3"><i class="fas fa-sign-out"></i></a></li>
              <li ><a href="#" rel="fas fa-signal fas-3"><i class="fas fa-signal"></i></a></li>
              <li ><a href="#" rel="fas fa-sitemap fas-3"><i class="fas fa-sitemap"></i></a></li>
              <li ><a href="#" rel="fas fa-sliders fas-3"><i class="fas fa-sliders"></i></a></li>
              <li ><a href="#" rel="fas fa-smile-o fas-3"><i class="fas fa-smile-o"></i></a></li>
              <li ><a href="#" rel="fas fa-sort fas-3"><i class="fas fa-sort"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-alpha-asc fas-3"><i class="fas fa-sort-alpha-asc"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-alpha-desc fas-3"><i class="fas fa-sort-alpha-desc"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-amount-asc fas-3"><i class="fas fa-sort-amount-asc"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-amount-desc fas-3"><i class="fas fa-sort-amount-desc"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-asc fas-3"><i class="fas fa-sort-asc"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-desc fas-3"><i class="fas fa-sort-desc"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-numeric-asc fas-3"><i class="fas fa-sort-numeric-asc"></i></a></li>
              <li ><a href="#" rel="fas fa-sort-numeric-desc fas-3"><i class="fas fa-sort-numeric-desc"></i></a></li>
              <li ><a href="#" rel="fas fa-space-shuttle fas-3"><i class="fas fa-space-shuttle"></i></a></li>
              <li ><a href="#" rel="fas fa-spinner fas-3"><i class="fas fa-spinner"></i></a></li>
              <li ><a href="#" rel="fas fa-spoon fas-3"><i class="fas fa-spoon"></i></a></li>
              <li ><a href="#" rel="fas fa-square fas-3"><i class="fas fa-square"></i></a></li>
              <li ><a href="#" rel="fas fa-square-o fas-3"><i class="fas fa-square-o"></i></a></li>
              <li ><a href="#" rel="fas fa-star fas-3"><i class="fas fa-star"></i></a></li>
              <li ><a href="#" rel="fas fa-star-half fas-3"><i class="fas fa-star-half"></i></a></li>
              <li ><a href="#" rel="fas fa-star-half-o fas-3"><i class="fas fa-star-half-o"></i></a></li>
              <li ><a href="#" rel="fas fa-star-o fas-3"><i class="fas fa-star-o"></i></a></li>
              <li ><a href="#" rel="fas fa-sticky-note fas-3"><i class="fas fa-sticky-note"></i></a></li>
              <li ><a href="#" rel="fas fa-sticky-note-o fas-3"><i class="fas fa-sticky-note-o"></i></a></li>
              <li ><a href="#" rel="fas fa-street-view fas-3"><i class="fas fa-street-view"></i></a></li>
              <li ><a href="#" rel="fas fa-suitcase fas-3"><i class="fas fa-suitcase"></i></a></li>
              <li ><a href="#" rel="fas fa-sun-o fas-3"><i class="fas fa-sun-o"></i></a></li>
              <li ><a href="#" rel="fas fa-tablet fas-3"><i class="fas fa-tablet"></i></a></li>
              <li ><a href="#" rel="fas fa-tag fas-3"><i class="fas fa-tag"></i></a></li>
              <li ><a href="#" rel="fas fa-tags  fas-3"><i class="fas fa-tags"></i></a></li>
              <li ><a href="#" rel="fas fa-tasks fas-3"><i class="fas fa-tasks"></i></a></li>
              <li ><a href="#" rel="fas fa-television fas-3"><i class="fas fa-television"></i></a></li>
              <li ><a href="#" rel="fas fa-terminal fas-3"><i class="fas fa-terminal"></i></a></li>
              <li ><a href="#" rel="fas fa-thumb-tack fas-3"><i class="fas fa-thumb-tack"></i></a></li>
              <li ><a href="#" rel="fas fa-thumbs-down fas-3"><i class="fas fa-thumbs-down"></i></a></li>
              <li ><a href="#" rel="fas fa-thumbs-o-down fas-3"><i class="fas fa-thumbs-o-down"></i></a></li>
              <li ><a href="#" rel="fas fa-thumbs-o-up fas-3"><i class="fas fa-thumbs-o-up"></i></a></li>
              <li ><a href="#" rel="fas fa-thumbs-up fas-3"><i class="fas fa-thumbs-up"></i></a></li>
              <li ><a href="#" rel="fas fa-ticket fas-3"><i class="fas fa-ticket"></i></a></li>
              <li ><a href="#" rel="fas fa-times-circle fas-3"><i class="fas fa-times-circle"></i></a></li>
              <li ><a href="#" rel="fas fa-times-circle-o fas-3"><i class="fas fa-times-circle-o"></i></a></li>
              <li ><a href="#" rel="fas fa-tint fas-3"><i class="fas fa-tint"></i></a></li>
              <li ><a href="#" rel="fas fa-toggle-off fas-3"><i class="fas fa-toggle-off"></i></a></li>
              <li ><a href="#" rel="fas fa-toggle-on fas-3"><i class="fas fa-toggle-on"></i></a></li>
              <li ><a href="#" rel="fas fa-trademark fas-3"><i class="fas fa-trademark"></i></a></li>
              <li ><a href="#" rel="fas fa-trash fas-3"><i class="fas fa-trash"></i></a></li>
              <li ><a href="#" rel="fas fa-trash-o fas-3"><i class="fas fa-trash-o"></i></a></li>
              <li ><a href="#" rel="fas fa-tree fas-3"><i class="fas fa-tree"></i></a></li>
              <li ><a href="#" rel="fas fa-trophy fas-3"><i class="fas fa-trophy"></i></a></li>
              <li ><a href="#" rel="fas fa-truck fas-3"><i class="fas fa-truck"></i></a></li>
              <li ><a href="#" rel="fas fa-tty fas-3"><i class="fas fa-tty"></i></a></li>
              <li ><a href="#" rel="fas fa-umbrella fas-3"><i class="fas fa-umbrella"></i></a></li>
              <li ><a href="#" rel="fas fa-universal-access fas-3"><i class="fas fa-universal-access"></i></a></li>
              <li ><a href="#" rel="fas fa-unlock fas-3"><i class="fas fa-unlock"></i></a></li>
              <li ><a href="#" rel="fas fa-unlock-alt fas-3"><i class="fas fa-unlock-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-upload fas-3"><i class="fas fa-upload"></i></a></li>
              <li ><a href="#" rel="fas fa-user-plus fas-3"><i class="fas fa-user-plus"></i></a></li>
              <li ><a href="#" rel="fas fa-user-secret fas-3"><i class="fas fa-user-secret"></i></a></li>
              <li ><a href="#" rel="fas fa-user-times fas-3"><i class="fas fa-user-times"></i></a></li>
              <li ><a href="#" rel="fas fa-video-camera fas-3"><i class="fas fa-video-camera"></i></a></li>
              <li ><a href="#" rel="fas fa-volume-control-phone fas-3"><i class="fas fa-volume-control-phone"></i></a></li>
              <li ><a href="#" rel="fas fa-volume-down fas-3"><i class="fas fa-volume-down"></i></a></li>
              <li ><a href="#" rel="fas fa-volume-off fas-3"><i class="fas fa-volume-off"></i></a></li>
              <li ><a href="#" rel="fas fa-volume-up fas-3"><i class="fas fa-volume-up"></i></a></li>
              <li ><a href="#" rel="fas fa-wheelchair fas-3"><i class="fas fa-wheelchair"></i></a></li>
              <li ><a href="#" rel="fas fa-wheelchair-alt fas-3"><i class="fas fa-wheelchair-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-wifi fas-3"><i class="fas fa-wifi"></i></a></li>
              <li ><a href="#" rel="fas fa-wrench fas-3"><i class="fas fa-wrench"></i></a></li>
              <li ><a href="#" rel="fas fa-audio-description fas-3"><i class="fas fa-audio-description"></i></a></li>
              <li ><a href="#" rel="fas fa-ambulance fas-3"><i class="fas fa-ambulance"></i></a></li>
              <li ><a href="#" rel="fas fa-subway fas-3"><i class="fas fa-subway"></i></a></li>
              <li ><a href="#" rel="fas fa-train fas-3"><i class="fas fa-train"></i></a></li>
              <li ><a href="#" rel="fas fa-genderless fas-3"><i class="fas fa-genderless"></i></a></li>
              <li ><a href="#" rel="fas fa-transgender fas-3"><i class="fas fa-transgender"></i></a></li>
              <li ><a href="#" rel="fas fa-mars fas-3"><i class="fas fa-mars"></i></a></li>
              <li ><a href="#" rel="fas fa-mars-double fas-3"><i class="fas fa-mars-double"></i></a></li>
               <li ><a href="#" rel="fas fa-mars-stroke fas-3"><i class="fas fa-mars-stroke"></i></a></li>
              <li ><a href="#" rel="fas ffas-mars-stroke-h fas-3"><i class="fas fa-mars-stroke-h"></i></a></li>
               <li ><a href="#" rel="fas fa-mars-stroke-v fas-3"><i class="fas fa-mars-stroke-v"></i></a></li>
               <li ><a href="#" rel="fas fa-mercury fas-3"><i class="fas fa-mercury"></i></a></li>
              <li ><a href="#" rel="fas fa-neuter fas-3"><i class="fas fa-neuter"></i></a></li>
               <li ><a href="#" rel="fas fa-transgender-alt fas-3"><i class="fas fa-transgender-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-venus fas-3"><i class="fas fa-venus"></i></a></li>
               <li ><a href="#" rel="fas fa-venus-double fas-3"><i class="fas fa-venus-double"></i></a></li>
              <li ><a href="#" rel="fas fa-venus-mars fas-3"><i class="fas fa-venus-mars"></i></a></li>
              <li ><a href="#" rel="fas fa-cc-amex fas-3"><i class="fas fa-cc-amex"></i></a></li>
             <li ><a href="#" rel="fas fa-cc-diners-club fas-3"><i class="fas fa-cc-diners-club"></i></a></li>
             <li ><a href="#" rel="fas fa-cc-discover fas-3"><i class="fas fa-cc-discover"></i></a></li>
            <li ><a href="#" rel="fas fa-cc-jcb fas-3"><i class="fas fa-cc-jcb"></i></a></li>
            <li ><a href="#" rel="fas fa-cc-mastercard fas-3"><i class="fas fa-cc-mastercard"></i></a></li>
            <li ><a href="#" rel="fas fa-cc-paypal fas-3"><i class="fas fa-cc-paypal"></i></a></li>
            <li ><a href="#" rel="fas fa-cc-stripe fas-3"><i class="fas fa-cc-stripe"></i></a></li>
            <li ><a href="#" rel="fas fa-cc-visa fas-3"><i class="fas fa-cc-visa"></i></a></li>
             <li ><a href="#" rel="fas fa-google-wallet fas-3"><i class="fas fa-google-wallet"></i></a></li>
             <li ><a href="#" rel="fas fa-paypal  fas-3"><i class="fas fa-paypal"></i></a></li>
             <li ><a href="#" rel="fas fa-btc fas-3"><i class="fas fa-btc"></i></a></li>
             <li ><a href="#" rel="fas fa-usd fas-3"><i class="fas fa-usd"></i></a></li>
             <li ><a href="#" rel="fas fa-eur fas-3"><i class="fas fa-eur"></i></a></li>
             <li ><a href="#" rel="fas fa-gbp fas-3"><i class="fas fa-gbp"></i></a></li>
             <li ><a href="#" rel="fas fa-gg fas-3"><i class="fas fa-gg"></i></a></li>
             <li ><a href="#" rel="fas fa-gg-circle fas-3"><i class="fas fa-gg-circle"></i></a></li>
             <li ><a href="#" rel="fas fa-ils fas-3"><i class="fas fa-ils"></i></a></li>
             <li ><a href="#" rel="fas fa-inr fas-3"><i class="fas fa-inr"></i></a></li>
             <li ><a href="#" rel="fas fa-jpy fas-3"><i class="fas fa-jpy"></i></a></li>
             <li ><a href="#" rel="fas fa-krw fas-3"><i class="fas fa-krw"></i></a></li>
             <li ><a href="#" rel="fas fa-rub fas-3"><i class="fas fa-rub"></i></a></li>
             <li ><a href="#" rel="fas fa-try fas-3"><i class="fas fa-try"></i></a></li>
             <li ><a href="#" rel="fas fa-align-center fas-3"><i class="fas fa-align-center"></i></a></li>
             <li ><a href="#" rel="fas fa-align-justify fas-3"><i class="fas fa-align-justify"></i></a></li>
             <li ><a href="#" rel="fas fa-align-left fas-3"><i class="fas fa-align-left"></i></a></li>
             <li ><a href="#" rel="fas fa-align-right fas-3"><i class="fas fa-align-right"></i></a></li>
             <li ><a href="#" rel="fas fa-bold fas-3"><i class="fas fa-bold"></i></a></li>
             <li ><a href="#" rel="fas fa-link fas-3"><i class="fas fa-link"></i></a></li>
             <li ><a href="#" rel="fas fa-chain-broken fas-3"><i class="fas fa-chain-broken"></i></a></li>
             <li ><a href="#" rel="fas fa-clipboard fas-3"><i class="fas fa-clipboard"></i></a></li>
             <li ><a href="#" rel="fas fa-columns fas-3"><i class="fas fa-columns"></i></a></li>
             <li ><a href="#" rel="fas fa-files-o fas-3"><i class="fas fa-files-o"></i></a></li>
             <li ><a href="#" rel="fas fa-scissors fas-3"><i class="fas fa-scissors"></i></a></li>
             <li ><a href="#" rel="fas fa-outdent fas-3"><i class="fas fa-outdent"></i></a></li>
             <li ><a href="#" rel="fas fa-floppy-o fas-3"><i class="fas fa-floppy-o"></i></a></li>
             <li ><a href="#" rel="fas fa-font fas-3"><i class="fas fa-font"></i></a></li>
             <li ><a href="#" rel="fas fa-header fas-3"><i class="fas fa-header"></i></a></li>
             <li ><a href="#" rel="fas fa-indent fas-3"><i class="fas fa-indent"></i></a></li>
             <li ><a href="#" rel="fas fa-italic fas-3"><i class="fas fa-italic"></i></a></li>
             <li ><a href="#" rel="fas fa-list fas-3"><i class="fas fa-list"></i></a></li>
             <li ><a href="#" rel="fas fa-list-alt fas-3"><i class="fas fa-list-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-list-ol fas-3"><i class="fas fa-list-ol"></i></a></li>
              <li ><a href="#" rel="fas fa-list-ul fas-3"><i class="fas fa-list-ul"></i></a></li>
              <li ><a href="#" rel="fas fa-paperclip fas-3"><i class="fas fa-paperclip"></i></a></li>
              <li ><a href="#" rel="fas fa-paragraph fas-3"><i class="fas fa-paragraph"></i></a></li>
              <li ><a href="#" rel="fas fa-repeat fas-3"><i class="fas fa-repeat"></i></a></li>
              <li ><a href="#" rel="fas fa-undo fas-3"><i class="fas fa-undo"></i></a></li>
              <li ><a href="#" rel="fas fa-strikethrough fas-3"><i class="fas fa-strikethrough"></i></a></li>
              <li ><a href="#" rel="fas fa-subscript fas-3"><i class="fas fa-subscript"></i></a></li>
              <li ><a href="#" rel="fas fa-superscript fas-3"><i class="fas fa-superscript"></i></a></li>
              <li ><a href="#" rel="fas fa-table fas-3"><i class="fas fa-table"></i></a></li>
              <li ><a href="#" rel="fas fa-text-height fas-3"><i class="fas fa-text-height"></i></a></li>
              <li ><a href="#" rel="fas fa-text-width fas-3"><i class="fas fa-text-width"></i></a></li>
              <li ><a href="#" rel="fas fa-th fas-3"><i class="fas fa-th"></i></a></li>
              <li ><a href="#" rel="fas fa-th-large fas-3"><i class="fas fa-th-large"></i></a></li>
              <li ><a href="#" rel="fas fa-th-list fas-3"><i class="fas fa-th-list"></i></a></li>
              <li ><a href="#" rel="fas fa-underline fas-3"><i class="fas fa-underline"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-double-down fas-3"><i class="fas fa-angle-double-down"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-double-left fas-3"><i class="fas fa-angle-double-left"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-double-right fas-3"><i class="fas fa-angle-double-right"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-double-up fas-3"><i class="fas fa-angle-double-up"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-up fas-3"><i class="fas fa-angle-up"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-down fas-3"><i class="fas fa-angle-down"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-left fas-3"><i class="fas fa-angle-left"></i></a></li>
              <li ><a href="#" rel="fas fa-angle-right fas-3"><i class="fas fa-angle-right"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-down fas-3"><i class="fas fa-arrow-circle-down"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-left fas-3"><i class="fas fa-arrow-circle-left"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-o-down fas-3"><i class="fas fa-arrow-circle-o-down"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-o-left fas-3"><i class="fas fa-arrow-circle-o-left"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-o-right fas-3"><i class="fas fa-arrow-circle-o-right"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-o-up fas-3"><i class="fas fa-arrow-circle-o-up"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-right fas-3"><i class="fas fa-arrow-circle-right"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-circle-up fas-3"><i class="fas fa-arrow-circle-up"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-down fas-3"><i class="fas fa-arrow-down"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-left fas-3"><i class="fas fa-arrow-left"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-right fas-3"><i class="fas fa-arrow-right"></i></a></li>
              <li ><a href="#" rel="fas fa-arrow-up fas-3"><i class="fas fa-arrow-up"></i></a></li>
              <li ><a href="#" rel="fas fa-arrows-alt fas-3"><i class="fas fa-arrows-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-caret-down fas-3"><i class="fas fa-caret-down"></i></a></li>
              <li ><a href="#" rel="fas fa-caret-left fas-3"><i class="fas fa-caret-left"></i></a></li>
              <li ><a href="#" rel="fas fa-caret-right fas-3"><i class="fas fa-caret-right"></i></a></li>
              <li ><a href="#" rel="fas fa-caret-up fas-3"><i class="fas fa-caret-up"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-circle-down fas-3"><i class="fas fa-chevron-circle-down"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-circle-left fas-3"><i class="fas fa-chevron-circle-left"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-circle-right fas-3"><i class="fas fa-chevron-circle-right"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-circle-up fas-3"><i class="fas fa-chevron-circle-up"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-down fas-3"><i class="fas fa-chevron-down"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-left fas-3"><i class="fas fa-chevron-left"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-right fas-3"><i class="fas fa-chevron-right"></i></a></li>
              <li ><a href="#" rel="fas fa-chevron-up fas-3"><i class="fas fa-chevron-up"></i></a></li>
              <li ><a href="#" rel="fas fa-hand-o-down fas-3"><i class="fas fa-hand-o-down"></i></a></li>
              <li ><a href="#" rel="fas fa-hand-o-left fas-3"><i class="fas fa-hand-o-left"></i></a></li>
              <li ><a href="#" rel="fas fa-hand-o-right fas-3"><i class="fas fa-hand-o-right"></i></a></li>
              <li ><a href="#" rel="fas fa-hand-o-up fas-3"><i class="fas fa-hand-o-up"></i></a></li>
              <li ><a href="#" rel="fas fa-long-arrow-down  fas-3"><i class="fas fa-long-arrow-down"></i></a></li>
              <li ><a href="#" rel="fas fa-long-arrow-left fas-3"><i class="fas fa-long-arrow-left"></i></a></li>
              <li ><a href="#" rel="fas fa-long-arrow-right fas-3"><i class="fas fa-long-arrow-right"></i></a></li>
              <li ><a href="#" rel="fas fa-long-arrow-up fas-3"><i class="fas fa-long-arrow-up"></i></a></li>
              <li ><a href="#" rel="fas fa-backward fas-3"><i class="fas fa-backward"></i></a></li>
              <li ><a href="#" rel="fas fa-compress fas-3"><i class="fas fa-compress"></i></a></li>
              <li ><a href="#" rel="fas fa-eject fas-3"><i class="fas fa-eject"></i></a></li>
              <li ><a href="#" rel="fas fa-expand fas-3"><i class="fas fa-expand"></i></a></li>
              <li ><a href="#" rel="fas fa-fasst-backward fas-3"><i class="fas fa-fasst-backward"></i></a></li>
              <li ><a href="#" rel="fas fa-fasst-forward fas-3"><i class="fas fa-fasst-forward"></i></a></li>
              <li ><a href="#" rel="fas fa-forward fas-3"><i class="fas fa-forward"></i></a></li>
               <li ><a href="#" rel="fas fa-pause fas-3"><i class="fas fa-pause"></i></a></li>
              <li ><a href="#" rel="fas fa-pause-circle fas-3"><i class="fas fa-pause-circle"></i></a></li>
             <li ><a href="#" rel="fas fa-pause-circle-o fas-3"><i class="fas fa-pause-circle-o"></i></a></li>
              <li ><a href="#" rel="fas fa-play fas-3"><i class="fas fa-play"></i></a></li>
             <li ><a href="#" rel="fas fa-play-circle fas-3"><i class="fas fa-play-circle"></i></a></li>
              <li ><a href="#" rel="fas fa-play-circle-o fas-3"><i class="fas fa-play-circle-o"></i></a></li>
             <li ><a href="#" rel="fas fa-step-backward fas-3"><i class="fas fa-step-backward"></i></a></li>
              <li ><a href="#" rel="fas fa-step-forward fas-3"><i class="fas fa-step-forward"></i></a></li>
             <li ><a href="#" rel="fas fa-stop fas-3"><i class="fas fa-stop"></i></a></li>
              <li ><a href="#" rel="fas fa-stop-circle fas-3"><i class="fas fa-stop-circle"></i></a></li>
             <li ><a href="#" rel="fas fa-stop-circle-o fas-3"><i class="fas fa-stop-circle-o"></i></a></li>
              <li ><a href="#" rel="fas fa-youtube-play fas-3"><i class="fas fa-youtube-play"></i></a></li>
               <li ><a href="#" rel="fas fa-500px fas-3"><i class="fas fa-500px"></i></a></li>
              <li ><a href="#" rel="fas fa-adn fas-3"><i class="fas fa-adn"></i></a></li>
               <li ><a href="#" rel="fas fa-amazon fas-3"><i class="fas fa-amazon"></i></a></li>
              <li ><a href="#" rel="fas fa-android fas-3"><i class="fas fa-android"></i></a></li>
               <li ><a href="#" rel="fas fa-angellist fas-3"><i class="fas fa-angellist"></i></a></li>
              <li ><a href="#" rel="fas fa-apple fas-3"><i class="fas fa-apple"></i></a></li>
               <li ><a href="#" rel="fas fa-bandcamp fas-3"><i class="fas fa-bandcamp"></i></a></li>
              <li ><a href="#" rel="fas fa-behance fas-3"><i class="fas fa-behance"></i></a></li>
               <li ><a href="#" rel="fas fa-behance-square fas-3"><i class="fas fa-behance-square"></i></a></li>
              <li ><a href="#" rel="fas fa-bitbucket fas-3"><i class="fas fa-bitbucket"></i></a></li>
               <li ><a href="#" rel="fas fa-bitbucket-square fas-3"><i class="fas fa-bitbucket-square"></i></a></li>
              <li ><a href="#" rel="fas fa-black-tie fas-3"><i class="fas fa-black-tie"></i></a></li>
               <li ><a href="#" rel="fas fa-bluetooth fas-3"><i class="fas fa-bluetooth"></i></a></li>
              <li ><a href="#" rel="fas fa-bluetooth-b fas-3"><i class="fas fa-bluetooth-b"></i></a></li>
              <li ><a href="#" rel="fas fa-buysellads fas-3"><i class="fas fa-buysellads"></i></a></li>
              <li ><a href="#" rel="fas fa-chrome fas-3"><i class="fas fa-chrome"></i></a></li>
              <li ><a href="#" rel="fas fa-codepen fas-3"><i class="fas fa-codepen"></i></a></li>
              <li ><a href="#" rel="fas fa-codiepie fas-3"><i class="fas fa-codiepie"></i></a></li>
              <li ><a href="#" rel="fas fa-connectdevelop fas-3"><i class="fas fa-connectdevelop"></i></a></li>
              <li ><a href="#" rel="fas fa-contao fas-3"><i class="fas fa-contao"></i></a></li>
              <li ><a href="#" rel="fas fa-css3 fas-3"><i class="fas fa-css3"></i></a></li>
              <li ><a href="#" rel="fas fa-dashcube fas-3"><i class="fas fa-dashcube"></i></a></li>
              <li ><a href="#" rel="fas fa-delicious fas-3"><i class="fas fa-delicious"></i></a></li>
              <li ><a href="#" rel="fas fa-deviantart fas-3"><i class="fas fa-deviantart"></i></a></li>
              <li ><a href="#" rel="fas fa-digg fas-3"><i class="fas fa-digg"></i></a></li>
              <li ><a href="#" rel="fas fa-dribbble fas-3"><i class="fas fa-dribbble"></i></a></li>
              <li ><a href="#" rel="fas fa-dropbox fas-3"><i class="fas fa-dropbox"></i></a></li>
              <li ><a href="#" rel="fas fa-drupal fas-3"><i class="fas fa-drupal"></i></a></li>
              <li ><a href="#" rel="fas fa-edge fas-3"><i class="fas fa-edge"></i></a></li>
              <li ><a href="#" rel="fas fa-empire fas-3"><i class="fas fa-empire"></i></a></li>
              <li ><a href="#" rel="fas fa-envira fas-3"><i class="fas fa-envira"></i></a></li>
              <li ><a href="#" rel="fas fa-expeditedssl fas-3"><i class="fas fa-expeditedssl"></i></a></li>
              <li ><a href="#" rel="fas fa-font-awesome fas-3"><i class="fas fa-font-awesome"></i></a></li>
              <li ><a href="#" rel="fas fa-fascebook fas-3"><i class="fas fa-fascebook"></i></a></li>
              <li ><a href="#" rel="fas fa-fascebook-official fas-3"><i class="fas fa-fascebook-official"></i></a></li>
              <li ><a href="#" rel="fas fa-fascebook-square fas-3"><i class="fas fa-fascebook-square"></i></a></li>
              <li ><a href="#" rel="fas fa-firefox fas-3"><i class="fas fa-firefox"></i></a></li>
              <li ><a href="#" rel="fas fa-first-order fas-3"><i class="fas fa-first-order"></i></a></li>
              <li ><a href="#" rel="fas fa-flickr fas-3"><i class="fas fa-flickr"></i></a></li>
              <li ><a href="#" rel="fas fa-fonticons fas-3"><i class="fas fa-fonticons"></i></a></li>
              <li ><a href="#" rel="fas fa-fort-awesome fas-3"><i class="fas fa-fort-awesome"></i></a></li>
              <li ><a href="#" rel="fas fa-forumbee fas-3"><i class="fas fa-forumbee"></i></a></li>
              <li ><a href="#" rel="fas fa-foursquare fas-3"><i class="fas fa-foursquare"></i></a></li>
              <li ><a href="#" rel="fas fa-free-code-camp fas-3"><i class="fas fa-free-code-camp"></i></a></li>
              <li ><a href="#" rel="fas fa-get-pocket fas-3"><i class="fas fa-get-pocket"></i></a></li>
              <li ><a href="#" rel="fas fa-git fas-3"><i class="fas fa-git"></i></a></li>
              <li ><a href="#" rel="fas fa-git-square fas-3"><i class="fas fa-git-square"></i></a></li>
              <li ><a href="#" rel="fas fa-github fas-3"><i class="fas fa-github"></i></a></li>
              <li ><a href="#" rel="fas fa-github-alt fas-3"><i class="fas fa-github-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-github-square fas-3"><i class="fas fa-github-square"></i></a></li>
              <li ><a href="#" rel="fas fa-gitlab fas-3"><i class="fas fa-gitlab"></i></a></li>
              <li ><a href="#" rel="fas fa-gratipay fas-3"><i class="fas fa-gratipay"></i></a></li>
              <li ><a href="#" rel="fas fa-glide fas-3"><i class="fas fa-glide"></i></a></li>
              <li ><a href="#" rel="fas fa-glide-g fas-3"><i class="fas fa-glide-g"></i></a></li>
              <li ><a href="#" rel="fas fa-google fas-3"><i class="fas fa-google"></i></a></li>
              <li ><a href="#" rel="fas fa-google-plus fas-3"><i class="fas fa-google-plus"></i></a></li>
              <li ><a href="#" rel="fas fa-google-plus-official fas-3"><i class="fas fa-google-plus-official"></i></a></li>
              <li ><a href="#" rel="fas fa-google-plus-square fas-3"><i class="fas fa-google-plus-square"></i></a></li>
              <li ><a href="#" rel="fas fa-hacker-news fas-3"><i class="fas fa-hacker-news"></i></a></li>
              <li ><a href="#" rel="fas fa-houzz fas-3"><i class="fas fa-houzz"></i></a></li>
              <li ><a href="#" rel="fas fa-html5 fas-3"><i class="fas fa-html5"></i></a></li>
              <li ><a href="#" rel="fas fa-imdb fas-3"><i class="fas fa-imdb"></i></a></li>
              <li ><a href="#" rel="fas fa-instagram fas-3"><i class="fas fa-instagram"></i></a></li>
              <li ><a href="#" rel="fas fa-internet-explorer fas-3"><i class="fas fa-internet-explorer"></i></a></li>
              <li ><a href="#" rel="fas fa-ioxhost fas-3"><i class="fas fa-ioxhost"></i></a></li>
              <li ><a href="#" rel="fas fa-joomla fas-3"><i class="fas fa-joomla"></i></a></li>
              <li ><a href="#" rel="fas fa-jsfiddle fas-3"><i class="fas fa-jsfiddle"></i></a></li>
              <li ><a href="#" rel="fas fa-lastfm fas-3"><i class="fas fa-lastfm"></i></a></li>
              <li ><a href="#" rel="fas fa-lastfm-square fas-3"><i class="fas fa-lastfm-square"></i></a></li>
              <li ><a href="#" rel="fas fa-leanpub fas-3"><i class="fas fa-leanpub"></i></a></li>
              <li ><a href="#" rel="fas fa-linkedin fas-3"><i class="fas fa-linkedin"></i></a></li>
              <li ><a href="#" rel="fas fa-linkedin-square fas-3"><i class="fas fa-linkedin-square"></i></a></li>
              <li ><a href="#" rel="fas fa-linux fas-3"><i class="fas fa-linux"></i></a></li>
              <li ><a href="#" rel="fas fa-maxcdn fas-3"><i class="fas fa-maxcdn"></i></a></li>
              <li ><a href="#" rel="fas fa-meanpath fas-3"><i class="fas fa-meanpath"></i></a></li>
              <li ><a href="#" rel="fas fa-medium fas-3"><i class="fas fa-medium"></i></a></li>
              <li ><a href="#" rel="fas fa-meetup fas-3"><i class="fas fa-meetup"></i></a></li>
              <li ><a href="#" rel="fas fa-mixcloud fas-3"><i class="fas fa-mixcloud"></i></a></li>
              <li ><a href="#" rel="fas fa-modx fas-3"><i class="fas fa-modx"></i></a></li>
              <li ><a href="#" rel="fas fa-odnoklassniki fas-3"><i class="fas fa-odnoklassniki"></i></a></li>
              <li ><a href="#" rel="fas fa-odnoklassniki-square fas-3"><i class="fas fa-odnoklassniki-square"></i></a></li>
              <li ><a href="#" rel="fas fa-opencart fas-3"><i class="fas fa-opencart"></i></a></li>
              <li ><a href="#" rel="fas fa-openid fas-3"><i class="fas fa-openid"></i></a></li>
              <li ><a href="#" rel="fas fa-opera fas-3"><i class="fas fa-opera"></i></a></li>
              <li ><a href="#" rel="fas fa-optin-monster fas-3"><i class="fas fa-optin-monster"></i></a></li>
              <li ><a href="#" rel="fas fa-pagelines fas-3"><i class="fas fa-pagelines"></i></a></li>
              <li ><a href="#" rel="fas fa-pied-piper fas-3"><i class="fas fa-pied-piper"></i></a></li>
              <li ><a href="#" rel="fas fa-pied-piper-alt fas-3"><i class="fas fa-pied-piper-alt"></i></a></li>
              <li ><a href="#" rel="fas fa-pied-piper-pp fas-3"><i class="fas fa-pied-piper-pp"></i></a></li>
              <li ><a href="#" rel="fas fa-pinterest fas-3"><i class="fas fa-pinterest"></i></a></li>
              <li ><a href="#" rel="fas fa-pinterest-p fas-3"><i class="fas fa-pinterest-p"></i></a></li>
              <li ><a href="#" rel="fas fa-pinterest-square fas-3"><i class="fas fa-pinterest-square"></i></a></li>
              <li ><a href="#" rel="fas fa-product-hunt fas-3"><i class="fas fa-product-hunt"></i></a></li>
              <li ><a href="#" rel="fas fa-qq fas-3"><i class="fas fa-qq"></i></a></li>
              <li ><a href="#" rel="fas fa-rebel fas-3"><i class="fas fa-rebel"></i></a></li>
              <li ><a href="#" rel="fas fa-reddit fas-3"><i class="fas fa-reddit"></i></a></li>
              <li ><a href="#" rel="fas fa-reddit-alien fas-3"><i class="fas fa-reddit-alien"></i></a></li>
              <li ><a href="#" rel="fas fa-reddit-square fas-3"><i class="fas fa-reddit-square"></i></a></li>
              <li ><a href="#" rel="fas fa-renren fas-3"><i class="fas fa-renren"></i></a></li>
              <li ><a href="#" rel="fas fa-safasri fas-3"><i class="fas fa-safasri"></i></a></li>
              <li ><a href="#" rel="fas fa-scribd fas-3"><i class="fas fa-scribd"></i></a></li>
              <li ><a href="#" rel="fas fa-sellsy fas-3"><i class="fas fa-sellsy"></i></a></li>
              <li ><a href="#" rel="fas fa-shirtsinbulk fas-3"><i class="fas fa-shirtsinbulk"></i></a></li>
              <li ><a href="#" rel="fas fa-simplybuilt fas-3"><i class="fas fa-simplybuilt"></i></a></li>
              <li ><a href="#" rel="fas fa-skyatlas fas-3"><i class="fas fa-skyatlas"></i></a></li>
              <li ><a href="#" rel="fas fa-skype fas-3"><i class="fas fa-skype"></i></a></li>
              <li ><a href="#" rel="fas fa-slack fas-3"><i class="fas fa-slack"></i></a></li>
              <li ><a href="#" rel="fas fa-slideshare fas-3"><i class="fas fa-slideshare"></i></a></li>
              <li ><a href="#" rel="fas fa-snapchat fas-3"><i class="fas fa-snapchat"></i></a></li>
              <li ><a href="#" rel="fas fa-snapchat-ghost fas-3"><i class="fas fa-snapchat-ghost"></i></a></li>
              <li ><a href="#" rel="fas fa-snapchat-square fas-3"><i class="fas fa-snapchat-square"></i></a></li>
              <li ><a href="#" rel="fas fa-soundcloud fas-3"><i class="fas fa-soundcloud"></i></a></li>
              <li ><a href="#" rel="fas fa-spotify fas-3"><i class="fas fa-spotify"></i></a></li>
              <li ><a href="#" rel="fas fa-stack-exchange fas-3"><i class="fas fa-stack-exchange"></i></a></li>
              <li ><a href="#" rel="fas fa-stack-overflow fas-3"><i class="fas fa-stack-overflow"></i></a></li>
              <li ><a href="#" rel="fas fa-steam fas-3"><i class="fas fa-steam"></i></a></li>
              <li ><a href="#" rel="fas fa-steam-square fas-3"><i class="fas fa-steam-square"></i></a></li>
              <li ><a href="#" rel="fas fa-stumbleupon fas-3"><i class="fas fa-stumbleupon"></i></a></li>
              <li ><a href="#" rel="fas fa-stumbleupon-circle fas-3"><i class="fas fa-stumbleupon-circle"></i></a></li>
              <li ><a href="#" rel="fas fa-tencent-weibo fas-3"><i class="fas fa-tencent-weibo"></i></a></li>
              <li ><a href="#" rel="fas fa-themeisle fas-3"><i class="fas fa-themeisle"></i></a></li>
              <li ><a href="#" rel="fas fa-trello fas-3"><i class="fas fa-trello"></i></a></li>
              <li ><a href="#" rel="fas fa-tripadvisor fas-3"><i class="fas fa-tripadvisor"></i></a></li>
              <li ><a href="#" rel="fas fa-tumblr fas-3"><i class="fas fa-tumblr"></i></a></li>
              <li ><a href="#" rel="fas fa-tumblr-square fas-3"><i class="fas fa-tumblr-square"></i></a></li>
              <li ><a href="#" rel="fas fa-twitch fas-3"><i class="fas fa-twitch"></i></a></li>
              <li ><a href="#" rel="fas fa-twitter fas-3"><i class="fas fa-twitter"></i></a></li>
              <li ><a href="#" rel="fas fa-twitter-square fas-3"><i class="fas fa-twitter-square"></i></a></li>
              <li ><a href="#" rel="fas fa-usb fas-3"><i class="fas fa-usb"></i></a></li>
              <li ><a href="#" rel="fas fa-viacoin fas-3"><i class="fas fa-viacoin"></i></a></li>
             <li ><a href="#" rel="fas fa-viadeo fas-3"><i class="fas fa-viadeo"></i></a></li>
             <li ><a href="#" rel="fas fa-viadeo-square fas-3"><i class="fas fa-viadeo-square"></i></a></li>
             <li ><a href="#" rel="fas fa-vimeo fas-3"><i class="fas fa-vimeo"></i></a></li>
             <li ><a href="#" rel="fas fa-vimeo-square fas-3"><i class="fas fa-vimeo-square"></i></a></li>
             <li ><a href="#" rel="fas fa-vine fas-3"><i class="fas fa-vine"></i></a></li>
             <li ><a href="#" rel="fas fa-vk fas-3"><i class="fas fa-vk"></i></a></li>
             <li ><a href="#" rel="fas fa-weixin fas-3"><i class="fas fa-weixin"></i></a></li>
             <li ><a href="#" rel="fas fa-weibo fas-3"><i class="fas fa-weibo"></i></a></li>
             <li ><a href="#" rel="fas fa-whatsapp fas-3"><i class="fas fa-whatsapp"></i></a></li>
             <li ><a href="#" rel="fas fa-wikipedia-w fas-3"><i class="fas fa-wikipedia-w"></i></a></li>
             <li ><a href="#" rel="fas fa-windows fas-3"><i class="fas fa-windows"></i></a></li>
             <li ><a href="#" rel="fas fa-wordpress fas-3"><i class="fas fa-wordpress"></i></a></li>
             <li ><a href="#" rel="fas fa-wpbeginner fas-3"><i class="fas fa-wpbeginner"></i></a></li>
             <li ><a href="#" rel="fas fa-wpforms fas-3"><i class="fas fa-wpforms"></i></a></li>
             <li ><a href="#" rel="fas fa-xing fas-3"><i class="fas fa-xing"></i></a></li>
             <li ><a href="#" rel="fas fa-xing-square fas-3"><i class="fas fa-xing-square"></i></a></li>
             <li ><a href="#" rel="fas fa-y-combinator fas-3"><i class="fas fa-y-combinator"></i></a></li>
             <li ><a href="#" rel="fas fa-yahoo fas-3"><i class="fas fa-yahoo"></i></a></li>
             <li ><a href="#" rel="fas fa-yelp fas-3"><i class="fas fa-yelp"></i></a></li>
             <li ><a href="#" rel="fas fa-yoast fas-3"><i class="fas fa-yoast"></i></a></li>
             <li ><a href="#" rel="fas fa-youtube fas-3"><i class="fas fa-youtube"></i></a></li>
             <li ><a href="#" rel="fas fa-youtube-square fas-3"><i class="fas fa-youtube-square"></i></a></li>
             <li ><a href="#" rel="fas fa-h-square fas-3"><i class="fas fa-h-square"></i></a></li>
             <li ><a href="#" rel="fas fa-hospital-o fas-3"><i class="fas fa-hospital-o"></i></a></li>
             <li ><a href="#" rel="fas fa-medkit fas-3"><i class="fas fa-medkit"></i></a></li>
             <li ><a href="#" rel="fas fa-stethoscope fas-3"><i class="fas fa-stethoscope"></i></a></li>
             <li ><a href="#" rel="fas fa-user-md fas-3"><i class="fas fa-user-md"></i></a></li>';
  }


  public function LgroupActions()
  {
        echo '<div class="lactionBtnWrapper">
                <button class="btn litemhandle" type="button" id="lgab">
                <i class="fas fa-grip-vertical left"></i>
                </button>
                <button class="btn item_editToggle" onclick="WIPageBuilder.edit();" type="button">
                <i class="fas fa-edit"></i>    
                </button>
                <button class="btn item_clone" onclick="WIPageBuilder.clone();" type="button">
                <i class="fas fa-copy"></i>
                </button>
                <button class="btn item_remove" onclick="WIPageBuilder.delete();" type="button">
                <i class="fas fa-times"></i> 
                </button>
            </div>';
  }

  public function MgroupActions()
  {
        echo '<div class="mactionBtnWrapper">
            <button class="btn mitemhandle" type="button" id="mgab">
            <i class="fas fa-grip-vertical middle"></i>
            </button>
            <button class="btn item_clone" type="button">
            <i class="fas fa-copy"></i>
            </button>
            <button class="btn item_remove" type="button">
            <i class="fas fa-times"></i> 
            </button>
        </div>';
  }

  public function RgroupActions()
  {
            echo '<div class="ractionBtnWrapper">
                <button class="btn ritemhandle" type="button" id="rgab">
                <i class="fas fa-grip-vertical right"></i>
                </button>
                <button class="btn item_editToggle" type="button">
                <i class="fas fa-edit"></i>    
                </button>
                <button class="btn item_clone" type="button">
                <i class="fas fa-copy"></i>
                </button>
                <button class="btn item_remove" type="button">
                <i class="fas fa-times"></i> 
                </button>
            </div>';
  }

 public function groupConfig()
  {
    echo '<div class="fCheck">
        <label for="inputting">
          <input name="inputting" type="checkbox" aria=label="rowSeetingsInputGroupAria" id="inputGroup">
          <span class="checkable">Repeatable Region</span>
          </label>
        </div>
        <hr>
      <div class="FFieldGroup">
      <label>Wrap row in a <fieldset> tag</label>
      <div class="inputGroup">
      <span class="inputGroupAddon">
      <input name="checkboxX" type="checkbox" aria-label="wrap Row in Fieldset" id="fieldset">
      </span>
      <input name="legend" type="text" aria-label="Legend for fieldset" placeholder="legend" id="legend">
      </div>
      </div>
      <hr>
      <label>Define Column widths</label>
      <div class="FFieldGroupNew row">
      <label class="col-sm-4 form-control-label">Layout Preset</label>
      <div class="col-sm-8">

      <span class="help-block">
          xs (for phones - screens less than 768px wide)
        sm (for tablets - screens equal to or greater than 768px wide)
        md (for small laptops - screens equal to or greater than 992px wide)
        lg (for laptops and desktops - screens equal to or greater than 1200px wide)          
                </span>

        <select name="column" aria-label="Define a column layout" class="columnPreset" id="columnPreset">
        <option value="xs-12" label="col-xs-12 (100%)" selected="true">100%</option>
        <option value="xs-10" label="col-xs-10 (90%)" selected="true">col-xs-10 (90%)</option>
        <option value="xs-8" label="col-xs-8 (80%)" selected="true">col-xs-8 (80%)</option>
        <option value="xs-7" label="col-xs-7 (65%)" selected="true">col-xs-7 (65%)</option>
        <option value="xs-6" label="col-xs-6 (50%)" selected="true">col-xs-6 (50%)</option>
        <option value="xs-5" label="col-xs-5 (40%)" selected="true">col-xs-5 (40%)</option>
        <option value="xs-4" label="col-xs-4 (30%)" selected="true">col-xs-4 (30%)</option>
        <option value="xs-3" label="col-xs-3 (15%)" selected="true">col-xs-3 (15%)</option>
        <option value="xs-2" label="col-xs-2 (10%)" selected="true">col-xs-2 (10%)</option>
        <option value="xs-1" label="col-xs-1 (5%)" selected="true">col-xs-1 (5%)</option>

        <option value="sm-12" label="col-sm-12 (100%)" selected="true">col-sm-12 (100%)</option>
        <option value="sm-10" label="col-sm-10 (90%)" selected="true">col-sm-10 (90%)</option>
        <option value="sm-8" label="col-sm-8 (80%)" selected="true">col-sm-8 (80%)</option>
        <option value="sm-7" label="col-sm-7 (65%)" selected="true">col-sm-7 (65%)</option>
        <option value="sm-6" label="col-sm-6 (50%)" selected="true">col-sm-6 (50%)</option>
        <option value="sm-5" label="col-sm-5 (40%)" selected="true">col-sm-5 (40%)</option>
        <option value="sm-4" label="col-sm-4 (30%)" selected="true">col-sm-4 (30%)</option>
        <option value="sm-3" label="col-sm-3 (15%)" selected="true">col-sm-3 (15%)</option>
        <option value="sm-2" label="col-sm-2 (10%)" selected="true">col-sm-2 (10%)</option>
        <option value="sm-1" label="col-sm-1 (5%)" selected="true">col-sm-1 (5%)</option>

        <option value="md-12" label="col-md-12 (100%)" selected="true">col-md-12 (100%)</option>
        <option value="md-10" label="col-md-10 (90%)" selected="true">col-md-10 (90%)</option>
        <option value="md-8" label="col-md-8 (80%)" selected="true">col-md-8 (80%)</option>
        <option value="md-7" label="col-md-7 (65%)" selected="true">col-md-7 (65%)</option>
        <option value="md-6" label="col-md-6 (50%)" selected="true">col-md-6 (50%)</option>
        <option value="md-5" label="col-md-5 (40%)" selected="true">col-md-5 (40%)</option>
        <option value="md-4" label="col-md-4 (30%)" selected="true">col-md-4 (30%)</option>
        <option value="md-3" label="col-md-3 (15%)" selected="true">col-md-3 (15%)</option>
        <option value="md-2" label="col-md-2 (10%)" selected="true">col-md-2 (10%)</option>
        <option value="md-1" label="col-md-1 (5%)" selected="true">col-md-1 (5%)</option>

        <option value="lg-12" label="col-lg-12 (100%)" selected="true">col-lg-12 (100%)</option>
        <option value="lg-10" label="col-lg-10 (90%)" selected="true">col-lg-10 (90%)</option>
        <option value="lg-8" label="col-lg-8 (80%)" selected="true">col-lg-8 (80%)</option>
        <option value="lg-7" label="col-lg-7 (65%)" selected="true">col-lg-7 (65%)</option>
        <option value="lg-6" label="col-lg-6 (50%)" selected="true">col-lg-6 (50%)</option>
        <option value="lg-5" label="col-lg-5 (40%)" selected="true">col-lg-5 (40%)</option>
        <option value="lg-4" label="col-lg-4 (30%)" selected="true">col-lg-4 (30%)</option>
        <option value="lg-3" label="col-lg-3 (15%)" selected="true">col-lg-3 (15%)</option>
        <option value="lg-2" label="col-lg-2 (10%)" selected="true">col-lg-2 (10%)</option>
        <option value="lg-1" label="col-lg-1 (5%)" selected="true">col-lg-1 (5%)</option>
        </select>
        </div>
      </div>
      <script>
      $(`#columnPreset`).on(`change`, function() {
            // alert( this.value );
    $("#columnPreset").val(this.value).prop("selected", "selected");                      
    })
    </script>';
  }


  public function attrsPanels()
  {

    echo '<div class="Fpanel WIattrsPanels" style="display:none;" id="WIattrsPanels">
      <div class="fPanelWrap">
      <ul class="fieldEditGroup fieldEditAttrs">
      <li class="attrsClassNameWrap propWrapper controlCount="1" id="PanelWrapers">
      <div class="propControls">
      <button type="button" class="propRemove propControls"></button>
      </div>
      <div class="propInputs">
      <div class="fieldGroup">
      <label for="className">Class</label>
      <select name="className" id="className">
        <option value="fBtnGroup">Grouped</option>
        <option value="FieldGroup">Un-Grouped</option>
        </select>
      </div>
      </div>
      </li>
      </ul>
      <div class="panelActionButtons">
      <button type="button" class="addAttrs">+ Atrribute</button>
      </div>
      </div>
      <div class="Fpanel optionsPanel">
      <div class="FpanelWrap">
        <ul class="fieldEditGroup fieldEditOptions">
          <li class="OptionsXWrapper propWrapper controlCount_2" id="propCont">
          <div class="propControls">
          <button type="button" class="propOrder propControls"></button>
          <button type="button" class="propOrder propControls"></button>
          </div>
          <div class="propInput FinputGroup">
          <input name="button" type="text" value="button" placeholder="label" id="buttons">
          <select name="button" id="buttonz">
          <option value="button" selected="true">appearing_button</option>
          <option value="reset">Reset</option>
          <option value="submit">Submit</option>
          </select>
          <select name="options" id="optional">
          <option selected="true">defasult</option>
          <option value="primary">Primary</option>
          <option value="error">Error</option>
          <option value="success">Success</option>
          <option value="warning">Warning</option>
          </select>
          </div>
          </li>
        </ul>
        </div>
        <div class="panelActionButtons">
        <button type="button" class="addOptions">+ Options</button>
        </div>
        </div>
        </div>';
  }


      public function fieldEdit()
  {

    $tabNum = self::numberGenerator();
    $tablets = self::numberGenerator();
    $addAtt = self::numberGenerator();
    echo ' <script>
  $( function() {
    $( "#' . $tabNum. '" ).tabs();
  } );
  </script>

<div id="' . $tabNum. '">
  <ul>
    <li><a href="#attributes-' . $tablets. '">Attributes</a></li>
    <li><a href="#options-' . $tablets. '">Options</a></li>
    <li><a href="#conditions-' . $tablets. '">Conditions</a></li>
  </ul>
  <div id="attributes-' . $tablets. '">
    <div class="fPanelWrap">
      <ul class="fieldEditGroup fieldEditAttrs">
      <li class="attrsClassNameWrap propWrapper controlCount="1" id="PanelWrapers">
      <div class="propControls">
      <button type="button" class="propRemove propControls"></button>
      </div>
      <div class="propInputs">
      <div class="fieldGroup">
      <label for="className">Class</label>
      <select name="className" id="className">
        <option value="fBtnGroup">Grouped</option>
        <option value="FieldGroup">Un-Grouped</option>
        </select>
      </div>
      </div>
      </li>
      </ul>
      <div class="panelActionButtons">
      <button type="button" class="addAttrs">+ Atrribute</button>
      </div>
      </div>
  </div>
  <div id="options-' . $tablets. '">
    <div class="Fpanel optionsPanel">
      <div class="FpanelWrap">
        <ul class="fieldEditGroup fieldEditOptions">
          <li class="OptionsXWrapper propWrapper controlCount_2" id="propCont">
          <div class="propControls">
          <button type="button" class="propOrder propControls"></button>
          <button type="button" class="propOrder propControls"></button>
          </div>
          <div class="propInput FinputGroup">
          <input name="button" type="text" value="button" placeholder="label" id="buttons">
          <select name="button" id="buttonz">
          <option value="button" selected="true">appearing_button</option>
          <option value="reset">Reset</option>
          <option value="submit">Submit</option>
          </select>
          <select name="options" id="optional">
          <option selected="true">defasult</option>
          <option value="primary">Primary</option>
          <option value="error">Error</option>
          <option value="success">Success</option>
          <option value="warning">Warning</option>
          </select>
          </div>
          </li>
        </ul>
        </div>
        <div class="panelActionButtons">
        <button type="button" class="addOptions" id="'. $addAtt.'">+ Options</button>
        </div>
        </div>
  </div>
  <div id="conditions-' . $tablets. '">
     <div class="panel conditions-panel">
          <ul class="field-edit-group">
            <li class="field-conditions">
              <div class="field-prop">
                <div class="conditions-prop-inputs">
                  <div class="f-condition-row if-condition-row condition-source condition-target condition-sourceProperty-value condition-comparison-equals condition-targetProperty-value">
                    <label class="condition-label if-condition-label">IF</label>
                    <div class="condition-source">
                      <input type="text" name="f-autocomplete-display-field">
                      <input type="hidden" name="condition-source">
                      <ul class="f-autocomplete-list">
                        
                      </ul>
                    </div>
                    <select class="condition-sourceProperty">
                      <option value="value" selected="true">value</option>
                      <option value="isVisible">is visible</option>
                      <option value="isNotVisible">is not visible</option>
                      
                    </select>

                    <select class="condition-comparison">
                      <option value="equals" selected="true">equals</option>
                      <option value="notEquals">not equals</option>
                      <option value="contains">contains</option>
                      <option value="notContains">not contains</option>
                      
                    </select>
                      <div class="conditons-target">
                        <input type="text" name="" class="f-autocomplete-display-field"  placeholder="target / value" autocomplete="off">
                        <input type="hidden" name="" class="condition-target">
                        <ul class="f-autocomplete-list">
                        
                      </ul>
                      </div>

                       <select class="condition-targetProperty">
                      <option value="value" selected="true">value</option>
                      <option value="isVisible">is visible</option>
                      <option value="isNotVisible">is not visible</option>
                      
                    </select>
                  </div>
                  <div class="f-condition-row then-condition-row condition-target condition-value condition-targetProperty-value condition-assignment-equals">
                    <label class="condition-label then-condition-label">Then</label>
                    <div class="condition-target">
                       <input type="text" name="" class="f-autocomplete-display-field"  placeholder="target / value" autocomplete="off">
                        <input type="hidden" name="" class="condition-target">
                        <ul class="f-autocomplete-list">
                        <li class="f-autocomplete-list-item" data-label="Button">
                          Button
                          <span class="component-label-count"></span>
                        <span class="component-type">Field</span>
                        </li>
                        <li class="f-autocomplete-list-item">External User
                          <span class="component-label-count"></span>
                        <span class="component-type">External</span>
                        </li>
                      </ul>
                    </div>
                     <select class="condition-targetProperty">
                      <option value="value" selected="true">value</option>
                      <option value="isVisible">is visible</option>
                      <option value="isNotVisible">is not visible</option>
                      
                    </select>
                    <select class="condition-assignment">
                      <option value="equals">Equals</option>
                    </select>
                    <input type="text" name="" class="condition-value" placeholder="value">
                  </div>
                </div>
                  <div class="conditions-prop-controls prop-controls">
                    <button class="prop-remove prop-control" type="button">remove</button>
                  </div>
              </div>
            </li>
          </ul> 
            <div class="panel-action-buttons">
              <button class="add-conditions" title="+ Condition" type="button">Add Condition</button>
            </div>
        </div>
  </div>
</div>';
  }

  public function numberGenerator()
  {
        $number = rand();
        return $number;
  }


}