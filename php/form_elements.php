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
$id_unit = $_GET['n'];
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

$html = array();
$html[0] = '<table style="width:94%;"><tbody><tr style="font-size:xx-small;"><td style="border:1px solid lightgrey;cursor:pointer;width:20%;" ondblclick="alert(\'php dovrà inserire id_unit e il nome della tabella\')">';

//$html[0] = '<table style="width:94%;"><tbody><tr style="font-size:xx-small;"><td style="border:1px solid lightgrey;cursor:pointer;width:20%;" id="edit_element_mz010" class="edit_element">';



$html[1] = 'MZ-010';
$html[2] = '</td><td style="border:1px solid lightgrey;width:80%;">';
$html[3] = 'Endereço físico';
$html[4] = '</td></tr><tr style="font-size:small;"><td colspan="2" style="border:1px solid lightgrey;">';
$html[5] = '';
$html[6] = '</td></tr></tbody></table>';

$sql = 'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1';
$tabquery = $db->query($sql);
$tabquery->setFetchMode(PDO::FETCH_ASSOC);
$row = $tabquery->fetch();
if (! $row) {
    $html[5] = 'Informação não disponível';
} else {
    $html[5] = $row['address'];
}

echo implode('', $html);

$html[1] = 'MZ-011';
$html[3] = 'Contacto';



?>