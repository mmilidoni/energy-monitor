<?php
echo $this->Html->script('d3/d3.min.js');
echo $this->Html->script('novus-nvd3/nv.d3.min.js');
echo $this->Html->script('flot/jquery.flot.min.js');
echo $this->Html->script('flot/jquery.flot.time.min.js');
echo $this->Html->script('flot/jquery.flot.tooltip.min.js');
echo $this->Html->script('flot/jquery.flot.pie.min.js');
echo $this->Html->script('flot/jquery.flot.crosshair.min.js');
echo $this->Html->script('flot/jquery.flot.resize.min.js');
echo $this->Html->script('apps/tisa_charts.js');
echo $this->Html->css('nv.d3.css');
echo $this->Html->css('datepicker3.css');
echo $this->Html->script('bootstrap-datepicker/bootstrap-datepicker.js');
echo $this->Html->script('bootstrap-datepicker/locales/bootstrap-datepicker.it.js');
echo $this->Html->script('jquery.powertip.min.js');
echo $this->Html->script('apps/tisa_tooltips.js');
?>

<style>
svg.svgchart {
  height: 300px; 
}

td.titolo_voce {
	font-weight: bold;
	width: 90px;
	padding: 5px;
}
</style>
<script>
$(document).ready(function(){
	$("#data_grafico").change(function() {
		$("#cerca_data").submit();
	});
});

</script>

<div class="panel panel-default">
  <div class="panel-heading">
<h2>Prestazioni Impianto <b><?php echo $impianto["Impianto"]["nome"]; ?></b></h2>
<div class="panel">
<?php
echo '<b>Titolare</b>: '.$impianto["Impianto"]["titolare"]." - <b>Ubicazione:</b> ";
echo $impianto["Impianto"]["indirizzo"].' - '.$impianto["Impianto"]["citta"].' ('.$impianto["Impianto"]["provincia"].')';
?>
</div>

<div id="cssmenu">
<ul>
<?php
	$lnk = $this->Html->link("Home",
			array(
		    "controller" => "EtichetteImpianto",
		    "action" => "dashGruppo",
			$impianto["Impianto"]["id"]
		));
#	echo "<li>".$lnk."</li>";
	
	foreach($gruppi as $g) {
		if ($g["Valore"]["gruppo"] == $gruppo) {
			$style = " class='active' ";
		} else {
			$style = "";
		}
	
		$lnk = $this->Html->link($g["EtichettaImpianto"]["nome_gruppo"]. " ".$g["Valore"]["gruppo"],
			array(
		    "controller" => "EtichetteImpianto",
		    "action" => "schedaGruppo",
			$impianto["Impianto"]["id"],
			$g["Valore"]["gruppo"])
		);
		echo "<li $style>".$lnk."</li>";
	}
	$lnk = $this->Html->link("Periodici",
		array(
	    "controller" => "EtichetteImpianto",
	    "action" => "graficiPeriodici",
		$impianto["Impianto"]["id"]
	));
	echo "<li>$lnk</li>";

	echo "<li><a href='".$this->webroot."Users/logout'>Esci</a></li>";
?>

</ul>
</div>
</div>
<div class="panel-body">
<div class="container-fluid">
<?php
foreach ($valori as $valore) {
	$etichetta = $valore->etichetta;
?>
			<div class="col-md-4 panel panel-default">
<div class="panel-body" style="text-align:center;">
<div class="heading_b" style="text-align: left;">

<i class="glyphicon glyphicon-dashboard"></i>
<?php if ($etichetta['nome'] != "") echo $etichetta['nome']; else echo $etichetta['codice'];
if (array_key_exists("dal", $valore->valori["Valore"]) && $valore->valori["Valore"]["dal"]) {
	#echo " (dal ".$valore->valori["Valore"]["dal"].")";
}
if (array_key_exists("descrizione", $etichetta) && $etichetta["descrizione"]) {
?>
<div style="float:right">
<i data-container="body" data-toggle="popover" data-placement="top" data-title="Informazioni" data-trigger="hover" data-content="<?php echo $etichetta["descrizione"]; ?>" class="glyphicon glyphicon-info-sign"></i>
</div>
<?php
}
?>
</div>
	<?php
echo "<span style='text-align: center; font-size: 32px; font-weight: bold;'>".round($valore->valori["Valore"]["valore"], 2)."</span><br/>";
echo "<span style='text-align: center; font-size: 12px;'>Ultimo aggiornamento: ".$valore->valori["Valore"]["data_ora"]."</span>";
?>
</div>
			</div>
<?php 
} // end foreach
?>

<div style='clear:both'></div>
<div class="panel">
<?php
	$urlForm = $this->Html->url(array(
    	"controller" => "EtichetteImpianto",
	    "action" => "schedaGruppo",
		$impianto["Impianto"]["id"],
		$gruppo
	));

?>
<form id="cerca_data" method="post" action="<?php echo $urlForm; ?>">
<label for="data_grafico">Data</label>
<div class="input-group date ts_datepicker" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
<input id="data_grafico" class="form-control" value="<?php echo $dataGrafico; ?>" name="data_grafico" type="text">
<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</form>
</div>



<?php

foreach ($grafici as $graficoObj) {
	$dati = new stdClass();
	$dati->key = "";
	$dati->values = array();
	$gruppoCorrente = -1;
	$sizeValori = count($graficoObj->valori);
	for ($i = 0; $i < $sizeValori; $i++) {
		$grafico = $graficoObj->valori[$i];
		array_push($dati->values, [strtotime($grafico["Valore"]["data_ora"])*1000, floatval($grafico["Valore"]["valore"])]);
	}
?>
<h3><?php 
if ($graficoObj->etichetta["nome"]) {
	echo $graficoObj->etichetta["nome"];
	echo " (".$graficoObj->etichetta["codice"].")"; 
	$dati->key = $graficoObj->etichetta["nome"];
} else {
	echo $graficoObj->etichetta["codice"]; 
	$dati->key = $graficoObj->etichetta["codice"];
}
echo " del giorno $dataGrafico";
?>
</h3>
 
<div id="chart_<?php echo $graficoObj->etichetta["id"]; ?>">
 <svg class="svgchart"></svg>
</div>
<script>
<?php echo "var data_".$graficoObj->etichetta["id"]." = ".json_encode($dati).";";?>

nv.addGraph(function() {
  var chart = nv.models.lineChart()
    .x(function(d) { return d[0] })
    .y(function(d) { return d[1] })
	.color([d3.scale.category10().range()[<?php echo $graficoObj->etichetta["id"]%10; ?>]])
    .useInteractiveGuideline(true)
    ;

  chart.xAxis
    .showMaxMin(false)
    .tickFormat(function(d) {
      return d3.time.format('%X')(new Date(d))
    });

  chart.yAxis
	  .tickFormat(d3.format(',.2f'))
    .showMaxMin(false)
	  ;

  d3.select('#chart_<?php echo $graficoObj->etichetta["id"]; ?> svg')
    .datum([data_<?php echo $graficoObj->etichetta["id"]; ?>])
    .transition().duration(500)
    .call(chart)
    ;

  nv.utils.windowResize(chart.update);
  
  chart.interactiveLayer.tooltip.gravity('s');

  return chart;
});
 
</script>
	<?php
}
?>

	</div>
</div>
</div>
