<h4>Statistiche mensili</h4>

<div class="list-group">  

	<?php foreach($monthly_statistics as $name => $dataitem): ?>

		<a href="javascript:;" class="list-group-item"><h3 class="pull-right"><i class="<?php echo $dataitem['icon-class']; ?>"></i></h3>
		  <h4 class="list-group-item-heading"><?php echo $dataitem['value']; ?></h4>
		  <p class="list-group-item-text"><?php echo $name; ?></p>
		</a>

	<?php endforeach ?>

</div>
