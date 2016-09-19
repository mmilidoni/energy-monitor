<?php
class ImpiantiController extends AppController {

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('logout', 'login');
    }

	public function profilo() {
		$id = $this->Auth->user('id');
		$impianto = $this->Impianto->findById($id);
		$this->request->data = $impianto;
		$this->set("nomeImpianto", $impianto['Impianto']['nome']);
		$this->set("admin", $this->Impianto->isAmministratore($id));
	}

	public function modifica($id) {
        if ($this->request->is(array('post', 'put'))) {
            $this->Impianto->clear();
            $this->Impianto->set('id', $id);
			if (strlen($this->request->data['Impianto']['password']) == 0) {
				unset($this->request->data['Impianto']['password']);
			}
            if ($this->Impianto->save($this->request->data)) {
            	$this->Session->setFlash("Impianto modificato con successo", self::SUCCESS_FLASH);
                return $this->redirect(array('action' => 'elenco'));
            }
        } else {
			$impianto = $this->Impianto->findById($id);
			$impianto["Impianto"]["password"] = "";
			$this->request->data = $impianto;
			$this->set("nomeImpianto", $impianto['Impianto']['nome']);
			$this->set("admin", $this->Impianto->isAmministratore($id));
		}
	}

	public function elenco() {
			$this->log("sono qui2", "debug");
			$this->log("sono qui2 ul:".$this->Auth->user('id'), "debug");
		$elenco = $this->Impianto->find("all", array(
			'conditions' => array('Impianto.admin' => 0)
		));
		$this->set("elenco", $elenco);
	}

	 public function login() {
        if ($this->Auth->user('id')) {
            return $this->redirect(array('controller' => 'Users', 'action' => 'index'));
            #return $this->redirect(array('action' => 'elenco'));
        } else {
            $this->layout = 'auth';
            if ($this->request->is('post')) {
                if ($this->Auth->login()) {
			$this->log("sono qui ul:".$this->Auth->user('id'), "debug");
            		$this->redirect(array('action' => 'elenco'));
                } else {
                    $this->Session->setFlash(__('Nome Utente o Password errati, riprova'), self::ERROR_FLASH);
                }
            }
        }
    }
    public function logout() {
		return $this->redirect(array('controller' => 'Users', 'action' => 'logout'));
	}

    public function isAuthorized($user) {
			$this->log("sono qui3", "debug");
			$this->log("sono qui3 ul:".$this->Auth->user('id'), "debug");
        $idImpianto = $this->Auth->user('id');
        if ($this->Impianto->isAmministratore($idImpianto)) {
            return in_array($this->action, array('elenco', 'modifica', 'isAmministratore'));
        } else {
            return in_array($this->action, array('profilo', 'isAmministratore'));
        }
        parent::isAuthorized();
    }


	public function index() {
		$this->set('msg', __('msg'));
	}
}
