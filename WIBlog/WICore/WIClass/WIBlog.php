<?php
/**
* resource Class
* Created by Warner Infinity
* Author Jules Warner
*/
class WIBlog
{
	function __construct() 
	{
       $this->WIdb = WIdb::getInstance();
       $this->Comment = new WIComment();
       $this->Page    = new WIPage();
       $this->Mod     = new WIModules();
    }


    public function Cat()
	 {


    $result = $this->WIdb->select("SELECT * FROM wi_blogcategories");

  	echo '<div class="title_widget">									
  			<h3>Categories</h3>								
  			</div>								
  			<ul class="arrows_list">';
  	foreach($result as $res){
  		echo '<li><a href="javascript:void(0);" class="category" cid="' . $res['cat_id']. '"><i class="fa fa-angle-right"></i> ' . $res['title'] . '<span></span></a></li>';
  		}
  	echo '</ul>';
	}

	public function SelectCategory()
	{

    $result = $this->WIdb->select("SELECT * FROM wi_blogcategories");

		echo '<label for="Category">Category</label>
    <select name="Category" id="cat"><option value="" selected="selected">Select Category</option> ';

		foreach($result as $res){
			echo '<option value="' . $res['cat_id'] . '">' . $res['title'] . '</option>';
		}
		echo ' </select>';

	}


