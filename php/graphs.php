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
$ini_array = parse_ini_file('../cron/sara.ini');
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

$sql = 'SELECT (SELECT areas.name FROM areas WHERE areas.id = hierarchy_areas_areas.id_up) AS name, count(hierarchy_areas_areas.id_up) AS count FROM hierarchy_areas_areas, hierarchy_units_areas WHERE hierarchy_areas_areas.id = hierarchy_units_areas.id_area GROUP BY hierarchy_areas_areas.id_up';

$unit_count_per_prov = create_array_from_tables ($db, $sql);

$tot_unit = 0;
$cat = [];
$ser = [];
foreach ($unit_count_per_prov as $item) {
    $tot_unit += $item['count'];
	$cat[] = $item['name'];
	$ser[] = $item['count'];
}
$categories = implode($cat,'\',\'');
$categories = "'" . $categories . "'" ;
$serie = implode($ser,',');
if ($debug) {
echo '<hr />';
!Kint::dump( $unit_count_per_prov );
echo '<hr />';
echo '$tot_unit = '.$tot_unit;
echo '<hr />';
echo $categories;
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
<title>SARA</title>
<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
<style type="text/css">
body {
font-family:Arial;
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
            text: 'Unidades de saúde por província'
        },
        subtitle: {
            text: 'Fonte: Moasis'
        },
        xAxis: {
            categories: [ <?php echo $categories; ?> ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'n. de unidades'
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Unidades',
            data: [ <?php echo $serie; ?> ]
        }]
    });

});
//----------------------------------------------------------------------------------------------------------------------
</script>
<script src="../js/highcharts.js"></script>
<script src="../js/exporting.js"></script>
</head>
<body>
<div id="main">
<div id="div01"></div>
</div>


</body>
</html>
