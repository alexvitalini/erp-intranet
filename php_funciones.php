<?php

function cGetIpCliente() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function set_and_enum_values( $table , $field ){
    $query = "SHOW COLUMNS FROM `$table` LIKE '$field'";
    $result = mysql_query( $query ) or die( 'Error getting Enum/Set field ' . mysql_error() );
    $row = mysql_fetch_array($result);
    if(stripos(".".$row[1],"enum(") > 0) $row[1]=str_replace("enum('","",$row[1]);
        else $row[1]=str_replace("set('","",$row[1]);
    $row[1]=str_replace("','","\n",$row[1]);
    $row[1]=str_replace("')","",$row[1]);
    $ar = split("\n",$row[1]);
    for ($i=0;$i<count($ar);$i++) $arOut[str_replace("''","'",$ar[$i])]=str_replace("''","'",$ar[$i]);
    return $arOut ;
}

function _cfecha( $nFecha ) {
	if ( !isset( $nFecha ) )
		$nFecha = nHoy();
	return date("Y-m-d", $nFecha );
	}

function nHoy() { return strtotime("now"); }

function cHoy() { return _cfecha(); } 

function nManana($nFecha) { return strtotime("+1 day",$nFecha); }

function nPrimeroDeMes($nFecha) { return mktime(0, 0, 0, date('m',$nFecha), 1 , date('Y',$nFecha)); }

function nUltimoDeMes($nFecha) { return mktime(0, 0, 0, date('m',$nFecha), date('t',$nFecha) , date('Y',$nFecha)); }

function nAyer($nFecha) { return strtotime("-1 day",$nFecha); }

function nEstaSemana($nFecha) { return  nManana(mktime(0, 0, 0, date('m',$nFecha), date('d',$nFecha) - date('w',$nFecha), date('Y',$nFecha))); }

function nLunesAnterior($nFecha) { return nEstaSemana($nFecha) - (7*86400); }

function nLunesSiguiente($nFecha) { return  nEstaSemana($nFecha) + (7*86400); }

function nSabadoSiguiente($nFecha) { return nEstaSemana($nFecha) + (5*86400); }

function nLunes2Semanas( $nFecha ) { 
	if ( !isset( $nFecha ) )
		$nFecha = nHoy();
	return ( nEstaSemana($nFecha) - ( (7*86400)*2) ); 
}

?>