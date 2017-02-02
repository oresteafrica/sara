<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<style>
		table {
			border-collapse:collapse;
		}
		td {
		    border:solid 1px black;
		    padding:6px;
		}
		a {
			text-decoration:none;
		}
		a:hover {
			background-color:lightgrey;
		}
		a:visited {
			color:black;
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

if (check_get('n')) {
	$curphp = strtok('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'?');
	$id_user = $_GET['n'];
	$sql = 'SELECT * FROM officer WHERE id = '.$id_user;
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$row = $tabquery->fetch();
	echo '<h3>Usuário '.$row['id'].'</h3>';
	echo '<table><tbody>';
	echo '<tr><td>Nome completo</td><td>'.$row['name'].'</td></tr>'."\n";
	echo '<tr><td>Nível</td><td>'.$row['rank'].'</td></tr>'."\n";
	echo '<tr><td>Email</td><td>'.$row['email'].'</td></tr>'."\n";
	echo '<tr><td>Cell</td><td>'.$row['cell'].'</td></tr>'."\n";
	echo '<tr><td>Estado</td><td>'.($row['active']?'Activo':'Não validado').'</td></tr>'."\n";
	echo '</tbody></table>';
	echo '<p><a href="'.$curphp.'">Voltar à lista</a></p>';
} else {
	$curphp = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?n=';
	$sql = 'SELECT id,name,active FROM officer';
	$tabquery = $db->query($sql);
	$tabquery->setFetchMode(PDO::FETCH_ASSOC);
	$rows = $tabquery->fetchAll();
	echo '<h3>Lista dos usuários</h3>';
	echo '<table><thead><tr><th>Nome completo</th><th>Estado</th></tr></thead><tbody>';
	foreach ($rows as $row) {
		$tid = $row['id'];
		echo '<tr><td><a href="'.$curphp.$tid.'">'.$row['name'].'</a></td><td>'.
				($row['active']?'Activo':'Não validado').'</td></tr>'."\n";
	}
	echo '</tbody></table>';
	echo '<p>Clicar o nome para visualizar a ficha</p>';
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
