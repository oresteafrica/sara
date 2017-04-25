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

$reftabs = ['unit_type', 'unit_authority', 'ministries', 'unit_state', 'unit_service'];

echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
echo '<reftabs>'."\n";

foreach ($reftabs as $tab) {
	echo "\t".'<'.$tab.'>'."\n";
	$sql = 'SELECT id, name FROM '.$tab;
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$rows = $tabquery->fetchAll();
	foreach ($rows as $row) {
		echo "\t\t".'<row>';
		echo '<id>'.$row['id'].'</id><name>'.$row['name'].'</name>';
		echo '</row>'."\n";
	}
	echo "\t".'</'.$tab.'>'."\n";
}

$sql2 = 'SELECT areas.id AS id, areas.name AS name, CAST(hierarchy_areas_areas.id_up AS UNSIGNED) AS id_up, CONCAT("a_",areas.id) AS sid, 3 as v FROM areas, hierarchy_areas_areas WHERE areas.id = hierarchy_areas_areas.id AND hierarchy_areas_areas.id_up < 13 UNION SELECT (@cnt := @cnt + 1) AS id, units.name AS name, CAST(hierarchy_units_areas.id_area AS UNSIGNED) AS id_up, CONCAT("u_",units.id) AS sid, units.valid as v FROM units, hierarchy_units_areas CROSS JOIN (SELECT @cnt := 10000) AS dummy WHERE units.id = hierarchy_units_areas.id_unit ORDER BY id_up, id';

$array_table = create_array_from_tables ($db, $sql2);
print_xml($array_table);

echo '</reftabs>'."\n";



//----------------------------------------------------------------------------------------------------------
function create_array_from_tables ($db, $sql) {
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	if ($tabquery->rowCount() < 1) { echo '<error>A base de dados é vazia</error>'; exit; }
	$array_table = [];
	foreach ($tabquery as $tabres) {
		array_push($array_table, $tabres);
	}
	return $array_table;
}
//----------------------------------------------------------------------------------------------------------
function print_xml($array) {
	foreach($array as $item) {
		$id_prov = $item['id'];
		if ( $id_prov > 1 && $id_prov < 13 ) {
	    	echo "\t".'<prov id="'.$id_prov.'" name="'.$item['name'].'">'."\n";
			foreach($array as $item) {
				$id_dist = $item['id'];
				$id_up_dist = $item['id_up'];
				if ( $id_up_dist == $id_prov ) {
					$id_dist = $item['id'];
			    	echo "\t\t".'<dist id="'.$item['id'].'" name="'.$item['name'].'">'."\n";
					foreach($array as $item) {
						if ( $id_dist == $item['id_up'] ) {
							$id_us = $item['id'] - 10000;
					    	echo "\t\t\t".'<us id="'.$id_us.'" name="'.$item['name'].'"></us>'."\n";
						}
					}
			    	echo "\t\t".'</dist>'."\n";
				}
			}
	    	echo "\t".'</prov>'."\n";
		}
//    	echo '<ele id="'.$item['id'].'" id_up="'.$item['id_up'].'">'.$item['name'].'</ele>'."\n";
	} 
}
//----------------------------------------------------------------------------------------------------------
?>
