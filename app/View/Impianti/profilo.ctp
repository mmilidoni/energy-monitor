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
  <div class="panel-heading"><h2>Profilo Impianto <b><?php echo $nomeImpianto; ?></b></h2></div>
  <div class="panel-body">
<br/>

<?php echo $this->Form->input('indirizzo', array('readonly' => true)); ?>
<?php echo $this->Form->input('citta', array('readonly' => true)); ?>
<?php echo $this->Form->input('provincia', array('readonly' => true)); ?>

</div>
</div>
