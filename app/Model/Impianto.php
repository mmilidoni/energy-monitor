<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * Impianto Model
 *
 */
class Impianto extends AppModel {

	public function beforeSave($options = array()) {
$this->log("sono qqui", "debug");
	    if (isset($this->data['Impianto']['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data['Impianto']['password'] = $passwordHasher->hash(
                $this->data["Impianto"]['password']
            );
        }
	}
	
	public function resetPassword($id, $password) {
        $password = trim($password);
        if ($password == "") {
            throw new CakeException("Password vuota");
        }
        $impianto = $this->findById($id);
        if ($impianto) {
            $this->clear();
            $passwordHasher = new BlowfishPasswordHasher();
            $impianto['Impianto']['password'] = $passwordHasher->hash($password);
            return $this->save($impianto);
        } else {
            throw new CakeException("Impianto non trovato");
        }
    }

	public function isAmministratore($idImpianto) {
		$impianto = $this->findById($idImpianto);
		return $impianto ? $impianto['Impianto']['admin'] : "";
	}
	
	/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nome';

}
