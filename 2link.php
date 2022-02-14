<html>

<head><title>Multi Submit Link</title></head>

<body>

<form action="cek.php" name="form_cek" id="form_cek">

<label for="nama">Nama:</label><input type="text" name="nama" id="nama" />

</form>

<a href="" onclick="document.form_cek.action = 'cari.php'; document.form_cek.method='get'; document.form_cek.submit(); return false;">Cari</a>

<a href="" onclick="document.form_cek.action = 'edit.php'; document.form_cek.submit(); return false;">Edit</a>

</body>

</html>