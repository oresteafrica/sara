<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<link rel="stylesheet" href="../js/jstree/themes/default/style.min.css">
	<link rel="stylesheet" href="../css/sara_tree.css">
	<script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="../js/jstree/jstree.min.js"></script>
	<script type="text/javascript" src="../js/cicle.js"></script>
	<script type="text/javascript" src="../js/sara_tree.js"></script>
</head>
<body>

<div id="treewait"></div>

<div id="treetitle">
<h2>SARA</h2>
<button id="bu_ou_csv_dhis2">Download CSV</button>
</div>

<div id="divtree">

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

$aous_level = create_array_from_table ($db, 'sara', 'id_up, id');

ob_start();
print_list($aous_level,1);
$ulli = ob_get_clean();

echo $ulli;

?>
</div>



<iframe style="display:none;" id="frame_download">
<p>Este navegador (browser) não é atualizado.</p>
</iframe>
<?php


if ($debug) {
!Kint::dump( $aous_level );
}

//----------------------------------------------------------------------------------------------------------
function print_list($array, $parent=0) {

	if ( $parent>1) print '<ul>'; else print '<ul id="ultree">';
    for($i=$parent, $ni=count($array); $i < $ni; $i++){
        if ($array[$i]['id_up'] == $parent) {
            print '<li>'.$array[$i]['name']. ' <span style="font-size:xx-small;">('.$array[$i]['id'].')</span>';
            print_list($array, $array[$i]['id']);  # recurse
            print '</li>';
    }   }
    print '</ul>';
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
//----------------------------------------------------------------------------------------------------------
/*
CREATE TABLE IF NOT EXISTS `sara` (
  `id` int(11) NOT NULL COMMENT 'Numero de identificação interno. Não visível para o utente.',
  `name` varchar(50) NOT NULL COMMENT 'Nome oficial do território',
  `id_up` int(11) NOT NULL COMMENT 'Id do território de referência com nível hierarquico superior',
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/
?>



</body>
</html>
