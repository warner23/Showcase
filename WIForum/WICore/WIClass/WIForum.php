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
        $this->user   = new WIUser(WISession::get('user_id'));
	}

    public function forum()
	{
		$categories = $this->WIdb->select("SELECT * FROM `wi_forum_categories`");
		$sections = $this->WIdb->select("SELECT * FROM `wi_forum_sections`");
		$posts = $this->WIdb->select("SELECT * FROM `wi_forum_posts`");

		echo '  <script>
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

			    
			    $( "#tabs" ).tabs({
			        // The zero-based index of the panel that is active (open)
			        active : oldIndex,
			        // Triggered after a tab has been activated
			        activate : function( event, ui ){
			            //  Get future value
			            var newIndex = ui.newTab.parent().children().index(ui.newTab);
			            //  Set future value
			            dataStore.setItem( index, newIndex ) 
			        }
			    }).addClass( "ui-tabs-vertical ui-helper-clearfix" ); 
			    $( "#tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

				    });
				  </script>
				  <div id="tabs">
				  <ul id="forum_category">';

				  foreach ($categories as $res) {
				  	echo '<li>
				  	<a href="javascript:void(0)" onclick="WIForum.SCF('. $res['id'] .')">' . $res['title'] .'</a>
				  	</li>';
				  }

			  echo '</ul>
			  <ul id="forum_section" class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">';

				  foreach ($sections as $res) {
				  	echo '<li>
				  	<a href="#tabs-'. $res['id'] .'" >' . $res['title'] .'</a>
				  	</li>';
				  }

			  echo '</ul>';

			  foreach ($posts as $res) {
				  	echo '<div id="tabs-'. $res['category_id'] .'">
				  		  <div>'. $res['title'] .'</div>
			              </div>';
				  }

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
		$username= $this->user->id();
		$this->WIdb->insert('wi_forum_categories', array(
            "title"     => strip_tags($cat['new_cat']),
            "user_created"  => $username
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
		$username= $this->user->id();
		$this->WIdb->insert('wi_forum_sections', array(
            "title"     => strip_tags($section['new_section']),
            "category_id"    => $section['cat'],
            "user_created"  => $username
        )); 

        $result = array(
        	"status" => "completed",
        	"msg"    => "successfully added new category named " . strip_tags($cat['new_cat'])
        );

        echo json_encode($result);

	}

	public function WISection($id)
	{
		 $result = $this->WIdb->select("SELECT * FROM `wi_forum_sections` WHERE `section_id` = :i",
		 	array(
		 	"section_id" => $id
		 	)
		 );

		foreach ($result as $res) {
		 echo  '<div class="col-topics">
		<a href="post.php?id='. $res['id'] .'">
		<div class="col-topic-section">'. $res['title'] .'</div>
		<div class="col-topic-author">'. $res['user_created'] .'
		</a>
		</div>';
		}
	}


		public function WIEditSection($id)
	{

		 $result = $this->WIdb->select("SELECT * FROM `wi_forum_sections` WHERE `section_id` = :i",
		 	array(
		 	"section_id" => $id
		 	)
		 );
		 	 foreach ($result as $res) {
		 echo  '<div class="col-topics">
		<a href="post.php?id='. $res['id'] .'">
		<div class="col-topic-section">'. $res['title'] .'</div>
		<div class="col-topic-author">'. $res['user_created'] .'
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

			 
			} elseif($this->user->isAdmin())  // admin
			{
			
			echo '<button id="opencatModal">New Category</button>
                <button id="opensectionModal">New Section</button>';
			
			}else{ // user
			
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
		$result = $this->WIdb->select("SELECT * FROM `wi_forum_sections` WHERE `cat_id`=:id",
						array(
						"id" => $id	
						)
					);

		foreach ($result as $res) {
			echo '<li>
				  	<a href="#tabs-'. $res['id'] .'" >' . $res['title'] .'</a>
				  	</li>';
		}
	}




}
