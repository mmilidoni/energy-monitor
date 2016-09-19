<!DOCTYPE HTML>
<html>
<head>
	<title><?php echo $this->fetch('title'); ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<?php echo $this->fetch('meta'); ?>
		
	<?php
		echo $this->Html->css('../bootstrap/css/bootstrap.min.css');
		echo $this->Html->css('http://fonts.googleapis.com/css?family=Source+Sans+Pro:400&amp;subset=latin-ext,latin');
		echo $this->Html->css('login.css');
		echo $this->Html->css('custom.css');
	?>

	<?php 
		// JQuery
		echo $this->Html->script('jquery.min.js');
		// Bootstrap JS Plugins
		echo $this->Html->script('../bootstrap/js/bootstrap.min.js');
		echo $this->fetch('script');
		echo $this->fetch('css');
	?>
	
</head>
<body>
	<div style="text-align: center;"><span class="logotext"><img src="<?php echo $this->webroot; ?>img/energy.png" /></span></div><br/>

	<?php echo $this->Session->flash(); ?>
	<div class="login_container">
		<?php echo $this->Form->create('Impianto', array("url" => array("action" => "login", 'controller' => 'Users'), 'id' => 'login_form')); ?>
			<h1 class="login_heading">Benvenuto</h1>
			<div class="form-group">
				<?php echo $this->Form->input('nome', array('class' => 'form-control', 'placeholder' => 'Nome utente', 'id' => 'login_username', 'class' => 'form-control input-lg')); ?>
			</div>
			<div class="form-group">
				<?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password', 'id' => 'login_password', 'class' => 'form-control input-lg')); ?>
			</div>
			<div class="submit_section">
				<button class="btn btn-lg btn-success btn-block">Accedi</button>
			</div>
		<?php echo $this->Form->end(); ?>
	<script>
		$(function() {
			// switch forms
			$('.open_register_form').click(function(e) {
				e.preventDefault();
				$('#login_form').removeClass().addClass('animated fadeOutDown');
				setTimeout(function() {
					$('#login_form').removeClass().hide();
					$('#register_form').show().addClass('animated fadeInUp');
				}, 700);
			})
			$('.open_login_form').click(function(e) {
				e.preventDefault();
				$('#register_form').removeClass().addClass('animated fadeOutDown');
				setTimeout(function() {
					$('#register_form').removeClass().hide();
					$('#login_form').show().addClass('animated fadeInUp');
				}, 700);
			})
		})
	</script>
</body>
</html>
