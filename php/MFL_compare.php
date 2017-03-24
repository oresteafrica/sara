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

$ini_array = parse_ini_file('../../cron/MFL_compare.ini');
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

$reftabs = ['CDC', 'misau'];
$refids = ['Id_CDC', 'Id_MISAU'];

$sql1 = 'SELECT * FROM '.$reftabs[0];
$tabquery1 = $db->query($sql1);
$tabquery1->setFetchMode(PDO::FETCH_ASSOC);
$rows1 = $tabquery1->fetchAll();

$sql2 = 'SELECT * FROM '.$reftabs[1];
$tabquery2 = $db->query($sql2);
$tabquery2->setFetchMode(PDO::FETCH_ASSOC);
$rows2 = $tabquery2->fetchAll();

$cross = [];
$per_limit = 50;
$count = 1;

foreach ($rows1 as $row1) {

	foreach ($rows2 as $row2) {

		$similar_per = 0;
		$lev = -1;

		if ( $row1['Provincia'] == $row2['Provincia'] && $row1['Distrito'] == $row2['Distrito'] ) {
			similar_text($row1['US'],$row2['US'],$similar_per);
			$lev = levenshtein($row1['US'],$row2['US']);
			if ( $similar_per > $per_limit ) array_push($cross, [	$row1['Provincia'],
																	$row1['Distrito'],
																	$row1['US'],
																	$row2['US'],
																	$row1['Id_CDC'],
																	$row2['Id_MISAU'],
																	round($similar_per),
																	$lev
																]);
		} // 1st if

	}
}

echo '<table style="border-collapse:collapse;">';
echo '<thead>';
echo '<th>N.</th><th>Província</th><th>Distrito</th><th>US CDC</th><th>US MISAU</th>'.
		'<th>Id_CDC</th><th>Id_MISAU</th><th>Similarity %</th><th>Lev.</th>';
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


?>
