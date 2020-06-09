<?php
/***
*
*   WARNER-INFINTY CMS SOCIAL
*   DEVELOPED BY WARNER-INFINITY FOR USE ONLY WITH WARNER-INFINITY PRODUCTS AND SERVICES
*   @author : Jules Warner
*             
*             
*/

	class WIForum
{
	public function __construct()
	{
		$this->WIdb = WIdb::getInstance();
		$this->login = new WILogin();
        $this->admin   = new WIadmin(WISession::get('admin_id'));
	}

    public function forum()
	{
		$categories = $this->WIdb->select("SELECT * FROM `wi_forum_categories`");
		$sections = $this->WIdb->select("SELECT * FROM `wi_forum_sections`");
		$posts = $this->WIdb->select("SELECT * FROM `wi_forum_posts`");

		echo ' <style>
			#postviewer{
			    width: 71%;
    float: right;
    overflow: scroll;
			}

			.well {
    height: 32em;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
		}

		.ui-tabs-vertical
		 {
    height: 29em;
		}

		.ui-tabs-vertical .ui-tabs-nav li {
    clear: left;
    width: 100%;
    border-bottom-width: 1px !important;
    border-right-width: 0 !important;
    margin: 0 -1px .2em 0;
    height: 2.27em;
}

		#forum_category {

}

.ui-tabs-vertical .ui-tabs-nav{
	padding: 0.2em 0.1em 0.2em 0.2em;
    float: left;
    width: 12em;
    height: 28.5em;
    overflow: scroll;
}


				</style>  <script>
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

			    
			    $( "#tabs" ).addClass( "ui-tabs-vertical ui-helper-clearfix" ); 
			    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

				    });
				  </script> 
				 
				  <div id="tabs" class="ui-tabs ui-corner-all ui-widget ui-widget-content ui-tabs-vertical ui-helper-clearfix">
				   <ul id="forum_category" class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">';
				   $count = "0";

				   $len = count($categories);
				  foreach ($categories as $res) {

				  	if($count == "0"){
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left ui-state-active" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.SCF('. $res['id'] .')">' . $res['title'] .'</a>
				  	</li>';
				  	}else{
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.SCF('. $res['id'] .')">' . $res['title'] .'</a>
				  	</li>';
				  	}
				  	if ($count == $len) {
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.SCF('. $res['id'] .')">' . $res['title'] .'</a>
				  	</li>';
				  	}
				  	$count++;
				  }

			  echo '</ul>
				  <ul id="forum_section" class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">';
				  $count1 = "0";

				   $len1 = count($sections);
				  foreach ($sections as $res) {
				  	if($count1 == "0"){
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left ui-state-active" aria-controls="ui-id-'. $res['id'] .'" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.CSF('. $res['id'] .')">' . $res['title'] .'</a>
				  	</li>';
				  	}else{
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" aria-controls="ui-id-'. $res['id'] .'" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.CSF('. $res['id'] .')">' . $res['title'] .'</a>
				  	</li>';
				  	}
				  	

				  	if ($count1 == $len1) {
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" aria-controls="ui-id-'. $res['id'] .'" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.CSF('. $res['id'] .')">' . $res['title'] .'</a>
				  	</li>';
				  	}
				  	$count1++;
				  }
			  echo '</ul>';

			  echo '<ul id="postviewer"class="ui-tabs-panel ui-corner-bottom ui-widget-content"  aria-hidden="true" role="tabpanel"style="width: 54%;float: right;">
				  		  <div id="forum_post_title"></div>
				  		  <div id="forum_post"></div>
			              </ul>';

			

			  echo '</div>';
	}

	    public function edit_forum()
	{
		$categories = $this->WIdb->select("SELECT * FROM `wi_forum_categories`");
		$sections = $this->WIdb->select("SELECT * FROM `wi_forum_sections`");
		$posts = $this->WIdb->select("SELECT * FROM `wi_forum_posts`");

		echo ' <style>
			#postviewer{
			    width: 71%;
    float: right;
    overflow: scroll;
			}

			.well {
    height: 32em;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f5f5f5;
    border: 1px solid #e3e3e3;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
		}

		.ui-tabs-vertical
		 {
    height: 29em;
		}

		.ui-tabs-vertical .ui-tabs-nav li {
    clear: left;
    width: 100%;
    border-bottom-width: 1px !important;
    border-right-width: 0 !important;
    margin: 0 -1px .2em 0;
    height: 2.27em;
}

		#forum_category {

}

