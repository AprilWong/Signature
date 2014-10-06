<?php

//get latest tweet
$url = 'https://twitter.com/LittleAprilFool';
$page_content = file_get_contents($url);
//If end with '=w=', display it on signature
eregi("data-aria-label-part=\"0\">(.*)=w=</p>",$page_content,$res);
echo $res[1];

//set time zone
date_default_timezone_set('America/Vancouver');

while(1){
	
	//remove old signature
	unlink('/var/www/html/qmd/april_qmd.jpg');
	
	//refresh the tweet once an hour
	$hour = date('G');
	$min = date('i');
	if($min==10){
		$url = 'https://twitter.com/LittleAprilFool';
		$page_content = file_get_contents($url);
		eregi("data-aria-label-part=\"0\">(.*)=w=</p>",$page_content,$res);
		echo $res[1];	
	}
	
	//set different times
	if($hour<9) $state = 1;
		else if($hour<12) $state = 2;
			else if($hour<18) $state = 3;
				else $state = 4;
	
	//set different texts
	switch ($state) {
		case 1:
			$text3 = '睡觉啦 (:3[____]';
			$text4 = '睡';
			break;
		case 2:
			$text3 = '早课 ∑(゜д゜lll)';
			$text4 = '虐';
			break;
		case 3:
			$text3 = '下午好呀 (●\'◡\'●)ﾉ';
			$text4 = '约吗';
			break;
		case 4:
			$text3 = '码码码 ｡•ˇ‸ˇ•｡';
			$text4 = '元气';
			break;
	}

	//load image
	$imgsrc = '/var/www/html/qmd/img/'.$state.'.jpg';
	$src = imagecreatefromjpeg($imgsrc);
	
	//create a new image
	$dest = imagecreatetruecolor(520, 150);
	
	//set background color
	$white = imagecolorallocate($dest, 255, 255, 255);
	imagefill($dest, 0, 0, $white);
	
	//copy source img to background img
	imagecopy($dest, $src, 10, 0, 0, 0, 150, 150);

	//add time
	$text1 = date('G:i');
	$font1 = '/var/www/html/qmd/font/Pop.ttf';
	$text_color1 = imagecolorallocate($dest, 55, 209, 183);
	imagettftext($dest, 48, 0, 180, 100, $text_color1, $font1, $text1);

	//add tweet
	$text2 = $res[1];
	$text5 = 'twitter@LittleAprilFool';
	$font2 = '/var/www/html/qmd/font/Yuanti.ttc';
	$text_color2 = imagecolorallocate($dest, 77, 204, 200);
	imagettftext($dest, 12, 0, 300, 100, $text_color2, $font2, $text2);
	imagettftext($dest, 8, 0, 300, 80, $text_color2, $font2, $text5);	

	//add other texts
	//$text_color3 = imagecolorallocate($dest, 53, 209, 181);
	//imagettftext($dest, 12, 0, 300, 75, $text_color3, $font2, $text3);

	$text_color4 = imagecolorallocate($dest, 238, 238, 238);
	imagettftext($dest, 30, 10, 450, 50, $text_color4, $font2, $text4);

	// save the image
	imagejpeg($dest, '/var/www/html/qmd/april_qmd.jpg',100);

	// Free up memory
	imagedestroy($dest);
	
	//sleep a minute (to save CPU)
	sleep(60);
}
?>
