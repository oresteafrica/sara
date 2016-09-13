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

$debug = false;

$ini_array = parse_ini_file('../../cron/moz.ini');
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

$table = 'sara';
$sort = 'id';
$sara = create_array_from_table ($db, $table, $sort);

ob_start();
print_list($sara,1);
$ulli = ob_get_clean();
echo $ulli;


if ($debug) {
    //echo '<pre>';
    //print_r($json);
    //echo '</pre>';
    !Kint::dump( $sara );
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
function create_array_from_tables ($db, $table, $sort) {
	$sql = "SELECT * FROM $table ORDER BY $sort ASC";
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
function create_array_from_table ($db, $table, $sort) {
	$sql = "SELECT * FROM $table ORDER BY $sort ASC";
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	if ($tabquery->rowCount() < 1) { echo '<h1>A base de dados é vazia</h1>'; exit; }
	$array_table = [];
	foreach ($tabquery as $tabres) {
		array_push($array_table, $tabres);
	}
	return $array_table;
}
/*
CREATE TABLE IF NOT EXISTS `sara` (
  `id` int(11) NOT NULL COMMENT 'Numero de identificação interno. Não visível para o utente.',
  `name` varchar(50) NOT NULL COMMENT 'Nome oficial do território',
  `id_up` int(11) NOT NULL COMMENT 'Id do território de referência com nível hierarquico superior',
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
//----------------------------------------------------------------------------------------------------------
?>

</div>

<div id="res"></div>

</body>
</html>
