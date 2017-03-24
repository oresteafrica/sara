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

$reftabs = ['mfl_misau_raw', 'areas','units'];
$reffields = [['Provincia','id_prov','Distrito','id_dist','US','id_us','Id_MISAU'],['id','name'],['id','name']];

$sql1 = 'SELECT ' . implode(',',$reffields[0]) . ' FROM '.$reftabs[0];
$tabquery1 = $db->query($sql1);
$tabquery1->setFetchMode(PDO::FETCH_ASSOC);
$rows1 = $tabquery1->fetchAll();

$sql2 = 'SELECT ' . implode(',',$reffields[1]) . ' FROM '.$reftabs[1];
$tabquery2 = $db->query($sql2);
$tabquery2->setFetchMode(PDO::FETCH_ASSOC);
$rows2 = $tabquery2->fetchAll();

$cross = [];
$per_limit = 70;
$count = 1;

foreach ($rows1 as $row1) {

	$id_prov = check_similarity ($rows2,$row1['Provincia'],'name',90,'name');
	$id_dist = check_similarity ($rows2,$row1['Distrito'],'name',60,'name');
	$eq_prov = trim($id_prov) == trim($row1['Provincia']);
	$eq_dist = trim($id_dist) == trim($row1['Distrito']);
	$id_prov = $eq_prov?$id_prov:'<span style="background-color:yellow;">'.$id_prov.'<span>';
	$id_dist = $eq_dist?$id_dist:'<span style="background-color:yellow;">'.$id_dist.'<span>';
	
	array_push($cross, [$row1['Provincia'],$id_prov,$row1['Distrito'],$id_dist]);



}

echo '<table style="border-collapse:collapse;">';
echo '<thead>';
echo '<th>N.</th><th>Província</th><th></th><th>Distrito</th><th></th>';
echo '</thead>';
echo '<tbody>';
foreach ($cross as $line) {
	echo '<tr><td style="border:solid 1px black;padding:1px;">';
	echo $count.'</td><td style="border:solid 1px black;padding:1px;">';
	echo implode('</td><td style="border:solid 1px black;padding:1px;">',$line);
	echo '</td></tr>';
	$count++;
}
echo '</tbody></table>';
//----------------------------------------------------------------------------------------------------------------------
function check_similarity ($rows,$compare,$field_to_compare,$min_similarity,$field_to_return) {
	foreach ($rows as $row) {
		$similar = 0;
		similar_text($compare,$row[$field_to_compare],$similar);
		if ($similar > $min_similarity) {
			return trim($row[$field_to_return]);
		}
	}
}
//----------------------------------------------------------------------------------------------------------------------

?>
