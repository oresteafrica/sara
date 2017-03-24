<?php
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

$sql = 'SELECT (SELECT name FROM officer WHERE officer.id = from_field_1.op_id) as Usuário, COUNT(op_id) as Num FROM from_field_1 GROUP BY op_id ORDER BY Usuário';

$entries_count_per_user = create_array_from_tables ($db, $sql);

$tot_unit = 0;
$cat = [];
$ser = [];
foreach ($entries_count_per_user as $item) {
    $tot_unit += $item['Num'];
	$cat[] = $item['Usuário'];
	$ser[] = $item['Num'];
}
$categories = implode($cat,'\',\'');
$categories = "'" . $categories . "'" ;
$serie = implode($ser,',');

if ($debug) {
echo '<hr />';
!Kint::dump( $unit_count_per_user );
echo '<hr />';
echo '$tot_unit = '.$tot_unit;
echo '<hr />';
echo $categories;
echo '<hr />';
exit;
}

$sql = 'SELECT (SELECT areas.name FROM areas WHERE areas.id = from_field_1.mz006) AS Províncias, COUNT(mz006) as Num FROM from_field_1 GROUP BY mz006 ORDER BY mz006';

$entries_count_per_province = create_array_from_tables ($db, $sql);

$tot_unit_2 = 0;
$cat_2 = [];
$ser_2 = [];
foreach ($entries_count_per_province as $item) {
    $tot_unit_2 += $item['Num'];
	$cat_2[] = $item['Províncias'];
	$ser_2[] = $item['Num'];
}
$categories_2 = implode($cat_2,'\',\'');
$categories_2 = "'" . $categories_2 . "'" ;
$serie_2 = implode($ser_2,',');

if ($debug) {
echo '<hr />';
!Kint::dump( $unit_count_per_province );
echo '<hr />';
echo '$tot_unit_2 = '.$tot_unit_2;
echo '<hr />';
echo $categories_2;
echo '<hr />';
exit;
}


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
//----------------------------------------------------------------------------------------------------------
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Desempenho</title>
<script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
<style type="text/css">
	body {
		font-family:Arial;
	}
	#main {
		width:100%;
	}
	.divchart {
		width:80%;
		float:left;
		margin-bottom:60px;
	}
</style>
<script type="text/javascript">
$(function () {
//----------------------------------------------------------------------------------------------------------------------
$('#div01').highcharts({
chart: {
            type: 'column'
        },
        title: {
            text: 'Desempenho no terreno'
        },
        subtitle: {
            text: 'Número de fichas por usuário'
        },
        xAxis: {
            categories: [ <?php echo $categories; ?> ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'n. fichas'
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Usuários',
            data: [ <?php echo $serie; ?> ]
        }]
    });
//----------------------------------------------------------------------------------------------------------------------
$('#div02').highcharts({
chart: {
            type: 'column'
        },
        title: {
            text: 'Desempenho no terreno'
        },
        subtitle: {
            text: 'Número de fichas por província'
        },
        xAxis: {
            categories: [ <?php echo $categories_2; ?> ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'n. fichas'
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
        series: {
            color: '#FF0000'
        }
        },
        series: [{
            name: 'Províncias',
            data: [ <?php echo $serie_2; ?> ]
        }]
    });
//----------------------------------------------------------------------------------------------------------------------

});
</script>
<script src="../js/highcharts.js"></script>
<script src="../js/exporting.js"></script>
</head>
<body>
<div id="main">
<div id="div01" class="divchart"></div>
<div id="div02" class="divchart"></div>
</div>


</body>
</html>
