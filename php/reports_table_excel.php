<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="../js/excelexportjs.js"></script>
<script type="text/javascript">
	$(function () {
		$('#bu_export').click(function(){
        	$("#stat_table").excelexportjs({
            	containerid: "stat_table",
				datatype: 'table'
	        });
        });
	});
</script>
<style type="text/css">
	body {
		font-family:Arial;
	}
	table {
		border-collapse:collapse;
		margin-bottom:6px;
		background-color:white;
	}
	table th {
		border:solid 1px black;padding:4px;
		background-color:grey;
		color:white;
	}
	table td {
		border:solid 1px black;padding:4px;
	}
	button {
		margin:10px;
	}
</style>
</head>
<body>

<button id="bu_export">Exportar tabela para Excel</button>


<?php

ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);
require 'kint/Kint.class.php';


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

$sql = 'SELECT MZ001 as "Código da unidade", CASE WHEN from_field_1.MZ003_n = 0 THEN MZ003 ELSE ( SELECT name FROM units WHERE units.id = from_field_1.MZ003_n ) END as "Nome da US", MZ004 as "Nome curto da unidade", MZ005 as "Localização da unidade", ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ006) as Província, CASE WHEN from_field_1.MZ007_n = 0 THEN MZ007 ELSE ( SELECT name FROM areas WHERE areas.id = from_field_1.MZ007_n ) END as Distrito, Mz008 as "Posto Administrativo", Mz009 as "Localidade", Mz010 as "Endereço físico", Mz011 as "Informação de contacto", (SELECT name FROM unit_type WHERE unit_type.id = from_field_1.MZ012 ) as "Tipo de unidade", (SELECT name FROM unit_authority WHERE unit_authority.id = from_field_1.MZ013 ) as "Autoridade gestora", (SELECT name FROM ministries WHERE ministries.id = from_field_1.MZ014 ) as "Ministério de Tutela", (SELECT name FROM unit_state WHERE unit_state.id = from_field_1.MZ015 ) as "Estado operacional", DATE_FORMAT(MZ016, "%d/%m/%Y") as "Data de construção", DATE_FORMAT(MZ017, "%d/%m/%Y") as "Data de início de funcionamento", DATE_FORMAT(MZ018, "%d/%m/%Y") as "Data da última requalificação", DATE_FORMAT(MZ019, "%d/%m/%Y") as "Data do último estado operacional", DATE_FORMAT(MZ020, "%d/%m/%Y") as "Data de alteração de dados da Unidade de Saúde", if(MZ022, "Sim", "Não") as "Consultas externas apenas (sem internamento)", MZ023_c as "Serviços", MZ025 as "Altitude (metros)", MZ026 as "Latitude (sistema WGS84)", MZ027 as "Longitude (sistema WGS84)" FROM from_field_1';

$tabquery = $db->query($sql);
$tabquery->setFetchMode(PDO::FETCH_ASSOC);
if ($tabquery->rowCount() < 1) { echo '<h1>A base de dados é vazia</h1>'; exit; }

echo '<table id="stat_table">';
echo '<thead>';
$i = 0;
foreach ($tabquery as $record) {
	echo '<tr>' ;
	foreach ($record as $key => $row) {
		if ($i==0) {
			echo '<th>' . $key . '</th>';
		} else {
			if ($key=='Serviços') {
				echo '<td style="font-size:xx-small;">' . services($db,$row) . '</td>' ;
			} else {
				echo '<td>' . $row . '</td>' ;
			}
		}
	}
	echo '</tr>' ;
	if ($i==0) { echo '</thead><tbody>' ; }
	$i++;
}
echo '</thead><tbody>' ;

//echo '<hr />';
//!Kint::dump( $count_merged );


function services ($db,$commalist) {
	$services = [];
	$alist = explode(',',$commalist);
	foreach ($alist as $numserv) {
		$sql = 'SELECT unit_service.name FROM unit_service WHERE unit_service.id = ' . $numserv ;
		$tabquery = $db->query($sql);
		$tabquery->setFetchMode(PDO::FETCH_ASSOC);
		$tabres = $tabquery->fetch();
		$services[] = $tabres['name'];
	}
	$sservices = implode('<br />',$services);
	return $sservices;
}

?>
</body>
</html>
