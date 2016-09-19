<?php $this->append('css'); ?>
	<style>
		ul.icons-list {
			list-style-type: none;
			padding:0px;
		}
	</style>
<?php $this->end(); ?>
<div style="" class="persona-notehead">
	<ul class="icons-list">
		<li>
			<i class="fa fa-user fa-2x"></i>
			<?php echo $datiPersona['Persona']['nome'].' '.$datiPersona['Persona']['cognome']; ?>	
		</li>
	</ul>
</div>
<div style="clear:left;"></div>
