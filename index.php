<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-light bg-light">
  <div class="container justify-content-center">
    <a class="navbar-brand" href="#">
      <img src="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png" alt="" width="80">
    </a>
  </div>
</nav>

<!-- membuat konten ada ditengah -->
<div class="row justify-content-center mt-4">    
    <div style="width: 25rem;">
        <form action="index.php" method="post" name="form_qr" id="form_qr">
            <div class="card text-center">
                <div class="card-header">
                    BMKG QR Generator
                </div>
                <div class="card-body">
                    <div class="mb-4" >
                    <input style="width: 21rem;" name="url" type="text" placeholder="Masukkan Alamat URL">
                    </div>
                    <div class="mb-4" >
                    <input style="width: 21rem;" name="nama" type="text" placeholder="Masukkan Nama File">
                    </div>
                    <div class="mb-1 ">
                            <input type="submit" class="btn btn-primary" value="Generate QR Code" >     
                    </div>
                </div>  
            </div>
        </form>  
    </div>
</div>

<?php 

if (isset($_POST['url']))
{ 
$url=$_POST['url'];
$nama=$_POST['nama'];
 include "phpqrcode/qrlib.php"; 
  $tempdir = "temp/"; //Nama folder tempat menyimpan file qrcode
    if (!file_exists($tempdir)) //Buat folder bername temp
    mkdir($tempdir);

    //ambil logo
    //$logopath="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png";
    //$logopath = 'temp/path1422.png';
    $imgname =$nama;
    $data = isset($_GET['data']) ? $_GET['data'] : $url;
    $logo = isset($_GET['logo']) ? $_GET['logo'] : 'logo.png';

 QRcode::png($data,$imgname,QR_ECLEVEL_L,11.45,0);

 // === Adding image to qrcode
 $QR = imagecreatefrompng($imgname);
 if($logo !== FALSE){
     $logopng = imagecreatefrompng($logo);
     $QR_width = imagesx($QR);
     $QR_height = imagesy($QR);
     $logo_width = imagesx($logopng);
     $logo_height = imagesy($logopng);
     
     list($newwidth, $newheight) = getimagesize($logo);
     $out = imagecreatetruecolor($QR_width, $QR_width);
     imagecopyresampled($out, $QR, 0, 0, 0, 0, $QR_width, $QR_height, $QR_width, $QR_height);
     imagecopyresampled($out, $logopng, $QR_width/2.65, $QR_height/2.65, 0, 0, $QR_width/4, $QR_height/4, $newwidth, $newheight);
     
 }
 imagepng($out,$imgname);
 imagedestroy($out);
 
 // === Change image color
 $im = imagecreatefrompng($imgname);
 $r = 44;$g = 62;$b = 80;
 for($x=0;$x<imagesx($im);++$x){
     for($y=0;$y<imagesy($im);++$y){
         $index 	= imagecolorat($im, $x, $y);
         $c   	= imagecolorsforindex($im, $index);
         if(($c['red'] < 100) && ($c['green'] < 100) && ($c['blue'] < 100)) { // dark colors
             // here we use the new color, but the original alpha channel
             $colorB = imagecolorallocatealpha($im, 0x12, 0x2E, 0x31, $c['alpha']);
             imagesetpixel($im, $x, $y, $colorB);
         }
     }
 }
 imagepng($im,$tempdir.'qrwithlogo.png');
 //imagedestroy($im);
 
 // === Convert Image to base64
 //$type = pathinfo($imgname, PATHINFO_EXTENSION);
 //$data = file_get_contents($imgname);
 //$imgbase64 = 'data:image/' . $type . ';jpg,' . base64_encode($data);

 //echo "<img src='$imgbase64' style='position:relative;display:block;width:240px;height:240px;margin:160px auto;'>";

 //simpan dalam png

 //imagepng($QR,$tempdir.'qrwithlogo.png');

$img = file_get_contents('temp/qrwithlogo.png');
$im = imagecreatefromstring($img);
$width = imagesx($im);
$height = imagesy($im);
$newwidth = '240';
$newheight = '240';
$thumb = imagecreatetruecolor($newwidth, $newheight);
imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagejpeg($thumb,'temp/'.$nama.'.png'); //save image as jpg

//imagedestroy($thumb); 

//imagedestroy($im);
 ?>

<div class="row justify-content-center mt-2">    
    <div style="width: 25rem;">
        <form action="download.php" method="post" name="form_qr" id="form_qr">          
                <div>
                    <input style="width: 21rem;" name="nama" type="hidden" placeholder="Masukkan Nama File" value="<?php if (isset($_POST['nama'])) { echo $_POST['nama']; } ?>">
                </div>
                <div class="mb-2 text-center">
                    <input type="submit" class="btn btn-success" value="Download QR Code" >     
                </div>           
        </form>
    </div>
</div>

 <?php
  //menampilkan file qrcode posisi ditengah
  echo '<div align="center">';
  echo '<img src="'.$tempdir.'/'.$nama.'.png" />';
  echo '</div>';

 ?>



</body>
<script language="JavaScript">
document.addEventListener("contextmenu", function(e)
	{e.preventDefault();
	}, false);
</script>
</html>

<?php
}
?>