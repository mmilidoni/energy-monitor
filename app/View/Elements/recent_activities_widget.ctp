<div class="well">
	<h4>Attivit&agrave; recenti</h4>

	<ul class="icons-list text-md">

		<?php foreach($activities as $activity): ?>
		
			<li>
				<i class="icon-li <?php echo $activity['icon-class']; ?>"></i>
				<?php echo $activity['nome']; ?>
				<br>
				<small><?php echo $activity['quando']; ?></small>
			</li>

		<?php endforeach ?>

	</ul>

</div>
