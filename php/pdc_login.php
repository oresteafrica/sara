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

session_start();


if (! check_get('no') ) { echo 0; exit; } // nome completo
if (! check_get('ws') ) { echo 0; exit; } // senha
if (! check_get('ca') ) { echo 0; exit; } // captcha

$ca = $_GET['ca'];

if ( $_SESSION['res'] != $ca ) {
	file_put_contents( 'debug_pdc_login_error.txt', print_r($_GET,true) . "\n" . print_r($_SESSION,true) ); // debug
	echo 0;
	exit;
} // check captcha

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

	$no = $_GET['no'];
	$no = rawurldecode($no);
	$no = stripslashes($no);
	$no = $db->quote($no);

	$ws = $_GET['ws'];
	$ws = rawurldecode($ws);

	$se = substr(substr($ws, 3), 0, -5);

	$se = $db->quote($se);

	$ca = stripslashes($ca);
	
	$sql = 'SELECT id, name FROM officer WHERE name = '.$no.' AND psw = '.$se.' AND active = 1 AND rank < 3' ;
	//file_put_contents('debug_pdc_login_sql.txt', $sql); // debug

	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$row = $tabquery->fetch();
	if ($tabquery->rowCount() > 0) {
		$_SESSION['user_name'] = $row['name'];
		$_SESSION['user_id'] = $row['id'];
		echo 1;
	} else {
		session_unset();
		session_destroy();
		echo 0;
		file_put_contents('debug_pdc_login_select_error.txt', $sql); // debug
	}
} catch(PDOException $e) {
	session_unset();
	session_destroy();
	file_put_contents('debug_pdc_login_db_error.txt', $e); // debug
    die(0);
//    die('Problemas de conexão à base de dados:<br/>' . $e);
}

//----------------------------------------------------------------------------------------
function check_get ($var) {
	if($_GET[$var] === '') {
		return false;
	}
	if($_GET[$var] === false) {
		return false;
	}
	if($_GET[$var] === null) {
		return false;
	}
	if(!isset($_GET[$var])) {
		return false;
	}
	if(empty($_GET[$var])) {
		return false;
	}
	return true;
}








?>