<?php

$localhosts = array(
    '127.0.0.1',
    'localhost',
	'::1'
);

if(in_array($_SERVER['REMOTE_ADDR'], $localhosts)) {
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);
}

if(isset($_GET['t'])) {
	if( ($_GET['t'] === '') or ($_GET['t'] === false) or ($_GET['t'] === null) or (empty($_GET['t'])) ) {
		$fmt = 'ul';
	} else {
		$fmt = $_GET['t'];
	}
} else {
	$fmt = 'ul';
}

$ini_array = parse_ini_file('../../cron/sara.ini');
$sdsn = $ini_array['sdsn'];
$user = $ini_array['user'];
$pass = $ini_array['pass'];
$opts = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $db = new PDO($sdsn, $user, $pass, $opts);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die('Problemas de conexão à base de dados:<br/>' . $e);
}
/*
risultato della sql

id | name | id_up | sid | v

sid -> 'a' + id nel caso di aree
sid -> 'u' + id nel caso di unità

v
0 = deleted (violet)
1 = stand-by (blue)
2 = not validated (red)
3 = validated (green)

*/

$sql = 'SELECT areas.id AS id, areas.name AS name, CAST(hierarchy_areas_areas.id_up AS UNSIGNED) AS id_up, CONCAT("a_",areas.id) AS sid, 3 as v FROM areas, hierarchy_areas_areas WHERE areas.id = hierarchy_areas_areas.id AND hierarchy_areas_areas.id_up < 13 UNION SELECT (@cnt := @cnt + 1) AS id, units.name AS name, CAST(hierarchy_units_areas.id_area AS UNSIGNED) AS id_up, CONCAT("u_",units.id) AS sid, units.valid as v FROM units, hierarchy_units_areas CROSS JOIN (SELECT @cnt := 10000) AS dummy WHERE units.id = hierarchy_units_areas.id_unit ORDER BY id_up, id';

$array_table = create_array_from_tables ($db, $sql);

switch ($fmt) {
    case 'ul':
		ob_start();
		print_list($array_table,1);
		$ulli = ob_get_clean();
		echo $ulli;
        break;
    case 'ulinfo':
		ob_start();
		print_ulinfo($array_table,1);
        break;
		$ulli = ob_get_clean();
		echo $ulli;
    case 'xml':
		print_xml($array_table);
        break;
    default:
		print_list($array_table,1);
}

//----------------------------------------------------------------------------------------------------------
function create_array_from_tables ($db, $sql) {
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	if ($tabquery->rowCount() < 1) { echo '<h1>A base de dados é vazia</h1>'; exit; }
	$array_table = [];
	foreach ($tabquery as $tabres) {
		array_push($array_table, $tabres);
	}
	return $array_table;
}
//----------------------------------------------------------------------------------------------------------
function print_list($array, $parent=0) {
	print '<ul>';
    for($i=$parent, $ni=count($array); $i < $ni; $i++){
        if ($array[$i]['id_up'] == $parent) {
            print '<li><span id="'.$array[$i]['sid'].'">'.$array[$i]['name'].'</span>';
            print_list($array, $array[$i]['id']);  # recurse
            print '</li>';
    }   }
    print '</ul>';
}
//----------------------------------------------------------------------------------------------------------
function print_ulinfo($array, $parent=0) {
	print '<ul>';
    for($i=$parent, $ni=count($array); $i < $ni; $i++){
        if ($array[$i]['id_up'] == $parent) {
            print '<li>'.$array[$i]['name'].' id='.$array[$i]['id'].' sid='.$array[$i]['sid'].' id_up='.$array[$i]['id_up'];
            print_ulinfo($array, $array[$i]['id']);  # recurse
            print '</li>';
    }   }
    print '</ul>';
}
//----------------------------------------------------------------------------------------------------------
function print_xml($array) {
	echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	echo '<tree>'."\n";
	foreach($array as $item) {
		$id_prov = $item['id'];
		if ( $id_prov > 1 && $id_prov < 13 ) {
	    	echo '<prov id="'.$id_prov.'" name="'.$item['name'].'">'."\n";
			foreach($array as $item) {
				$id_dist = $item['id'];
				$id_up_dist = $item['id_up'];
				if ( $id_up_dist == $id_prov ) {
					$id_dist = $item['id'];
			    	echo "\t".'<dist id="'.$item['id'].'" name="'.$item['name'].'">'."\n";
					foreach($array as $item) {
						if ( $id_dist == $item['id_up'] ) {
							$id_us = $item['id'] - 10000;
					    	echo "\t\t".'<us id="'.$id_us.'" name="'.$item['name'].'"></us>'."\n";
						}
					}
			    	echo "\t".'</dist>'."\n";
				}
			}
	    	echo '</prov>'."\n";
		}
//    	echo '<ele id="'.$item['id'].'" id_up="'.$item['id_up'].'">'.$item['name'].'</ele>'."\n";
	} 
    echo '</tree>'."\n";
}
//----------------------------------------------------------------------------------------------------------
?>
