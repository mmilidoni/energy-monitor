<?php
	$this->extend('default');
	echo $this->fetch('content');
?>
<?php $this->startIfEmpty('top-menu'); ?>
	<li class="user_menu">
		<a href="<?php echo $this->Html->url(array('controller' => 'Impianti', 'action' => 'logout')); ?>">Esci</a>
	</li>
<?php $this->end(); ?>
<?php $this->startIfEmpty('main-menu'); ?>
	<li class="nav_trigger">
					<a href="#">
						<span class="glyphicon glyphicon-tower"></span>
			            <span class="nav_title">Impianti</span>
					</a>
					<div class="sub_panel" style="left: -220px;">
						<div class="side_inner ps-ready ps-container" style="height: 544px;">
							<h4 class="panel_heading panel_heading_first">Menu Impianti</h4>
							<ul>
							    <li>
							        <a href="<?php echo $this->Html->url(array('controller' => 'Impianti', 'action' => 'elenco')); ?>">
										<span class="side_icon ion-navicon"></span>Elenco Impianti</a>
							    </li>
							    <li>
							        <a href="<?php echo $this->Html->url(array('controller' => 'EtichetteImpianto', 'action' => 'processaCSV')); ?>">
										<span class="side_icon ion-shuffle"></span>Elabora CSV</a>
							    </li>
							</ul>
					</div>
				</li>
	<li>
        <a href="<?php echo $this->Html->url(array('controller' => 'Etichette', 'action' => 'elenco')); ?>">
            <span class="glyphicon glyphicon-tag"></span>
            <span class="nav_title">Etichette</span>
        </a>
    </li>
<?php $this->end(); ?>
