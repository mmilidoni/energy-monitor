<div class="panel panel-default">
  <div class="panel-heading"><h2>Elaborazione file CSV</h2></div>
  <div class="panel-body">Procedura per forzare l'operazione di importazione dei file CSV che contengono i dati energetici. <br/>I file CSV devono trovarsi nella directory predefinita e, dopo l'elaborazione, sono trasferiti in una subdirectory.
<br/>
<hr/>
<br/>
<?php
if ($numero > 0) {
	echo "Sono stati elaborati $numero file CSV";
} else {
	echo "Nessun file CSV elaborato";
}

?>
</div>
</div>
