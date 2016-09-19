<?php
App::uses('AppModel', 'Model');
App::uses('Etichetta', 'Model');
/**
 * Valore Model
 *
 * @property EtichettaImpianto $EtichettaImpianto
 */
class Valore extends AppModel {

	public function beforeSave($options = array()) {
		if (empty($this->data['Valore']['gruppo'])) {
			$this->data["Valore"]["gruppo"] = 1;
		}
	}

	public function afterFind($results, $primary = false) {
		$etichetta = new Etichetta();
		foreach ($results as $key => $val) {
			if (isset($val["EtichettaImpianto"]["etichetta_id"])) {
				$moltiplicatore = $etichetta->getMoltiplicatore($val["EtichettaImpianto"]["etichetta_id"]);
				if ($moltiplicatore != 1) {
	            	$results[$key]['Valore']['valore'] = $val['Valore']['valore'] * $moltiplicatore;
	    	    }
			}
  		}
    	return $results;
	}



	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'EtichettaImpianto' => array(
			'className' => 'EtichettaImpianto',
			'foreignKey' => 'etichetta_impianto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
