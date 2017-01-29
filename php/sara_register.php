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

//foreach($_GET as $k => $v) { echo '<p>'."$k => $v".'</p>'; } // debug

$res_url = 'https://www.google.com/recaptcha/api/siteverify?';
$secret = 'secret=6Lc6QxMUAAAAAGrwmj8wHVz1i6OjMh-Lq7RyShag'.'&response='.$_GET['g-recaptcha-response'];
$remote = '&remoteip='.$_SERVER['REMOTE_ADDR'];
$res=json_decode(file_get_contents($res_url.$secret.$remote), true);

//echo '<p>remoteip='.$_SERVER['REMOTE_ADDR'].'</p>'; // debug
//foreach($res as $k => $v) { echo '<p>'."$k => $v".'</p>'; } ; // debug

$sql = 'INSERT INTO officer ( name, rank, email, cell, psw, active ) VALUES ( ' . 
		"'" . $_GET['cad01'] . "', " .
		'5, ' .
		"'" . $_GET['cad02'] . "', " .
		"'" . $_GET['cad03'] . "', " .
		"'" . $_GET['cad04'] . "', " .
		'0' .
		' )' ;

//echo $sql ; exit; // debug


if ( ! $res['success'] ) { echo 0; exit; }

try {
	$db = new PDO($sdsn, $user, $pass, $opts);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec($sql);
	echo '1';
} catch(PDOException $e) {
    die('Problemas de conexão à base de dados:<br/>' . $e);
}

?>