<?php

$localhosts = array('127.0.0.1','localhost','::1','8888');
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

$ts = '<td style="border: solid 1px black;">';
$tdsel = '<td><select><option value="0" selected="selected">Validar</option><option value="1">Rejeitar</option><option value="2">Amalgamar</option></select></td>';

if (check_get('n')) {

	$ta = '<table id="single_entry_form_table" style="border-collapse:collapse;font-size:x-small;margin:10px auto;">';
	$id_field = $_GET['n'];

	$sql = 'SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, MZ001 as "Código da unidade", MZ003 as "Nome da unidade", MZ004 as "Nome curto da unidade", MZ005 as "Localização da unidade", ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, Mz008 as "Posto Administrativo", Mz009 as "Localidade", Mz010 as "Endereço físico", Mz011 as "Informação de contacto", (SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade", (SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora", (SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela", (SELECT name FROM unit_state WHERE unit_state.id = from_field_1.MZ015 ) as "Estado operacional", DATE_FORMAT(MZ016, "%d/%m/%Y") as "Data de construção", DATE_FORMAT(MZ017, "%d/%m/%Y") as "Data de início de funcionamento", DATE_FORMAT(MZ018, "%d/%m/%Y") as "Data da última requalificação", DATE_FORMAT(MZ019, "%d/%m/%Y") as "Data do último estado operacional", DATE_FORMAT(MZ020, "%d/%m/%Y") as "Data de alteração de dados da Unidade de Saúde", if(MZ022, "Sim", "Não") as "Consultas externas apenas (sem internamento)", MZ023_c as "Tipos de serviços prestados", MZ025 as "	Altitude (metros)", MZ026 as "Latitude (sistema WGS84)", MZ027 as "Longitude (sistema WGS84)"
FROM from_field_1 WHERE id = '.$id_field;

	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$row = $tabquery->fetch();

	$form_top = $ta.'<tbody>';
	$trs_service = '';
	$form_bottom = '';
	$break_line = false;
	$v_serv = '';
	$select_valid = '<select>'.
					'<option value="0">Validar</option>'.
					'<option value="1">Rejeitar</option>'.
					'<option value="2">Amalgamar</option>'.
					'</select>';

	$selcount = 0;
	foreach ($row as $k => $v) {
		$selcount++;
		$line = '<tr><td></td>'.$ts.$k.'</td>'.$ts.$v.'</td><td></td></tr>'."\n";
		$linesel = '<tr>'.$ts.'&bull;</td>'.$ts.$k.'</td>'.$ts.$v.'</td>'.$ts.$select_valid.'</td></tr>'."\n";
		if ($k == 'Tipos de serviços prestados') {
			$break_line = true;
			$v_serv = $v;
			continue;
		}
		if ($break_line) {
			$form_bottom .= ($selcount<4)?$line:$linesel;
		} else {
			$form_top .= ($selcount<4)?$line:$linesel;
		}
	}

	if ($break_line) {
		$a_serv = explode(',', $v_serv);
		$a_serv_text = [];
		$tit_serv = '<td colspan="2" style="border: solid 1px black;">Tipos de serviços prestados</td>';
		$trs_service .= '<tr>'.$ts.'&bull;</td>'.$tit_serv.'<td>'.$select_valid.'</td>';
		foreach ($a_serv as $v) {
			$sql = 'SELECT name FROM unit_service WHERE id = '. $v;
			$tabquery = $db->query($sql);
			$tabquery->setFetchMode(PDO::FETCH_ASSOC);
			$row = $tabquery->fetch();
			$a_serv_text[] = $row['name'];
			$trs_service .= '<tr><td style="border: solid 1px black;" colspan="3">'.$row['name'].'<td></td>';
		}
	}

	$form_bottom .= '</tbody></table>';

	echo $form_top;
	echo $trs_service;
	echo $form_bottom;

} else {  // if (check_get('n'))

	$ta = '<table id="collective_entry_form_table" style="border-collapse:collapse;font-size:x-small;margin:10px auto;">';

	$sql = 'SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, MZ003 as "Nome da US" FROM from_field_1 ORDER BY in_date';
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$rows = $tabquery->fetchAll();
	echo $ta.'<thead><tr><th>Id</th><th>Usuário</th><th>Data</th><th>Província</th><th>Distrito</th>'.
				'<th>Nome da US</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		echo '<tr>'.$ts;
		echo implode('</td>'.$ts,$row);
		echo '</td></tr>';
	}
	echo '</tbody></table>';
	echo '<p>Clicar a linha para visualizar a ficha</p>';
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