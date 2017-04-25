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

$debug = print_r($_GET,true); // debug
file_put_contents('debug_sara_db_insert.txt', $debug); // debug


$ini_array = parse_ini_file('../../cron/sara.ini');
$sdsn = $ini_array['sdsn'];
$user = $ini_array['user'];
$pass = $ini_array['pass'];
$opts = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

$key = $_GET['key'];
$val = $_GET['val'];
$unit_id = $_GET['unit_id'];
$today_mysql = date('Y-m-d');
$skey = '';
$sql = '';

switch ($key) {
	case 'mz001':
		$skey = 'Código da unidade';
		if (strlen($val) > 16) { exit; }
		if (strlen($val) < 1) { exit; }
//		$sql = 'UPDATE unit_code SET code = "'.$val.'", date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_code (code,date,id_unit) VALUES("'.$val.'", "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz003':
		$skey = 'Nome da unidade';
		if (strlen($val) > 255) { exit; }
		if (strlen($val) < 1) { exit; }
		$sql = 'UPDATE units SET name = "'.$val.'" WHERE id = '.$unit_id;
		break;
	case 'mz004':
		$skey = 'Nome curto da unidade';
		if (strlen($val) > 10) { exit; }
		if (strlen($val) < 1) { exit; }
		$sql = 'UPDATE units SET short_name = "'.$val.'" WHERE id = '.$unit_id;
		break;
	case 'mz005':
		$skey = 'Localização da unidade';
		if (strlen($val) > 255) { exit; }
		if (strlen($val) < 1) { exit; }
//		$sql = 'UPDATE unit_loc SET loc = "'.$val.'", date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_loc (loc,date,id_unit) VALUES("'.$val.'", "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz007':
		$skey = 'Distrito';
		if( is_nan($val) ) { exit; }
		$sql = 'UPDATE hierarchy_units_areas SET id_area = '.$val.' WHERE id_unit = '.$unit_id;
		break;
	case 'mz008':
		$skey = 'Posto Administrativo';
		if( is_nan($val) ) { exit; }
//		$sql = 'UPDATE unit_pa SET pa = "'.$val.'", date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_pa (pa,date,id_unit) VALUES("'.$val.'", "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz009':
		$skey = 'Localidade';
		if (strlen($val) > 255) { exit; }
		if (strlen($val) < 1) { exit; }
//		$sql = 'UPDATE unit_place SET place = "'.$val.'", date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_place (place,date,id_unit) VALUES("'.$val.'", "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz010':
		$skey = 'Endereço fisico';
		if (strlen($val) > 255) { exit; }
		if (strlen($val) < 1) { exit; }
//		$sql = 'UPDATE unit_address SET address = "'.$val.'", date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_code (address,date,id_unit) VALUES("'.$val.'", "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz011':
/*
CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `id_type` int(11) NOT NULL,
  `info` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `contact_type` (
  `id` int(11) NOT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `unit_contact` (
  `id_unit` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
		$skey = 'Informação de contacto'; 													// <------------- !!!!
		if (strlen($val) > 255) { exit; }
		if (strlen($val) < 1) { exit; }
		$sql = '';
		break;
	case 'mz006':
		$skey = 'Província'; 	// not allowed
		break;
	case 'mz012':
		$skey = 'Tipo de unidade';
		if( is_nan($val) ) { exit; }
//		$sql = 'UPDATE unit_unit_type SET id_type = '.$val.', date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_unit_type (id_type,date,id_unit) VALUES('.$val.', "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz013':
		$skey = 'Autoridade gestora';
		if( is_nan($val) ) { exit; }
//		$sql = 'UPDATE unit_unit_authority SET id_authority = '.$val.', date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_unit_authority (id_authority,date,id_unit) VALUES('.$val.', "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz014':
		$skey = 'Ministério de tutela';
		if( is_nan($val) ) { exit; }
//		$sql = 'UPDATE unit_ministry SET id_ministry = '.$val.', date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_ministry (id_ministry,date,id_unit) VALUES('.$val.', "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz015':
		$skey = 'Estado operacional';
		if( is_nan($val) ) { exit; }
//		$sql = 'UPDATE unit_unit_state SET id_state = '.$val.', date = "'.$today_mysql.'" WHERE id_unit = '.$unit_id;
		$sql = 'INSERT INTO unit_unit_state (id_state,date,id_unit) VALUES('.$val.', "'.$today_mysql.'", '.$unit_id.')';
		break;
	case 'mz023': 													// <------------- !!!!
		$skey = 'Tipos de serviços prestados';
		if( is_nan($val) ) { exit; }
		$sql = '';
		break;
	case 'mz022':
/*
CREATE TABLE `unit_cons_ext` (
  `id_unit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Consultas externas apenas (sem internamento)';
*/
		$skey = 'Consultas externas apenas';
		if($val > 1 || val < 0) { exit; }
		if($val = 0) {
			$sql = '';
		} else {
			$sql = '';
		}
		break;
	case 'mz016':
		$skey = 'Data de construção';
		if(! check_dd_mm_yyyy($val)) { exit; }
		$val = mmddyyyy_to_mysql ($val);
		$sql = 'UPDATE unit_dates SET build = "'.$val.'" WHERE id_unit = '.$unit_id;
		break;
	case 'mz017':
		$skey = 'Data de ínicio';
		if(! check_dd_mm_yyyy($val)) { exit; }
		$val = mmddyyyy_to_mysql ($val);
		$sql = 'UPDATE unit_dates SET first_fun = "'.$val.'" WHERE id_unit = '.$unit_id;
		break;
	case 'mz018':
		$skey = 'Data última requalificação';
		if(! check_dd_mm_yyyy($val)) { exit; }
		$val = mmddyyyy_to_mysql ($val);
		$sql = 'UPDATE unit_dates SET last_requal = "'.$val.'" WHERE id_unit = '.$unit_id;
		break;
	case 'mz019':
		$skey = 'Data do último estado operacional';
		if(! check_dd_mm_yyyy($val)) { exit; }
		$val = mmddyyyy_to_mysql ($val);
		$sql = 'UPDATE unit_dates SET last_oper = "'.$val.'" WHERE id_unit = '.$unit_id;
		break;
	case 'mz020':
		$skey = 'Data alteração de dados da Unidade de Saúde';
		if(! check_dd_mm_yyyy($val)) { exit; }
		$val = mmddyyyy_to_mysql ($val);
		$sql = 'UPDATE unit_dates SET alter_data = "'.$val.'" WHERE id_unit = '.$unit_id;
		break;
	case 'mz023_c': 													// <------------- !!!!
/*
CREATE TABLE `unit_unit_service` (
  `id_unit` int(11) NOT NULL,
  `id_service` int(11) NOT NULL,
  `date` date NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
		$skey = 'Tipos de serviços prestados';
		if (strlen($val) < 1) { exit; }
// iterate values
		$sql = '';
		break;
	case 'mz025':
		$skey = 'Altitude';
		if( is_nan($val) ) { exit; }
		$sql = 'UPDATE units_coord SET alt = '.$val.' WHERE id_unit = '.$unit_id;
		break;
	case 'mz026':
		$skey = 'Latitude';
		if( is_nan($val) ) { exit; }
		$sql = 'UPDATE units_coord SET lat = '.$val.' WHERE id_unit = '.$unit_id;
		break;
	case 'mz027':
		$skey = 'Longitude';
		if( is_nan($val) ) { exit; }
		$sql = 'UPDATE units_coord SET lon = '.$val.' WHERE id_unit = '.$unit_id;
		break;
}
try {
    $db = new PDO($sdsn, $user, $pass, $opts);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec($sql);
	echo '1';
} catch(PDOException $e) {
	file_put_contents('debug_sara_db_insert.txt', $sql." <br />\n ".$e, FILE_APPEND); // debug
	echo '0';
    die(0);
}

//----------------------------------------------------------------------------------------------------------------------
function check_dd_mm_yyyy ($sdate) {
	$pattern = 	'/^(?:(?:(?:(?:0[1-9]|1[0-9]|2[0-8])[\/](?:0[1-9]|1[012]))|(?:(?:29|30|31)[\/](?:0[13578]|1[02]))|(?:(?:29|30)[\/](?:0[4,6,9]|11)))[\/](?:19|[2-9][0-9])\d\d)|(?:29[\/]02[\/](?:19|[2-9][0-9])(?:00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96))$/';
	return preg_match($pattern, $sdate);
}
//----------------------------------------------------------------------------------------------------------------------
function mmddyyyy_to_mysql ($sdate) {
	$sdate_temp = str_replace('/', '-', $sdate);
	return date('Y-m-d', strtotime($sdate_temp));
}
//----------------------------------------------------------------------------------------------------------------------
?>










