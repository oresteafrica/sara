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

$reftabs = ['unit_type', 'unit_authority', 'unit_state', 'unit_service'];

foreach ($reftabs as $tab) {
	echo '<p style="font-weight:bold;">'.$tab.'</p>';
	echo '<table style="border-collapse:collapse;"><tbody>';
	$sql = 'SELECT id, name FROM '.$tab;
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$rows = $tabquery->fetchAll();
	echo '<br />';
	foreach ($rows as $row) {
		echo '<tr><td style="border:solid 1px black;padding:1px;">';
		echo implode('</td><td style="border:solid 1px black;padding:1px;">',$row);
		echo '</td></tr>';
	}
	echo '</tbody></table>';
	echo '<hr />';
}


?>