		public function selectedCat($cid)
	{

		 if(isset($_POST["page"])){
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
        if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
    }else{
        $page_number = 1; //if there's no page number, set it to 1
    }

        $item_per_page = 8;

        $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blog`");
        $rows = count($result);

        //break records into pages
        $total_pages = ceil($rows/$item_per_page);

                //get starting position to fetch the records
        $page_position = (($page_number-1) * $item_per_page);


        $result = $this->WIdb->select(
                    "SELECT * FROM wi_blog WHERE Category = :cid",
                     array(
                       "cid" => $cid
                     )
                  );

        foreach($result as $res){
          $type = $res['type'];
          $date = $res['day'];

          if($type == "NoMedia"){
            self::NoMedia();
          }else if($type == "mediaSlider"){
            self::mediaSlider();
          }else if($type == "mediaVideo"){
            self::mediaVideo();
          }else if($type == "blog_image"){
            self::blogImage();
          }else if($type == "mediaaudio"){
            self::mediaAudio();
          }else if($type == "mediaYoutube")
            self::mediaYoutube();
        }
	}


		public function NoMedia()
    {
     
      foreach ($media as $post) {
        echo '<div class="blog_style_2"><article class="post_container">                             
         <div class="post-info">                                    
         <div class="post-date">                                        
         <span class="day">' . $post['day'] . '</span>                                        
         <span class="month">' . $post['month'] . '</span>                                    
         </div>                                    
         <div class="post-category">                                      
         <i class="fa fa-file-text-o"></i>                                    
         </div>                               
          </div><!-- .post-info end -->                                
          <div class="post-content">                                   
           <a href="javascript:void(0)"  onclick="WIBlog.postPage(`'. $media['title'] .'`,`' . $media['id'] . '`);">                                       
            <h4>' . $post['title'] . '</h4>                                    
            </a>                                    
            <div class="blog-meta">                                        
            <ul>                                            
            <li class="fa fa-user">                                               
             <a href="#">' . $post['user'] . '</a>                                            
             </li>                                            
             <li class="post-tags fa fa-tags">                                                
             <a href="#">news, </a>                                               
              <a href="#">dois</a>                                            
              </li>                                        
              </ul>                                   
               </div>                                    
               <p>                                      
               ' . $post['post'] . '                                  
               </p>                                    
               <a href="' . $post['href'] . '">' . $post['button_name'] . '</a>                             
               </div>                        
                </article></div>
               <!-- .blog-post end -->';
          }

    }

    public function mediaAudio()
    {

    }

    public function mediaVideo($media)
    {
      $result = $this->WIdb->select(
          "SELECT * FROM `wi_blog` WHERE type =:type AND Category = :cid ORDER BY day DESC",
           array(
             "cid" => $cid,
             "type" => $type
           )
        );
      foreach($result as $media){
        echo '<article class="post_container">                              
<div class="post-info">                                   
 <div class="post-date">                                        
 <span class="day">' . $media['day'] . '</span>                                        
 <span class="month">' . $media['month'] . '</span>                                    
 </div>                                   
  <div class="post-category">                                     
  <i class="fa fa-picture-o"></i>                                    
  </div>                                
  </div><!-- .post-info end -->                                
  <figure class="post-video">                                    
  <video width="400" height="160" controls>
  <source src="../../../WIAdmin/WIMedia/Vid/blog/' . $media['video'] . '" type="video/mp4">
</video>                                
  </figure>                               
   <div class="post-content">
   <a href="javascript:void(0)"  onclick="WIBlog.postPage(`'. $media['title'] .'`,`' . $media['id'] . '`);">                                   
   <h4>' . $media['title'] . '</h4>                                    
   <div class="blog-meta">                                        
   <ul>                                            
   <li class="fa fa-user">                                                
   <a href="javascript:void(0)">' . $media['user'] . '</a>                                            
   </li>                                            
   <li class="post-tags fa fa-tags">                                                
   <a href="javascript:void(0)">news, </a>                                                
   <a href="javascript:void(0)">dois</a>                                            
   </li>                                        
   </ul>                                    
   </div>                                   
    <p>                                     
    ' . $media['post'] . '                                 
    </p>                                    
     </div>  
         <div class="comments-comments">';
              $comments = $this->Comment->getBlogComments($media['id']);
              foreach ($comments as $c) {
                echo '<blockquote>' . $c['comment'] . '
                <small>' . $c['posted_by_name'] . ' <em>at ' . $c['post_time'] . '</em></small>
                </backquote>';
              }
               echo '</div>   

         <textarea class="form-control" name="comment" rows="3" id="comment-text-'.$media['id'].'"></textarea> 

          <div class="form-group">
                    <button class="btn btn-primary" id="btn-comment-'.$media['id'].'" onclick="WIComment.newCommment(`'.$media['id'].'`)" type="submit">
                        <i class="fa fa-comment"></i>
                        '.WILang::get("comment").'
                    </button>
                </div>                        
                                
         </article>';
      }
    }

    public function mediaSlider($media)
    {

      foreach ($media as $media) {
        echo '<!-- .latest-posts start -->                            
<article class="post_container">                              
<div class="post-info">                                   
 <div class="post-date">                                        
 <span class="day">' . $media['day'] . '</span>                                        
 <span class="month">' . $media['month'] . '</span>                                   
  </div>                                    
  <div class="post-category">                                     
  <i class="fa fa-picture-o"></i>                                    
  </div>                                
  </div><!-- .post-info end -->                               
   <figure class="post-image">                                  
   <div class="slideshow-container">

<div class="mySlides">
  <div class="numbertext"></div>
   <img src="../../../WIAdmin/WIMedia/Img/blog/revslider/' . $media['image'] . '" style="width:100%">
  <div class="text">' . $media['caption'] . '</div>
</div>

<div class="mySlides">
  <div class="numbertext"></div>
<img src="../../../WIAdmin/WIMedia/Img/blog/revslider/' . $media['image2'] . '" style="width:100%">        
  <div class="text">' . $media['caption1'] . '</div>
</div>

<div class="mySlides">
  <div class="numbertext"></div>
<img src="../../../WIAdmin/WIMedia/Img/blog/revslider/' . $media['image3'] . '" style="width:100%">
  <div class="text">' . $media['caption2'] . '</div>
</div>

<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

</div>
<br>

<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
  <span class="dot" onclick="currentSlide(2)"></span> 
  <span class="dot" onclick="currentSlide(3)"></span>
</div>                                             
   </figure>                               
    <div class="post-content">                                    
    <a href="javascript:void(0)"  onclick="WIBlog.postPage(`'. $media['title'] .'`,`' . $media['id'] . '`);">                                      
    <h4>' . $media['title'] . '</h4>                                    
    </a>                                    
    <div class="blog-meta">                                        
    <ul>                                            
    <li class="fa fa-user">                                                
    <a href="javascript:void(0)">' . $media['user'] . '</a>                                            
    </li>                                           
     <li class="post-tags fa fa-tags">                                               
      <a href="javascript:void(0)">news, </a>                                                
      <a href="javascript:void(0)">dois</a>                                            
      </li>                                        
</ul>                                    
</div>                                    
<p>                                        
' . $media['post'] . '                                  
</p>                                    
 </div>  
         <div class="comments-comments">';
              $comments = $this->Comment->getBlogComments($media['id']);
              foreach ($comments as $c) {
                echo '<blockquote>' . $c['comment'] . '
                <small>' . $c['posted_by_name'] . ' <em>at ' . $c['post_time'] . '</em></small>
                </backquote>';
              }
               echo '</div>   

         <textarea class="form-control" name="comment" rows="3" id="comment-text-'.$media['id'].'"></textarea> 

          <div class="form-group">
                    <button class="btn btn-primary" id="btn-comment-'.$media['id'].'" onclick="WIComment.newCommment(`'.$media['id'].'`)" type="submit">
                        <i class="fa fa-comment"></i>
                        '.WILang::get("comment").'
                    </button>
                </div>                        
                                
         </article>
        <script type="text/javascript">
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
        showSlides(slideIndex += n);
        }

        function currentSlide(n) {
        showSlides(slideIndex = n);
        }

        function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {slideIndex = 1}    
        if (n < 1) {slideIndex = slides.length}
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";  
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex-1].style.display = "block";  
        dots[slideIndex-1].className += " active";
        }
        </script>';
      }
    }

    public function mediaYoutube($media)
    {
        echo '<!-- .latest-posts start -->                            
    <article class="post_container">                              
    <div class="post-info">                                    
    <div class="post-date">                                        
    <span class="day">' . $media['day']. '</span>                                        
    <span class="month">' . $media['month'] .'</span>                                    
    </div>                                    
    <div class="post-category">' . self::blogCat($media['Category']) .'                                     
    <i class="fa fa-picture-o"></i>                                    
    </div>                                
    </div><!-- .post-info end -->                                
    <figure class="post-video">                                    
   ' . $media['youtube'] .'      
     </figure>                                
     <div class="post-content">                                    
     <a href="javascript:void(0)"  onclick="WIBlog.postPage(`'. $media['title'] .'`,`' . $media['id'] . '`);">                                           
     <h4>' . $media['title'] . '</h4>                                    
     </a>                                    
     <div class="blog-meta">                                        
     <ul>                                           
      <li class="fa fa-user">                                                
      <a href="javascript:void(0);">' . $media['user'] . '</a>                                            
      </li>                                            
      <li class="post-tags fa fa-tags">                                                
      <a href="#">news, </a>                                                
     <a href="#">dois</a>                                            
      </li>                                        
    </ul>                                    
    </div>                                    
    <p>                                     
    ' . $media['post'] . '                                 
    </p>                                                               
    </div>                        
    </article>
      <!-- .blog-post end -->';
   }

    public function blogImage($media)
    {
      
      foreach ($media as $post) {
        echo '<!-- .latest-posts start --><div class="blog_style_2">                            
        <article class="post_container">                              
        <div class="post-info">                                    
        <div class="post-date">                                        
        <span class="day">' . $post['day'] . '</span>                                        
        <span class="month">' . $post['month'] . '</span>                                    
        </div>                                    
        <div class="post-category">                                     
        <i class="fa fa-picture-o"></i>                                    
        </div>                                
        </div><!-- .post-info end -->                                
        <figure class="post-image">                 
        <a href="#"><img src="WIMedia/Img/blog/' . $post['image'] . '" alt=""></a>                
        </figure>                               
         <div class="post-content">                                    
         <a href="javascript:void(0)"  onclick="WIBlog.postPage(`'. $media['title'] .'`,`' . $media['id'] . '`);">                                       
         <h4>' . $post['title'] . '</h4>                                    
         </a>                                    
         <div class="blog-meta">                                        
         <ul>                                            
         <li class="fa fa-user">                                                
         <a href="#">' . $post['user'] . '</a>                                           
          </li>                                           
           <li class="post-tags fa fa-tags">                                               
            <a href="#">news, </a>                                                
            <a href="#">dois</a>                                           
             </li>                                        
             </ul>                                    
             </div>                                    
             <p>                                      
             ' . $post['post'] . '                               
             </p>                                    
             <textarea class="form-control" name="comment" rows="3"></textarea>                            
             </div>                         
             </article><!-- .blog-post end --> </div>';
        
      }
    }





		public function Resource()
	  {

      $result = $this->WIdb->select(
                    "SELECT * FROM wi_resources ORDER BY RAND() LIMIT 0,9");


		foreach($result as $res){
			echo '	<div class="col-md-4 col-lg-4 col-sm-4">
		<div class="panel panel-info">
		<div class="panel-heading">' . $res['title'] . '</div>
		<div class="panel-body">
			<img src="WIMedia/Img/resources/' . $res['image'] . '" style="width:160px;height:250px;"/>
		</div>
		<div class="panel-footer">' . $res['publish_date'] . '
			<button rid="' . $res['resource_id'] . '" onclick="WIResources.Source(' . $res['resource_id'] . ')" style="float:right;" class="btn btn-danger btn-xs" id="OSDP_resource">View Resource</button>
		</div>
		</div>
	</div>';
		}
	}

	public function InsertnoMedia($PostNoMedia)
	{
    $data = $PostNoMedia['PostData'];
		          $this->WIdb->insert('wi_blog', array(
            "type"     => $data['type'],
            "day"  => $data['day'],
            "month"  => $data['month'],
            "title" => strip_tags($data['title']),
            "user" => $data['user'],
            "post" => $data['post'],
            "Category"  => $data['Category']
            ));

     $page = $PostNoMedia['PostData']['title'];

     if( strpos($page, " ") !== false )
      {
        $page = preg_replace('/\s+/', '_', $page);
      }
     $this->Page->newPage($page);
     $this->Mod->saving_mod($page);

		 $msg = "Successfully added to db";

		 $result = array(
		 	"status" => "complete",
		 	"msg"    => $msg
		 );

		 echo json_encode($result);

	}


		public function blogPostImage($PostImage)
	{
		//echo $type;
		 $this->WIdb->insert('wi_blog', $PostImage);
      $page = $PostNoMedia['PostData']['title'];
     if( strpos($page, " ") !== false )
      {
        $page = preg_replace('/\s+/', '_', $page);
      }
     $this->Page->newPage($page);
     $this->Mod->saving_mod($page);

	}

	public function blogPostSlider($postSlider)
	{
		//echo $type;
		 $this->WIdb->insert('wi_blog', $postSlider);
      $page = $postSlider['PostData']['title'];
     if( strpos($page, " ") !== false )
      {
        $page = preg_replace('/\s+/', '_', $page);
      }
     $this->Page->newPage($page);
     $this->Mod->saving_mod($page);

	}

	public function blogPostAudio($PostAudio)
	{
		//echo $type;
		 $this->WIdb->insert('wi_blog', $PostAudio);
      $page = $PostAudio['PostData']['title'];
     if( strpos($page, " ") !== false )
      {
        $page = preg_replace('/\s+/', '_', $page);
      }
     $this->Page->newPage($page);
     $this->Mod->saving_mod($page);

	}

	public function blogPostVideo($PostVideo)
	{
		//echo $type;
		 $this->WIdb->insert('wi_blog', $PostVideo);
      $page = $PostVideo['PostData']['title'];
     if( strpos($page, " ") !== false )
      {
        $page = preg_replace('/\s+/', '_', $page);
      }
     $this->Page->newPage($page);
     $this->Mod->saving_mod($page);
	}

	public function YoutubeMedia($PostYouTube)
	{
     $data = $PostYouTube['PostData'];
      // insert blog post into db
         $this->WIdb->insert('wi_blog', array(
            "type"     => $data['type'],
            "day"  => $data['day'],
            "month"  => $data['month'],
            "title" => strip_tags($data['title']),
            "youtube" => $data['ytlink'],
            "user" => $data['user'],
            "post" => $data['post'],
            "Category"  => $data['Category']
            ));

     //create main blog page for the main post
     $page = $PostYouTube['PostData']['title'];
     if( strpos($page, " ") !== false )
      {
        $page = preg_replace('/\s+/', '_', $page);
      }
     $this->Page->newPage($page);
     $this->Mod->saving_mod($page);

		 $msg = "Successfully added to db";

		 $result = array(
		 	"status" => "complete",
		 	"msg"    => $msg
		 );

		 echo json_encode($result);

	}





	public function Search($keywords)
	{

          $result = $this->WIdb->select(
                    "SELECT * FROM wi_resources WHERE keywords LIKE :keyword",
                     array(
                       "keyword" => $keywords
                     )
                  );


    		foreach($result as $res){
    			echo '	<div class="col-md-4 col-lg-8 col-sm-4">
    		<div class="panel panel-info">
    		<div class="panel-heading">' . $res['title'] . '</div>
    		<div class="panel-body">
    			<img src="WIMedia/Img/resources/' . $res['image'] . '" style="width:160px;height:250px;"/>
    			
    		</div>
    		<div class="panel-heading">' . $res['publish_date'] . '
    			<button pid="' . $res['resource_id'] . '" style="float:right;" class="btn btn-danger btn-xs" id="product">Add to cart</button>
    		</div>
    		</div>
    	</div>';
		}
	}

	public function getResource($rid)
	{

        $result = $this->WIdb->select(
              "SELECT * FROM wi_resources WHERE resource_id =:rid",
               array(
                 "rid" => $rid
               )
            );



		foreach($result as $res){

			echo '<div class="row">
          <div class="span5">
            <div id="items-carousel" class="carousel slide mbottom0">
              <div class="carousel-inner">
                <div class="active item">
                  <img class="media-object" id="media-object" src="WIMedia/Img/resources/' . $res['image'] . '" style="width:160px;height:250px;" alt="" />
                </div>

                <div class="item">
                  <img class="media-object" src="" alt="" />
                </div>

                <div class="item">
                  <img class="media-object" src="" alt="" />
                </div>
              </div>
              <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
              <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>
          </div>

          <div class="span4">
            <h4 id="brand">' . WIResources::catType($res['cat'])  . '</h4>
            <h5 id="name" class="item_name">' . $res['title'] . '</h5>
            <p id="descript"></p>
            
              <a href="WIMedia/Resources/' . $res['dl_link'] . '" class="btn btn-primary" id="osdp" onclick="WIResources.Download(event)">View & download</a>
            
            
            
          </div>
        </div>';
		}
		

	
	}

	public function Share()
	{
		echo '<ul class="shares">									
		<li class="shareslabel"><h3>Share</h3></li>									
		<li><a title="" data-toggle="tooltip" data-placement="top" href="#" class="twitter" data-original-title="Twitter"></a></li>	
		<li><a title="" data-toggle="tooltip" data-placement="top" href="#" class="facebook" data-original-title="Facebook"></a></li>									
		<li><a title="" data-toggle="tooltip" data-placement="top" href="#" class="gplus" data-original-title="Google Plus"></a></li>									
		<li><a title="" data-toggle="tooltip" data-placement="top" href="#" class="pinterest" data-original-title="Pinterest"></a></li>									
		<li><a title="" data-toggle="tooltip" data-placement="top" href="#" class="yahoo" data-original-title="Yahoo"></a></li>									
		<li><a title="" data-toggle="tooltip" data-placement="top" href="#" class="linkedin" data-original-title="LinkedIn"></a></li>								</ul>';
	}

	public function catType($cat_id)
	{
		 $result = $this->WIdb->select(
                    "SELECT `title` FROM `wi_categories`
                     WHERE `cat_id` = :cat_id",
                     array(
                       "cat_id" => $cat_id
                     )
                  );
		//var_dump($result) ;
		  if ( count ( $result ) > 0 )
            return $result[0]['title'];
        else
            return null;
	}


	public function OSDPResource($rid, $column)
	{
     $result = $this->WIdb->select(
                    "SELECT * FROM wi_resources WHERE resource_id =:rid",
                     array(
                       "rid" => $rid
                     )
                  );

		echo $result[0][$column];
	}

	public function hasPosts()
	{
		
		$res = $this->WIdb->select('SELECT * FROM `wi_blog` ORDER BY day DESC');
		//print_r($res);
		if(count($res) < 1){
			echo "No Posts Yet.";
		}else{

		foreach ($res as $media) {
		
		if($media['type'] === "NoMedia"){
				
        //self::NoMedia($media);
              echo '<div class="blog_style_2"><article class="post_container">                             
         <div class="post-info">                                    
         <div class="post-date">                                        
         <span class="day">' . $media['day'] . '</span>                                        
         <span class="month">' . $media['month'] . '</span>                                    
         </div>                                    
         <div class="post-category">                                      
         <i class="fa fa-file-text-o"></i>                                    
         </div>                               
          </div><!-- .post-info end -->                                
          <div class="post-content">                                   
           <a href="javascript:void(0)"  onclick="WIBlog.postPage(`'. $media['title'] .'`,`' . $media['id'] . '`);">                                       
            <h4>' . $media['title'] . '</h4>                                    
            </a>                                    
            <div class="blog-meta">                                        
            <ul>                                            
            <li class="fa fa-user">                                               
             <a href="#">' . $media['user'] . '</a>                                            
             </li>                                            
             <li class="post-tags fa fa-tags">                                                
             <a href="#">news, </a>                                               
              <a href="#">dois</a>                                            
              </li>                                        
              </ul>                                   
               </div>                                    
               <p>                                      
               ' . $media['post'] . '                                  
               </p>                                    
               <a href="' . $media['href'] . '">' . $media['button_name'] . '</a>                             
               </div>                        
                </article></div>
               <!-- .blog-post end -->';
				
		}
	    if($media['type'] === "blog_slider"){
			
		}

		if($media['type'] === "blog_video"){
			//self::mediaVideo($media);
       echo '<article class="post_container">                              
<div class="post-info">                                   
 <div class="post-date">                                        
 <span class="day">' . $media['day'] . '</span>                                        
 <span class="month">' . $media['month'] . '</span>                                    
 </div>                                   
  <div class="post-category">                                     
  <i class="fa fa-picture-o"></i>                                    
  </div>                                
  </div><!-- .post-info end -->                                
  <figure class="post-video">                                    
  <video width="400" height="160" controls>
  <source src="../../../WIAdmin/WIMedia/Vid/blog/' . $media['video'] . '" type="video/mp4">
</video>                                
  </figure>                               
   <div class="post-content">
   <a href="javascript:void(0)"  onclick="WIBlog.postPage(`'. $media['title'] .'`,`' . $media['id'] . '`);">                                 
   <h4>' . $media['title'] . '</h4>                                    
   <div class="blog-meta">                                        
   <ul>                                            
   <li class="fa fa-user">                                                
   <a href="javascript:void(0)">' . $media['user'] . '</a>                                            
   </li>                                            
   <li class="post-tags fa fa-tags">                                                
   <a href="javascript:void(0)">news, </a>                                                
   <a href="javascript:void(0)">dois</a>                                            
   </li>                                        
   </ul>                                    
   </div>                                   
    <p>                                     
    ' . $media['post'] . '                                 
    </p>                                    
     </div>  
         <div class="comments-comments">';
              $comments = $this->Comment->getBlogComments($media['id']);
              foreach ($comments as $c) {
                echo '<blockquote>' . $c['comment'] . '
                <small>' . $c['posted_by_name'] . ' <em>at ' . $c['post_time'] . '</em></small>
                </backquote>';
              }
               echo '</div>   

         <textarea class="form-control" name="comment" rows="3" id="comment-text-'.$media['id'].'"></textarea> 

          <div class="form-group">
                    <button class="btn btn-primary" id="btn-comment-'.$media['id'].'" onclick="WIComment.newCommment(`'.$media['id'].'`)" type="submit">
                        <i class="fa fa-comment"></i>
                        '.WILang::get("comment").'
                    </button>
                </div>                        
                                
         </article>';
			
		}
		//$type = "blog_image";
		if($media['type'] === "blog_image"){
			
				self::blogImage($media);
		}

		if($media['type'] === "blog_audio"){
			
			self::mediaAudio($media);
		}

		if($media['type'] === "blog_youtube"){
			
      $link = $media['title'];
      if( strpos($link, " ") !== false )
      {
        $link = preg_replace('/\s+/', '_', $link);
      }
		  self::mediaYoutube($media);
			  
          }
      }
		}
	}


  public function blogCat($id)
  {
            $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blogcategories`
                     WHERE `cat_id` = :id",
                     array(
                       "id" => $id
                     )
                  );
        //print_r($result);
        
        if(count($result) > 0) 
        {
          return $result[0]['title'];
        }else{

        }
  }



}


?>