.ui-tabs-vertical .ui-tabs-nav{
	padding: 0.2em 0.1em 0.2em 0.2em;
    float: left;
    width: 12em;
    height: 28.5em;
    overflow: scroll;
}


				</style>  <script>
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

			    
			    $( "#tabs" ).addClass( "ui-tabs-vertical ui-helper-clearfix" ); 
			    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

				    });
				  </script> 
				 
				  <div id="tabs" class="ui-tabs ui-corner-all ui-widget ui-widget-content ui-tabs-vertical ui-helper-clearfix">
				   <ul id="forum_category" class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">';
				   $count = "0";

				   $len = count($categories);
				  foreach ($categories as $res) {

				  	if($count == "0"){
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left ui-state-active" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.SCF('. $res['id'] .')">' . $res['title'] .'</a>
				  	<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div><
				  	</li>';
				  	}else{
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.SCF('. $res['id'] .')">' . $res['title'] .'</a>
				  	<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div><
				  	</li>';
				  	}
				  	if ($count == $len) {
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.SCF('. $res['id'] .')">' . $res['title'] .'</a>
				  	<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div><
				  	</li>';
				  	}
				  	$count++;
				  }

			  echo '</ul>
				  <ul id="forum_section" class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">';
				  $count1 = "0";

				   $len1 = count($sections);
				  foreach ($sections as $res) {
				  	if($count1 == "0"){
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left ui-state-active" aria-controls="ui-id-'. $res['id'] .'" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.CSF('. $res['id'] .')">' . $res['title'] .'</a>
				  	<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div><
				  	</li>';
				  	}else{
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" aria-controls="ui-id-'. $res['id'] .'" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.CSF('. $res['id'] .')">' . $res['title'] .'</a>
				  	<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div><
				  	</li>';
				  	}
				  	

				  	if ($count1 == $len1) {
				  		echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left" aria-controls="ui-id-'. $res['id'] .'" role="tab">
				  	<a href="javascript:void(0)" onclick="WIForum.CSF('. $res['id'] .')">' . $res['title'] .'</a>
				  	<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div><
				  	</li>';
				  	}
				  	$count1++;
				  }
			  echo '</ul>';

			  echo '<ul id="postviewer"class="ui-tabs-panel ui-corner-bottom ui-widget-content"  aria-hidden="true" role="tabpanel"style="width: 54%;float: right;">
				  		  <div id="forum_post_title"></div>
				  		  <div id="forum_post"></div>
			              </ul>';

			

			  echo '</div>';
	}


    public function WICategories()
    {
	  $result = $this->WIdb->select("SELECT * FROM `wi_forum_categories`");
	  foreach ($result as $res ) {
	  	echo  '<div class="col-cats">
				<div class="col-category">
				<a href="section.php?id=' . $res['id'] . '">
				<p class="text">' . $res['title'] . '</p>
				</a>
				</div><!-- end of col-category-->
				</div><!-- end of col-cats-->';
	  }
    	
	}

	public function WIEditCategories()
	{
	  $result = $this->WIdb->select("SELECT * FROM `wi_forum_categories`");
	  foreach ($result as $res ) {
	  	echo  '<div class="col-cats">
				<div class="col-category">
				<a href="section.php?id=' . $res['id'] . '">
				<p class="text">' . $res['title'] . '</p>
				</a>
				</div>
				<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div></div>';
	  }
	}

	public function new_category($title)
	{
		$cat = $title['CatData'];
		$adminname= $this->admin->id();
		$this->WIdb->insert('wi_forum_categories', array(
            "title"     => strip_tags($cat['new_cat']),
            "admin_created"  => $adminname
        )); 

        $result = array(
        	"status" => "completed",
        	"msg"    => "successfully added new category named " . strip_tags($cat['new_cat'])
        );

        echo json_encode($result);

	}


		public function new_section($title)
	{
		$section = $title['SectionData'];
		$adminname= $this->admin->id();
		$this->WIdb->insert('wi_forum_sections', array(
            "title"     => strip_tags($section['new_section']),
            "category_id"    => $section['cat'],
            "admin_created"  => $adminname
        )); 

        $result = array(
        	"status" => "completed",
        	"msg"    => "successfully added new category named " . strip_tags($cat['new_cat'])
        );

        echo json_encode($result);

	}

	public function WISection($id)
	{
		 $result = $this->WIdb->select("SELECT * FROM `wi_forum_sections` WHERE `section_id` = :id",
		 	array(
		 	"section_id" => $id
		 	)
		 );

		foreach ($result as $res) {
		 echo  '<div class="col-topics">
		<a href="post.php?id='. $res['id'] .'">
		<div class="col-topic-section">'. $res['title'] .'</div>
		<div class="col-topic-author">'. $res['admin_created'] .'
		</a>
		</div>';
		}
	}


		public function WIEditSection($id)
	{

		 $result = $this->WIdb->select("SELECT * FROM `wi_forum_sections` WHERE `section_id` = :id",
		 	array(
		 	"section_id" => $id
		 	)
		 );
		 	 foreach ($result as $res) {
		 echo  '<div class="col-topics">
		<a href="post.php?id='. $res['id'] .'">
		<div class="col-topic-section">'. $res['title'] .'</div>
		<div class="col-topic-author">'. $res['admin_created'] .'
		</a>
		</div>';
		 	 

		}
	}


	public function WIPosts($id)
	{
		$query = $this->WIdb->prepare('SELECT * FROM `wi_post_forum` WHERE `post_id` =:id ORDER BY `date_time` ASC');
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->execute();

		while($result = $query->fetch(PDO::FETCH_ASSOC))
		{
			echo '<div class="col-100">
<div class="col-labels1">'. $result['post_title'] .'</div></div>
			<div class="inner_col">
<div class="section_box">
<div class="avatpic_post"><a href="#"><img class="ava" src="#"></a>
</div><!-- end avatpic-->
<div class="post_name">' . $result['thread_title'] . '</div><!-- end section-->
<div class="post_comment">' . $result['post_body'] . '</div><!-- end section-->
<div class="post_author">' . $result['post_author'] . '</div><!-- end section-->
<div class="last_time">' . $result['date_time'] . '</div><!-- end section-->
</div><!-- end section box-->
</div><!-- end inner col-->';
		}

	}

	public function ForumMenu()
	{
		
			if(!$this->login->isLoggedIn()) // guest
			{

			echo '';

			 
			} elseif($this->admin->isAdmin())  // admin
			{
			
			echo '<button id="opencatModal">New Category</button>
                <button id="opensectionModal">New Section</button>';
			
			}else{ // admin
			
			echo '<button id="opencatModal">New Category</button>
                  <button id="opensectionModal">New Section</button>';

		};
	}

	public function category_selector()
	{
		$result = $this->WIdb->select("SELECT * FROM `wi_forum_categories`");

		foreach ($result as $res) {
			echo '<option value="' . $res['id']. '">' . $res['title'] . '</option>';
		}
	}


	public function DeleteCategory($id)
	{
		$this->WIdb->delete("wi_forum_categories", "id = :id", array( "id" => $id ));

	 $result = array(
        	"status" => "completed",
        	"msg"    => "successfully deleted this category"
        );

        echo json_encode($result);
	}

	public function SCF($id)
	{
		$result = $this->WIdb->select("SELECT * FROM `wi_forum_sections` WHERE `category_id`=:id",
						array(
						"id" => $id	
						)
					);

		foreach ($result as $res) {
			echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left">
				  	<a href="javascript:void(0)" onclick="WIForum.CSF('. $res['id'] .')">' . $res['title'] .'</a>
				  	<div class="col-sm-1 col-md-1 col-lg-1 col-xs-2">
				<a href="#" onclick="WIForum.showCategoryModal(' . $res['id'].')">
				<i class="fa fa-edit"></i>
				</a>
				</div>
                <div class="col-sm-1 col-md-1 col-lg-1 col-xs-1">
                <a href="#" class="glyphicon glyphicon-trash" onclick="WIForum.DeletecategoryModal(' . $res['id'].')">
                </a>
				</div><
				  	</li>';
		}
	}

		public function CSF($id)
	{
		$result = $this->WIdb->select("SELECT * FROM `wi_forum_posts` WHERE `section_id`=:id",
						array(
						"id" => $id	
						)
					);
		$count = "0";
		$len = count($result);


		foreach ($result as $res) {

			if($count == "0"){
				echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left">
			<div class-"col-lg-12 col-xs-11 col-md-12">
					<input type="hidden" id="'. $res['id'] .'">
				  	<div id="forum_post_title">' . $res['title'] .'</div>
				  		  <div id="forum_post">' . $res['post'] .'</div>
				  		  </div>
				  	</li>';
			}else{
				echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left">
			<div class-"col-lg-12 col-xs-11 col-md-12">
					<input type="hidden" id="'. $res['id'] .'">
				  	<div id="forum_post_title">' . $res['title'] .'</div>
				  		  <div id="forum_post">' . $res['post'] .'</div>
				  		  </div>
				  	</li>';
			}
			

			if($count == $len){
				echo '<li class="ui-tabs-tab ui-state-default ui-tab ui-corner-left">
			<div class-"col-lg-12 col-xs-11 col-md-12">
					<input type="hidden" id="'. $res['id'] .'">
				  	<div id="forum_post_title">' . $res['title'] .'</div>
				  		  <div id="forum_post">' . $res['post'] .'</div>
				  		  </div>
				  	</li><li><button>Reply</button></li>';
			}

			$count++;
		}
	}




}
