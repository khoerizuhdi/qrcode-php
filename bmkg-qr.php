<?php 

if (isset($_POST['url']))
{ 
   ?>

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

        <form action="bmkg-qr.php" method="post">
            <div class="card text-center">
                <div class="card-header">
                    BMKG QR Generator
                </div>
                <div class="card-body">
                    <div class="mb-4" >
                    <input style="width: 21rem;" name="url" type="text" placeholder="Masukkan Alamat URL">
                    </div>
                    <div class="mb-2 ">
                            <input type="submit" class="btn btn-primary" value="Generate QR Code" >     
                    </div>
                </div>  
            </div>
        </form>
        <div class="text-center mt-3">
            <a type="button" class="btn btn-success" href="download.php">Download QR Code</a>
        </div> 
    </div>
    
     
</div>
    


<?php
$url=$_POST['url'];
 include "phpqrcode/qrlib.php"; 
  $tempdir = "temp/"; //Nama folder tempat menyimpan file qrcode
    if (!file_exists($tempdir)) //Buat folder bername temp
    mkdir($tempdir);

    //ambil logo
    //$logopath="https://cdn.bmkg.go.id/Web/Logo-BMKG-new.png";
    $logopath = 'temp/rect847.png';

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
 $logo_qr_width = $QR_width/7;
 $scale = $logo_width/$logo_qr_width;
 $logo_qr_height = $logo_height/$scale;

 imagecopyresampled($QR, $logo, $QR_width/2.4, $QR_height/2.4, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

 // Simpan kode QR lagi, dengan logo di atasnya
 imagepng($QR,$tempdir.'qrwithlogo.png');

$img = file_get_contents('temp/qrwithlogo.png');

$im = imagecreatefromstring($img);

$width = imagesx($im);

$height = imagesy($im);

$newwidth = '240';

$newheight = '240';

$thumb = imagecreatetruecolor($newwidth, $newheight);

imagecopyresized($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

imagejpeg($thumb,'temp/resizeqr.png'); //save image as jpg

//imagedestroy($thumb); 

//imagedestroy($im);
 
  //menampilkan file qrcode posisi ditengah
  echo '<div align="center">';
  echo '<img src="'.$tempdir.'resizeqr.png'.'" />';
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
else {  
?>



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


<div class="row justify-content-center mt-4">    


<div style="width: 25rem;">

<form action="bmkg-qr.php" method="post">

        <div class="card text-center">
            <div class="card-header">
            BMKG QR Generator
            </div>
            <div class="card-body">
            <div class="mb-4" >
            <input style="width: 21rem;" name="url" type="text" placeholder="Masukkan Alamat URL">
            </div>
            <div class="mb-2 ">
                    <input type="submit" class="btn btn-primary" value="Generate QR Code" >  
                </div>
            </div>
        </div>
       
    </form>
</div>  
</div>
</body>
</html>

<?php } ?>






