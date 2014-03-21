<?php
/*

Author: DigitalDoener (Andreas W.) / www.digitaldoener.de || www.dilution.de
Email : admin@digitaldoener.de
Version: 0.2b: Feb 2005
Compatibility: with any platform. You only need a webserver and php

************* DESCRIPTION *************

ENG: This simple class calculate the love-factor between two names
	 I used my own theory to calculate the love :D *g*
	 
GER: Diese kleine Klasse berechnet den Liebesfaktor von zwei Personennamen.
	 Kennt ihr wahrscheinlich von MTV und anderen Sekten.
	 
************* UPDATE *************

v0.2a
- New faster Code
v0.2b
- fixed Bug

************* USAGE *************

include ("lovecalc.inc.php"); //
$my_love = new lovecalc('paris hilton','my name'); // Supports only ANCII-characters. Need two Strings
echo $my_love->showlove(); // Show the result

************* EXAMPLE *************

include ("lovecalc.inc.php"); // Class
$my_love = new lovecalc('Bill Gates','Linus Torvalds');// New instance
echo $my_love->showlove(); // Show result

************* IMPORTANT ***********

ENG: Please vote for me at www.phpclasses.org
GER: Bitte votet für mich auf www.phpclasses.org
SPA: Por favor voto para me en www.phpclasses.org

************* LICENCE ************

ENG: Free for non-commercial use
GER: Kostenlos für private Seiten. KOSTENPFLICHTIG für alle anderen.

*/

// Klasse
class lovecalc {
	/**
	* @return lovecalc
	* @param string $firstname
	* @param string $secondname
	* @desc Konstructor
	*/
	function lovecalc ($firstname, $secondname) {
		$this->lovename = strtolower(preg_replace("/ /","",strip_tags(trim($firstname.$secondname))));
		$alp = count_chars($this->lovename);
		for($i=97;$i<=122;$i++){
			if($alp[$i]!=false){
				$anz = strlen($alp[$i]);
				if($anz<2){ $calc[] = $alp[$i]; }
				else{ for($a=0;$a<$anz;$a++){ $calc[] = substr($alp[$i],$a,1); } }
			}
		}
		while (($anzletter = count($calc))>2) {
			$lettermitte = ceil($anzletter/2);
			for($i=0;$i<$lettermitte;$i++){
				// Just a little bit SHIFT :D
				$sum = array_shift($calc)+array_shift($calc);
				$anz = strlen($sum);
				if($anz<2){ $calcmore[] = $sum; }
				else{ for($a=0;$a<$anz;$a++){ $calcmore[] = substr($sum,$a,1); } }
			}
			$anzc = count($calcmore);
			for($b=0;$b<$anzc;$b++){ $calc[] = $calcmore[$b]; }
			array_splice($calcmore,0);
		}
		$this->lovestat = $calc[0].$calc[1];
	}
	/**
	* @return int
	* @desc Show result
	*/
	function showlove () {
		return "<table height=40 width=43><tr><td background=3.gif style='font: 15px Verdana, Geneva, Arial, Helvetica, sans-serif; color: yellow;' align=center><b>$this->lovestat</b></td></tr></table>";
	}
}
?>