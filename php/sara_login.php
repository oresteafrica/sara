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

$login_err_msg = '<p style="color:red;font-weight:bold;">Nome ou senha não correta</p>';
if (! check_get('no') ) {echo $login_err_msg; exit; } // nome completo
if (! check_get('em') ) {echo $login_err_msg; exit; } // email
if (! check_get('ce') ) {echo $login_err_msg; exit; } // numéro celular
if (! check_get('se') ) {echo $login_err_msg; exit; } // senha

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

$no = $_GET['no'];
$no = stripslashes($no);
$no = $db->quote($no);
$em = $_GET['em'];
$em = stripslashes($em);
$em = $db->quote($em);
$ce = $_GET['ce'];
$ce = stripslashes($ce);
$ce = $db->quote($ce);
$se = $_GET['se'];
$se = stripslashes($se);
$se = $db->quote($se);

$sql = 'SELECT id FROM officer WHERE name = '.$no.' AND email = '.$em.' AND cell = '.$ce.' AND psw = '.$se.' AND active = 1' ;

$tabquery = $db->query($sql);
$tabquery->setFetchMode(PDO::FETCH_ASSOC);
$row = $tabquery->fetch();
if ($tabquery->rowCount() > 0) { echo $row['id']; } else { echo 0; }


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
