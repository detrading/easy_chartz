
<?php

//////////////////////
///////////////////////////////
	$halfscreenwidth = $_SESSION['screen_width'] /2;
			$_SESSION['array_to_save'] = array_slice($line[2],-1 * $halfscreenwidth,$halfscreenwidth);
			$_SESSION['array_to_save1'] = $line[3];
			
			echo '<pre>';print_r($line[2]); echo '<pre>';
			//var_dump($_SESSION['array_to_save']);

		

		shell_exec('php 2.php'); //sleep(1);
		echo '<img src="2.php"/>';
//////////////////////////
////////////////////////////





session_start();
//$diag = 1;

function generateGraphFromArray($array, $perpixel, $im, $startingy,$diag=NULL){
  $white = imagecolorallocate($im, 214,230,224);
$black = imagecolorallocate($im, 0x00, 0x00, 0x00);
$green = imagecolorallocate($im,0,230,0);
$red = imagecolorallocate($im,230,0,0);
$k =0; $xframe = 1; 
foreach($array as $indprice){
  //echo $k,'>';
  if($k == 0 ){   $previousprice = $indprice;   } 
  elseif ($k == 1 )  {
  $change[$k] = $indprice - $previousprice;
  $previousprice = $indprice;
  $rate = $change[$k] * $perpixel;
  //var_dump($rate);
  $newy = round($startingy - $rate);
  $x =0;
  imageline($im, $x, $startingy,$x,$newy, 0xFF);
  //echo $im,' / ', 0,' / ', 300 ,' / ',$x,' / ',$newy,'<BR>';
  $prevy =$newy; $prevx=$x;}

  elseif($k > 1 ){ 
  
  $change[$k] = $indprice - $previousprice;
 
  $previousprice = $indprice;
  $rate = $change[$k] * $perpixel;
  $newy = round($newy  - $rate);
  $x= $x +$xframe;
  if($newy > $prevy) {   imageline($im, $prevx, $prevy ,$x ,$newy, $red); } 
  elseif ($newy == $prevy){   imageline($im, $prevx, $prevy ,$x ,$newy, $black); } 
  else{   imageline($im, $prevx, $prevy ,$x ,$newy, $green); }
  
  if(isset($diag)){echo $im,' / ', $prevx,' / ', $prevy ,' / ',$x,' / ',$newy,'<BR>';}
  $prevy =$newy; $prevx=$x;}

  $k++;
  if($k % 60 == 0){ imagestring($im, 5, $x, $newy,  $indprice, 0xFF); }
}

$timeend = microtime(true);
$timediff = (round(($timeend - $timestart),5)*1000). 'ms ';
if(!isset($diag)){imagestring($im, 5, $width-50, $height - 50,  $timediff, 0xFF);}


}




$array2 = $_SESSION['array_to_save'];
$array3 = $_SESSION['array_to_save1'];
$datestamp = end($array3);



//$halfscreenwidth = $_SESSION['screen_width'] /2; 
//$array2 = array_slice($array6, -1 *$halfscreenwidth, $halfscreenwidth));
$width = count($array2);// +100;

$height = 400;

//foreach($array as $val){ $array2[] = $val * 100000000;}
//foreach($array1 as $val){ $array3[] = $val * 100000000;} 

$maxval = max($array2); $minval =min($array2); $range = $maxval - $minval;$perpixel =  $height / $range ;
if(!isset($diag)){$im = ImageCreate($width,$height+70);
$text_color = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);imagestring($im, 5, 1, 1,  $_SESSION['market'], 0xFF);}
$datetime = new DateTime();
$datestamp = (string)$datetime->format('Y-m-d H:i:s');
if(!isset($diag)){imagestring($im, 5, $width - 170, 10,  $datestamp, 0xFF);}

$startingy = $height - (($array2[0] - $minval) *$perpixel) + 50;
$timestart = microtime(true);

generateGraphFromArray($array2, $perpixel, $im, $startingy);
if(!isset($diag)){
header('Content-Type: image/png');
ImagePNG($im);
}



/*


$n1 = 0;
$n2 = -600;
$m1 = 50;
$m2 = -550;
do {
//imageline($im, $n1, $n2, $m1, $m2, 0xFF);
imageline($im, rand(0, 1200), rand(0, 600), rand(0, 1200), rand(0, 600), 0xFF);
//imagestring($im, 1, 5, 5,  'A Simple Text String', 0xFF);
$m1 = $m1 + 6; //rand(-10, 10);
$n1 = $n1 + 5; //rand(-10, 10);
}while($m1 < 20000);

$thisy =960;$thisx= 540;
$width = $thisx; $height = $thisy;
$im = ImageCreate($thisx,$thisy);
$othercolor = imagecolorallocate($im,0,155,223);
$backgroundcolor = imagecolorallocate($im, 47, 80, 130);
$white = imagecolorallocate($im, 0xFF, 0xFF, 0xFF);
$black = imagecolorallocate($im, 0x00, 0x00, 0x00);
$n1 = 0;
$n2 = -600;
$m1 = 50;
$m2 = -550;
do {
imageline($im,  rand(0, $thisx),rand(0, $thisy),   rand(0, $thisx),rand(0, $thisy), $backgroundcolor);
$m1 = $m1 + rand(1,10);
$n1 = $n1 + rand(1,10);
}while($m1 < 90000);

$n1 = 0;
$n2 = -600;
$m1 = 50;
$m2 = -550;
do {
imageline($im,  rand(0, $thisx),rand(0, $thisy),   rand(0, $thisx),rand(0, $thisy), $othercolor);
$m1 = $m1 + rand(1,10); 
$n1 = $n1 + rand(1,10); 
}while($m1 < 4000);

$n1 = 0;
$n2 = -600;
$m1 = 50;
$m2 = -550;
do {
imageline($im,  rand(0, $thisx),rand(0, $thisy),   rand(0, $thisx),rand(0, $thisy), $black);
$m1 = $m1 + rand(1,10); 
$n1 = $n1 + rand(1,10);
}while($m1 < 20000);

header('Content-Type: image/png');
ImagePNG($im);
imagedestroy($im); 

die();





//imagestring($im, 5, 1, 1,  'DAYENDTRADING', E90C5B);
// hexadecimal way



$half = $height/2;
imagestring($im, 5, 50, $half,  'HAPPY INTERNATIONAL', $othercolor);
imagestring($im, 5, 60, ($half + 20),  'MENS DAY', $othercolor);
imagestring($im, 5, 51, $half + 1,  'HAPPY INTERNATIONAL', $backgroundcolor);
imagestring($im, 5, 61, ($half + 21),  'MENS DAY', $backgroundcolor);
imagestring($im, 5, 52, $half + 2,  'HAPPY INTERNATIONAL', 0x00);
imagestring($im, 5, 62, ($half + 22),  'MENS DAY', 0x00);
*/

?>
