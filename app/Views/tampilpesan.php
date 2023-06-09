<!DOCTYPE html>
<html>
<head>
    <title>Input pesan</title>
</head>
<body>
    <h1>Tampilkan Pesan</h1>
    <?php 
     echo $_GET['pesan'];
     echo "<br>";
     echo "<a href='/Pesan/index'> Kembali </a>";
    ?>
</body>
</html>