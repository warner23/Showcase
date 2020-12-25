<?php
/**
* resource Class
* Created by Warner Infinity
* Author Jules Warner
*/
class WIPost
{
	function __construct() 
	{
     $this->WIdb = WIdb::getInstance();
     $this->Comment = new WIComment();
     $this->Page    = new WIPage();
  }

  public function MediaYoutube($id)
  {
    $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blog`
                     WHERE `id` = :id",
                     array(
                       "id" => $id
                     )
                  );
    foreach($result as $media){
      if($media['type'] === "NoMedia"){
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
           <a href="blog_post.html">                                       
            <h4>' . $media['title'] . '</h4>                                    
            </a>                                    
            <div class="blog-meta">                                        
            <ul>                                            
            <li class="fa fa-user">                                               
             <a href="javascript:void(0)">' . $media['user'] . '</a>                                            
             </li>                                            
             <li class="post-tags fa fa-tags">                                                
             <a href="javascript:void(0)">news, </a>                                               
              <a href="#">dois</a>                                            
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
      }elseif($media['type'] === "blog_slider"){
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
    <a href="blog_post.html">                                        
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
      }elseif($media['type'] === "blog_video"){
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
      }elseif($media['type'] === "blog_image"){
         echo '<!-- .latest-posts start --><div class="blog_style_2">                            
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
                              <a href="javascript:void(0)"><img src="../../../WIAdmin/WIMedia/Img/blog/' . $media['image'] . '" alt=""></a>                
                              </figure>                               
                               <div class="post-content">                                    
                               <a href="blog_post.html">                                        
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
                                
         </article>';
      }elseif($media['type'] === "blog_audio"){
         echo ' <!-- .latest-posts start -->                            
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
      <figure class="post-audio">                 
      <audio controls>
      <source src="../../../WIAdmin/WIMedia/Audio/blog/' . $media['audio'] . '" type="audio/mp3"></audio>             
      </figure>                               
       <div class="post-content">                                    
       <a href="blog_post.html">                                        
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
         ' . $media['post'] . '</p> 

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
      }elseif($media['type'] === "blog_youtube"){
         echo '<div class="preview">blog media youtube</div>
                    <div class="view">
                   
                  <!-- .latest-posts start --><div class="blog_style_2">                           
    <article class="post_container">                              
    <div class="post-info">                                    
    <div class="post-date">                                        
    <span class="day">' . $media['day']. '</span>                                        
    <span class="month">' . $media['month'] .'</span>                                    
    </div>                                    
    <div class="post-category">                                     
    <i class="fa fa-picture-o"></i>                                    
    </div>                                
    </div><!-- .post-info end -->                                
    <figure class="post-video">                                    
   "' . $media['youtube'] .'"       
     </figure>                                
     <div class="post-content">                                    
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
                                
         </article>
                </div>';
      }
   
    }
  }

  public function MediaNo($id)
  {
    $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blog`
                     WHERE `id` = :id",
                     array(
                       "id" => $id
                     )
                  );
    foreach($result as $media){
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
           <a href="blog_post.html">                                       
            <h4>' . $media['title'] . '</h4>                                    
            </a>                                    
            <div class="blog-meta">                                        
            <ul>                                            
            <li class="fa fa-user">                                               
             <a href="javascript:void(0)">' . $media['user'] . '</a>                                            
             </li>                                            
             <li class="post-tags fa fa-tags">                                                
             <a href="javascript:void(0)">news, </a>                                               
              <a href="#">dois</a>                                            
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

  public function MediaImage($id)
  {
    $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blog`
                     WHERE `id` = :id",
                     array(
                       "id" => $id
                     )
                  );
    foreach($result as $media){
      echo '<!-- .latest-posts start --><div class="blog_style_2">                            
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
                              <a href="javascript:void(0)"><img src="../../../WIAdmin/WIMedia/Img/blog/' . $media['image'] . '" alt=""></a>                
                              </figure>                               
                               <div class="post-content">                                    
                               <a href="blog_post.html">                                        
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
                                
         </article>';

    }
  }

  public function MediaSlider($id)
  {

    $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blog`
                     WHERE `id` = :id",
                     array(
                       "id" => $id
                     )
                  );
    foreach ($result as $media) {
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
    <a href="blog_post.html">                                        
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

  public function MediaVideo($id)
  {
    $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blog`
                     WHERE `id` = :id",
                     array(
                       "id" => $id
                     )
                  );
    foreach ($result as $media) {
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

  public function MediaAudio($id)
  {

    $result = $this->WIdb->select(
                    "SELECT * FROM `wi_blog`
                     WHERE `id` = :id",
                     array(
                       "id" => $id
                     )
                  );
    foreach ($result as $media) {
      echo ' <!-- .latest-posts start -->                            
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
      <figure class="post-audio">                 
      <audio controls>
      <source src="../../../WIAdmin/WIMedia/Audio/blog/' . $media['audio'] . '" type="audio/mp3"></audio>             
      </figure>                               
       <div class="post-content">                                    
       <a href="blog_post.html">                                        
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
         ' . $media['post'] . '</p> 

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




}


?>