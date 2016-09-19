<div class="panel panel-default">
  <div class="panel-heading"><h2><?php echo $nomeEtichetta; ?> - Modifica Etichetta</h2></div>
  <div class="panel-body">In questa sezione è possibile modificare le proprietà dell'etichetta.<br/>
La proprietà <i>aggregazione</i> può assumere i seguenti valori:
<ul>
<li>SUM</li>
<li>COUNT</li>
<li>AVG</li>
</ul>
<br/>
<br/>


<?php

echo $this->Form->create('Etichetta');
 $this->Form->inputDefaults(array(
        'div' => array(
            'class' => 'form-group'
        ),
        'class' => 'form-control'
    ));

?>
<?php echo $this->Form->input('codice', array('required' => true, 'readonly' => true)); ?>
<?php echo $this->Form->input('nome', array('required' => false)); ?>
<?php echo $this->Form->input('aggregazione', array('required' => true)); ?>
<?php echo $this->Form->input('descrizione', array('required' => false)); ?>
<?php echo $this->Form->input('posizione', array('required' => false)); ?>
<?php
                    echo $this->Form->end(array(
                        'label' => 'Salva',
                        'class' => 'btn btn-primary form-close-button',
                        'style' => 'float:left;'
					));
                ?>
</div>
</div>

