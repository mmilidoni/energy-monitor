<div class="panel panel-default">
  <div class="panel-heading"><h2>Etichette Impianto <b><?php echo $impianto["Impianto"]["nome"] ?></b></h2>
<p>
<?php echo $impianto["Impianto"]["titolare"] ?><br />
<?php echo $impianto["Impianto"]["indirizzo"] ?><br />
<?php echo $impianto["Impianto"]["citta"] ?>
(<?php echo $impianto["Impianto"]["provincia"] ?>)<br />
</p>
</div>
  <div class="panel-body">Questa sezione contiene l'elenco delle etichette associate all'impianto selezionato.<br/>E' possibile modificare la visibilità delle etichette in tabella e su grafico.
<br/>
<br/>

<div class="table-responsive">
  <table class="table">
	<thead>
	<tr>
<th>Codice<br/>Etichetta</th>
<th>Nome Etichetta</th>
<th>Nome Gruppo</th>
<th>Tabella</th>
<th>Grafico</th>
<!--
<th>Tabella<br/>Homepage</th>
<th>Grafico<br/>Homepage</th>
-->
<th>Calcolo da<br/>inizio giornata</th>
<th>Azioni</th></tr>
	</thead>
	<tbody>
	
<?php
	foreach($elenco as $etichetta) {
		echo "<tr>";
		echo "<td>";
		echo $this->Html->link($etichetta['Etichetta']['codice'],
		    array(
        		'controller' => 'Etichette',
		        'action' => 'modifica/'.$etichetta['Etichetta']['id'],
    		)
		);
		echo "</td>";
		echo "<td>".$etichetta['Etichetta']['nome']."</td>";
		echo "<td>".$etichetta['EtichettaImpianto']['nome_gruppo']."</td>";
		echo "<td>";
		$urlCambiaStatoTabella = $this->Html->url(array(
			"controller" => "EtichetteImpianto",
		    "action" => "cambiaStatoTabella/".$etichetta["EtichettaImpianto"]["id"]
		));
		echo "<a href='".$urlCambiaStatoTabella."'>";
		if ($etichetta['EtichettaImpianto']['tabella']) {
			echo "<span class='label label-success'><i class='fa fa-check'></i></span>";
		} else {
			echo "<span class='label label-default'><i class='fa fa-times'></i></span>";
		}
		echo "</a>";
		echo "</td>";
		echo "<td>";
		$urlCambiaStatoGrafico = $this->Html->url(array(
			"controller" => "EtichetteImpianto",
		    "action" => "cambiaStatoGrafico/".$etichetta["EtichettaImpianto"]["id"]
		));
		echo "<a href='".$urlCambiaStatoGrafico."'>";
		if ($etichetta['EtichettaImpianto']['grafico']) {
			echo "<span class='label label-success'><i class='fa fa-check'></i></span>";
		} else {
			echo "<span class='label label-default'><i class='fa fa-times'></i></span>";
		}
		echo "</a>";
		echo "</td>";/*
		echo "<td>";
		$urlCambiaStatoTabellaHomepage = $this->Html->url(array(
			"controller" => "EtichetteImpianto",
		    "action" => "cambiaStatoTabellaHomepage/".$etichetta["EtichettaImpianto"]["id"]
		));
		echo "<a href='".$urlCambiaStatoTabellaHomepage."'>";
		if ($etichetta['EtichettaImpianto']['tabella_homepage']) {
			echo "<span class='label label-success'><i class='fa fa-check'></i></span>";
		} else {
			echo "<span class='label label-default'><i class='fa fa-times'></i></span>";
		}
		echo "</a>";
		echo "</td>";
		echo "<td>";
		$urlCambiaStatoGraficoHomepage = $this->Html->url(array(
			"controller" => "EtichetteImpianto",
		    "action" => "cambiaStatoGraficoHomepage/".$etichetta["EtichettaImpianto"]["id"]
		));
		echo "<a href='".$urlCambiaStatoGraficoHomepage."'>";
		if ($etichetta['EtichettaImpianto']['grafico_homepage']) {
			echo "<span class='label label-success'><i class='fa fa-check'></i></span>";
		} else {
			echo "<span class='label label-default'><i class='fa fa-times'></i></span>";
		}
		echo "</a>";
		echo "</td>";*/
		echo "<td>";
		$urlCambiaStatoCalcoloInizioGiornata = $this->Html->url(array(
			"controller" => "EtichetteImpianto",
		    "action" => "cambiaStatoCalcoloInizioGiornata/".$etichetta["EtichettaImpianto"]["id"]
		));
		echo "<a href='".$urlCambiaStatoCalcoloInizioGiornata."'>";
		if ($etichetta['EtichettaImpianto']['calcolo_inizio_giornata']) {
			echo "<span class='label label-success'><i class='fa fa-check'></i></span>";
		} else {
			echo "<span class='label label-default'><i class='fa fa-times'></i></span>";
		}
		echo "</a>";
		echo "</td>";
		echo "<td>";
		echo $this->Html->link('', array(
	        'controller' => 'EtichetteImpianto',
    	    'action' => 'modifica/'.$etichetta['EtichettaImpianto']['id'],
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
