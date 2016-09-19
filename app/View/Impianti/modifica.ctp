<?php

echo $this->Form->create('Impianto');
 $this->Form->inputDefaults(array(
        'div' => array(
            'class' => 'form-group'
        ),
        'class' => 'form-control'
    ));

?>
<div class="panel panel-default">
  <div class="panel-heading"><h2>Profilo Impianto</h2><h3>Nome impianto: <?php echo $nomeImpianto; ?></h3></div>
  <div class="panel-body">In questa sezione è possibile modificare i dati principali dell'impianto.<br/>Per visualizzare le prestazioni dell'impianto è possibile effettuare il login con le credenziali <i>nome impianto</i> e <i>password</i>.
<br/>
<br/>

<?php echo $this->Form->input('titolare', array('required' => true)); ?>
<?php echo $this->Form->input('indirizzo', array('required' => true)); ?>
<?php echo $this->Form->input('citta', array('required' => true)); ?>
<?php echo $this->Form->input('provincia', array('required' => true)); ?>
<?php echo $this->Form->input('password'); ?>
<?php
                    echo $this->Form->end(array(
                        'label' => 'Salva',
                        'class' => 'btn btn-primary form-close-button',
                        'style' => 'float:left;'
					));
                ?>

</div>
</div>
