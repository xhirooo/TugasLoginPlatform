<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kegiatan</title>
</head>

<style>
    table {
        border-collapse: collapse;
        width: 20%;
    }

    td {
        text-align: center;
        border-bottom: 2px solid black;
    }
</style>

<body>
    <h1>APLIKASI TO-DO LIST</h1>
    <form method="post" action="todolist/save">
        <label>Masukan Kegiatan :</label><br>
        <input name="kegiatan" id="kegiatan" type="text" style="width: 200px;">
        <input name="tambah" type="submit" value="Tambahkan">
    </form>
    <br>
    <p>Daftar Kegiatan :</p>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tododb";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
    }

    //tambah data
    if (isset($_POST['tambah'])) {
        $kegiatan = $_POST['kegiatan'];
        $sql = "INSERT INTO todolist (kegiatan) VALUES ('$kegiatan')";
        $query = mysqli_query($conn, $sql);
    }

    //status selesai
    if (isset($_GET['selesai'])) {
        $id = $_GET['selesai'];
        $sql = "UPDATE todolist SET status = 'selesai' WHERE idkegiatan = $id";
        $query = mysqli_query($conn, $sql);
    }

    //hapus data
    if (isset($_GET['hapus'])) {
        $id = $_GET['hapus'];
        $sql = "DELETE FROM todolist WHERE idkegiatan = $id";
        $query = mysqli_query($conn, $sql);
    }

    //membuat tabel
    $sql = "SELECT * FROM todolist";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<thead><tr><th>No</th><th>Kegiatan</th><th>Status</th><th>Aksi</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["idkegiatan"] . "</td><td>" . $row["kegiatan"] . "</td><td>" . $row["status"] . "</td><td>";
            echo "<a href='" . $_SERVER['PHP_SELF'] . "?selesai=" . $row["idkegiatan"] . "'>Selesai</a> ";
            echo "<a href='" . $_SERVER['PHP_SELF'] . "?hapus=" . $row["idkegiatan"] . "'>Hapus</a>";
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Tidak ada kegiatan yang tersimpan.";
        $sql = "ALTER TABLE todolist AUTO_INCREMENT = 1";
        $query = mysqli_query($conn, $sql);
    }
    $conn->close();
     ?>
</body>

</html>