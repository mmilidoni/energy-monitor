<?php
App::uses('AppModel', 'Model');
App::uses('Valore', 'Model');
App::uses('ZenitUtility', 'Lib');
/**
 * EtichettaImpianto Model
 *
 * @property Impianto $Impianto
 * @property Etichetta $Etichetta
 * @property Valore $Valore
 */
class EtichettaImpianto extends AppModel {
	public function processaCSV() {
		Configure::load('ftp');
		$ftpConfig = Configure::read("ftp_materiale");

        $CSV_PATH = "./";
        $CSV_PATH_PROCESSED = "processati/";
		$FTP_HOST = $ftpConfig["hostname"];
		$FTP_USER = $ftpConfig["username"];
		$FTP_PASS = $ftpConfig["password"];
    	$conn = ftp_connect($FTP_HOST);#.$CSV_PATH); 

    	if (ftp_login($conn, $FTP_USER, $FTP_PASS)) { 
        	ftp_chdir($conn, $CSV_PATH); 
    	} 

        $n = 0;
		$i = 0;
		$totCsv = 0;
		$listaFile = ftp_nlist($conn, ".");
		foreach($listaFile as $f) {
			if (ZenitUtility::endsWith($f, ".csv")) {
				$totCsv++;
			}
		}

        foreach ($listaFile as $f){
            if (ZenitUtility::endsWith($f, ".csv")) {
				$tmpFile = APP."csv/temp_".intval(date("su")/10000).".csv";
				ftp_get($conn, $tmpFile, $f, FTP_BINARY);
				$content = file_get_contents($tmpFile);
                if ($this->processaCSVString($CSV_PATH.$f, $content)) {
                    $n++;
                    #if (!file_exists($CSV_PATH_PROCESSED)) {
                    #    mkdir($CSV_PATH_PROCESSED);
					#}
                }
                ftp_rename($conn, $f, $CSV_PATH_PROCESSED.$f);
				$i++;
			}
        }
		ftp_close($conn);
        return $n;
    }

	private function processaCSVString($filename, $content) {
		// IL NOME FILE DEVE AVERE LA STRUTTURA NOMEIMPIANTO_YYYYMMDDHHIISS.CSV
		$t1 = explode("/", $filename);
		$t1 = $t1[count($t1)-1];
		$nomeImpianto = explode("_", $t1)[0];
		$dataLog = substr(explode("_", $t1)[1], 0, 14);
		$dataLog = substr($dataLog, 0, 4)."-".substr($dataLog, 4, 2)."-".substr($dataLog, 6, 2)." ".substr($dataLog, 8, 2).":".substr($dataLog, 10, 2).":".substr($dataLog, 12, 2);
		$impianto = $this->getImpianto($nomeImpianto);

		$ei = array();
		$gruppi = array();
		$nRiga = 0;
		$dataArray = str_getcsv($content, "\n");
		#while (($data = str_getcsv($content, ";")) !== FALSE) {
		foreach ($dataArray as $dataLine) {
			$data = str_getcsv($dataLine, ";");
			if ($nRiga == 0) {
				for ($i = 0; $i < count($data); $i++) {
					$aetichetta = explode("_", $data[$i]);
					$etichetta = $this->getEtichetta($aetichetta[0]);
					$rei = $this->getEtichettaImpianto($etichetta["Etichetta"]["id"], $impianto["Impianto"]["id"]);
					$ei[$i] = $rei["EtichettaImpianto"]["id"];
					if (count($aetichetta) > 1) {
						$gruppi[$i] = $aetichetta[1];
					} else {
						$gruppi[$i] = 1;
					}
				}
			} else {
				for ($i = 0; $i < count($data); $i++) {
#					if ($i == 2) {
#					} else {
						$obj = array();
						$obj["Valore"] = array();
						$obj["Valore"]["data_ora"] = $dataLog;
						$obj["Valore"]["valore"] = str_replace(",", ".", $data[$i]);
						$obj["Valore"]["gruppo"] = $gruppi[$i];
						$obj["Valore"]["etichetta_impianto_id"] = $ei[$i];
						$val = new Valore();
						$val->clear();
						$val->save($obj);
#					}
				}	
			}
			$nRiga++;
		}
		return true;
	}

	private function getEtichetta($codice) {
		$etichetta = $this->Etichetta->find("first", array(
			"conditions" => array(
				"Etichetta.codice" => $codice
			)
		));
		if ($etichetta) {
			return $etichetta;
		} else {
			$this->Etichetta->clear();
			$obj = array();
			$obj["Etichetta"] = array();
			$obj["Etichetta"]["codice"] = $codice;
			$obj = $this->Etichetta->save($obj);
			return $obj;
		}
	}

	private function getImpianto($nome) {
		$impianto = $this->Impianto->find("first", array(
			"conditions" => array(
				"Impianto.nome" => $nome
			)
		));
		if ($impianto) {
			return $impianto;
		} else {
			$this->Impianto->clear();
			$obj = array();
			$obj["Impianto"] = array();
			$obj["Impianto"]["nome"] = $nome;
			$obj = $this->Impianto->save($obj);
			return $obj;
		}
	}

	private function getEtichettaImpianto($idEtichetta, $idImpianto) {
		$impianto = $this->find("first", array(
			"conditions" => array(
				"Impianto.id" => $idImpianto,
				"Etichetta.id" => $idEtichetta,
			)
		));
		if ($impianto) {
			return $impianto;
		} else {
			$this->clear();
			$obj = array();
			$obj["EtichettaImpianto"] = array();
			$obj["EtichettaImpianto"]["impianto_id"] = $idImpianto;
			$obj["EtichettaImpianto"]["etichetta_id"] = $idEtichetta;
			$obj = $this->save($obj);
			return $obj;
		}
	}

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Impianto' => array(
			'className' => 'Impianto',
			'foreignKey' => 'impianto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Etichetta' => array(
			'className' => 'Etichetta',
			'foreignKey' => 'etichetta_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	/*
	public $hasMany = array(
		'Valore' => array(
			'className' => 'Valore',
			'foreignKey' => 'etichetta_impianto_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	 */
}
