<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

	public $theme = 'Tisa';

	public $user = array();

	public function beforeFilter() {
    	parent::beforeFilter();
    	$this->Auth->allow(array('logout', 'login','index','unauthorizedAccess'));
	}

	public function index() {
		/*
		$this->log("sono qui4", "debug");
		$idPersona = $this->Auth->user('id');
		if ($this->Impianto->isAmministratore($idPersona)) {
			return $this->redirect(array('controller' => 'Impianti', 'action' => 'elenco'));
		} else if ($idPersona) {
			return $this->redirect(array('controller' => 'Impianti', 'action' => 'profilo'));
		} else {
			return $this->redirect(array('controller' => 'Impianti', 'action' => 'login'));
		}
		 */
	}
	public function login() {
		$this->log("sono", "debug");
		$this->log($this->request->is('post'), "debug");

		if ($this->request->is('post')) {
 	       if ($this->Auth->login()) {
				$this->log("sono io: ".$this->Auth->user("id"), "debug");
    	        #return $this->redirect($this->Auth->redirectUrl());
				#return $this->redirect(array("action" => "elenco", "controller" => "Impianti"));
				$idPersona = $this->Auth->user('id');
		        if ($this->Impianto->isAmministratore($idPersona)) {
        		    return $this->redirect(array('controller' => 'Impianti', 'action' => 'elenco'));
		        } else if ($idPersona) {
        		    return $this->redirect(array('controller' => 'EtichetteImpianto', 'action' => 'schedaGruppo/'.$idPersona));
		        } else {
        		    return $this->redirect(array('controller' => 'Impianti', 'action' => 'login'));
		        }
        	}
            $this->Session->setFlash(__('Nome Utente o Password errati, riprova'), self::ERROR_FLASH);
    	}
		$this->layout = 'auth';
		$this->redirect(array('controller' => 'Impianti', 'action' => 'login'));
	}

	public function logout() {
		$this->layout = 'auth';
		if (!$this->Auth->logout()) {
			$this->redirect(array('controller' => 'Impianti', 'action' => 'login'));
		} else {
			$this->redirect($this->Auth->logout());
		}
	}
	public function unauthorizedAccess() {
		
	}
/*
	public function isAuthorized($user) {
		$idPersona = $this->Auth->user('id');
		if ($this->Impianto->isAmministratore($idPersona)) {
			return true;
		} else {
			if (in_array($this->action, array('logout', 'login', 'index'))) {
				return true;
			} else {
				return false;
			}
		}
		parent::isAuthorized();
	}
 */
}
