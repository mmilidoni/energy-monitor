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
</style>

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
	
	foreach($gruppi as $g) {
		$style = "";
	
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
	echo "<li class='active'>$lnk</li>";
	echo "<li><a href='".$this->webroot."Users/logout'>Esci</a></li>";
?>

</ul>
</div>
<div class="panel-body">
<div class="container-fluid">
<?php
foreach ($graficiAnnuali as $graficoObj) {
	$dati = new stdClass();
	$dati->key = "";
	$dati->values = array();
	$gruppoCorrente = -1;
	$sizeValori = count($graficoObj->valori);
	foreach ($graficoObj->valori as $k => $grafico) {
		array_push($dati->values, array("label" => $k, "value" => floatval($grafico)));
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
echo " - andamento annuale";
?>
</h3>
 
<div id="chart_a_<?php echo $graficoObj->etichetta["id"]; ?>">
 <svg class="svgchart"></svg>
</div>
<script>
<?php echo "var data_a_".$graficoObj->etichetta["id"]." = [".json_encode($dati)."];";?>
/*
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
      return parseInt(d)
    });
 
  chart.yAxis
	  .tickFormat(d3.format(',.2f'))
    .showMaxMin(false)
	  ;

  d3.select('#chart_a_<?php echo $graficoObj->etichetta["id"]; ?> svg')
    .datum([data_a_<?php echo $graficoObj->etichetta["id"]; ?>])
    .transition().duration(500)
    .call(chart)
    ;

  nv.utils.windowResize(chart.update);
  
  chart.interactiveLayer.tooltip.gravity('s');

  return chart;
});
 */
nv.addGraph(function() {
  var chart = nv.models.discreteBarChart()
      .x(function(d) { return d.label })    //Specify the data accessors.
      .y(function(d) { return d.value })
      .staggerLabels(true)    //Too many bars and not enough room? Try staggering labels.
      .tooltips(false)        //Don't show tooltips
      .showValues(true)       //...instead, show the bar value right on top of each bar.
      .transitionDuration(350)
      ;

  d3.select('#chart_a_<?php echo $graficoObj->etichetta["id"]; ?> svg')
      .datum(data_a_<?php echo $graficoObj->etichetta["id"]; ?>)
      .call(chart);

  nv.utils.windowResize(chart.update);

  return chart;
});




</script>
	<?php
}

foreach ($graficiMensili as $graficoObj) {
	$dati = new stdClass();
	$dati->key = "";
	$dati->values = array();
	$gruppoCorrente = -1;
	$sizeValori = count($graficoObj->valori);
	foreach ($graficoObj->valori as $k => $grafico) {
		array_push($dati->values, array("label" => $k, "value" => floatval($grafico)));
		#array_push($dati->values, [$k, floatval($grafico)]);
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
echo " - andamento mensile";
?>
</h3>
 
<div id="chart_m_<?php echo $graficoObj->etichetta["id"]; ?>">
 <svg class="svgchart"></svg>
</div>
<script>
<?php echo "var data_m_".$graficoObj->etichetta["id"]." = ".json_encode($dati).";";?>
/*
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
      return d
    });
 
  chart.yAxis
	  .tickFormat(d3.format(',.2f'))
    .showMaxMin(false)
	  ;

  d3.select('#chart_m_<?php echo $graficoObj->etichetta["id"]; ?> svg')
    .datum([data_m_<?php echo $graficoObj->etichetta["id"]; ?>])
    .transition().duration(500)
    .call(chart)
    ;

  nv.utils.windowResize(chart.update);
  
  chart.interactiveLayer.tooltip.gravity('s');

  return chart;
});
 */

nv.addGraph(function() {
  var chart = nv.models.discreteBarChart()
      .x(function(d) { return d.label })    //Specify the data accessors.
      .y(function(d) { return d.value })
      .staggerLabels(true)    //Too many bars and not enough room? Try staggering labels.
      .tooltips(false)        //Don't show tooltips
      .showValues(true)       //...instead, show the bar value right on top of each bar.
      .transitionDuration(350)
      ;

  d3.select('#chart_m_<?php echo $graficoObj->etichetta["id"]; ?> svg')
      .datum([data_m_<?php echo $graficoObj->etichetta["id"]; ?>])
      .call(chart);

  nv.utils.windowResize(chart.update);

  return chart;
});



</script>
	<?php
}

?>

	</div>
</div>
</div>
