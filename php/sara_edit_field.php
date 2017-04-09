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

// echo '<pre>'; print_r($_GET); echo '</pre>'; exit; // debug

$fn = $_GET['fn'];
$id = $_GET['id'];

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
    die('Problemas de conexão à base de dados');
}

$fd = '';
$top_label = '<label style="width:100%;float:left;margin-left:4px;">'.strtoupper($fn).'</label>';
$ini_label = '<label style="width:100%;float:left;margin-left:4px;">Novo valor para ';
$end_label = '</label>';
$single_text_input = '<input class="sara_edit_field_chosen_value" style="width:100%;float:left;margin-left:4px;margin-top:6px;" type="text" value="" />';
$single_integer_input = '<input class="sara_edit_field_chosen_value" style="width:40%;float:left;margin-left:4px;margin-top:6px;" type="number" step="1" min="0" value="" />';
$single_float_input = '<input class="sara_edit_field_chosen_value" style="width:40%;float:left;margin-left:4px;margin-top:6px;" type="number" min="0" value="" />';
$single_date_input = '(dd/mm/aaaa)<br /><input class="sara_edit_field_chosen_value" style="width:40%;float:left;margin-left:4px;margin-top:6px;" type="text" />';
$naosim = '<select class="sara_edit_field_chosen_value" style="width:100%;float:left;margin-left:4px;margin-top:6px;"><option value="0">Não</option><option value="1">Sim</option></select>';
$explicamulti = '<span style="width:100%;float:left;margin-left:4px;margin-top:6px;font-size:x-small;">Windows an Linux: ctrl-clik, Mac: cmd-click para escolha multipla</span>';
$button = '<button style="width:100%;float:left;margin-left:4px;margin-top:6px;" id="bu_sara_edit_'.$fn.'" class="bu_sara_edit">Gravar</button>';

switch ($fn) {
    case 'mz001':
		$fd = 'Código';
		echo $top_label.$ini_label.$fd.$end_label.$single_text_input.$button;
		break;
    case 'mz003':
		$fd = 'Nome';
		echo $top_label.$ini_label.$fd.$end_label.$single_text_input.$button;
		break;
    case 'mz004':
		$fd = 'Nome curto';
		echo $top_label.$ini_label.$fd.$end_label.$single_text_input.$button;
		break;
    case 'mz005':
		$fd = 'Localização';
		echo $top_label.$ini_label.$fd.$end_label.$single_text_input.$button;
		break;
    case 'mz006': // Province cannot be modified
		echo 'A província pode ser modificada só pelo administrador de sistema';
//		$fd = 'Província';
//		echo $top_label.$ini_label.$fd.$end_label;
//		echo querytoselect($db,'SELECT id, name FROM areas WHERE id > 1 AND id < 13',0);
//		echo $button;
		break;
    case 'mz007': // district is modified only on the already chosen province
		$fd = 'Distrito'; // deve dipendere da mz006 !
		echo $top_label.$ini_label.$fd.$end_label;
		echo querytoselect($db,'SELECT areas.id, areas.name FROM areas WHERE areas.id IN (SELECT hierarchy_areas_areas.id FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id_up IN (SELECT hierarchy_areas_areas.id_up FROM hierarchy_areas_areas WHERE hierarchy_areas_areas.id IN (SELECT hierarchy_units_areas.id_area FROM hierarchy_units_areas WHERE hierarchy_units_areas.id_unit = '.$id.')))',0);
		echo $button;
		break;
    case 'mz008':
		$fd = 'Posto Administrativo';
		echo $top_label.$ini_label.$fd.$end_label.$single_text_input.$button;
		break;
    case 'mz009':
		$fd = 'Localidade';
		echo $top_label.$ini_label.$fd.$end_label.$single_text_input.$button;
		break;
    case 'mz010':
		$fd = 'Endereço físico';
		echo $top_label.$ini_label.$fd.$end_label.$single_text_input.$button;
		break;
    case 'mz011':
		$fd = 'Informação de contacto';									// <------------ !!!!
		echo '';
		break;
    case 'mz012':
		$fd = 'Tipos de unidades';
		echo $top_label.$ini_label.$fd.$end_label;
		echo querytoselect($db,'SELECT id, name FROM unit_type',0);
		echo $button;
		break;
    case 'mz013':
		$fd = 'Autoridade gestora';
		echo $top_label.$ini_label.$fd.$end_label;
		echo querytoselect($db,'SELECT id, name FROM unit_authority',0);
		echo $button;
		break;
    case 'mz014':
		$fd = 'Ministério de Tutela';
		echo $top_label.$ini_label.$fd.$end_label;
		echo querytoselect($db,'SELECT id, name FROM ministries',0);
		echo $button;
		break;
    case 'mz015':
		$fd = 'Estado operacional';
		echo $top_label.$ini_label.$fd.$end_label;
		echo querytoselect($db,'SELECT id, name FROM unit_state',0);
		echo $button;
		break;
    case 'mz016':
		$fd = 'Data de construção';
		echo $top_label.$ini_label.$fd.$end_label.$single_date_input.$button;
		break;
    case 'mz017':
		$fd = 'Data de início de funcionamento';
		echo $top_label.$ini_label.$fd.$end_label.$single_date_input.$button;
		break;
    case 'mz018':
		$fd = 'Data da última requalificação';
		echo $top_label.$ini_label.$fd.$end_label.$single_date_input.$button;
		break;
    case 'mz019':
		$fd = 'Data do último estado operacional';
		echo $top_label.$ini_label.$fd.$end_label.$single_date_input.$button;
		break;
    case 'mz020':
		$fd = 'Data de alteração de dados da Unidade de Saúde';
		echo $top_label.$ini_label.$fd.$end_label.$single_date_input.$button;
		break;
    case 'mz022':
		$fd = 'Consultas externas apenas (sem internamento)';
		echo $top_label.$ini_label.$fd.$end_label;
		echo $naosim;
		echo $button;
		break;
    case 'mz023':
		$fd = 'Tipos de serviços prestados';
		echo $top_label.$ini_label.$fd.$end_label;
		echo $explicamulti;
		echo querytoselect($db,'SELECT id, name FROM unit_service',1);
		echo $button;
		break;
    case 'mz025':
		$fd = 'Altitude';
		echo $top_label.$ini_label.$fd.$end_label.$single_integer_input.$button;
		break;
    case 'mz026':
		$fd = 'Latitude';
		echo $top_label.$ini_label.$fd.$end_label.$single_float_input.$button;
		break;
    case 'mz027':
		$fd = 'Longitude';
		echo $top_label.$ini_label.$fd.$end_label.$single_float_input.$button;
		break;
	default:
		echo '';
		break;
}
//----------------------------------------------------------------------------------------------------------------------
function querytoselect($db,$sql,$multi) {
	if ($multi) {
		$select = '<select class="sara_edit_field_chosen_value" multiple="multiple"'.
			' style="width:100%;float:left;margin-left:4px;margin-top:6px;">';
	} else {
		$select = '<select class="sara_edit_field_chosen_value"'.
			' style="width:100%;float:left;margin-left:4px;margin-top:6px;">';
	}
	$tabquery = $db->query($sql);
	$rows = $tabquery->fetchAll();
	foreach ($rows as $row) {
		$select .= '<option value="'.$row['id'].'">'.htmlspecialchars($row['name']).'</option>';
	}
	$select .= '</select>';
	return $select;
}
//----------------------------------------------------------------------------------------------------------------------
?>









