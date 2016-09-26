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

$loop_elements = array(
    array('mz010',
          'Endereço físico',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz011',
          'Informação de contacto',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz012',
          'Tipos de unidades',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz013',
          'Autoridade gestora',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz014',
          'Ministério de Tutela',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz015',
          'Estado operacional',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz016',
          'Data de construção',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz017',
          'Data de início de funcionamento',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz018',
          'Data da última requalificação',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz019',
          'Data do último estado operacional',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz020',
          'Data de alteração de dados da Unidade de Saúde',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz023',
          'Tipos de serviços prestados',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1')
);

foreach ($loop_elements as $element) {
    $tabquery = $db->query($element[2]);
    $tabquery->setFetchMode(PDO::FETCH_ASSOC);
    $row = $tabquery->fetch();
    if (! $row) {
        $sqlres = 'Informação não disponível';
    } else {
        $sqlres = $row['address'];
    }
    $html = '<table style="width:94%;margin-bottom:8px;"><tbody><tr style="font-size:xx-small;"><td style="border:1px solid lightgrey;cursor:pointer;width:20%;" id="edit_element_'.$element[0].'" class="edit_element">'. strtoupper($element[0]).'</td><td style="border:1px solid lightgrey;width:80%;">'.$element[1].'</td></tr><tr style="font-size:small;"><td colspan="2" style="border:1px solid lightgrey;">'.$sqlres.'</td></tr></tbody></table>';
    echo $html;
}




?>