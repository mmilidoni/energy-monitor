<?php

class EtichetteController extends AppController {

#    public $components = array('BilloClub', 'Utilities');
    #public $uses = array("EtichetteEtichetta");

    public function beforeFilter() {
        parent::beforeFilter();
    }
	
	public function elenco() {
		$etichetteTabella = $this->Etichetta->find("all", array(
			"conditions" => array(
			),
			"order" => array(
				"Etichetta.posizione" => "asc"
			)
		));
		$this->set("elenco", $etichetteTabella);
	}

	public function modifica($id) {
        if ($this->request->is(array('post', 'put'))) {
            $this->Etichetta->clear();
            $this->Etichetta->set('id', $id);
            if ($this->Etichetta->save($this->request->data)) {
            	$this->Session->setFlash("Etichetta modificata con successo", self::SUCCESS_FLASH);
                return $this->redirect(array('action' => 'elenco'));
            }
        } else {
			$Etichetta = $this->Etichetta->findById($id);
			$this->request->data = $Etichetta;
			$this->set("nomeEtichetta", $Etichetta['Etichetta']['nome']);
		}
	}


    public function isAuthorized($user) {
        $idEtichetta = $this->Auth->user('id');
        if ($this->Impianto->isAmministratore($idEtichetta)) {
			return in_array($this->action, array("elenco", "modifica"));
        } else {
			return in_array($this->action, array());
        }
        parent::isAuthorized();
    }

}
