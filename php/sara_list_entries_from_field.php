<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
	        var curfile = window.location.href;

    	    $('tbody > tr').click(function(){
				var id = this.id;
				if (curfile.indexOf('?') == -1) { window.location.href = curfile+'?n='+id; }
        	});

		});
	</script>
	<style>
		body {
			font-family:Arial;
		}
		table {
			border-collapse:collapse;
		}
		td {
		    border:solid 1px black;
		    padding:6px;
		}
		tbody > tr:hover {
			background-color:yellow;
			cursor:
		}
	</style>
</head>
<body>

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

$fields = [];
$fields_mz200 = [];
$sql = 'SHOW COLUMNS FROM from_field_1';
$tabquery = $db->query($sql);
$tabquery->setFetchMode(PDO::FETCH_ASSOC);
$rows = $tabquery->fetchAll();
foreach ($rows as $row) {
	if ( substr($row['Field'],0,5) == 'mz200' ) {
		array_push($fields_mz200,$row['Field']);
	}
}
$s_fields = implode(', ',$fields_mz200);

//echo '<hr />' . $s_fields . '<hr />'; //     <----- test


if (check_get('n')) {
	$curphp = strtok('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'?');
	$id_field = $_GET['n'];


	$sql = 'SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, MZ001 as "Código da unidade", MZ003 as "Nome da unidade", MZ004 as "Nome curto da unidade", MZ005 as "Localização da unidade", ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, Mz008 as "Posto Administrativo", Mz009 as "Localidade", Mz010 as "Endereço físico", Mz011 as "Informação de contacto", (SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade", (SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora", (SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela", (SELECT name FROM unit_state WHERE unit_state.id = from_field_1.MZ015 ) as "Estado operacional", DATE_FORMAT(MZ016, "%d/%m/%Y") as "Data de construção", DATE_FORMAT(MZ017, "%d/%m/%Y") as "Data de início de funcionamento", DATE_FORMAT(MZ018, "%d/%m/%Y") as "Data da última requalificação", DATE_FORMAT(MZ019, "%d/%m/%Y") as "Data do último estado operacional", DATE_FORMAT(MZ020, "%d/%m/%Y") as "Data de alteração de dados da Unidade de Saúde", if(MZ022, "Sim", "Não") as "Consultas externas apenas (sem internamento)", MZ023_c as "Tipos de serviços prestados", MZ025 as "Altitude (metros)", MZ026 as "Latitude (sistema WGS84)", MZ027 as "Longitude (sistema WGS84)", ' . $s_fields . ' FROM from_field_1 WHERE id = '.$id_field;

	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$row = $tabquery->fetch();

	$form = '<h3>Ficha '.$row['id'].'</h3>';
	$form .= '<table><tbody>';
	$trs_service = '';
	$trs_mz200 = '<tr><td colspan="2" style="font-weight:bold;">Pessoal</td></tr>';
	$count200 = 0;

	foreach ($row as $k => $v) {
		if ($k == 'Tipos de serviços prestados') {
			$a_serv = explode(',', $v);
			$trs_service .= '<tr><td colspan="2">Tipos de serviços prestados</td>';
			foreach ($a_serv as $row_v_serv) {
				$sql_serv = 'SELECT name FROM unit_service WHERE id = '. $row_v_serv;
				$tabquery_serv = $db->query($sql_serv);
				$tabquery_serv->setFetchMode(PDO::FETCH_ASSOC);
				$row_serv = $tabquery_serv->fetch();
				$trs_service .= '<tr><td></td><td>'.$row_serv['name'].'</td>';
			}
			$form .= $trs_service."\n";
			continue;
		}

		if ( substr($k,0,5) == 'mz200' ) {
			if ( $v > 0 ) {
				if ($count200==0) { $form .= '<tr style="background-color:lightgrey;text-align:center;">'.
					'<td colspan="2">Secção 2A - Pessoal (MZ200)</td></tr>'."\n"; }
				$mz200_code = substr($k,6,5);
				$mz200_time = (substr($k,12,2)=='TI')?'Tempo inteiro':'Tempo parcial';
				$mz200_nat = (substr($k,15,1)=='N')?'Nacional':'Estrangeiro';
				$mz200_sex = (substr($k,16,1)=='M')?'Homem':'Mulher';
				$sql_mz200 = 'SELECT name FROM personnel WHERE code = "'. $mz200_code . '"';
				$tabquery_mz200 = $db->query($sql_mz200);
				$tabquery_mz200->setFetchMode(PDO::FETCH_ASSOC);
				$row_mz200 = $tabquery_mz200->fetch();
				$form .= '<tr><td>'.$row_mz200['name'].', '.$mz200_time.', '.$mz200_nat.', '.$mz200_sex.'</td><td>'.$v.'</td></tr>'."\n";
				$count200++;
			}
		continue;
		}
		
		$form .= '<tr><td>'.$k.'</td><td>'.$v.'</td></tr>'."\n";

	}

	$form .= '</tbody></table>';
	$form .= '<p><a href="'.$curphp.'">Voltar à lista</a></p>';

	echo $form;


} else {
	$curphp = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?n=';
	$sql = 'SELECT id, (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, DATE_FORMAT(in_date, "%d/%m/%Y") as Data, ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, MZ007 as Distrito, MZ003 as "Nome da US" FROM from_field_1 ORDER BY in_date';
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$rows = $tabquery->fetchAll();
	echo '<h3>Lista de entradas por ordem cronológica</h3>';
	echo '<table><thead><tr><th></th><th>Usuário</th><th>Data</th><th>Província</th><th>Distrito</th><th>Nome da US</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		echo '<tr id="'.$row['id'].'"><td>';
		echo implode('</td><td>',$row);
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

</body>
</html>
