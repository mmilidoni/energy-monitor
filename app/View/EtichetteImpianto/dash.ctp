<?php
echo $this->Html->css('datepicker3.css');
echo $this->Html->script('bootstrap-datepicker/bootstrap-datepicker.js');
echo $this->Html->script('bootstrap-datepicker/locales/bootstrap-datepicker.it.js');
echo $this->Html->script('jquery.powertip.min.js');
echo $this->Html->script('apps/tisa_tooltips.js');
?>

<style>
td.titolo_voce {
	font-weight: bold;
	width: 90px;
	padding: 5px;
}
</style>

<div class="panel panel-default">
  <div class="panel-heading">
<h2>Prestazioni Impianto <b><?php echo $impianto["Impianto"]["nome"]; ?></b></h2>

<div id="cssmenu">
<ul>
<?php
	$lnk = $this->Html->link("Home",
			array(
		    "controller" => "EtichetteImpianto",
		    "action" => "dash",
			$impianto["Impianto"]["id"]
		));
	echo "<li class='active'>".$lnk."</li>";
	
	foreach($etichetteImpianto as $ei) {
		$nome = $ei["Etichetta"]["nome"] == "" ? $ei["Etichetta"]["codice"] : $ei["Etichetta"]["nome"];
		$lnk = $this->Html->link($nome,
			array(
		    "controller" => "EtichetteImpianto",
		    "action" => "tabelle",
			$ei["EtichettaImpianto"]["id"])
		);
		
		echo "<li>".$lnk."</li>";
	}
	echo "<li><a href='/Users/logout'>Esci</a></li>";
?>

</ul>
</div>
</div>
<div class="panel-body">
<div class="container-fluid">
<div class="panel">
<?php
echo '<b>Titolare</b>: '.$impianto["Impianto"]["titolare"]." - <b>Ubicazione:</b> ";
echo $impianto["Impianto"]["indirizzo"].' '.$impianto["Impianto"]["citta"].' ('.$impianto["Impianto"]["provincia"].')';
?>
</div>
<?php
foreach ($valori as $valore) {
	$etichettaImpianto = $valore->etichettaImpianto;
?>
			<div class="col-md-4 panel panel-default">
<div class="panel-body" style="text-align:center;">
<div class="heading_b" style="text-align: left;">

<i class="glyphicon glyphicon-dashboard"></i>
<?php if ($etichettaImpianto['Etichetta']['nome'] != "") echo $etichettaImpianto['Etichetta']['nome']; else echo $etichettaImpianto['Etichetta']['codice'];
echo " (".$etichettaImpianto['Etichetta']['aggregazione'].")"; 

if ($etichettaImpianto["Etichetta"]["descrizione"]) {
?>
<div style="float:right">
<i data-container="body" data-toggle="popover" data-placement="top" data-title="Informazioni" data-trigger="hover" data-content="<?php echo $etichettaImpianto["Etichetta"]["descrizione"]; ?>" class="glyphicon glyphicon-info-sign"></i>
</div>
<?php
}
?>
</div>
	<?php
echo "<span style='text-align: center; font-size: 32px; font-weight: bold;'>".round($valore->valori["0"]["valore"], 2)."</span><br/>";
echo "<span style='text-align: center; font-size: 12px;'>Ultimo aggiornamento: ".$valore->valori["Valore"]["data_ora"]."</span>";
?>
</div>
			</div>
<?php 
} // end foreach
?>
	</div>
</div>
</div>
