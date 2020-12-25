<?php
        $page = "php_modules";

        include_once "WIInc/WI_StartUp.php";

        $ref = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "";

        $agent = $_SERVER["HTTP_USER_AGENT"];
        $ip = $_SERVER["REMOTE_ADDR"];


        $tracking_page = $_SERVER["SCRIPT_NAME"];

        $country = $maint->ip_info($ip, "country");
        $location = $maint->ip_info($ip, "location");
        $city = $location["city"];
        if($country === null){
          $country = "localhost";
        }

        $maint->visitors_log($page, $ip, $country, $ref, $agent, $tracking_page, $city);

        $panelPower = $web->pageModPower($page, "panel");

        $Panel = $web->PageMod($page, "panel");
        if ($panelPower === "0") {
          
        }else{

          $mod->getMod($Panel);
        }

        $topPower = $web->pageModPower($page, "top_head");
        $top_head = $web->PageMod($page, "top_head");
        if ($topPower === "0") {
          
        }else{

          $mod->getMod($top_head);
        }

        $headerPower = $web->pageModPower($page, "header");
        if ($headerPower === "0") {
          
        }else{
        $web->MainHeader();
        }

        $web->MainMenu();
        

        $contents = $web->pageModPower($page, "contents");
        $mod->getModMain($contents, $page, $contents);

        $footerPower = $web->pageModPower($page, "footer");

        if ($footerPower === "0") {
          
        }else{
        $web->footer();
        }
        ?>
          <script type="text/javascript" src="../WITheme/WICMS/blog/js/vendor/jquery.easing.1.3.js"></script>
  <script type="text/javascript" src="../WITheme/WICMS/blog/js/jquery.cookie.js"></script> <!-- jQuery cookie --> 
  <script type="text/javascript" src="../WITheme/WICMS/blog/js/styleswitch.js"></script> <!-- Style Colors Switcher -->
   
  <script type="text/javascript" src="../WITheme/WICMS/blog/js/plugin/jquery.themepunch.revolution.min.js"></script>
  <script type="text/javascript" src="../WITheme/WICMS/blog/js/plugin/jquery.plugin.js"></script>

  <!-- Start Style Switcher -->
  <div class="switcher"></div>
  <!-- End Style Switcher -->
        </body>
        </html>
        