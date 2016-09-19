<?php

class EtichetteImpiantoController extends AppController {

	public $uses = array("EtichettaImpianto", "Valore");

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('logout', 'login', 'processaCSV');
    }
	
	public function modifica($id) {
        $ei = $this->EtichettaImpianto->findById($id);
        if ($this->request->is(array('post', 'put'))) {
            $this->EtichettaImpianto->clear();
            $this->EtichettaImpianto->set('id', $id);
            if ($this->EtichettaImpianto->save($this->request->data)) {
                $this->Session->setFlash("Etichetta impianto modificata con successo", self::SUCCESS_FLASH);
                return $this->redirect(array('action' => 'elenco/'.$ei['Impianto']['id']));
            }
        } else {
            $this->request->data = $ei;
			$this->set("etichettaImpianto", $ei);
        }
    }

	public function cambiaStatoCalcoloInizioGiornata($id) {
		$ei = $this->EtichettaImpianto->findById($id);
		$ei["EtichettaImpianto"]["calcolo_inizio_giornata"] = 1-$ei["EtichettaImpianto"]["calcolo_inizio_giornata"];
		$this->EtichettaImpianto->save($ei);
		return $this->redirect(
            array('controller' => 'EtichetteImpianto', 'action' => 'elenco/'.$ei["Impianto"]["id"])
        );
	}

	public function cambiaStatoTabellaHomepage($id) {
		$ei = $this->EtichettaImpianto->findById($id);
		$ei["EtichettaImpianto"]["tabella_homepage"] = 1-$ei["EtichettaImpianto"]["tabella_homepage"];
		$this->EtichettaImpianto->save($ei);
		return $this->redirect(
            array('controller' => 'EtichetteImpianto', 'action' => 'elenco/'.$ei["Impianto"]["id"])
        );
	}

	public function cambiaStatoGraficoHomepage($id) {
		$ei = $this->EtichettaImpianto->findById($id);
		$ei["EtichettaImpianto"]["grafico_homepage"] = 1-$ei["EtichettaImpianto"]["grafico_homepage"];
		$this->EtichettaImpianto->save($ei);
		return $this->redirect(
            array('controller' => 'EtichetteImpianto', 'action' => 'elenco/'.$ei["Impianto"]["id"])
        );
	}

	public function cambiaStatoTabella($id) {
		$ei = $this->EtichettaImpianto->findById($id);
		$ei["EtichettaImpianto"]["tabella"] = 1-$ei["EtichettaImpianto"]["tabella"];
		$this->EtichettaImpianto->save($ei);
		return $this->redirect(
            array('controller' => 'EtichetteImpianto', 'action' => 'elenco/'.$ei["Impianto"]["id"])
        );
	}

	public function cambiaStatoGrafico($id) {
		$ei = $this->EtichettaImpianto->findById($id);
		$ei["EtichettaImpianto"]["grafico"] = 1-$ei["EtichettaImpianto"]["grafico"];
		$this->EtichettaImpianto->save($ei);
		return $this->redirect(
            array('controller' => 'EtichetteImpianto', 'action' => 'elenco/'.$ei["Impianto"]["id"])
        );
	}

    public function elenco($idImpianto) {
        $elenco = $this->EtichettaImpianto->find("all", array(
            'conditions' => array('Impianto.admin' => 0, "Impianto.id" => $idImpianto)
        ));
        $this->set("elenco", $elenco);
		$impianto = $this->Impianto->findById($idImpianto);
        $this->set("impianto", $impianto);
    }

	public function processaCSV() {
		$n = $this->EtichettaImpianto->processaCSV();
		$this->set("numero", $n);
	}

	public function schedaGruppo($idImpianto, $gruppo = 1) {
		$gruppi = $this->Valore->find("all", array(
			"fields" => array("DISTINCT Valore.gruppo", "EtichettaImpianto.nome_gruppo"),
			"conditions" => array("EtichettaImpianto.impianto_id" => $idImpianto),
		));
		$this->set("gruppi", $gruppi);

		$impianto = $this->Impianto->findById($idImpianto);
		$this->set("impianto", $impianto);
		$this->set("gruppo", $gruppo);

		$etichetteImpiantoTabella = $this->EtichettaImpianto->find("all", array(
			"fields" => array("Etichetta.nome", "Etichetta.codice", "EtichettaImpianto.id", "Etichetta.descrizione"),
			"conditions" => array(
				"Impianto.id" => $idImpianto,
				"EtichettaImpianto.tabella" => 1
			),
			"order" => array(
				"Etichetta.posizione" => "asc"
			),
		));

		$valori = array();
		foreach ($etichetteImpiantoTabella as $ei) {
			$valore = new stdClass();

			$valore->etichetta = array("nome" => $ei["Etichetta"]["nome"], "codice" => $ei["Etichetta"]["codice"], "descrizione" => $ei["Etichetta"]["descrizione"]);
			$temp = $this->Valore->find("first", array(
				"fields" => array(
					"EtichettaImpianto.calcolo_inizio_giornata",
					"Valore.valore",
					"Valore.data_ora",
					"EtichettaImpianto.etichetta_id"
				),
				"conditions" => array(
					"EtichettaImpianto.id" => $ei["EtichettaImpianto"]["id"],
					"Valore.gruppo" => $gruppo
				),
				"order" => array(
					"Valore.data_ora" => "DESC")
				)
			);

			if ($temp["EtichettaImpianto"]["calcolo_inizio_giornata"])	{
				$datai = substr($temp["Valore"]["data_ora"], 0, 10)." 00:00:00";
				$valoreInizioGiornata = $this->Valore->find("first", array(
					"fields" => array(
						"Valore.valore",
						"Valore.data_ora",
						"EtichettaImpianto.etichetta_id"
					),
					"conditions" => array(
						"EtichettaImpianto.id" => $ei["EtichettaImpianto"]["id"],
						"Valore.gruppo" => $gruppo,
						"Valore.data_ora > " => $datai
					),
					"order" => array(
						"Valore.data_ora" => "ASC")
					));
				$temp["Valore"]["dal"] = $valoreInizioGiornata["Valore"]["data_ora"];
				$temp["Valore"]["valore"] -= $valoreInizioGiornata["Valore"]["valore"];
			}

			$valore->valori = $temp;
			$valori[] = $valore;
		}
		$this->set("valori", $valori);

		if ($this->request->is('post') && $this->request->data["data_grafico"]) {
			$dataGrafico = $this->request->data["data_grafico"];
			$this->Session->write('data_grafico', $dataGrafico);
		} else {
			$dataGrafico = $this->Session->read('data_grafico');
		}
		if (!$dataGrafico){
			$dataGrafico = date("d-m-Y");
		}

		$dataGraficoDal = substr($dataGrafico, 6, 4)."-".substr($dataGrafico, 3, 2)."-".substr($dataGrafico, 0, 2)." 00:00:00";
		$dataGraficoAl = substr($dataGrafico, 6, 4)."-".substr($dataGrafico, 3, 2)."-".substr($dataGrafico, 0, 2)." 23:59:59";
		
		$this->set("dataGrafico", $dataGrafico);

		$etichetteImpiantoGrafico = $this->EtichettaImpianto->find("all", array(
			"fields" => array("EtichettaImpianto.id", "Etichetta.nome", "Etichetta.codice", "Etichetta.id"),
			"conditions" => array(
				"Impianto.id" => $idImpianto,
				"EtichettaImpianto.grafico" => 1,
			),
			"order" => array(
				"Etichetta.posizione" => "asc"
			),
		));

		$grafici = array();
		foreach ($etichetteImpiantoGrafico as $ei) {
			$valore = new stdClass();
			$valore->etichetta = array("id" => $ei["Etichetta"]["id"], "nome" => $ei["Etichetta"]["nome"], "codice" => $ei["Etichetta"]["codice"]);
			$temp = $this->Valore->find("all", array(
				"fields" => array(
					"EtichettaImpianto.calcolo_inizio_giornata",
					"Valore.valore",
					"Valore.data_ora",
					"EtichettaImpianto.etichetta_id"
				),
				"conditions" => array(
					"EtichettaImpianto.id" => $ei["EtichettaImpianto"]["id"],
					"Valore.gruppo" => $gruppo,
					"Valore.data_ora BETWEEN ? AND ?" => array($dataGraficoDal, $dataGraficoAl)
				),
				"order" => array(
					"Valore.gruppo" => "asc",
					"Valore.data_ora" => "asc"
				)
			));

			$primoValoreTemp = 0;
			$ii = 0;
			for ($ii = 0; $ii < count($temp); $ii++) {
				if ($temp[$ii]["EtichettaImpianto"]["calcolo_inizio_giornata"]) {
					if ($ii == 0) {
						$primoValoreTemp = $temp[$ii]["Valore"]["valore"];
					}
					$temp[$ii]["Valore"]["valore"] -= $primoValoreTemp;
				}
			}

			$valore->valori = $temp;
			$grafici[] = $valore;
		}

		$this->set("grafici", $grafici);
	}

	public function graficiPeriodici($idImpianto) {
		$gruppi = $this->Valore->find("all", array(
			"fields" => array("DISTINCT Valore.gruppo", "EtichettaImpianto.nome_gruppo"),
			"conditions" => array("EtichettaImpianto.impianto_id" => $idImpianto),
		));
		$this->set("gruppi", $gruppi);

		$impianto = $this->Impianto->findById($idImpianto);
		$this->set("impianto", $impianto);
		$etichetteImpiantoGrafico = $this->EtichettaImpianto->find("all", array(
			"fields" => array("EtichettaImpianto.id", "Etichetta.nome", "Etichetta.codice", "Etichetta.id"),
			"conditions" => array(
				"Impianto.id" => $idImpianto,
				"EtichettaImpianto.grafico" => 1,
				"Etichetta.storico" => 1,
			),
			"order" => array(
				"Etichetta.posizione" => "asc"
			),
		));

		$grafici = array();
		foreach ($etichetteImpiantoGrafico as $ei) {
			$valore = new stdClass();
			$valore->etichetta = array("id" => $ei["Etichetta"]["id"], "nome" => $ei["Etichetta"]["nome"], "codice" => $ei["Etichetta"]["codice"]);
			$anni = array();
			$annoCorrente = date("Y");
			$annoIniziale = 2016;
			for ($i = $annoIniziale; $i <= $annoCorrente; $i++) {
				$anni[] = $i;
			}

			$valoreAnnoPrecedente = 0;
			$valoriAnnui = array();
			foreach($anni as $anno) {
				$dal = $anno."-01-01";
				$al = $anno."-12-31";
				$tempAnno = $this->Valore->find("first", array(
					"fields" => array(
						"Valore.valore",
						"EtichettaImpianto.etichetta_id",
					),
					"conditions" => array(
						"EtichettaImpianto.id" => $ei["EtichettaImpianto"]["id"],
						"Valore.gruppo" => 1,
						"Valore.data_ora BETWEEN ? AND ?" => array($dal, $al)
					),
					"order" => array(
						"Valore.data_ora" => "desc"
					)
				));
				$valoriAnnui[$anno] = $tempAnno["Valore"]["valore"] - $valoreAnnoPrecedente;
				$valoreAnnoPrecedente = $valoriAnnui[$anno];
			}
			$valore->valori = $valoriAnnui;
			$grafici[] = $valore;
		}

		$this->set("graficiAnnuali", $grafici);
	
		$grafici = array();
		foreach ($etichetteImpiantoGrafico as $ei) {
			$valore = new stdClass();
			$valore->etichetta = array("id" => $ei["Etichetta"]["id"], "nome" => $ei["Etichetta"]["nome"], "codice" => $ei["Etichetta"]["codice"]);
			$mesi = array();
			$annoCorrente = date("Y");
			$meseCorrente = date("m");
			$annoIniziale = 2016;
			for ($i = $annoIniziale; $i <= $annoCorrente; $i++) {
				for ($j = 1; $j <= 12 && !($i == $annoCorrente && $j > $meseCorrente); $j++) {
					$mm = $j;
					if ($j < 10) {
						$mm = "0".$j;
					}
					$mesi[] = $i."-".$mm;
				}
			}
			$valoreMesePrecedente = 0;
			$valoriMesi = array();
			foreach($mesi as $mese) {
				$dal = $mese."-01";
				$al = $mese."-31";
				$tempMese = $this->Valore->find("first", array(
					"fields" => array(
						"Valore.valore",
						"EtichettaImpianto.etichetta_id",
					),
					"conditions" => array(
						"EtichettaImpianto.id" => $ei["EtichettaImpianto"]["id"],
						"Valore.gruppo" => 1,
						"Valore.data_ora BETWEEN ? AND ?" => array($dal, $al)
					),
					"order" => array(
						"Valore.data_ora" => "desc"
					)
				));
				$valoriMesi[$mese] = $tempMese["Valore"]["valore"] - $valoreMesePrecedente;
				$valoreMesePrecedente = $valoriMesi[$mese];
			}
			$valore->valori = $valoriMesi;
			$grafici[] = $valore;

		}

		$this->set("graficiMensili", $grafici);
 
	}

	public function tabelle($idEtichettaImpianto) {
		$etichettaImpianto = $this->EtichettaImpianto->findById($idEtichettaImpianto);
		$idUtente = $this->Auth->user("id");
		if (!$this->Impianto->isAmministratore($idUtente) 
				&& $idUtente != $etichettaImpianto["Impianto"]["id"]) {
			throw new CakeException("Utente non autorizzato");
		}

		if ($this->request->is('post') && $this->request->data["data_grafico"]) {
			$dataGrafico = $this->request->data["data_grafico"];
			$this->Session->write('data_grafico', $dataGrafico);
		} else {
			$dataGrafico = $this->Session->read('data_grafico');
		}
		if (!$dataGrafico){
			$dataGrafico = date("d-m-Y");
		}

		$dataGraficoDal = substr($dataGrafico, 6, 4)."-".substr($dataGrafico, 3, 2)."-".substr($dataGrafico, 0, 2)." 00:00:00";
		$dataGraficoAl = substr($dataGrafico, 6, 4)."-".substr($dataGrafico, 3, 2)."-".substr($dataGrafico, 0, 2)." 23:59:59";
		
		$etichetteImpianto = $this->EtichettaImpianto->find("all", array(
			"conditions" => array(
				"Impianto.id" => $etichettaImpianto["Impianto"]["id"],
				"AND" => array(
					"OR" => array(
						"EtichettaImpianto.tabella" => 1,
						"EtichettaImpianto.grafico" => 1
					)
				)
			),
			"order" => array(
				"Etichetta.posizione" => "asc"
			),
		));
	
		$valore = $this->Valore->find("first", array(
			"conditions" => array(
				"EtichettaImpianto.id" => $idEtichettaImpianto,
				"EtichettaImpianto.tabella" => 1,
			),
			"fields" => array(
				"Valore.data_ora as data_ora",
				$etichettaImpianto["Etichetta"]["aggregazione"]."(Valore.valore) as valore",
			),
			"order" => array(
				"Valore.gruppo" => "asc",
				"Valore.data_ora" => "desc"
			),
			"group" => array("Valore.data_ora"),
			"limit" => 1
		));

		$etichetteImpiantoGrafico = $this->EtichettaImpianto->find("all", array(
			"conditions" => array(
				"EtichettaImpianto.id" => $idEtichettaImpianto,
				"EtichettaImpianto.grafico" => 1,
			),
			"order" => array(
				"Etichetta.posizione" => "asc"
			),
		));
	
		$etichetteGrafico = array();

		foreach ($etichetteImpiantoGrafico as $e) {
			$obj = new stdClass();
			$obj->etichettaImpianto = $e;
			$obj->valori = $this->Valore->find("all", array(
				"conditions" => array(
					"EtichettaImpianto.id" => $e["EtichettaImpianto"]["id"],
					"Valore.data_ora BETWEEN ? AND ?" => array($dataGraficoDal, $dataGraficoAl)
				),
				"order" => array(
					"Valore.gruppo" => "asc",
					"Valore.data_ora" => "asc"
				),
			));
			$etichetteGrafico[] = $obj;
		}
	
		$this->set("etichetteImpianto", $etichetteImpianto);
		$this->set("etichettaImpianto", $etichettaImpianto);
		$this->set("valore", $valore);
		$this->set("dataGrafico", $dataGrafico);
		$this->set("grafici", $etichetteGrafico);
	}

	public function dash($idImpianto = 0) {
		$idUtente = $this->Auth->user("id");
		if (!$this->Impianto->isAmministratore($idUtente) && $idImpianto > 0 && $idUtente != $idImpianto) {
			throw new CakeException("Utente non autorizzato");
		} else if (!$this->Impianto->isAmministratore($idUtente) && $idImpianto == 0) {
			$idImpianto = $idUtente;
		}

		$impianto = $this->Impianto->findById($idImpianto);

		$etichetteImpianto = $this->EtichettaImpianto->find("all", array(
			"conditions" => array(
				"Impianto.id" => $idImpianto,
				"AND" => array(
					"OR" => array(
						"EtichettaImpianto.tabella" => 1,
						"EtichettaImpianto.grafico" => 1
					)
				)
			),
			"order" => array(
				"Etichetta.posizione" => "asc"
			),
		));
	
		$valori = array();

		foreach ($etichetteImpianto as $etichettaImpianto) {
			$obj = new stdClass();
			$obj->etichettaImpianto = $etichettaImpianto;
			$obj->valori = $this->Valore->find("first", array(
				"conditions" => array(
					"EtichettaImpianto.id" => $etichettaImpianto["EtichettaImpianto"]["id"],
					"EtichettaImpianto.tabella" => 1,
				),
				"fields" => array(
					"Valore.data_ora as data_ora",
					$etichettaImpianto["Etichetta"]["aggregazione"]."(Valore.valore) as valore",
				),
				"order" => array(
					"Valore.gruppo" => "asc",
					"Valore.data_ora" => "desc"
				),
				"group" => array("Valore.data_ora"),
				"limit" => 1
			));
			$valori[] = $obj;
		}

		$this->set("etichetteImpianto", $etichetteImpianto);
		$this->set("impianto", $impianto);
		$this->set("valori", $valori);
	}

    public function isAuthorized($user) {
        $idImpianto = $this->Auth->user('id');
        if ($this->Impianto->isAmministratore($idImpianto)) {
			return in_array($this->action, array(
				"elenco", 
				"modifica", 
				"processaCSV", 
				"tabelle", 
				"cambiaStatoTabella", 
				"schedaGruppo", 
				"cambiaStatoGrafico", 
				"cambiaStatoTabellaHomepage", 
				"cambiaStatoGraficoHomepage", 
				"cambiaStatoCalcoloInizioGiornata", 
				"graficiPeriodici", 
				"dash"));
        } else {
			return in_array($this->action, array('tabelle', 'dash', 'schedaGruppo', 'graficiPeriodici'));
        }
        parent::isAuthorized();
    }

}
