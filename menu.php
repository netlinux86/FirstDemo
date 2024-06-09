<?php
//ULTIMA MODIFICACION 25-Jul-17
//Código Fuente App/Web GrupoIbarra TTUR
//Ernesto Hernández Barrón 
//Menu.php
//Function para buscar el arreglo de los permisos
$rsp='';
function multidimensional_search($parents, $searched) {
  if (empty($searched) || empty($parents)) {
    return false;
  }

  foreach ($parents as $key => $value) {
    $exists = true;
    foreach ($value as $skey => $svalue) {
    	echo $skey.'-'.$svalue.'<br>';
    }
    /*foreach ($searched as $skey => $svalue) {
    	//echo $skey.'-'.$svalue.'-'.$parents[$key][$skey].'<br>';
    	$exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
		//$rsp.=$parents[$key]["variables"].'<br />';
		echo $parents[$key][$skey].'-'.$svalue.'-'.$exists.'<br />';
    }
    if($exists){ return $rsp; }*/
  }
  return false;
}
//Arreglo del menu
$parents = array();
$parents = array ((10) => array ("mnu_id" => 0, "variables" => "titulo=Inicio&class=fa-home&seccion=side-menu"),
				(11) => array ("mnu_id" => 0, "variables" => "titulo=Inicio&class=fa-home&seccion=side-menu1"),
				(12) => array ("mnu_id" => 11, "variables" => "titulo=Inicio&class=fa-home&seccion=side-menu2"),
				(13) => array ("mnu_id" => 11, "variables" => "titulo=Inicio&class=fa-home&seccion=side-menu3"),
				(14) => array ("mnu_id" => 0, "variables" => "titulo=Inicio&class=fa-home&seccion=side-menu4"));

$multi = multidimensional_search(12, array('mnu_id'=>11)); // 1

var_dump($parents[$multi]);
?>