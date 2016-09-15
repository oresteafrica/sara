<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript">
    $( document ).ready(function() {
        $('li').on("click", function (e) {
        e.stopPropagation();
            $(this).children('ul').toggle('slow');
        });
        $('span').click(function(){
            $('#res').html($(this).text() + ' ('+this.id+')');
        });
    }); // $
    </script>
    <style>
        body {
            font-family: "Arial";
        }
        #tree {
            font-size:small;
        }
        ul {
            list-style-type:none;
        }
        #ultree ul {
            display:none;
        }
        span:hover { background: lightblue; }
        div {
            float:left;
        }
        #res {
            margin-top:20px;
            margin-left:60px;
            padding:6px;
            border:1px solid black;
            min-height:40px;
            min-width: 40px;
        }
    </style>
</head>
<body>

<div id="tree">

<?php

$localhosts = array(
    '127.0.0.1',
    'localhost',
	'::1'
);

if(in_array($_SERVER['REMOTE_ADDR'], $localhosts)) {
ini_set('display_errors', '1');
error_reporting(E_ALL | E_STRICT);
require 'kint/Kint.class.php';
}

//ini_set('max_execution_time', 300);

$debug = 0;

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

$sql = 'select areas.id, areas.name, hierarchy_areas_areas.id_up from areas, hierarchy_areas_areas where areas.id = hierarchy_areas_areas.id and hierarchy_areas_areas.id_up < 13 order by areas.id';
$array_table = create_array_from_tables ($db, $sql);

if ($debug) {
    //echo '<pre>';
    //print_r($json);
    //echo '</pre>';
    !Kint::dump( $array_table );
    exit;
}

ob_start();
print_list($array_table,1);
$ulli = ob_get_clean();
echo $ulli;

$sql = 'select units.id, units.name, hierarchy_units_areas.id_area from units, hierarchy_units_areas where units.id = hierarchy_units_areas.id_unit order by units.id';
$array_table = create_array_from_tables ($db, $sql);
!Kint::dump( $array_table );



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
function print_list($array, $parent=0) {

	if ( $parent>1) print '<ul>'; else print '<ul id="ultree">';
    for($i=$parent, $ni=count($array); $i < $ni; $i++){
        if ($array[$i]['id_up'] == $parent) {
            print '<li><span id="'.$array[$i]['id'].'">'.$array[$i]['name'].'</span>';
            print_list($array, $array[$i]['id']);  # recurse
            print '</li>';
    }   }
    print '</ul>';
}
//----------------------------------------------------------------------------------------------------------
/*
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=749 ;
CREATE TABLE `hierarchy_areas_areas` (
  `id` int(11) NOT NULL,
  `id_up` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `hierarchy_units_areas` (
  `id_unit` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1591 ;
CREATE TABLE `units_coord` (
  `id_unit` int(11) NOT NULL,
  `lat` float NOT NULL,
  `lon` float NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

/*
working sqls
---
select areas.id, areas.name, hierarchy_areas_areas.id_up from areas, hierarchy_areas_areas where areas.id = hierarchy_areas_areas.id and hierarchy_areas_areas.id_up < 13 order by areas.id
---
select concat("a_",areas.id) as id, areas.name as name, concat("a_",hierarchy_areas_areas.id_up) as id_up from areas, hierarchy_areas_areas where areas.id = hierarchy_areas_areas.id and hierarchy_areas_areas.id_up < 13 union select concat("u_",units.id) as id, units.name as name, concat("a_",hierarchy_units_areas.id_area) as id_up from units, hierarchy_units_areas where units.id = hierarchy_units_areas.id_unit order by id_up
---
*/

?>

</div>

<div id="res"></div>

</body>
</html>
