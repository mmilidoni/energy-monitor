<?php

class ZenitUtility {

	static function startsWith($haystack, $needle) {
    	// search backwards starting from haystack length characters from the end
	    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
	}

	static function endsWith($haystack, $needle) {
	    // search forward starting from end minus needle length characters
    	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
	}
	
	public function getNomeMeseFromNumero($numero) {
		$mesi = array(
			1 => 'Gennaio',
			2 => 'Febbraio',
			3 => 'Marzo',
			4 => 'Aprile',
			5 => 'Maggio',
			6 => 'Giugno',
			7 => 'Luglio',
			8 => 'Agosto',
			9 => 'Settembre',
			10 => 'Ottobre',
			11 => 'Novembre',
			12 => 'Dicembre',
		);
		return $mesi[$numero];
	}

	public function getMesiSelect() {
		return array(1=>'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre');
	}

	public function getAnniSelect($da, $a=null) {
		if (!$a)
			$a = date('Y');
		$anniSelect = array();
		for ($anno = $da; $anno <= $a; $anno++) {
			$anniSelect[] = $anno;
		}
		return $anniSelect;
	}

    public function getAnnoMeseFromSQL($data) {
        return substr($data, 0, 4).substr($data, 5, 2);
    }

    public function getAnnoMeseFromLocal($data) {
        return substr($data, 6, 4).substr($data, 3, 2);
    }

    public function getDateForSQL($dataIt) {
        return substr($dataIt, 6,4)."-".substr($dataIt, 3, 2)."-".substr($dataIt, 0, 2);
    }


}
