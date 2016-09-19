<!DOCTYPE HTML>
<html>
<head>
	<!-- meta tags -->
		<title><?php echo $this->fetch('title').$page_title_suffix; ?></title>
		<meta charset="UTF-8">
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
<!--
    <header class="navbar navbar-fixed-top" role="banner">
			<div class="container-fluid">
				<ul class="nav navbar-nav navbar-left">
					<?php #echo $this->fetch('top-menu'); ?>
				</ul>
			</div>
	</header>
-->

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
<!--
	<nav id="side_nav">
			<ul>
				<?php
					echo $this->fetch('main-menu');
				?>
			</ul>
	</nav>
-->
  </body>
</html>
<!-- http://tisa-admin.tzdthemes.com/ -->
