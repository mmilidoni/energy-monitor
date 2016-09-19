<?php

echo $this->Form->create('EtichettaImpianto');
 $this->Form->inputDefaults(array(
        'div' => array(
            'class' => 'form-group'
        ),
        'class' => 'form-control'
    ));

?>
<div class="panel panel-default">
  <div class="panel-heading"><h2>Modifica Etichette Impianto <b><?php echo $etichettaImpianto["Impianto"]["nome"].":".$etichettaImpianto["Etichetta"]["codice"]; ?></b></h2>
</div>
  <div class="panel-body">In questa sezione è possibile modificare la visibilità delle etichette in tabella e su grafico.
<br/>
<br/>

<?php echo $this->Form->input('Impianto.nome', array('readonly' => true, 'label' => "Nome Impianto")); ?>
<?php echo $this->Form->input('Etichetta.codice', array('readonly' => true, 'label' => "Codice Etichetta")); ?>
<?php echo $this->Form->input('nome_gruppo', array()); ?>
<?php echo $this->Form->input('tabella', array()); ?>
<?php echo $this->Form->input('grafico', array()); ?>
<?php
                    echo $this->Form->end(array(
                        'label' => 'Salva',
                        'class' => 'btn btn-primary form-close-button',
                        'style' => 'float:left;'
					));
                ?>

</div>
</div>
