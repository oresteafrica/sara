<?php

if ( check_get('m') ) { $menu = $_GET['m']; } else { exit; }

$localhosts = array(
    '127.0.0.1',
    'localhost',
	'::1'
);
$debug = false;
if(in_array($_SERVER['REMOTE_ADDR'], $localhosts)) {
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);
require 'kint/Kint.class.php';
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

$sql = 'SELECT * FROM from_field_1';
$graph_title = 'All data from field';
$graph_subtitle = '';
$graph_yAxis_title = '';
$graph_series_color = 'black';
$graph_series_name = '';
$field_names = [];
$provs = ['','','Niassa','Cabo Delgado','Nampula','Tete','Zambezia','Manica','Sofala','Gaza','Inhambane','Maputo Cidade','Maputo'];
$sql_ter_dis = ['SELECT (SELECT areas.name FROM areas WHERE areas.id = from_field_1.mz007_n) AS ',
	', COUNT(mz007_n) as ', ' FROM from_field_1 WHERE mz006 = ', ' GROUP BY mz007_n ORDER BY mz007_n DESC'];
$sql_tip_dis = ['SELECT (SELECT unit_type.name FROM unit_type WHERE unit_type.id = from_field_1.mz012) AS ',
	', COUNT(mz012) as ',' FROM from_field_1 WHERE mz006 = ',' GROUP BY mz012 ORDER BY mz012 DESC'];
$sql_aut_dis = ['SELECT  '.
	'(SELECT unit_authority.name FROM unit_authority WHERE unit_authority.id = from_field_1.mz013) AS ',
	', COUNT(mz013) as ',' FROM from_field_1 WHERE mz006 = ',' GROUP BY mz013 ORDER BY mz013 DESC'];
$sql_min_dis = ['SELECT  '.
	'(SELECT ministries.name FROM ministries WHERE ministries.id = from_field_1.mz014) AS ',
	', COUNT(mz014) as ',' FROM from_field_1 WHERE mz006 = ',' GROUP BY mz014 ORDER BY mz014 DESC'];
$sql_est_dis = ['SELECT  '.
	'(SELECT unit_state.name FROM unit_state WHERE unit_state.id = from_field_1.mz015) AS ',
	', COUNT(mz015) as ',' FROM from_field_1 WHERE mz006 = ',' GROUP BY mz015 ORDER BY mz015 DESC'];
$sql_ser_dis = [];

