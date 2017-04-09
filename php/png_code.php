<?php
session_start();
$w = 100;
$h = 20;
$n = 16;
$o = ['+','-'];
$p = rand(0,1);
$op = $o[$p];
$temp1 = rand(10,49);
$temp2 = rand(10,50);
if ($temp1 >= $temp2) {
$num01 = $temp1;
$num02 = $temp2;
} else {
$num01 = $temp2;
$num02 = $temp1;
}
switch ($op) {
    case '+':
        $num03 = $num01 + $num02;
        break;
    case '-':
        $num03 = $num01 - $num02;
        break;
    default:
        $num03 = $num01 + $num02;
}
$_SESSION['res'] = $num03;
//$alfab = array_merge(range('a', 'z'), range('A', 'Z'));
//shuffle($alfab);
//$noise = substr(implode($alfab), 0, $n);
$text = "$num01 $op $num02 = ";
header('Content-Type: image/png');
$im = imagecreatetruecolor($w, $h);
$white = imagecolorallocate($im, 255, 255, 255);
$grey = imagecolorallocate($im, 128, 128, 128);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, $w, $h, $white);
$font = 'fonts/arial.ttf';
imagettftext($im, 14, 0, 1, 20, $black, $font, $text);
//imagettftext($im, 10, 0, 10, 44, $black, $font, 'escreve o resultado númerico em baixo (números não palavras)');
//imagettftext($im, 10, 0, 10, 40, $black, $font, 'escreve o resultado númerico em baixo ('.$num03.')');
imagepng($im);
imagedestroy($im);
?>
