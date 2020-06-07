<?php

/**
* WIPermissions Class
* Created by Warner Infinity
* Author Jules Warner
*/

class WIPermissions
{
  function __construct() {
       $this->WIdb = WIdb::getInstance();
    }

    public function permissionTabs()
    {

        $sql = "SELECT * FROM `wi_user_roles`";
        $query = $this->WIdb->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        echo ' <script>
                $( function() {
                  $( "#tabs" ).tabs();
                } );
                </script>

                <div id="tabs">
              <ul>';
         foreach ($result as $tab) {
          echo  '<li><a href="#tabs-' . $tab['role_id'] . '">' . $tab['role'] . '</a></li>';
        }
        echo '</ul>';

        foreach ($result as $tab) {
          echo  '<div id="tabs-' . $tab['role_id'] . '">';

          include_once 'WIInc/site/permissions/' . $tab['role'] . '.php';
                  echo '</div>'; 
        }
        echo '</div>';


    }


        public function ForumPermissionTabs()
    {

        $sql = "SELECT * FROM `wi_forum_roles`";
        $query = $this->WIdb->prepare($sql);
        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        echo ' <script>
                $( function() {
                  $( "#tabs" ).tabs();
                } );
                </script>

                <div id="tabs">
              <ul>';
         foreach ($result as $tab) {
          echo  '<li><a href="#tabs-' . $tab['role_id'] . '">' . $tab['role'] . '</a></li>';
        }
        echo '</ul>';

        foreach ($result as $tab) {
          echo  '<div id="tabs-' . $tab['role_id'] . '">';

          include_once 'WIInc/site/WIForum/' . $tab['role'] . '.php';
                  echo '</div>'; 
        }
        echo '</div>';


    }

   
}