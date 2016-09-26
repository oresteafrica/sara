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
          'SELECT (SELECT unit_type.name FROM unit_type WHERE  unit_unit_type.id_type = unit_type.id) as type FROM  unit_unit_type WHERE id_unit = '.$id_unit),
    array('mz013',
          'Autoridade gestora',
          'SELECT (SELECT unit_authority.name FROM unit_authority WHERE unit_unit_authority.id_authority = unit_authority.id) as authority FROM unit_unit_authority WHERE id_unit = '.$id_unit),
    array('mz014',
          'Ministério de Tutela',
          'SELECT (SELECT ministries.name FROM ministries WHERE unit_ministry.id_ministry = ministries.id) as ministry FROM unit_ministry WHERE id_unit = '.$id_unit),
    array('mz015',
          'Estado operacional',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1'),
    array('mz016',
          'Data de construção',
          'SELECT DATE_FORMAT(build, "%d-%m-%y") as build FROM unit_dates WHERE id_unit = '.$id_unit),
    array('mz017',
          'Data de início de funcionamento',
          'SELECT DATE_FORMAT(first_fun, "%d-%m-%y") as first_fun FROM unit_dates WHERE id_unit = '.$id_unit),
    array('mz018',
          'Data da última requalificação',
          'SELECT DATE_FORMAT(last_requal, "%d-%m-%y") as last_requal FROM unit_dates WHERE id_unit = '.$id_unit),
    array('mz019',
          'Data do último estado operacional',
          'SELECT DATE_FORMAT(last_oper, "%d-%m-%y") as last_oper FROM unit_dates WHERE id_unit = '.$id_unit),
    array('mz020',
          'Data de alteração de dados da Unidade de Saúde',
          'SELECT DATE_FORMAT(alter_data, "%d-%m-%y") as alter_data FROM unit_dates WHERE id_unit = '.$id_unit),
    array('mz023',
          'Tipos de serviços prestados',
          'SELECT address FROM unit_address WHERE id_unit = '.$id_unit.'  ORDER BY date DESC LIMIT 1')
);

foreach ($loop_elements as $element) {
    $tabquery = $db->query($element[2]);
    $row = $tabquery->fetch();
    if (! $row) {
        $sqlres = 'Informação não disponível';
    } else {
        $sqlres = $row[0];
    }
    $html = '<table style="width:94%;margin-bottom:8px;"><tbody><tr style="font-size:xx-small;"><td style="border:1px solid lightgrey;cursor:pointer;width:20%;" id="edit_element_'.$element[0].'" class="edit_element">'. strtoupper($element[0]).'</td><td style="border:1px solid lightgrey;width:80%;">'.$element[1].'</td></tr><tr style="font-size:small;"><td colspan="2" style="border:1px solid lightgrey;">'.$sqlres.'</td></tr></tbody></table>';
    echo $html;
}


/*

fake data test units id 1 and 2
1 Sambula Lichinga Niassa
2 Namacula Lichinga Niassa
*/
?>