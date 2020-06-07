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
        $this->Info = new WIUserInfo();
        $this->user   = new WIUser(WISession::get('user_id'));
	}

    public function WICategories()
    {
    	$query = $this->WIdb->prepare('SELECT * FROM `wi_forum_categories` ORDER BY `cat_Title`  ASC');
    	$query->execute();
		while($result = $query->fetch(PDO::FETCH_ASSOC))
		{
			
		if($result > 0)
		{


		echo  '<div class="col-cats">
		<div class="col-category">
		<div class="avatpic">
		<a href="topic.php" id="' . $result['cat_id'] . '" class="cat_id">
		<p class="text">' . $result['cat_title'] . '</p></a>
		</div><!-- end avatpic-->
		</div><!-- end of col-category-->
		</div><!-- end of col-cats-->';
		}else{
			echo "There are currently no categories";
		}

		}
    	
	}

	public function WISection($id)
	{
		
    	$query = $this->WIdb->prepare('SELECT * FROM `wi_forum_topics` WHERE `cat_id` = :id ORDER BY `topic_reply_date` ASC LIMIT 10');
    	$query->bindParam(':id', $id, PDO::PARAM_INT);
    	$query->execute();
		while($result = $query->fetch(PDO::FETCH_ASSOC))
		{

		echo  '<div class="col-topics">
			<a href="post.php" id="'. $result['id'] .'" class="topic_id"><div class="col-topic-section">'. $result['topic_title'] .'</div><!-- end of topic section-->
			<div class="col-topic-author">';echo $this->getUsername($result['topic_creator']); echo '<div class="avatpic1">
			</div><!-- end avatpic--></div><!-- end of topic section-->
			<div class="col-topic-views">'. $result['view_count'] .'</div><!-- end of topic section-->
			<div class="col-topic-replies">'. $result['replies'] .'</div><!-- end of topic section--></a>
			</div><!--e nd of topics-->';
		}
	}


	public function WIPosts($id)
	{
		$query = $this->WIdb->prepare('SELECT * FROM `wi_forum_posts` WHERE `cat_id` =:id ORDER BY `date_time` ASC');
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->execute();

		while($result = $query->fetch(PDO::FETCH_ASSOC))
		{
			echo '<div class="col-100">
			<div class="col-labels1">'. $result['section_title'] .'</div></div>
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

	public function forumMenu()
	{
		
			if(!$this->login->isLoggedIn()) // guest
			{

			echo ' <nav role="navigation" class="navbar navbar-default">
			<ul class="navbar-nav nav">
			<li><a href="index.php">Categories</a></li>
			<li><a href="topic.php">Topic</a></li>
			
			 </nav>';

			 
			} elseif($this->user->isAdmin())  // admin
			{
			
			echo '<nav role="navigation" class="navbar navbar-default">
			<ul class="navbar-nav nav">
			<li><a href="index.php">Categories</a></li>
			<li><a href="topic.php">Topics</a></li>
			<li><a href="new_cat.php">Create New Category</a></li>
			<li><a href="new_topic.php">Create New Topic</a></li>
			<li><a href="#">Post</a></li>
			<li><a href="#">Edit Post</a></li>
			 </nav>';
			
			}else{ // user
			
			echo '<nav role="navigation" class="navbar navbar-default">
			<ul class="navbar-nav nav">
			<li><a href="index.php">Categories</a></li>
			<li><a href="topic.php">Topic</a></li>
			 </nav>';

		};
	}


	public function getUsername($id)
	{
		$query = $this->WIdb->prepare('SELECT * FROM `wi_members` WHERE `user_id` =:id');
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		$query->execute();

		$result = $query->fetch(PDO::FETCH_ASSOC);
		$username = $result['username'];
		return $username;
	}

	public function new_cat()
	{
		echo '<form class="new_cat" id="new_cat">
		<label class="label" for="Category title"> Category Title</label>
		<input class="title" type="text" placeholder="title" name="cat_title" id="cat_Title">
		<label class="label" for="Category description"></label>
		<input class="desc" type="text" placeholder="description" name="cat_desc" id="cat_desc">
		<button class="btn btn-as pull-right" id="cat" onclick="forum.new_cat();" type="button">Save</button>
		</form><div id="result"></div>';
	}

		public function new_topic()
	{
		echo '<form id="new_topic">
		<label class="label" for="Topic title">Topic Title</label>
		<input class="title" type="text" placeholder="title" name="topic_title" id="topic_Title">
		<button class="btn btn-as pull-right" onclick="forum.new_topic();" id="new_topic" type="button">Save</button>
		</form><div id="result"></div>';
	}

			public function new_post()
	{
		echo '<form id="new_topic">
		<div class="col-md-4">
		<label class="label" for="Post title">Thread Title</label>
		</div>
		<div class="col-md-6">
		<input class="title" type="text" placeholder="title" id="title"></div><div class="col-md-12">';
		echo $this->wysiwyg();
		echo '</div>
		<div class="col-md-6">
		<button class="btn btn-as pull-right" onclick="posts.new_post();"  id="new_post" type="button">Save</button></div>
		</form><div id="result"></div>';
	}

	public function add_new_cat($title, $cat_desc)
	{
		$user = WISession::get("user_id");
		$date_time = date('Y-m-d H:i:s');
		$cat_desc = $_POST['cat_descr'];
		$sql = "INSERT INTO `wi_forum_categories` (`cat_title`, `cat_desc`, `last_post_date`,`last_user_posted`) VALUES ( :title, :descrip, :last_post_date,:last_user_posted)";

				$query = $this->WIdb->prepare($sql);
				$query->bindParam(':title', $title, PDO::PARAM_STR);
				$query->bindParam(':descrip', $cat_desc, PDO::PARAM_STR);
				$query->bindParam(':last_post_date', $date_time, PDO::PARAM_STR);
				$query->bindParam(':last_user_posted', $user, PDO::PARAM_STR);

				$query->execute();

			$result = array(
				"status" => "completed",
				"msg"    => "You have successfully added a new category"
			);

			echo json_encode($result);
	}

	public function add_new_topic($title,$cat_id)
	{
		
		$user = WISession::get("user_id");
		$date_time = date('Y-m-d H:i:s');
		$topic_views = 0;
		$sql = "INSERT INTO `wi_forum_topics` (`cat_id`, `topic_title`, `topic_creator`,`topic_last_user`,`topic_date`,`topic_reply_date`,`topic_views`) VALUES ( :cat_id, :topic_title, :topic_creator, :topic_last_user, :topic_date, :topic_reply_date ,:topic_views)";

				$query = $this->WIdb->prepare($sql);
				$query->bindParam(':cat_id', $cat_id, PDO::PARAM_STR);
				$query->bindParam(':topic_title', $title, PDO::PARAM_STR);
				$query->bindParam(':topic_creator', $user, PDO::PARAM_STR);
				$query->bindParam(':topic_last_user', $user, PDO::PARAM_STR);
				$query->bindParam(':topic_date', $date_time, PDO::PARAM_STR);
				$query->bindParam(':topic_reply_date', $date_time, PDO::PARAM_STR);
				$query->bindParam(':topic_views', $topic_views, PDO::PARAM_STR);

				$query->execute();

				$result = array(
				"status" => "completed",
				"msg"    => "You have successfully added a new topic"
			);

			echo json_encode($result);
	}

	public function add_new_post($body, $topic_id, $cat_id, $title)
	{

		$user = WISession::get("user_id");
		$date_time = date('Y-m-d H:i:s');
		$count = 0;

		$sql = "INSERT INTO `wi_forum_posts` (`post_author_id`, `date_time`, `view_count`, `thread_title`, `topic_id` ,`post_body`, `cat_id`) VALUES ( :post_author_id, :date_time, :view_count, :thread_title, :topic_id, :post_body, :cat_id)";

				$query = $this->WIdb->prepare($sql);
				$query->bindParam(':post_author_id', $user, PDO::PARAM_STR);
				$query->bindParam(':date_time', $date_time, PDO::PARAM_STR);
				$query->bindParam(':view_count', $count, PDO::PARAM_STR);
				$query->bindParam(':thread_title', $title, PDO::PARAM_STR);
				$query->bindParam(':topic_id', $topic_id, PDO::PARAM_STR);
				$query->bindParam(':post_body', $body, PDO::PARAM_STR);
				$query->bindParam(':cat_id', $cat_id, PDO::PARAM_STR);

				$query->execute();

				$result = array(
				"status" => "completed",
				"msg"    => "You have successfully added a new post"
			);

			echo json_encode($result);
	}



	public function wysiwyg()
	{
		echo '<link href="https://fonts.googleapis.com/css?family=Dosis|Candal" rel="stylesheet" type="text/css">
<div class="toolbar">
  <a href="#" data-command="undo"><i class="fa fa-undo"></i></a>
  <a href="#" data-command="redo"><i class="fa fa-repeat"></i></a>
  <div class="fore-wrapper"><i class="fa fa-font" style="color:#C96;""></i>
    <div class="fore-palette">
    </div>
  </div>
  <div class="back-wrapper"><i class="fa fa-font" style="background:#C96;"></i>
    <div class="back-palette">
    </div>
  </div>
  <a href="#" data-command="bold"><i class="fa fa-bold" title="BOLD"></i></a>
  <a href="#" data-command="italic"><i class="fa fa-italic" title="italic"></i></a>
  <a href="#" data-command="underline"><i class="fa fa-underline" title="underline"></i></a>
  <a href="#" data-command="strikeThrough"><i class="fa fa-strikethrough" title="strikeThrough"></i></a>
  <a href="#" data-command="justifyLeft"><i class="fa fa-align-left" title="justifyLeft"></i></a>
  <a href="#" data-command="justifyCenter"><i class="fa fa-align-center" title="justifyCenter"></i></a>
  <a href="#" data-command="justifyRight"><i class="fa fa-align-right" title="justifyRight"></i></a>
  <a href="#" data-command="justifyFull"><i class="fa fa-align-justify" title="justifyFull"></i></a>
  <a href="#" data-command="indent"><i class="fa fa-indent" title="indent"></i></a>
  <a href="#" data-command="outdent"><i class="fa fa-outdent" title="outdent"></i></a>
  <a href="#" data-command="insertUnorderedList"><i class="fa fa-list-ul" title="insertUnorderedList"></i></a>
  <a href="#" data-command="insertOrderedList"><i class="fa fa-list-ol" title="insertOrderedList"></i></a>
  <a href="#" data-command="h1">H1</a>
  <a href="#" data-command="h2">H2</a>
  <a href="#" data-command="createlink"><i class="fa fa-link" title="createlink"></i></a>
  <a href="#" data-command="unlink"><i class="fa fa-unlink" title="unlink(filename)"></i></a>
  <a href="#" data-command="insertimage"><i class="fa fa-image" title="insertimage"></i></a>
  <a href="#" data-command="p">P</a>
  <a href="#" data-command="subscript"><i class="fa fa-subscript" title="subscript"></i></a>
  <a href="#" data-command="superscript"><i class="fa fa-superscript" title="superscript"></i></a>
</div>
<div id="editor" contenteditable>
  <h1>A Heading.</h1>
  <p>Some text that you can format. Try inserting an image or a link.</p>
</div>';
	}



}