switch ( $menu ) {
	//------ território---------------------
	case 'sara_report_ter_provs':
		$field_names = ['Províncias','Num'];
		$sql = 'SELECT (SELECT areas.name FROM areas WHERE areas.id = from_field_1.mz006) AS ' . 
				$field_names[0] .
				', COUNT(mz006) as '.
				$field_names[1] .
				' FROM from_field_1 GROUP BY mz006 ORDER BY ' . $field_names[1] . ' DESC';
		$graph_title = 'Número de fichas por província';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_nias':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '2' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Niassa';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_cabo':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '3' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Cabo Delgado';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_namp':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '4' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Nampula';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_tete':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '5' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Tete';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_zamb':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '6' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos da Zambézia';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_mani':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '7' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Manica';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_sofa':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '8' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Sofala';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_gaza':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '9' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Gaza';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_inha':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '10' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Inhambane';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_mapc':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '11' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Maputo Cidade';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ter_dist_mapd':
		$field_names = ['Distritos','Num'];
		$sql = $sql_ter_dis[0] . $field_names[0] . $sql_ter_dis[1] . $field_names[1] . 
				$sql_ter_dis[2] . '12' . $sql_ter_dis[3];
		$graph_title = 'Número de fichas por Distritos de Maputo Província';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	//------ tipologia---------------------
	case 'sara_report_tip_moz' :
		$field_names = ['Tipologia','Num'];
		$sql = 'SELECT (SELECT unit_type.name FROM unit_type WHERE unit_type.id = from_field_1.mz012) AS ' .
			$field_names[0] . ', COUNT(mz012) as ' . 
			$field_names[1] . ' FROM from_field_1 GROUP BY mz012 ORDER BY mz012';
		$graph_title = 'Tipologia Moçambique';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_provs' :
		$field_names = ['Províncias','Num'];
		$sql = '';
		$graph_title = '';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_nias' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '2' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Niassa';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_cabo' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '3' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Cabo Delgado';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_namp' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '4' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Nampula';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_tete' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '5' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Tete';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_zamb' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '6' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província da Zambézia';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_mani' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '7' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Manica';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_sofa' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '8' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Sofala';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_gaza' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '9' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Gaza';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_inha' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '10' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Inhambane';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_mapc' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '11' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Maputo Cidade';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_tip_dist_mapd' :
		$field_names = ['Tipologia','Num'];
		$sql = $sql_tip_dis[0] . $field_names[0] . $sql_tip_dis[1] . $field_names[1] . 
				$sql_tip_dis[2] . '12' . $sql_tip_dis[3];
		$graph_title = 'Tipologia província de Maputo';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	//------ autoridade---------------------
	case 'sara_report_aut_moz' :
		$field_names = ['Moçambique','Num'];
		$sql = 'SELECT' .
			'(SELECT unit_authority.name FROM unit_authority WHERE unit_authority.id = from_field_1.mz013) AS ' .
			$field_names[0] . ', COUNT(mz013) as ' . 
			$field_names[1] . ' FROM from_field_1 GROUP BY mz013 ORDER BY mz013';
		$graph_title = 'Autoridade Moçambique';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_nias' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '2' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[2];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_cabo' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '3' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[3];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_namp' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '4' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[4];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_tete' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '5' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[5];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_zamb' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '6' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[6];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_mani' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '7' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[7];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_sofa' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '8' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[8];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_gaza' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '9' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[9];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_inha' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '10' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[10];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_mapc' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '11' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[11];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_aut_dist_mapd' :
		$field_names = ['Autoridade','Num'];
		$sql = $sql_aut_dis[0] . $field_names[0] . $sql_aut_dis[1] . $field_names[1] . 
				$sql_aut_dis[2] . '12' . $sql_aut_dis[3];
		$graph_title = 'Autoridade província de ' . $provs[12];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	//------ ministério---------------------
	case 'sara_report_min_moz' :
		$field_names = ['Moçambique','Num'];
		$sql = 'SELECT' .
			'(SELECT ministries.name FROM ministries WHERE ministries.id = from_field_1.mz014) AS ' .
			$field_names[0] . ', COUNT(mz014) as ' . 
			$field_names[1] . ' FROM from_field_1 GROUP BY mz014 ORDER BY mz014';
		$graph_title = 'Ministério de tutela Moçambique';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_nias' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '2' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[2];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_cabo' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '3' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[3];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_namp' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '4' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[4];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_tete' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '5' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[5];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_zamb' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '6' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[6];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_mani' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '7' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[7];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_sofa' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '8' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[8];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_gaza' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '9' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[9];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_inha' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '10' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[10];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_mapc' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '11' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[11];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_min_dist_mapd' :
		$field_names = ['Ministério','Num'];
		$sql = $sql_min_dis[0] . $field_names[0] . $sql_min_dis[1] . $field_names[1] . 
				$sql_min_dis[2] . '12' . $sql_min_dis[3];
		$graph_title = 'Ministério de tutela província de ' . $provs[12];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	//------ estado---------------------
	case 'sara_report_est_moz' :
		$field_names = ['Moçambique','Num'];
		$sql = 'SELECT' .
			'(SELECT unit_state.name FROM unit_state WHERE unit_state.id = from_field_1.mz015) AS ' .
			$field_names[0] . ', COUNT(mz015) as ' . 
			$field_names[1] . ' FROM from_field_1 GROUP BY mz015 ORDER BY mz015';
		$graph_title = 'Estado funcional Moçambique';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_nias' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '2' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[2];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_cabo' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '3' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[3];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_namp' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '4' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[4];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_tete' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '5' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[5];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_zamb' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '6' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[6];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_mani' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '7' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[7];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_sofa' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '8' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[8];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_gaza' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '9' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[9];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_inha' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '10' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[10];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_mapc' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '11' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[11];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_est_dist_mapd' :
		$field_names = ['Estado','Num'];
		$sql = $sql_est_dis[0] . $field_names[0] . $sql_est_dis[1] . $field_names[1] . 
				$sql_est_dis[2] . '12' . $sql_est_dis[3];
		$graph_title = 'Estado funcional província de ' . $provs[12];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	//------ serviço---------------------
	case 'sara_report_ser_moz' :
		$field_names = ['Moçambique','Num'];
		$sserv = Frequency_of_services ($db, 0);
		$graph_title = 'Serviços Moçambique';
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_nias' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 2);
		$graph_title = 'Serviços província de ' . $provs[2];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_cabo' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 3);
		$graph_title = 'Serviços província de ' . $provs[3];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_namp' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 4);
		$graph_title = 'Serviços província de ' . $provs[4];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_tete' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 5);
		$graph_title = 'Serviços província de ' . $provs[5];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_zamb' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 6);
		$graph_title = 'Serviços província de ' . $provs[6];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_mani' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 7);
		$graph_title = 'Serviços província de ' . $provs[7];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_sofa' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 8);
		$graph_title = 'Serviços província de ' . $provs[8];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_gaza' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 9);
		$graph_title = 'Serviços província de ' . $provs[9];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_inha' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 10);
		$graph_title = 'Serviços província de ' . $provs[10];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_mapc' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 11);
		$graph_title = 'Serviços província de ' . $provs[11];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	case 'sara_report_ser_dist_mapd' :
		$field_names = ['Serviço','Num'];
		$sserv = Frequency_of_services ($db, 12);
		$graph_title = 'Serviços província de ' . $provs[12];
		$graph_subtitle = '';
		$graph_yAxis_title = $field_names[1] ;
		$graph_series_color = 'red';
		$graph_series_name = $field_names[0] ;
		break;
	default:
		echo $menu;
		exit;
}
$tot_unit = 0;
$cat = [];
$ser = [];
if (substr($menu,0,15) == 'sara_report_ser') {
	foreach ($sserv as $item) {
	    $tot_unit += $item[1];
		$cat[] = $item[0];
		$ser[] = $item[1];
	}
} else {
	$arraydb = create_array_from_tables ($db, $sql);
	foreach ($arraydb as $item) {
	    $tot_unit += $item[$field_names[1]];
		$cat[] = $item[$field_names[0]];
		$ser[] = $item[$field_names[1]];
	}
}
$categories = implode($cat,'\',\'');
$categories = "'" . $categories . "'" ;
$serie = implode($ser,',');

