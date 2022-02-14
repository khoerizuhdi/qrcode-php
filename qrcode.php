<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="download.php">Download QR Code</a>
</body>
</html>

<?php

$url=$_POST['url'];

 include "phpqrcode/qrlib.php"; 
  $tempdir = "temp/"; //Nama folder tempat menyimpan file qrcode
    if (!file_exists($tempdir)) //Buat folder bername temp
    mkdir($tempdir);

    //ambil logo
    $logopath="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png";

 //isi qrcode jika di scan
 $codeContents = $url; 

 //simpan file qrcode
 QRcode::png($codeContents, $tempdir.'qrwithlogo.png', QR_ECLEVEL_H, 10,4);


 // ambil file qrcode
 $QR = imagecreatefrompng($tempdir.'qrwithlogo.png');

 // memulai menggambar logo dalam file qrcode
 $logo = imagecreatefromstring(file_get_contents($logopath));
 
 imagecolortransparent($logo , imagecolorallocatealpha($logo , 0, 0, 0, 127));
 imagealphablending($logo , false);
 imagesavealpha($logo , true);

 $QR_width = imagesx($QR);
 $QR_height = imagesy($QR);

 $logo_width = imagesx($logo);
 $logo_height = imagesy($logo);

 // Scale logo to fit in the QR Code
 $logo_qr_width = $QR_width/8;
 $scale = $logo_width/$logo_qr_width;
 $logo_qr_height = $logo_height/$scale;

 imagecopyresampled($QR, $logo, $QR_width/2.3, $QR_height/2.3, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

 // Simpan kode QR lagi, dengan logo di atasnya
 imagepng($QR,$tempdir.'qrwithlogo.png');

  //menampilkan file qrcode 
 echo '<div align="center"><h2>BMKG QR CODE Test</h2>';
 echo '<img src="'.$tempdir.'qrwithlogo.png'.'" />';

$img = file_get_contents('temp/qrwithlogo.png');

$im = imagecreatefromstring($img);

$width = imagesx($im);

$height = imagesy($im);

$newwidth = '120';

$newheight = '120';

$thumb = imagecreatetruecolor($newwidth, $newheight);

imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

imagejpeg($thumb,'temp/resizeqr.png'); //save image as jpg

//imagedestroy($thumb); 

//imagedestroy($im);
 
 ?>