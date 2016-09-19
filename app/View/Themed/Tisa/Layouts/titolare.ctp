<?php
	$this->extend('default_titolare');
	echo $this->fetch('content');
?>
<?php $this->startIfEmpty('top-menu'); ?>
	<li class="user_menu">
		<a href="<?php echo $this->Html->url(array('controller' => 'Impianti', 'action' => 'logout')); ?>">Esci</a>
	</li>
<?php $this->end(); ?>
<?php $this->startIfEmpty('main-menu'); ?>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'Impianti', 'action' => 'profilo')); ?>">
			<span class="glyphicon glyphicon-tower"></span>
			<span class="nav_title">Impianto</span>
		</a>
	</li>
	<li>
		<a href="<?php echo $this->Html->url(array('controller' => 'EtichetteImpianto', 'action' => 'tabelle')); ?>">
			<span class="glyphicon glyphicon-dashboard"></span>
			<span class="nav_title">Prestazioni</span>
		</a>
	</li>
<?php $this->end(); ?>
