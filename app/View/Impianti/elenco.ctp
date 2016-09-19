<div class="panel panel-default">
  <div class="panel-heading"><h2>Elenco Impianti</h2></div>
  <div class="panel-body">Questa sezione contiene l'elenco degli impianti importati dai file CSV.<br/>E' possibile:
<ul>
<li>modificare i dati principali (password di accesso, indirizzo, titolare, ecc.)</li>
<li>gestire la visualizzazione delle etichette associate all'impianto</li>
<li>visualizzare le prestazioni dell'impianto in formato tabellare e in formato grafico.</li>
</ul>
<br/>
<br/>

<div class="table-responsive">
  <table class="table">
	<thead>
	<tr><th>Nome Impianto</th><th>Titolare</th><th>Indirizzo</th><th>Citt&agrave;</th><th>Prov.</th><th>Azioni</th></tr>
	</thead>
	<tbody>
	
<?php
	foreach($elenco as $impianto) {
		echo "<tr>";
		echo "<td>".$impianto['Impianto']['nome']."</td>";
		echo "<td>".$impianto['Impianto']['titolare']."</td>";
		echo "<td>".$impianto['Impianto']['indirizzo']."</td>";
		echo "<td>".$impianto['Impianto']['citta']."</td>";
		echo "<td>".$impianto['Impianto']['provincia']."</td>";
		echo "<td style='width: 140px;'>";
		echo $this->Html->link('', array(
	        'controller' => 'Impianti',
    	    'action' => 'modifica/'.$impianto['Impianto']['id'],
		), array('class' => 'btn btn-default glyphicon glyphicon-pencil', 'title' => "Modifica i dati dell'impianto")
		);
		echo $this->Html->link('', array(
	        'controller' => 'EtichetteImpianto',
    	    'action' => 'elenco/'.$impianto['Impianto']['id'],
		), array('class' => 'btn btn-default glyphicon glyphicon-th', 'title' => 'Visibilità elementi')
		);
		/*
		echo $this->Html->link('', array(
		        'controller' => 'EtichetteImpianto',
    		    'action' => 'dash/'.$impianto['Impianto']['id'],
			), array('class' => 'btn btn-default glyphicon glyphicon-dashboard', 'title' => 'Prestazioni')
		);
		 */
		echo $this->Html->link('', array(
		        'controller' => 'EtichetteImpianto',
    		    'action' => 'schedaGruppo/'.$impianto['Impianto']['id'],
			), array('class' => 'btn btn-default glyphicon glyphicon-dashboard', 'title' => 'Prestazioni')
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

