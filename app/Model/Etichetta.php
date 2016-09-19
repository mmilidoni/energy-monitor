<?php
App::uses('AppModel', 'Model');
/**
 * Etichetta Model
 *
 */
class Etichetta extends AppModel {

	public function getMoltiplicatore($id) {
		$res = $this->findById($id);
		if (isset($res["Etichetta"]["moltiplicatore"])) {
			return $res["Etichetta"]["moltiplicatore"];
		}
		return 1;
	}
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nome';

}