// debug
//file_put_contents('debug_stats.txt', $graph_title . "\n" . $categories . "\n" . $serie);
//file_put_contents('debug_stats.txt', $sql);


//----------------------------------------------------------------------------------------------------------
function create_array_from_tables ($db, $sql) {
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	if ($tabquery->rowCount() < 1) { echo '<h1>A base de dados é vazia</h1>'; exit; }
	$array_table = [];
	foreach ($tabquery as $tabres) {
		array_push($array_table, $tabres);
	}
	return $array_table;
}
//----------------------------------------------------------------------------------------
function Frequency_of_services ($db, $area) {
	if ($area==0) {
		$sql = 'SELECT from_field_1.mz023_c FROM from_field_1';
	} else {
		$sql = 'SELECT from_field_1.mz023_c FROM from_field_1 WHERE mz006 = ' . $area;
	}
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	if ($tabquery->rowCount() < 1) { echo '<h1>A base de dados é vazia</h1>'; exit; }
	$array_table = [];
	foreach ($tabquery as $tabres) {
		array_push($array_table, $tabres);
	}
	$merged = [];
	foreach ($array_table as $v) {
	$s = implode(',',$v);
	$arrn = explode(',',$s);
		foreach ($arrn as $n) {
			$merged[] = $n;
		}
	}
	$count_merged = array_count_values($merged);
	$service_calculated_frequency = [];
	foreach ($count_merged as $service_number => $service_frequency) {
		$sql = 'SELECT unit_service.name FROM unit_service WHERE unit_service.id = ' . $service_number ;
		$tabquery = $db->query($sql);
		$tabquery->setFetchMode(PDO::FETCH_ASSOC);
		$tabres = $tabquery->fetch();
		$service_calculated_frequency[] = [$tabres['name'], $service_frequency];
	}
	return $service_calculated_frequency;
}
//----------------------------------------------------------------------------------------
function check_get ($var) {
	if(!isset($_GET[$var])) { return false; }
	if($_GET[$var] === '') { return false; }
	if($_GET[$var] === false) { return false; }
	if($_GET[$var] === null) { return false; }
	if(empty($_GET[$var])) { return false; }
	return true;
}
//----------------------------------------------------------------------------------------
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="../js/highcharts.js"></script>
<script type="text/javascript" src="../js/exporting.js"></script>
<script type="text/javascript" src="../js/excelexportjs.js"></script>
<script type="text/javascript">
$(function () {
//----------------------------------------------------------------------------------------------------------------------
	$('#bu_export').click(function(){
		var url = '../php/download_excel.php';
		var dom = $('#stat_table').prop('outerHTML');		
		var data = 'h='+dom;
		var urldata = url + '?' + data;

        $("#stat_table").excelexportjs({
            containerid: "stat_table"
            , datatype: 'table'
        });


	});
//----------------------------------------------------------------------------------------------------------------------
	$('#div_chart').highcharts({
	chart: {
    	        type: 'column'
    	    },
        	title: {
            	text: '<?php echo $graph_title; ?>'
	        },
    	    subtitle: {
        	    text: '<?php echo $graph_subtitle; ?>'
        	},
        	xAxis: {
            	categories: [ <?php echo $categories; ?> ],
            	crosshair: true
        	},
        	yAxis: {
            	min: 0,
            	title: {
                	text: '<?php echo $graph_yAxis_title; ?>'
            	}
        	},
        	plotOptions: {
            	column: {
                	pointPadding: 0.2,
	                borderWidth: 0
    	        },
        	series: {
	            color: '<?php echo $graph_series_color; ?>'
    	    }
        	},
        	series: [{
            	name: '<?php echo $graph_series_name; ?>',
            	data: [ <?php echo $serie; ?> ]
        	}]
    	});
//----------------------------------------------------------------------------------------------------------------------
});
</script>
<style type="text/css">
	body {
		font-family:Arial;
	}
	#main {
		width:100%;
	}
	#div_chart {
		width:100%;
		float:left;
		margin-bottom:10px;
	}
	#div_table {
		width:100%;
		float:left;
		margin-bottom:10px;
	}
	#stat_table {
		border-collapse:collapse;
		margin-bottom:6px;
		background-color:white;
	}
	#stat_table th {
		border:solid 1px black;padding:4px;
		background-color:grey;
		color:white;
	}
	#stat_table td {
		border:solid 1px black;padding:4px;
	}
