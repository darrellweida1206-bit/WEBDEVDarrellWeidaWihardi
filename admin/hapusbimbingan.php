<?php
    include "includes/config.php";
    if(isset($_GET['hapusbimbingan']))
    {
        $mhs_NPM = $_GET["hapusbimbingan"];
        $tanggal = $_GET["tanggal"];
        mysqli_query($conn, "DELETE FROM bimbingan
        WHERE mhs_NPM = '$mhs_NPM' AND bimbingan_TGL = '$tanggal'");
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputbimbingan.php'</script>";
    }
?>