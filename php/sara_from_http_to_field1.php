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

$ok = false;

try {
    $db = new PDO($sdsn, $user, $pass, $opts);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$fields_type = [];
	$sql = 'SHOW COLUMNS FROM from_field_1';
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$rows = $tabquery->fetchAll();
	foreach ($rows as $row) {
		$fields_type[$row['Field']] = $row['Type'];
	}



} catch(PDOException $e) {
    die('Problemas de conexão à base de dados:<br/>' . $e);
}

try {
    $db = new PDO($sdsn, $user, $pass, $opts);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$fields_to_insert = implode(',', array_keys($_GET));
	$values_to_insert = '';
	foreach($_GET as $k => $v) {

// deve servire per discriminare fra stringhe, numeri e date nel $values_to_insert

	}

	$sql = 'INSERT INTO from_field_1 (' . $fields_to_insert . ') VALUES (' . $values_to_insert . ')' ;

	$db->exec($sql);

} catch(PDOException $e) {
    die('Problemas de conexão à base de dados:<br/>' . $e);
}





if ($ok) { echo 'OK'; } else { echo 0; }


?>
