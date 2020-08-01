<link rel="stylesheet" href="WIInc/css/font-awesome.css">
<!-- <link rel="stylesheet" href="../WITheme/Debate/admin/css/style.css"> -->
<div class="navbar navbar-inverse navbar-fixed-top">
<div class="container">
<div class="row">
<div class="navbar navbar-header">
<a href="dashboard.php" class="navbar-brand glyphicon glyphicon-cog" title="<?php echo WEBSITE_NAME; ?> Admin Panel"></a>
<a href="../index.php" class="navbar-visit"><span class="glyphicon glyphicon-home" title="Visit Site"></span></a>
</div>


<?php $web->AdminMenu();?>


<ul class="nav navbar-nav navbar-right">
<li><a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="WIDashboard.Notifications();"><span class="fa fa-bell-o" title="Notifications"></span>
<span class="badge" id="not_badge"></span></a>
<div class="dropdown-menu">
  <div class="panel panel-success">
    <div class="panel-heading">
You have <?php echo $site->notifications_badge()?>  notifications

    </div>
    <div class="panel-body" id="Notifications"></div>
    <div class="panel-footer"><a href="WINotifications.php">View all</a></div>
  </div>
</div>

</li>
<li><a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="WIDashboard.messages();"><span class="fa fa-envelope-o" title="Messages"></span>
<span class="badge" id="mess_badge"></span></a>
<ul class="dropdown-menu">
    <div class="panel panel-primary">
    <div class="panel-heading">Messages</div>
    <div class="panel-body" id="cmessages">

  

    </div>
    <div class="panel-footer" id="e_msg"><a href="WIMessages.php">See All Messages</a></div>
    </div>
</ul>
</li>

 <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="WIDashboard.tasks();">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger" id="task_badge"></span>
            </a>
            <ul class="dropdown-menu">
              <div class="panel panel-tasks">
    <div class="panel-heading">Tasks: You have <?php echo $site->TaskBagde()?>  tasks</div>
    <div class="panel-body" id="tasks">

  

    </div>
    <div class="panel-footer" id="e_tasks"><a href="WITasks.php">View all tasks</a></div>
    </div>
            </ul>
          </li>


  <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php echo $user_pic = $Info->admin_pic(WISession::get('user_id'))?>
             <!--  <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <span class="hidden-xs"><?php echo $Info->admin_name(WISession::get('user_id'))?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              <?php echo $user_pic = $Info->admin_pic(WISession::get('user_id'))?>
                

                <p>
                  
                  <small></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="../WIMembers/profile.php" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>

           <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>




</ul>
</div>
</div>
</div>

<script type="text/javascript" src="WICore/WIJ/WIDashboard.js"></script>