</style>
</head>
<body>
<div id="main">
<div id="div_chart"></div>
<div id="div_table">
<table id="stat_table"><thead>
<?php
echo '<tr>' ;
echo '<th>' . $graph_title . '</th>' ;
echo '<th>' . $graph_yAxis_title . '</th>' ;
echo '</tr>' ;
echo '</thead><tbody>' ;
if (substr($menu,0,15) == 'sara_report_ser') {
	foreach ($sserv as $item) {
		echo '<tr>' ;
		echo '<td>' . $item[0] . '</td>' ;
		echo '<td>' . $item[1] . '</td>' ;
		echo '</tr>' ;
	}
} else {
	foreach ($arraydb as $item) {
		echo '<tr>' ;
		echo '<td>' . $item[$field_names[0]] . '</td>' ;
		echo '<td>' . $item[$field_names[1]] . '</td>' ;
		echo '</tr>' ;
	}
}
?>
</tbody></table>
<button id="bu_export">Exportar tabela para Excel</button>
</div>
<div id="div_debug">
<?php
if ($debug) {
	echo '<hr />';
	!Kint::dump( $arraydb );
	echo '<hr />';
	echo '$serie = '. $serie;
	echo '<br />';
	echo '$categories = '. $categories;
	echo '<br />';
	echo '$graph_title = '. $graph_title;
	echo '<br />';
	echo '$graph_subtitle = '. $graph_subtitle;
	echo '<br />';
	echo '$graph_yAxis_title = '. $graph_yAxis_title;
	echo '<br />';
	echo '$graph_series_color = '. $graph_series_color;
	echo '<br />';
	echo '$graph_series_name = '. $graph_series_name;
	echo '<hr />';
	echo '$tot_unit = '.$tot_unit;
	echo '<hr />';
	echo $categories;
	echo '<hr />';
	exit;
}
?>
</div>
</div>
</body>
</html>
