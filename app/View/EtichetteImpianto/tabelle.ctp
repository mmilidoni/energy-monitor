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
<h2>Prestazioni Impianto <b><?php echo $etichettaImpianto["Impianto"]["nome"]; ?></b></h2>

<div id="cssmenu">
<ul>
<?php
	$lnk = $this->Html->link("Home",
			array(
		    "controller" => "EtichetteImpianto",
		    "action" => "dash",
			$etichettaImpianto["Impianto"]["id"]
	));
	echo "<li>".$lnk."</li>";
	
	foreach($etichetteImpianto as $ei) {
		$nome = $ei["Etichetta"]["nome"] == "" ? $ei["Etichetta"]["codice"] : $ei["Etichetta"]["nome"];
		if ($ei["Etichetta"]["id"] == $etichettaImpianto["Etichetta"]["id"]) {
			$style = " class='active' ";
		} else {
			$style = "";
		}
		$lnk = $this->Html->link($nome,
			array(
		    "controller" => "EtichetteImpianto",
		    "action" => "tabelle",
			$ei["EtichettaImpianto"]["id"])
		);
		
		echo "<li $style>".$lnk."</li>";
	}
	echo "<li><a href='/Users/logout'>Esci</a></li>";
?>
</ul>
</div>
</div>
<div class="panel-body">
<div class="panel">
<form id="cerca_data" method="post" action="/EtichetteImpianto/tabelle/<?php echo $etichettaImpianto["EtichettaImpianto"]["id"]; ?>/">
<label for="data_grafico">Data</label>
<div class="input-group date ts_datepicker" data-date-format="dd-mm-yyyy" data-date-autoclose="true">
<input id="data_grafico" class="form-control" value="<?php echo $dataGrafico; ?>" name="data_grafico" type="text">
<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
</div>
</form>
</div>

<br/>

<div class="container-fluid">
			<div class="col-md-4 panel panel-default">
<div class="panel-body" style="text-align:center;">
<div class="heading_b" style="text-align: left;"><i class="glyphicon glyphicon-dashboard"></i>
<?php if ($etichettaImpianto['Etichetta']['nome'] != "") echo $etichettaImpianto['Etichetta']['nome']; else echo $etichettaImpianto['Etichetta']['codice'];
echo " (".$etichettaImpianto['Etichetta']['aggregazione'].")"; ?>
</div>
	<?php
echo "<span style='text-align: center; font-size: 32px; font-weight: bold;'>".round($valore[0]['valore'], 2)."</span><br/>";
echo "<span style='text-align: center; font-size: 12px;'>Ultimo aggiornamento: ".substr($valore["Valore"]['data_ora'], 0)."</span>";
?>
</div>
			</div>
<?php 
$desc = $etichettaImpianto["Etichetta"]["descrizione"];
if (count(trim($desc)) > 0) {
?>
<div class="col-md-4 panel panel-default" style="vertical-align: top; color:#333; font-size:14px;">
<div class="panel-body">
<div class="heading_b"><i class="glyphicon glyphicon-info-sign"></i> Informazioni</div>
<?php echo $desc; ?></div>
</div>
<?php
}
?>
<div class="col-md-4 panel panel-default" style="vertical-align: top;">
<div class="panel-body">
<div class="heading_b"><i class="glyphicon glyphicon-tower"></i> Impianto</div>
<table style="font-size: 12px; width:100%;">
<?php
$impianto = $etichettaImpianto["Impianto"];
echo '<tr><td class="titolo_voce">Nome</td><td>'.$impianto["nome"].'</td></tr>';
echo '<tr><td class="titolo_voce">Indirizzo</td><td>'.$impianto["indirizzo"].'</td></tr>';
echo '<tr><td class="titolo_voce">Citt&agrave;</td><td>'.$impianto["citta"].' ('.$impianto["provincia"].')</td></tr>';
echo '<tr><td class="titolo_voce">Titolare</td><td>'.$impianto["provincia"].'</td></tr>';
?>
</table>
</div>
</div>
<?php
echo "<div style='clear:both'></div>";

foreach ($grafici as $graficoObj) {
	$dati = array();
	$gruppoCorrente = -1;
	$sizeValori = count($graficoObj->valori);
	for ($i = 0; $i < $sizeValori; $i++) {
		$grafico = $graficoObj->valori[$i];
		if ($gruppoCorrente != $grafico["Valore"]["gruppo"]) {
			if ($gruppoCorrente > 0) {
#				array_push($dati, $obj);
			} 
			$obj = new stdClass();
			$obj->key = $grafico["EtichettaImpianto"]["nome_gruppo"]." ".$grafico["Valore"]["gruppo"];
			$obj->values = array();
			$gruppoCorrente = $grafico["Valore"]["gruppo"];
		}
		array_push($obj->values, [strtotime($grafico["Valore"]["data_ora"])*1000, floatval($grafico["Valore"]["valore"])]);

		if($i < $sizeValori - 1 && $gruppoCorrente != $graficoObj->valori[$i+1]["Valore"]["gruppo"]) {
			array_push($dati, $obj);
		} else if ($i == $sizeValori -1) {
			array_push($dati, $obj);
		}
	}
?>
<h3><?php 
if ($graficoObj->etichettaImpianto["Etichetta"]["nome"]) {
	echo $graficoObj->etichettaImpianto["Etichetta"]["nome"];
	echo " (".$graficoObj->etichettaImpianto["Etichetta"]["codice"].")"; 
} else {
	echo $graficoObj->etichettaImpianto["Etichetta"]["codice"]; 
}
echo " del giorno $dataGrafico";
?>
</h3>
 
<div id="chart_<?php echo $graficoObj->etichettaImpianto["Etichetta"]["id"]; ?>">
 <svg class="svgchart"></svg>
</div>
<script>

<?php echo "var data_".$graficoObj->etichettaImpianto["Etichetta"]["id"]." = ".json_encode($dati).";";?>

nv.addGraph(function() {
  var chart = nv.models.lineChart()
    .x(function(d) { return d[0] })
    .y(function(d) { return d[1] })
    .color(d3.scale.category10().range())
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

  d3.select('#chart_<?php echo $graficoObj->etichettaImpianto["Etichetta"]["id"]; ?> svg')
    .datum(data_<?php echo $graficoObj->etichettaImpianto["Etichetta"]["id"]; ?>)
    .transition().duration(500)
    .call(chart)
    ;

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
