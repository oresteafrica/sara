<?php
session_start();
if ( isset($_SESSION['res']) AND isset($_SESSION['user_name']) AND isset($_SESSION['user_id']) ) {
	echo '<span style="font-size:x-small;">Usuário: '.$_SESSION['user_name'].'</span>' ;
} else {
	echo '';
}
?>