<?php


class WIBootstrap 
{  
  private $WIdb;

  function __construct()
  {
    $this->WIdb =  WIdb::getInstance();
    $this->login = new  WILogin();
    $this->Info = new WIUserInfo();
    $this->user   = new WIUser(WISession::get('user_id'));
    //$WIdb = WIdb::getInstance();
  }


  public function mod_name_start()
  {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
  }

  public function mod_name_nosidebar()
  {
    echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
  }

  public function mod_name_sidebar()
  {
   echo '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">';
  }

    public function mod_name_main()
  {
   echo '<div class="container-fluid text-center">    
  <div class="row content">
  <div class="col-lg-12 col-md-12 col-sm-12" >';
  }


  public function mod_name()
  {
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container-fluid text-center">    
  <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 min_height">';

    if(isset($page)){
    $left_sidePower = $this->Web->pageModPower($page, "left_sidebar");
    $leftSideBar = $this->Web->PageMod($page, "left_sidebar");
    //echo $Panel;
    if ($left_sidePower > 0) {
      $this->mod->getMod($leftSideBar);
      echo '<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 index">';
    }else{
      echo '<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 index">';
    }

    }

if($this->user->isAdmin()){

    echo '<div class="type">
<div class="blogSelect" id="blog_post" title="Choose Post" onclick="WIBlog.type()">
<i class="fa fa-th"></i>
</div>  

<div class="admin_post hidden">
<ul>
  <li class="blog_type" title="Blog post no media"><a href="javascript:void(0)"  onclick="WIBlog.noMedia(`';echo $this->user->getRole(); echo'`)"><i class="fa fa-file-text" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post slider"><a href="javascript:void(0)" onclick="WIBlog.slider(`'; echo $this->user->getRole(); echo'`)"><i class="fa fa-sliders" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post video"><a href="javascript:void(0)" onclick="WIBlog.video(`'; echo $this->user->getRole(); echo'`)"><i class="fa fa-list-alt" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post audio"><a href="javascript:void(0)"  onclick="WIBlog.audio(`'; echo $this->user->getRole(); echo '`)"><i class="fa fa-file-audio-o" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post image"><a href="javascript:void(0)" onclick="WIBlog.image(`'; echo $this->user->getRole(); echo '`)"><i class="fa fa-picture-o" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post youtube"><a href="javascript:void(0)" onclick="WIBlog.youtube(`';echo $this->user->getRole(); echo '`)"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
</ul>
</div>
  </div>';
  } else {
        echo '<div class="type">
</div>';  
       }


echo '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">  
  
  <div class="blog_style" id="blog_style">
    
  </div>  

  <div class="blog_style" id="posts">             
            
  </div>      
  
        
            </div>  
            </div>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

     <script type="text/javascript" src="WICore/WIJ/WICore.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIPost.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIMediaCenter.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIMedia.js"></script>
<script type="text/javascript" src="WICore/WIJ/WISlideMedia.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIComment.js"></script>
';

    if(isset($page)){     
    $right_sidePower = $this->Web->pageModPower($page, "right_sidebar");
    $rightSideBar = $this->Web->PageMod($page, "right_sidebar");
    //echo $Panel;
    if ($right_sidePower > 0) {

      $this->mod->getMod($rightSideBar);
    } 
    }   
          

  echo '</div>
      </div></div>';
  }
  
  public function startMod()
  {
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div class="container-fluid text-center">    
  <div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 min_height">';
  }

  public function blogAdmin()
  {
    echo '<div class="type">
<div class="blogSelect" id="blog_post" title="Choose Post" onclick="WIBlog.type()">
<i class="fa fa-th"></i>
</div>  

<div class="admin_post hidden">
<ul>
  <li class="blog_type" title="Blog post no media"><a href="javascript:void(0)"  onclick="WIBlog.noMedia(`';echo $this->user->getRole(); echo'`)"><i class="fa fa-file-text" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post slider"><a href="javascript:void(0)" onclick="WIBlog.slider(`'; echo $this->user->getRole(); echo'`)"><i class="fa fa-sliders" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post video"><a href="javascript:void(0)" onclick="WIBlog.video(`'; echo $this->user->getRole(); echo'`)"><i class="fa fa-list-alt" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post audio"><a href="javascript:void(0)"  onclick="WIBlog.audio(`'; echo $this->user->getRole(); echo '`)"><i class="fa fa-file-audio-o" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post image"><a href="javascript:void(0)" onclick="WIBlog.image(`'; echo $this->user->getRole(); echo '`)"><i class="fa fa-picture-o" aria-hidden="true"></i></a></li>
  <li class="blog_type" title="Blog post youtube"><a href="javascript:void(0)" onclick="WIBlog.youtube(`';echo $this->user->getRole(); echo '`)"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
</ul>
</div>
  </div>';
  }

  public function blogNotAdmin()
  {
    echo '<div class="type"></div>';
  }

  public function contents()
  {

    echo '<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">  
  
  <div class="blog_style" id="blog_style">
    
  </div>  

  <div class="blog_style" id="posts">             
            
  </div>      
  
        
            </div>  
            </div>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

     <script type="text/javascript" src="WICore/WIJ/WICore.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIPost.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIMediaCenter.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIMedia.js"></script>
<script type="text/javascript" src="WICore/WIJ/WISlideMedia.js"></script>
<script type="text/javascript" src="WICore/WIJ/WIComment.js"></script>
';

  } 

}