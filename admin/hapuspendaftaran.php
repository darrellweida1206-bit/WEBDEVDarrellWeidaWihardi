<?php
    include "includes/config.php";
    if(isset($_GET['hapuspendaftaran']))
    {
        $id = $_GET["hapuspendaftaran"];
        mysqli_query($conn, "DELETE FROM pendaftaranwisuda
        WHERE mhs_NPM = '$id' ");
        echo "<script>alert('DATA BERHASIL DIHAPUS');
        document.location='inputpendaftaran.php'</script>";
    }
?>