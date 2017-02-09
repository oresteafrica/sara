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

	$fields_type = [];
	$sql = 'SHOW COLUMNS FROM from_field_1';
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$rows = $tabquery->fetchAll();
	foreach ($rows as $row) {
		$fields_type[$row['Field']] = $row['Type'];
	}
} catch(PDOException $e) {
	file_put_contents('debug.txt', $e);
	    die('Problemas de conexão à base de dados:<br/>' . $e);
}

try {
    	$db = new PDO($sdsn, $user, $pass, $opts);
    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$fields_to_insert = implode(',', array_keys($_GET));
	$values = [];
	foreach($_GET as $k => $v) {
		switch ( substr($fields_type[$k],0,3) ) {
			case 'int':
				if ($v == NULL) { $v = 0; }
				array_push($values,$v);
				break;
			case 'var':
				array_push($values,'"'.$v.'"');
				break;
			case 'dat':
				array_push($values,'"'.$v.'"');
				break;
			case 'tin':
				array_push($values,$v);
				break;
			case 'flo':
				if ($v == NULL) { $v = 0; }
				array_push($values,$v);
				break;
			default:
				array_push($values,$v);
		}
	}
	$values_to_insert = implode(',', $values);
	$sql = 'INSERT INTO from_field_1 (' . $fields_to_insert . ') VALUES (' . $values_to_insert . ')' ;
	$db->exec($sql);
	echo '1';
	//file_put_contents('debug.txt', $sql);
} catch(PDOException $e) {
	file_put_contents('debug.txt', $e);
    	die('Problemas de conexão à base de dados:<br/>' . $e);
}

?>