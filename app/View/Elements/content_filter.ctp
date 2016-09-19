<script>
	$(function(){
		$("#contentFilterForm").submit(function(e){
			var idIncaricato = $("#incaricato").val();
			if (idIncaricato == "") {
				e.preventDefault();
			}
		});
	});
</script>
<?php

	if (!isset($emptyAllowed)) {
		$emptyAllowed = true;
	}

	echo $this->Form->create(false, array('url' => $url, 'class' => 'form-inline form-filter', 'id' => 'contentFilterForm'));
	foreach ($filters as $name => $filter) {
		echo $this->Form->label($name, $filter['label']);
		echo $this->Form->select($name, $filter['values'], array('label' => $filter['label'], 'class' => 'form-control', 'div' => array('class' => 'form-group'), 'empty' => isset($filter['empty']) ? $filter['empty'] : true, 'value' => $filter['default'], 'id' => 'incaricato'));
	}
	echo $this->Form->end(array('label' => 'Mostra', 'class' => 'btn btn-default', 'div' => false));
?>
