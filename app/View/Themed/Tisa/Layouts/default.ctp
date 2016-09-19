<!DOCTYPE HTML>
<html>
<head>
	<!-- meta tags -->
		<title><?php echo $this->fetch('title').$page_title_suffix; ?></title>
		<meta charset="UTF-8">
		<meta http-equiv="Refresh" content="300">
		<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
		<?php echo $this->fetch('meta'); ?>
		
		<link rel="shortcut icon" type="images/x-icon" href="/favicon.ico" />

	<!-- stylesheets -->
		<?php
			echo $this->Html->css('../bootstrap/css/bootstrap.min.css');
			echo $this->Html->css('../icons/font-awesome/css/font-awesome.min.css');
			echo $this->Html->css('../icons/ionicons/css/ionicons.min.css');
			echo $this->Html->css('../icons/flags/flags.css');
			// tisa main styles
			echo $this->Html->css('style.css');
			echo $this->Html->css('style-table.css');
			echo $this->Html->css('custom.css');
		?>
	<!-- Google Web fonts -->
<link href='https://fonts.googleapis.com/css?family=Racing+Sans+One' rel='stylesheet' type='text/css'>
		<?php 
			// Date library
			echo $this->Html->script('../lib/moment-js/moment.min.js');
			// JQuery
			echo $this->Html->script('jquery.min.js');
			// Easing
			echo $this->Html->script('jquery.easing.1.3.min.js');
			// Bootstrap JS Plugins
			echo $this->Html->script('../bootstrap/js/bootstrap.min.js');
			// Top dropdown navigation
			echo $this->Html->script('tinynav.js');
			// Perfect scrollbar
			echo $this->Html->script('../lib/perfect-scrollbar/min/perfect-scrollbar-0.4.8.with-mousewheel.min.js');
			// Common functions
			echo $this->Html->script('tisa_common.js');
			echo $this->fetch('script');
			echo $this->fetch('css');
			
			echo $this->Html->script('apps/tisa_extended_elements.js');
		?>
	<!-- moment.js (date library) -->
</head>
  <body>
 
    <!-- top bar -->
    <header class="navbar navbar-fixed-top" role="banner">
			<div class="container-fluid">
				<div class="navbar-header">
				<a href="/" class="navbar-brand logotext"><img src="<?php echo $this->webroot; ?>img/energy.png" /></a>
				</div>
<!--
				<ul class="top_links l_tinynav1">
					<li>
						<a href="tasks_summary.html"><span>23</span>Tasks</a>
					</li>
					<li>
						<a href="mail_inbox.html"><span>8</span>Mails</a>
					</li>
				</ul><select class="form-control input-sm tinynav tinynav1" id="tinynav1"><option>-- Nav --</option><option value="tasks_summary.html">Tasks</option><option value="mail_inbox.html">Mails</option></select>
-->
				<ul class="nav navbar-nav navbar-right">
					<?php echo $this->fetch('top-menu'); ?>
				</ul>
			</div>
    </header>
	
    <!-- main content -->
	<div id="main_wrapper">
		<div class="page_content">
			<div class="container-fluid">
				<?php echo $this->Flash->render() ?>
				<?php #echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
	</div>
 
    <!-- side navigation -->
	<nav id="side_nav">
			<ul>
				<?php
					echo $this->fetch('main-menu');
				?>
			</ul>
	</nav>

    <!-- right slidebar -->
	<div id="slidebar">
			<div id="slidebar_content" class="ps-container" style="height: 326px;">
				<div class="input-group">
					<input type="text" class="form-control input-sm" placeholder="Search...">
					<span class="input-group-btn">
						<button class="btn btn-default btn-sm" type="button"><i class="fa fa-search"></i></button>
					</span>
					</div>
				<hr>
					
				<div class="sepH_a">
					<div class="progress">
						<div style="width: 60%;" role="progressbar" class="progress-bar">
							60%
						</div>
					</div>
					<span class="help-block">CPU Usage</span>
				</div>
				<div class="sepH_a">
					<div class="progress">
						<div style="width: 28%;" class="progress-bar progress-bar-success">
							28%
						</div>
					</div>
					<span class="help-block">Disk Usage</span>
				</div>
				<div class="progress">
					<div style="width: 82%;" class="progress-bar progress-bar-danger">
						0.2GB/20GB
					</div>
				</div>
				<span class="help-block">Monthly Transfer</span>
				<hr>
					
				<div class="heading_a">New Users</div>
				<div class="user_img_grid clearfix">
					<!--<a class="user_img_item" href="#"><img src="/assets/img/avatars/avatar_3.jpg" alt="" class="img-thumbnail"></a>
					<a class="user_img_item" href="#"><img src="/assets/img/avatars/avatar_5.jpg" alt="" class="img-thumbnail"></a>
					<a class="user_img_item" href="#"><img src="/assets/img/avatars/avatar_8.jpg" alt="" class="img-thumbnail"></a>
					<a class="user_img_item" href="#"><img src="/assets/img/avatars/avatar_6.jpg" alt="" class="img-thumbnail"></a>-->
				</div>
				<hr>
					
				<form>
					<div class="form-group">
						<input type="text" class="input-sm form-control" placeholder="Tilte...">
					</div>
					<div class="form-group">
						<textarea cols="30" rows="3" class="form-control input-sm" placeholder="Message..."></textarea>
					</div>
					<button type="button" class="btn btn-default btn-sm">Send message</button>
				</form>
				<hr>
				<div class="sepH_a">
					<span class="label label-info">Reminder</span>
				</div>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat fuga omnis ipsa odit sint aut molestiae enim. Quia cupiditate distinctio ad dicta qui ducimus aspernatur debitis incidunt minima laboriosam atque.</p>
			<div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 3px; width: 280px; display: none;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px; height: 326px; display: inherit;"><div class="ps-scrollbar-y" style="top: 0px; height: 146px;"></div></div></div>
		</div>

  </body>
</html>
<!-- http://tisa-admin.tzdthemes.com/ -->
