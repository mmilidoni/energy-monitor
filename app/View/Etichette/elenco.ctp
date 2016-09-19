<div class="panel panel-default">
  <div class="panel-heading"><h2>Elenco Etichette</h2></div>
  <div class="panel-body">In questa sezione è possibile visualizzare e modificare il nome dell'etichetta.<br/>E' anche possibile modificarne l'ordine di visualizzazione.
<br/>
<br/>

<div class="table-responsive">
  <table class="table">
	<thead>
	<tr><th>Codice Etichetta</th><th>Nome</th><th>Aggregazione</th><th>Posizione</th><th>Azioni</th></tr>
	</thead>
	<tbody>
	
<?php
	foreach($elenco as $etichetta) {
		echo "<tr>";
		echo "<td>".$etichetta['Etichetta']['codice']."</td>";
		echo "<td>".$etichetta['Etichetta']['nome']."</td>";
		echo "<td>".$etichetta['Etichetta']['aggregazione']."</td>";
		echo "<td>".$etichetta['Etichetta']['posizione']."</td>";
		echo "<td>";
		echo $this->Html->link('', array(
	        'controller' => 'Etichette',
    	    'action' => 'modifica/'.$etichetta['Etichetta']['id'],
#			'full_base' => true,
		), array('class' => 'btn btn-default glyphicon glyphicon-pencil')
		);
		echo "<td>";
		echo "</tr>";
	}
?>

	</tbody>
  </table>
</div>
</div>
</div>

